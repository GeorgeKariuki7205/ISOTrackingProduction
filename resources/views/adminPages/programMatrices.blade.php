@extends('extendingCode.adminExtending')
@section('section')
<div id = "ajaxReload">
@php
    $increment2 = 0;
@endphp
@php   
    $name = str_replace('_', ' ', $programName);
    $name = ucwords($name);
@endphp

@php
    //getting to know the length of the shorthand of the progrm        
        $shorthandLength = strlen($programShortHand)+1;
@endphp

{{-- GETTING THE QUATER THAT IS ACTIVE AND ALSO THE YEAR THAT IS ACTIVE. --}}
<input type = "hidden" value="{{$activeQuater}}" name = "activeQuater" id = "activeQuater">
<input type = "hidden" value="{{$activeYaer}}" name = "activeYear" id="activeYear">
<div style="margin-bottom:5%;margin-top:5%"id="heading">
<h1 class="text-center" style="font-family:Times New Roman;">{{$name}}</h1>
    <h1 class="text-center" style="font-family:Times New Roman;">({{$programShortHand}})</h1>
    <h2 class="text-center" style="font-family:Times New Roman;"><b>Martices (Perspectives, Strategic Objectives and Key Perfomance Indicators.)</b></h2>
</div>
    
<div class="panel-group" id="accordion" role="tablist"> 
    
    @if (count($perspectives) == 0)

    <h2 style="text-align:center;font-family:'Times New Roman', Times, serif;color:red;"> <b>THERE ARE NO PERSPECTIVES FOR THIS PROGRAM....</b></h2>
        
    @endif
@foreach ($perspectives as $perspective)
    
    {{-- getting the name of the particular perspective. --}}

    @php
        $perspectiveId = $perspective->id;
        $name2 = $perspective->name;
        $nameOfPerspective = substr($name2,$shorthandLength);
        $name2 = str_replace('_', ' ', $nameOfPerspective);
        $name2 = ucwords($name2);
        $increment2++;               
    @endphp

