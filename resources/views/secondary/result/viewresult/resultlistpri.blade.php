<!DOCTYPE html>
<html>
	<head>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
		
		<!-- CSS property to place div
			side by side -->
		<style>
			#leftbox {
				float:left;
				width:50%;
			}
			#rightbox{
				float:right;
				width:50%;

			}
            #leftbox1 {
				float:left;
				width:25%;
			}
			#rightbox1{
				float:right;
				width:75%;

			}
			h1{
				color:green;
				text-align:center;
			}
            table, th, td {
                border: 1px solid black;
            }
            table {
                border-collapse: collapse;
            }

            tr th{
                font-size: 11px;
                font-family: 'Roboto Slab', serif;
            }

            tr, td{
                font-size: 11px;
            }

            #gradestable td{
                font-size: 9px;
            }

            #gradestableratings td{
                font-size: 7px;
            }

            #resulttable{
                background-color: #40babd;
                color: #fff;
                -webkit-print-color-adjust: exact; 
            }

            .thdesignhh{
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .rotated {
                writing-mode: tb-rl;
                transform: rotate(-180deg);
            }
            .page-break {
                page-break-after: always;
            }

            /* Create two equal columns that floats next to each other */
            .column {
            float: left;
            width: 50%;
            padding: 10px;
            height: 300px; /* Should be removed. Only for demonstration */
            }

            /* Clear floats after the columns */
            .row:after {
            content: "";
            display: table;
            clear: both;
            }
		</style>
	</head>
	
	<body>

        @foreach ($studentInClass as $item)

            @if ($item->getStudentName != null)
            <div class="page-break">

                <div class="container-fluid">
                    <div class="row">
    
                        <div class="col-md-2">
                            <div style="margin:0 auto;">
                                <div id="imagelogo" style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center;">
            
                                        {{-- @if ($addschool->schoolLogo != Null) --}}
                                        <img src="{{ asset('storage/schimages/'.$addschool->schoolLogo) }}" alt="" width="90px" height="90px">
                                        {{-- @endif --}}
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div style="margin:0 auto;">
    
                                <div style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                    <i style="font-size: 30px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">{{ $addschool->schoolname }}</i>
                                    <i style="font-size: 12px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">{{$addschool->schooladdress}}, {{$addschool->mobilenumber}}</i>
                                    <i style="font-size: 15px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;"></i>
                                    <div>
                                        <i style="font-size: 20px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">Termly Report</i>
                                    </div>
                                </div>
        
                            </div>
                        </div>
        
                    </div>
                </div>
                
                <br>
                
                <div class="container-fluid">
                    <div class="row">
    
                        <div class="col-md-6">
                            <div style="width: 95%; margin:0 auto;">
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Name of Student: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->getStudentName->firstname }} {{ $item->getStudentName->middlename }} {{ $item->getStudentName->lastname }}</i>
                                </div>
                                <div style="height: 7px;"></div>
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Class: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->getClassName->classname }} {{ $item->getSectionName->sectionname }}</i>
                                </div>
                                <div style="height: 7px;"></div>
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Next Term Resumes: <i style="font-style: normal;" id="honourorpricesremarkmain">
                                                            @if ($term == 1)
                                                            <i style="font-style: normal; font-weight: bold;">{{ $addschool->secondtermstarts }}</i> 
                                                            @elseif ($term == 2)
                                                                <i style="font-style: normal; font-weight: bold;">{{ $addschool->thirdtermstarts }}</i>
                                                            @elseif ($term == 3)
                                                                <i style="font-style: normal; font-weight: bold;">{{ $addschool->firsttermstarts }}</i>
                                                            @else
                                                                <i style="font-style: normal; font-weight: bold;">NAN</i>
                                                            @endif
                                                       </i>
                                </div>
                                <div style="height: 7px;"></div>
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Sex: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->gender }}</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="width: 95%; margin:0 auto;">
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Term: <i style="font-style: normal;" id="honourorpricesremarkmain">
    
                                                @if ($term == 1)
                                                    <i style="font-style: normal;">First</i> 
                                                @elseif ($term == 2)
                                                    <i style="font-style: normal;">Second</i>
                                                @elseif ($term == 3)
                                                    <i style="font-style: normal;">Third</i>
                                                @else
                                                    <i style="font-style: normal;">NAN</i>
                                                @endif
                                    
                                          </i>
                                </div>
                                <div style="height: 7px;"></div>
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Admission No: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->admission_no }}</i>
                                </div>
                                <div style="height: 7px;"></div>
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Position: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $addschool->getResultAverage($item->id, $classid, $term, $schoolsession) == NULL ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->position }} Out Of {{ $item->getClassCount($item->classid, $item->schoolsession, $item->studentsection)->count() }}</i>
                                </div>
                                <div style="height: 7px;"></div>
                                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                                    Session: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $schoolsession }}</i>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
    
                <br>
    
                <div class="container-fluid">
                    <div style="display: flex; align-items: center; justify-content: center; height: 10px;">
                        <i style="text-decoration: underline; font-style: normal; font-weight: bold;">ACCADEMIC RECORDS</i>
                    </div>
                </div>
    
                <br>
    
                <div class="container-fluid">
                    <table style="width: 100%; margin: 0 auto;" id="category">
                        <thead style="text-align: center;">
                            <tr>
                                <th style="font-size: 12px; width: 100px;">SUBJECTS</th>
                               
                                    {{-- <th class="text-center  thdesign"><i class="rotated" class="text-center" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Class Assignment</p></th> --}}
                                
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">First CA</i></th>
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Second CA</i></th>
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">EXAM SCORE</i></th>
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">TOTAL MARK</i></th>
                                {{-- <th class="text-center  thdesign"><i style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Points</i></th> --}}
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Average</i></th>
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">POSITION</i></th>
                                <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Grade</i></th>
                                {{-- <th class="text-center  thdesign"><i style="font-size: 12px;">Teacher</i></th> --}}
                                <th class="text-center  thdesign">
                                    <i style="font-size: 12px;">Year Summary</i>
                                    <table style="width: 100%; margin: 0 auto;">
                                        <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">1st term</i></th>
                                        <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">2nd term</i></th>
                                        <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">3rd term</i></th>
                                        <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Avg. Score</i></th>
                                        <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Position</i></th>
                                    </table>
                                </th>
    
                            </tr>
                        </thead>
                        <tbody id="resultprinttable">
    
                            @foreach ($addschool->getSubjectList($item->id, $schoolsession, $classid, $section, $term) as $subjects)
    
                            <tr style='font-size: 12px; width: 150px;'>
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $subjects->subjectname }}</center></td>
                                @if ($addschool->caset == 1)
                                    <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $subjects->getSubjectMark($item->id, $subjects->id, $schoolsession)->ca3 }}</center></td>
                                @endif
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->ca2 }}</center></td>
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->ca1 }}</center></td>
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->exams }}</center></td>
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->totalmarks }}</center></td>
                                {{-- <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $item->getSubjectMark($studentdetails->id, $item->id, $schoolsession) == NULL ? "0": $item->getSubjectMark($studentdetails->id, $item->id, $schoolsession)->points }}</center></td> --}}
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getClassAverageMarkSubject($subjects->id, $term, $schoolsession) == NULL ? "0":round($addschool->getClassAverageMarkSubject($subjects->id, $term, $schoolsession)->average, 1) }}</center></td>
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->position }}</center></td>
                                <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->grades }}</center></td>
                                {{-- <td class='text-center thdesign' style='font-size: 10px;'><center>{{ $addschool->getTeacherName($subjects->id) }}</td> --}}
                                <td class='text-center thdesign'>
                                    <table style="width: 100%; margin: 0 auto;">
                                        <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 1, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 1, $item->id)->totalmarks }}</i></th>
                                        <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 2, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 2, $item->id)->totalmarks }}</i></th>
                                        <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 3, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 3, $item->id)->totalmarks }}</i></th>
                                        <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getAverageScore($subjects->id, $schoolsession, $item->id) == NULL ? "0":round($addschool->getAverageScore($subjects->id, $schoolsession, $item->id)) }}</i></th>
                                        <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;"></i></th>
                                    </table>
                                </td>
                            <tr>
                                
                            @endforeach
                    
    
    
    
                            
                        </tbody>
                    </table>
                </div>
                <br>
                
                <div style="container-fluid">
                    <i style="margin: 10px 0px 0px 50px; font-style: normal; font-size: 13px;">Exam Total: <i id="sum1" style="margin: 10px 0px 0px 5px; font-style: normal; font-size: 13px;">{{ round(empty($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)) ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->sumofmarks, 2) }}</i></i>
                    <i style="margin: 10px 0px 0px 50px; font-style: normal; font-size: 13px;">Student Average: {{ round(empty($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)) ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average, 2) }}</i>
                    {{-- <i style="margin: 10px 0px 0px 50px; font-style: normal; font-size: 13px;">Final Grade: {{ $addschool->getGrade(empty($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)) ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average, $classtype) }}</i> --}}
                </div>
                
                <center><div class="text-center" style="width: 95%; margin: 10px auto;">
                    @if ($addschool->getGradeDetails($addschool->id, $classtype)->count() > 0)
                        @foreach ($addschool->getGradeDetails($addschool->id, $classtype) as $itemgrade)
                            <i style="font-size: 10px; font-style: normal;">{{ $itemgrade->gpaname }} = ({{ $itemgrade->marksfrom }}-{{ $itemgrade->marksto }})</i>
                        @endforeach
                    @endif
                </div></center>
                
                <div class="container-fluid">
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <i style="text-decoration: underline; font-style: normal; font-weight: bold;">RATINGS</i>
                    </div>
                </div>
                <br>
    
                <div class="container-fluid">
                    <div style="display: flex; flex-direction: row; width: 100%; margin: 0 auto;">
                        <div class="" style="width: 50%;">
                            {{-- <div style="width: 99%; border: 1px solid black;">Physomoto</div> --}}
                            <div style="width: 99%;">
                                <table style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 10px; width: 50%;">BEHAVIOUR AND ACTIVITIES</th>
                                            <th class="text-center  thdesign1">Marks(1-5)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    
                                        @if ($motolistbeha->count() > 0)
    
                                            @foreach ($motolistbeha as $itemmoto)
                                                <tr>
                                                    <td class="thdesign1"><i style="padding-left: 10px; font-style: normal;">{{ $itemmoto->name }}</i></td>
                                                    <td id="punctuation" class="thdesign1">{{ $itemmoto->getmotoscore($itemmoto->id, $item->id, $schoolsession, $term) }}</td>
                                                </tr>
                                            @endforeach
                                            
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="" style="width: 50%;">
                            <div style="width: 99%;">
                                <table style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 10px; width: 50%;">SKILLS</th>
                                            <th class="text-center  thdesign1">Marks(1-5)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    
                                        @if ($motolistskills->count() > 0)
    
                                            @foreach ($motolistskills as $itemskills)
                                                <tr>
                                                    <td class="thdesign1">{{ $itemskills->name }}</td>
                                                    <td id="punctuation" class="thdesign1">{{ $itemskills->getmotoscore($itemskills->id, $item->id, $schoolsession, $term) }}</td>
                                                </tr>
                                            @endforeach
                                            
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
    
                    </div>
                </div>
    
    
                <br>
                <div class="container-fluid">
                    {{-- <div data-toggle="collapse" data-target="#housemastersremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                        House Master Remark: <i style="font-style: normal;" id="housemastercommentMain"></i>
                    </div> --}}
                    <div style="height: 7px;"></div>
                    <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                        Honours Or Prizes Won: <i style="font-style: normal;" id="honourorpricesremarkmain"></i>
                    </div>
                    <div style="height: 7px;"></div>
                    <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                        Form Master's Remarks <i style="font-style: normal;" id="honourorpricesremarkmain"></i>
                    </div>
                </div>
                <div style="height: 7px;"></div>
                <div class="container-fluid">
                    <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black; font-size: 13px;">
                        Head of School's Comments: 
                        <i style="font-style: normal;" id="honourorpricesremarkmain">
                        @if ($addschool->getResultAverage($item->id, $classid, $term, $schoolsession) != NULL)
        
    
                            @if($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 90 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 100)
                                An excellent performance.
    
                            @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 70 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 89.9)
                                A good performance, reinforce.
    
                            @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 50 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 69.9)
                                An average performance, reinforce.
    
                            @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average/$addschool->getSubjectList($item->id, $schoolsession, $classid, $section, $term)->count() >= 0 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average/$addschool->getSubjectList($item->id, $schoolsession, $classid, $section, $term)->count() <= 49.9)
                                A fairly good performance, advised to repeat.
                            @endif
        
                            
                        @endif
                        
                        </i>
                    </div>
                </div>
    
                <br>
                <div class="container-fluid">
                    <div style="width: 100%; display: flex; flex-direction: row; margin: 0 auto;">
                        <div class="" style="width: 50%; height: 50px; display: flex; flex-direction: row; align-items: center;">
                            {{-- <img src="{{asset('storage/schimages/'.$allDetails['addpost'][0]['schoolprincipalsignature'])}}" alt="" width="90px" height="90px"> --}}
                            <i style="font-size: 13px; font-style: normal;">Head of School's Signature</i></i>
                            <img src="{{asset('storage/schimages/'.$addschool->schoolprincipalsignature)}}" alt="" height="50px">
            
                        </div>
                        <div class="" style="width:50%; height: 50px;">
                            <!--<i style="font-size: 13px; font-style: normal;">Date<i>_________________________________</i></i>-->
                        </div>
                    </div>
                </div>
                </div>
                
            </div>
            @endif

            
        @endforeach






	</body>
</html>					
