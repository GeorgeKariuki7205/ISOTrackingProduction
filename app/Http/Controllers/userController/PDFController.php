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
class PDFController extends Controller
{
    public function downloadPFD($id){
        $idRetrieved = $id;

        $activeYaerCollections = YearActive::where('Active','=',1)->get();
        foreach($activeYaerCollections as $activeYaerCollection){
            $activeYaer = $activeYaerCollection->Year;
        }

        $activeQuaterCollections = QuaterActive::where('Active','=',1)->get();
        foreach($activeQuaterCollections as $activeQuaterCollection){
            $activeQuater = $activeQuaterCollection->Quater;
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
                $strategicObjectiveScores = count($perspective->strategicObjectiveScores);

                if($strategicObjectiveScores == $strategicObjectiveNumbers){
                    $strategicObjectivesSum = 0;
                    $strateicObjectiveAverage = 0;      
                    //!pushing the number of strategic objectives to the array.
                    array_push($trackingNumberArray,count($perspective->strategicObjectiveScores));
                    //! pushing the perspective name to the array.
                    array_push($perspectiveNameArray,$perspective->name);

                    //!getting the strategic objectives of the particular perspective. 
                    $strategicObjectives = StrategicObjective::where('perspective_id','=',$perspective->id)->get();

                    foreach($strategicObjectives as $strategicObjective){
                        array_push($strategicObjectiveNameArray,$strategicObjective->name);

                        //!getting the rhyming strategic objective scores.
                        $trategicObjectiveScores = StrategicObjectiveScore::where('strategicObjective_id','=',$strategicObjective->id)->where('year','=',$activeYaer)->get();                        

                        foreach ($trategicObjectiveScores as $trategicObjectiveScore) {
                            # code...
                            array_push($strategicObjectiveScoresArray,$trategicObjectiveScore->score);
                            
                            //!getting the final score that willl be displayed.
                            $strategicObjectivesSum += $trategicObjectiveScore->score;
                        }
                        
                    }
                    $strateicObjectiveAverage = $strategicObjectivesSum/count($strategicObjectives);
                    // dd($strateicObjectiveAverage);
                    $weight = $perspective->weight;
                    $finalSScore += ($strateicObjectiveAverage*$weight)/100;
                    // dd($finalSScore.' '.$weight);
                    // $finalSScore += $strateicObjectiveAverage;
                    
                }
                else{
                    return "THERE ARE SOME STRATEGIC OBJECTIVES THAT HAVE NOT BEEN SCORED.";
                }

                //! selecting the strategic objecive scores that have the following perspective.
                
            }
        }
        
        $yearForPdf =str_replace('/', '-', $activeYaer); 
        $data = Program::all();
        $pdf = PDF::loadView('users.templatePDFView',compact('activeYaer','programName','finalSScore','programImage','programDetail','activeQuater','trackingNumberArray','strategicObjectiveNameArray','strategicObjectiveScoresArray','perspectiveNameArray'));
        
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

        
        $pdf->save('reports/'.$pdfNames);        
        return $pdf->download($pdfNames);
    }
}
