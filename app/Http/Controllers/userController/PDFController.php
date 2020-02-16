<?php

namespace App\Http\Controllers\userController;
use App\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\QuaterActive;
use App\YearActive;
use App\StrategicObjective;
use PDF;
use App\reportsGenerated;
use App\StrategicObjectiveScore;
use RealRashid\SweetAlert\Facades\Alert;
class PDFController extends Controller
{
    public function downloadPFD($id,$activeYaer,$activeQuater){
        $idRetrieved = $id;
        
        if ($activeYaer == 0 && $activeYaer == 0) {
            # code...
            $activeYaerCollections = YearActive::where('Active','=',1)->get();
            foreach($activeYaerCollections as $activeYaerCollection){
                $activeYaer = $activeYaerCollection->Year;
            }
    
            $activeQuaterCollections = QuaterActive::where('Active','=',1)->get();
            foreach($activeQuaterCollections as $activeQuaterCollection){
                $activeQuater = $activeQuaterCollection->Quater;
            }
        } 
        else{
            substr_replace('-','/',$activeYaer);
        }               
        //!getting the program Details.
        $programDetails = Program::where('id','=',$id)->get();

        foreach ($programDetails as $programDetail) {
            # code...
            //!initialising the arrays that are key in this section.
            $trackingNumberArray = array();
            $strategicObjectiveNameArray = array();
            $strategicObjectiveScoresArray = array();
            $perspectiveNameArray = array();
            $finalSScore = 0;
            
            

            $programName = $programDetail->name;
            $programShortHand = $programDetail->shortHand;
            $programImage = $programDetail->imageLocation;
            $gettingThePersectivesOfTheProgram =$programDetail->perspectives;
            $perspectives = $gettingThePersectivesOfTheProgram;

            foreach ($perspectives as $perspective) {
                # code...
                $perspectiveId = $perspective->id;
                $strategicObjectiveNumbers = count($perspective->strategicObjectives);
                

                //! this section of the code is used to get the strategic objectives that have been stored. 
                $strategicObjectiveScores = StrategicObjectiveScore::where('year','=',$activeYaer)
                                                                    ->where('quater','=',$activeQuater)
                                                                    ->where('perspective_id','=',$perspectiveId)
                                                                    ->get();

                
                if(count($strategicObjectiveScores) == $strategicObjectiveNumbers){
                    $strategicObjectivesSum = 0;
                    $strateicObjectiveAverage = 0;      
                    //!pushing the number of strategic objectives to the array.
                    array_push($trackingNumberArray,count($strategicObjectiveScores));
                    //! pushing the perspective name to the array.
                    array_push($perspectiveNameArray,$perspective->name);

                    //!getting the strategic objectives of the particular perspective. 
                    $strategicObjectives = StrategicObjective::where('perspective_id','=',$perspective->id)->get();
                    
                    
                    foreach($strategicObjectives as $strategicObjective){
                        $strategicObjectiveWeight = $strategicObjective->weight;
                        array_push($strategicObjectiveNameArray,$strategicObjective->name);

                        //!getting the rhyming strategic objective scores.
                        $trategicObjectiveScores = StrategicObjectiveScore::where('strategicObjective_id','=',$strategicObjective->id)->where('year','=',$activeYaer)->where('quater','=',$activeQuater)->get();                        
                        
                        foreach ($trategicObjectiveScores as $trategicObjectiveScore) {
                            # code...
                            $finalSScore += $trategicObjectiveScore->score;
                            array_push($strategicObjectiveScoresArray,(($trategicObjectiveScore->score)/$strategicObjectiveWeight)*100);
                            
                            //!getting the final score that willl be displayed.
                            $strategicObjectivesSum += (($trategicObjectiveScore->score)/$strategicObjectiveWeight)*100;
                        }
                        
                    }
                    
                }
                
                else{
                    Alert::error(' <h4 style = "color:red;">Ooops    <i class="fa fa-thumbs-down"></i></h4>', 'There Is A strategic Objective With unScored KPIs.');
                    return back();
                }

                //! selecting the strategic objecive scores that have the following perspective.
                
            }
        }
        
        $yearForPdf =str_replace('/', '-', $activeYaer); 
        $data = Program::all();
        $pdf = PDF::loadView('user.templatePDFView',compact('activeYaer','programName','finalSScore','programImage','programDetail','activeQuater','trackingNumberArray','strategicObjectiveNameArray','strategicObjectiveScoresArray','perspectiveNameArray'));
        
        //! this section of the code will be used to check if the report card has been stored in the 
        //!file system, if not store it, if yes replace its location.

        $reportInStore = reportsGenerated::where('quater','=',$activeQuater)
                                         ->where('year','=',$activeYaer)
                                         ->where('program_id','=',$programDetail->id)   
                                         ->get();

        $pdfNames = $programShortHand.'_report_'.$yearForPdf.'_'.$activeQuater.'_'.time().'.pdf';                                         
        if(count($reportInStore) == 0){
            //!store the data in the BD.
            $storingRecordInDB = new reportsGenerated(
                                array(
                                    'quater'=>$activeQuater,
                                    'year'=>$activeYaer,
                                    'reportLocation'=>'reports/'.$pdfNames,
                                    'program_id'=>$programDetail->id

                                )
            ); 
            $storingRecordInDB->save();
        }
        else{
            //!update the record (report location) name in DB.
            foreach($reportInStore as $report){
                $report->reportLocation = 'reports/'.$pdfNames;
                $report->save();
            }

        }                                         

        
        // $pdf->save('reports/'.$pdfNames);        
        return $pdf->download($pdfNames);
    }
}