<div class="panel box box-solid">
  <div class="box-header with-border" style="background-color:tomato;">
    <h4 class="box-title" style="width:100%;">
      <a data-toggle="collapse" style="padding-right:10px;color:white" data-parent="#accordion" href="{{"#collapseOne".$increment2}}" aria-expanded="true" aria-controls="collapseOne">
        {{$name2}} <i style = "float:right;"class="accordion_icon fa fa-plus"></i>
      </a>
    </h4>
  </div>
  <div id="{{"collapseOne".$increment2}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body">

        {{-- the modal that will be used to add the new strategic objectives --}}
        <div role="dialog" tabindex="-1" class="modal fade" id="{{"addingStrategicObjectives".$perspective->id}}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#23bac3;"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="text-center modal-title"><strong>Add A New STRATEGIC OBJECTIVE.</strong></h4>
                        </div>
                        <div class="modal-body" style="background-color:#2af3ff;">
                                <form action="{{"/addingNewStrstegicObjective/".$perspective->id}}" method="POST">
                                    {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Strategic Objective Name.</h4>
                                </div>
                                <div class="col-md-6"><input type="text" style="width:100%;height:35px;" name="strName"/></div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color:#23bac3;"><button class="btn btn-danger" type="button" data-dismiss="modal">Close</button><button class="btn btn-success" type="submit">Save</button></div>
                        </form>
                    </div>
                </div>
            </div>
      {{-- getting the strategic objectives of theperspecives that have been given. --}}
      

      @php
          $strategicObjectives = $perspective->strategicObjectives;
          $number = count($strategicObjectives);

      @endphp

      @if ($number < 1)
          <h3 style="font-family:'Times New Roman', Times, serif; text-align:center;">THERE ARE NO STRATEGIC OBJECTIVES FOR THIS PERSPECTIVE.</h3>
          <div style="" class="col-md-6  col-sm-6">
                <a class="btn btn-warning btn-md" data-toggle="modal"  data-target="{{"#addingStrategicObjectives".$perspective->id}}"> <b>Add New Strategic Objective.</b> </a>                  
         </div>          
      @endif
      @if ($number > 0)
      <div>
            <a class="btn btn-warning btn-md" data-toggle="modal"  data-target="{{"#addingStrategicObjectives".$perspective->id}}"> <b>Add New Strategic Objective.</b> </a>                  
      </div> 

      <br>
          @foreach ($strategicObjectives as $strategicObjective)
          {{-- cleaning the data that is in the strategic objective for better visualisation. --}}
          @php
              $perspetiveName= str_replace('_', ' ', $strategicObjective->name);
              $perspetiveName = ucwords($perspetiveName);
          @endphp
          
          <div class="box box-primary box-solid">
            <div class="box-header with-border text-center"style="text-align:center">
            <h3 class="box-title text-center">{{$perspetiveName}}</h3>
            </div>
            
            {{-- getting the key perfomance indicators for the specific strategic objectives. --}}
            @php
                $kpis = $strategicObjective->keyPerfomanceIndicator;
                $numberOfKPI = count($kpis);
            @endphp
            @if ($numberOfKPI <= 0)
            <div>
                <div class="box-body">
                    <h4 style="text-align:center;">There are no key perfomance indicators for this strategic objective. <b> Click on the add button to add the kpis.</b></h4>
                </div>
              
            </div> 
            <div class="box-footer clearfix">
                    <div style="text-align:left" class="col-md-6  col-sm-6">
                        <a class="btn btn-success btn-md" data-toggle="modal" data-target="{{"#modal".$strategicObjective->id}}"> <b>Add New</b> </a>                  
                    </div>
                </div>
            <div role="dialog" tabindex="-1" class="modal fade" id="{{"modal".$strategicObjective->id}}">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h4 class="modal-title" style="text-align:center;">Add a new KPI to the Strategic Objective : <strong>{{$perspetiveName}}</strong></h4>
                      </div>
                      <div class="modal-body">
                        <form method="POST" id = "{{"modalSubmit".$strategicObjective->id}}">
                            <div id="{{"KPIalert".$strategicObjective->id}}"></div>
                          {{ csrf_field() }}
                            <input type="hidden" name="perpective" value="{{$perspectiveId}}">
                            <input type="hidden" name="strategicObjective" value="{{$strategicObjective->id}}">
                            <div class="row">
                                <div class="col-lg-6 col-md-6  col-sm-6">
                                    <p><strong>Name of KPI:</strong></p>
                                </div>
                                <div class="col-lg-6 col-md-6  col-sm-6"><input type="text" required name="kpiName" /></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6  col-sm-6">
                                    <p><strong>Target</strong></p>
                                </div>
                                <div class="col-lg-6 col-md-6  col-sm-6"><input type="number" required name="kpiTarget" /></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6  col-sm-6">
                                    <p><strong>Arithmtic Structure</strong></p>
                                </div>
                                <div class="col-lg-6 col-md-6  col-sm-6"><select required name="arithmeticStructure"><optgroup label="Arithmetic Structure"><option value="1">Above</option><option value="0">Below</option></optgroup></select></div>
                            </div>
                            <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-6">
                                        <p><strong>Period.</strong></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6  col-sm-6">
                                        <select required name="period">
                                            <optgroup label="Select Period.">
                                                <option value="4">Quaterly</option>
                                                <option value="2">Semi Anually</option>
                                                <option value="1">Anually</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>                                
                            <div class="modal-footer"><button class="btn btn-danger" type="button" data-dismiss="modal">Close</button><button class="btn btn-success" type="submit">Save</button></div>
                        </form>
                          

                      </div>
                      
                  </div>
              </div>
          </div> 
          </div>  
                  
            @else
            <form id = "{{"form".$strategicObjective->id}}" method="POST" name = "{{"form".$strategicObjective->id}}" >
              <div id = "{{"alert".$strategicObjective->id}}"></div>
              {{ csrf_field() }}
              <input type = "hidden" value ="{{$strategicObjective->id}}" name="strategicObjective"/>
                               {{-- <input type="hidden" name = "objectiveName" value="{{$objevtiveId}}"> --}}
                               <div class="row">
                                   <div class="col-md-1">
                                       <p class="text-center" style="font-size:16px;"><strong>No</strong></p>
                                   </div>
                                   <div class=" col-md-6 ">
                                       <p  style="font-size:16px;text-align:left;"><strong>Key Perfomance Indicator</strong><br /></p>
                                   </div>
                                   <div class=" col-md-2">
                                    <p  style="font-size:16px;text-align:left;"><strong>Assesment Period.</strong><br /></p> 
                                </div>
                                   <div class="col-md-1">
                                       <p class="text-center" style="font-size:16px;"><strong>Target</strong><br /></p>
                                   </div>
                                   <div class="col-md-2">
                                       <p class="text-center" style="font-size:16px;"><strong>Actions</strong><br /></p>
                                   </div>
                               </div>
                              
                               @foreach ($kpis as $kpi)

                               @php
                                  //counting the number of returned kpis.                                   
                                   $increment3 = 0;
                               @endphp

                               @php
                               $score = "number";
                               $kpiOriginalName = $kpi->name;
                               $name3 = $kpi->name;
                               $name3 = str_replace('_', ' ', $name3);
                               $name3 = ucwords($name3);
                               $increment3++;
                               $kpiId = $kpi->id;
                               $scoreRecordedNumberReturned = count($keyPerfomanceIndicatorsScores);

                              //!  getting the score of the particular strategic objective.
                               if(is_null($keyPerfomanceIndicatorsScores)){
                                $score = 0;
                                // dd("null");
                               }
                               else{
                                //  dd($scoreRecordedNumberReturned);
                                if ($scoreRecordedNumberReturned<1) {
                                  # code...
                                  $score = 0;
                                } else {
                                  # code...                                
                                        foreach($keyPerfomanceIndicatorsScores as $keyPerfomanceIndicatorsScoress)
                                      {
                                        // dd($keyPerfomanceIndicatorsScoress);
                                        $scoreKPI = $keyPerfomanceIndicatorsScoress->kpi_id;
                                        $scoreYear = $keyPerfomanceIndicatorsScoress->year;
                                        if($scoreKPI == $kpiId){
                                            $score = $keyPerfomanceIndicatorsScoress->ytd;
                                        break;
                                        }
                                        else{
                                          $score =0;
                                        }
                                      }
                                }
                               }     
                               //end of getting the score of the key perfomance indicator.                                
                               @endphp
                               
                                      <div class="row" style="margin-bottom:0.5%;">
                                        {{-- <input type = "hidden" value="{{$originalObjectiveName}}" id = "{{"hiddenKPIObective".$kpiOriginalName}} name = "{{"hiddenObjectiveName".$originalObjectiveName}}"/> --}}
                                        {{-- hidden input to et the value of the arithmetic structure. --}}
                                        
                                        <input type="hidden" id="{{"arithmeticStructure".$kpi->id}}" value = "{{$kpi->arithmeticStructure}}"/>
                                        <div class=" col-md-1"style="text-align:center">
                                            <p>{{$kpi->id}}</p>
                                        </div>
                                        <div class=" col-md-6" style="text-align:left">
                                            <p>{{$name3}}</p>
                                        </div>
                                        <div class=" col-md-2" style="text-align:left">
                                          <p>Quaterly</p>
                                      </div>
                                        {{-- <div class=" col-md-1" style="text-align:center"><p>{{$score}}</p></div> --}}
                                        <div class=" col-md-1"style="text-align:center">
                                            <p id = "{{"target".$kpi->id}}" class ="{{"target".$kpi->id}}" >{{$kpi->target}}</p>
                                        </div>
                                        <div class=" col-md-2" style="text-align:center">
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="{{"#editKpiModal".$kpi->id}}"> <b>Edit KPI.</b></button>
                                        </div>
                                      </div>
                               @endforeach
                               <div class="box-footer">   
                                    <div class="box-footer">   
                                            {{-- Adding the Modal That is used to add the Key Perfomance Indicators.  --}}
                                            {{-- id="{{ "modal".$originalObjectiveName}} --}}                                                                    
                                            <div style="text-align:left" class="col-md-6  col-sm-6">
                                              <a class="btn btn-success btn-md" data-toggle="modal" data-target="{{"#modal".$strategicObjective->id}}"> <b>Add New</b> </a>
                                              {{-- <a class="btn btn-warning btn-md" > <b>Edit .</b> </a> --}}
                                            </div>
                                            {{-- <div style="text-align:right;" class="col-md-6  col-sm-6">
                                              <button class="btn btn-danger btn-md" type = "submit" id= "{{"submit".$strategicObjective->name}}"> <b>Save</b> </button>
                                            </div> --}}
                                           </div> 
                               </div>                               
                               {{-- <input type = "hidden" value = "{{$numberOfKPI}}" id="{{$originalObjectiveName."numberOfKPI"}}"> --}}
            </form> 
            {{-- inserting the modals that will be thrown once the targets are not reached. --}}
            @foreach ($kpis as $kpiModal)

            @php
                $kpiName = $kpiModal->name;
                $kpiName = str_replace('_', ' ', $kpiName);
                $kpiName = ucwords($kpiName);
            @endphp
            <div role="dialog" tabindex="-1" style="font-family:'Times New Roman', Times, serif" class="modal fade" id="{{"editKpiModal".$kpiModal->id}}">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#62d975;"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="text-center modal-title"><strong>Edit The KPI: {{$kpiName}}</strong></h4>
                            </div>
                            <div class="modal-body" style="background-color:#a4daac;">
                                <form action="" method="POST">                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 style="font-family:'Times New Roman', Times, serif;">KPI Name:</h4>
                                    </div>
                                    <div class="col-md-6"><input type="text" name="name" style="width:100%;height:35px;" value="{{$kpiName}}"/></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 style="font-family:'Times New Roman', Times, serif">KPI Assesment Period:</h4>
                                    </div>
                                    <div class="col-md-6">
                                    <select name="period" style="height:35px;width:100%;">
                                        <optgroup label="Assesment Period.">
                                            @if ($kpiModal->period == 4)
                                            <option value="4" selected >Quater</option>
                                            <option value="2">Semi Anually</option>
                                            <option value="1" >Anually</option>
                                            @elseif($kpiModal->period == 2)
                                            <option value="4">Quater</option>
                                            <option value="2" selected>Semi Anually</option>
                                            <option value="1">Anually</option>
                                            @elseif($kpiModal->period == 1)
                                            <option value="4">Quater</option>
                                            <option value="2">Semi Anually</option>
                                            <option value="1" selected>Anually</option>
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 style="font-family:'Times New Roman', Times, serif">Arithmetic Structure:</h4>
                                    </div>
                                    <div class="col-md-6"><select name="arithmeticStructure" style="width:100%;height:35px;">
                                        <optgroup label="Arithmetic Structure">
                                            @if ($kpiModal->arithmeticStructure == 0)
                                            <option value="1">Above</option>
                                            <option value="0" selected>Below</option>
                                            @elseif($kpiModal->arithmeticStructure == 1)
                                            <option value="1">Above</option>
                                            <option value="0" selected>Below</option>
                                            @endif
                                            
                                        </optgroup></select></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 style="font-family:'Times New Roman', Times, serif">Target:</h4>
                                    </div>
                                    <div class="col-md-6"><input type="text" name="target" style="width:100%;height:35px;" value="{{$kpiModal->target}}"/></div>
                                </div>
                            </div>
                            <div class="modal-footer" style="background-color:#62d975;"><button class="btn btn-danger btn-sm" type="button" data-dismiss="modal"><strong>Close</strong></button><button class="btn btn-success btn-sm" type="submit"><strong>Save</strong></button></div>
                        </form>
                        </div>
                    </div>
                </div>
            @endforeach
          </div>

           <div role="dialog" tabindex="-1" class="modal fade" id="{{"modal".$strategicObjective->id}}">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h4 class="modal-title" style="text-align:center;">Add a new KPI to the Strategic Objective :  <strong>{{$perspetiveName}}</strong></h4>
                      </div>
                      <div class="modal-body">
                        <form method="POST" id = "{{"modalSubmit".$strategicObjective->id}}">
                          <div id="{{"KPIalert".$strategicObjective->id}}"></div>
                          {{ csrf_field() }}
                            <div class="row">
                              <input type="hidden" name="perpective" value="{{$perspectiveId}}">
                              <input type="hidden" name="strategicObjective" value="{{$strategicObjective->id}}">
                                <div class="col-lg-6 col-md-6  col-sm-6">
                                    <p><strong>Name of KPI:</strong></p>
                                </div>
                                <div class="col-lg-6 col-md-6  col-sm-6"><input type="text" required name="kpiName" /></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6  col-sm-6">
                                    <p><strong>Target</strong></p>
                                </div>
                                <div class="col-lg-6 col-md-6  col-sm-6"><input type="number" required name="kpiTarget" /></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6  col-sm-6">
                                    <p><strong>Arithmtic Structure</strong></p>
                                </div>
                                <div class="col-lg-6 col-md-6  col-sm-6"><select required name="arithmeticStructure"><optgroup label="Arithmetic Structure"><option value="1">Above</option><option value="0">Below</option></optgroup></select></div>
                            </div>
                            <div class="row">
                                    <div class="col-lg-6 col-md-6  col-sm-6">
                                        <p><strong>Period.</strong></p>
                                    </div>
                                    <div class="col-lg-6 col-md-6  col-sm-6">
                                        <select required name="period">
                                            <optgroup label="Select Period.">
                                                <option value="4">Quaterly</option>
                                                <option value="2">Semi Anually</option>
                                                <option value="1">Anually</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div> 
                            <div class="modal-footer"><button class="btn btn-danger" type="button" data-dismiss="modal">Close</button><button class="btn btn-success" type="submit">Save</button></div>
                        </form>
                          

                      </div>
                      
                  </div>
              </div>
          </div>      
          @endif  
          {{-- this section is used to add the modal for adding a new KPI. --}}
          @php
              // dd($strategicObjective->name);
          @endphp          
            
          @endforeach

      @endif

    </div>
  </div>
</div>
@endforeach
</div>
<script src="design/assets/js/jquery.min.js"></script>
</div>
@endsection