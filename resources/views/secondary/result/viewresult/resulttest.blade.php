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

            .textfontstyle{
                font-size: 13px;
            }
		</style>
	</head>
	
	<body>

        @foreach ($studentInClass as $item)

        <div class="page-break">

            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-2">
                        <div style="margin:0 auto;">
                            <div id="imagelogo" style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center;">
        
                                    {{-- @if ($addschool->schoolLogo != Null) --}}
                                        <img src="https://drive.google.com/thumbnail?id=1BggdEUjriRhGioI0EBUe9X42qFFsJ1jg" alt="" width="90px" height="90px">
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
                                    <i style="font-size: 20px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">Junior Secondary School Termly Report</i>
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
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                                Name of Student: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->getStudentName->firstname }} {{ $item->getStudentName->middlename }} {{ $item->getStudentName->lastname }}</i>
                            </div>
                            <div style="height: 7px;"></div>
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                                Class: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->getClassName->classname }} {{ $item->getSectionName->sectionname }}</i>
                            </div>
                            <div style="height: 7px;"></div>
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
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
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                                Sex: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->gender }}</i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="width: 95%; margin:0 auto;">
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
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
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                                Admission No: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $item->admission_no }}</i>
                            </div>
                            <div style="height: 7px;"></div>
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                                Position: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $addschool->getResultAverage($item->id, $classid, $term, $schoolsession) == NULL ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->position }} No. in Class {{ $item->getClassCount($item->classid, $item->schoolsession, $item->studentsection)->count() }}</i>
                            </div>
                            <div style="height: 7px;"></div>
                            <div class="textfontstyle" data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                                Session: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $schoolsession }}</i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <br>

            <div class="container-fluid">
                <div style="display: flex; align-items: center; justify-content: center; height: 10px;">
                    <i class="textfontstyle" style="text-decoration: underline; font-style: normal; font-weight: bold;">ACCADEMIC RECORDS</i>
                </div>
            </div>

            <br>

            <div class="container-fluid">
                <table style="width: 100%; margin: 0 auto;" id="category">
                    <thead style="text-align: center;">
                        <tr>
                            <th class="textfontstyle" style="width: 100px;">SUBJECTS</th>
                           
                                {{-- <th class="text-center  thdesign"><i class="rotated" class="text-center" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Class Assignment</p></th> --}}
                            
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">First CA</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Second CA</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">EXAM SCORE</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">TOTAL MARK</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Points</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Average</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">POSITION</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Grade</i></th>
                            <th class="text-center  thdesign textfontstyle"><i style="">Teacher</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">1st term</i>
                                {{-- <i style="font-size: 12px;">Year Summary</i>
                                <table style="width: 100%; margin: 0 auto;">
                                    <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">1st term</i></th>
                                    <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">2nd term</i></th>
                                    <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">3rd term</i></th>
                                    <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Avg. Score</i></th> --}}
                                    {{-- <th class="text-center  thdesign"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">Position</i></th> --}}
                                {{-- </table> --}}
                            </th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">2nd term</i></th>
                            <th class="text-center  thdesign textfontstyle"><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px;">3rd term</i></th>

                        </tr>
                    </thead>
                    <tbody id="resultprinttable">

                        @foreach ($addschool->getSubjectList($item->id, $schoolsession, $classid, $section, $term) as $subjects)

                        <tr style='width: 150px;'>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $subjects->subjectname }}</center></td>
                            @if ($addschool->caset == 1)
                                <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $subjects->getSubjectMark($item->id, $subjects->id, $schoolsession)->ca3 }}</center></td>
                            @endif
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->ca2 }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->ca1 }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->exams }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->totalmarks }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getPoints($addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->totalmarks) == NULL ? "0": $addschool->getPoints($addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->totalmarks) }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getClassAverageMarkSubject($subjects->id, $term, $schoolsession) == NULL ? "0":round($addschool->getClassAverageMarkSubject($subjects->id, $term, $schoolsession)->average, 1) }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->position }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession) == NULL ? "0": $addschool->getSubjectMark($item->id, $subjects->id, $schoolsession)->grades }}</center></td>
                            <td class='text-center thdesign textfontstyle' style=''><center>{{ $addschool->getTeacherName($subjects->id) }}</td>
                            <td class='text-center thdesign textfontstyle'><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 1, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 1, $item->id)->totalmarks }}</i>
                                {{-- <table style="width: 100%; margin: 0 auto;">
                                    <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 1, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 1, $item->id)->totalmarks }}</i></th>
                                    <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 2, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 2, $item->id)->totalmarks }}</i></th>
                                    <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 3, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 3, $item->id)->totalmarks }}</i></th>
                                    <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getAverageScore($subjects->id, $schoolsession, $item->id) == NULL ? "0":round($addschool->getAverageScore($subjects->id, $schoolsession, $item->id)) }}</i></th> --}}
                                    {{-- <th><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;"></i></th> --}}
                                {{-- </table> --}}
                            </td>
                            <td class='text-center thdesign textfontstyle'><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 2, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 2, $item->id)->totalmarks }}</i>
                            <td class='text-center thdesign textfontstyle'><i class="text-center" style="margin: 0px; padding: 10px; font-style: normal; font-weight: normal;">{{ $addschool->getResultSummary($subjects->id, $schoolsession, 3, $item->id) == NULL ? "0":$addschool->getResultSummary($subjects->id, $schoolsession, 3, $item->id)->totalmarks }}</i>
                        <tr>
                            
                        @endforeach
                



                        
                    </tbody>
                </table>
            </div>
            <br>
            
            <div class="textfontstyle" style="container-fluid">
                <i style="margin: 10px 0px 0px 50px; font-style: normal;">Exam Total: <i id="sum1" style="margin: 10px 0px 0px 5px; font-style: normal;">{{ round(empty($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)) ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->sumofmarks, 2) }}</i></i>
                @if ($addschool->term == "3")
                    <i style="margin: 10px 0px 0px 50px; font-style: normal;">Sessional Avg: {{ $addschool->getPromoAverage($item->id, $classid, $term, $schoolsession) == NULL ? "NAN":round($addschool->getPromoAverage($item->id, $classid, $term, $schoolsession)->promomarks, 2) }}</i>
                @endif
                <i style="margin: 10px 0px 0px 50px; font-style: normal;">Student Average: {{ round(empty($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)) ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average, 2) }}</i>
                <i style="margin: 10px 0px 0px 50px; font-style: normal;">Final Grade: {{ $addschool->getGrade(empty($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)) ? "NAN":$addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average, $classtype) }}</i>
            </div>
            
            <center><div class="text-center textfontstyle" style="width: 95%; margin: 10px auto;">
                @if ($addschool->getGradeDetails($addschool->id, $classtype)->count() > 0)
                    @foreach ($addschool->getGradeDetails($addschool->id, $classtype) as $itemgrade)
                        <i style="font-style: normal;">{{ $itemgrade->gpaname }} = ({{ $itemgrade->marksfrom }}-{{ $itemgrade->marksto }})</i>
                    @endforeach
                @endif
            </div></center>
            
            <div class="container-fluid textfontstyle">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <i style="text-decoration: underline; font-style: normal; font-weight: bold;">RATINGS</i>
                </div>
            </div>
            <br>

            <div class="container-fluid textfontstyle">
                <div style="display: flex; flex-direction: row; width: 100%; margin: 0 auto;">
                    <div class="textfontstyle" style="width: 50%;">
                        {{-- <div style="width: 99%; border: 1px solid black;">Physomoto</div> --}}
                        <div style="width: 99%;">
                            <table style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 50%;">BEHAVIOUR AND ACTIVITIES</th>
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
                    <div class="textfontstyle" style="width: 50%;">
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
            <div class="container-fluid textfontstyle">
                <div data-toggle="collapse" data-target="#housemastersremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                    House Master Remark: <i style="font-style: normal;" id="housemastercommentMain"></i>
                </div>
                <div style="height: 7px;"></div>
                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                    Honours Or Prizes Won: <i style="font-style: normal;" id="honourorpricesremarkmain"></i>
                </div>
                <div style="height: 7px;"></div>
                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                    Form Master's Remarks: <i style="font-style: normal;" id="honourorpricesremarkmain">{{ $addschool->getStudentComment($item->id, $classid, $term, $schoolsession) == null ? "":$addschool->getStudentComment($item->id, $classid, $term, $schoolsession)->comments }}</i>
                </div>
            </div>
            <div style="height: 7px;"></div>
            <div class="container-fluid textfontstyle">
                <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                    Principal's Comments: 
                    <i style="font-style: normal;" id="honourorpricesremarkmain">
                    @if ($addschool->getResultAverage($item->id, $classid, $term, $schoolsession) != NULL)
    
                        @if ($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 90 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 100)
                            An Outstanding performance. Keep it up.
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 80 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 89.9)
                            An excellent performance. Keep it up.
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 75 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 79.9)
                            A very good performance. Keep it up.
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 70 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 74.9)
                            A good performance but can still do better
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 65 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 69.9)
                            A good performance but can still do better
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 60 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 64.5)
                            Fairly good performance but can still do better
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 55 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 59.9)
                            A fair performance. Needs to pay more attention to studies.
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 50 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 54.9)
                            An average performance. Needs to pay more attention to studies.
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 45 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 49.9)
                            An average performance. Needs to pay more attention to studies.
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average >= 40 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average <= 44.9)
                            A poor performance. Please sit up.
    
                        @elseif($addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average/$addschool->getSubjectList($item->id, $schoolsession, $classid, $section, $term)->count() >= 0 && $addschool->getResultAverage($item->id, $classid, $term, $schoolsession)->average/$addschool->getSubjectList($item->id, $schoolsession, $classid, $section, $term)->count() <= 39.9)
                            A very poor performance. Please sit up.
                        @endif
    
                        
                    @endif
                    
                    </i>
                </div>
            </div>
            <br>
            <div class="container-fluid textfontstyle">
                <div style="height: 7px;"></div>
                <div data-toggle="collapse" data-target="#housemastersremark" style="width: 100%; margin: 0 auto; border-bottom: 1px solid black;">
                    <i style="font-style: normal;" id="housemastercommentMain"></i>
                </div>
                <div style="height: 7px;"></div>
            </div>

            <br>
            <div class="container-fluid textfontstyle">
                <div style="width: 100%; display: flex; flex-direction: row; margin: 0 auto;">
                    <div class="" style="width: 50%; height: 50px; display: flex; flex-direction: row; align-items: center;">
                        {{-- <img src="{{asset('storage/schimages/'.$allDetails['addpost'][0]['schoolprincipalsignature'])}}" alt="" width="90px" height="90px"> --}}
                        <i style="font-style: normal;">Principal Signature's</i></i>
                        <img src="{{asset('storage/schimages/'.$addschool->schoolprincipalsignature)}}" alt="" height="50px">
        
                    </div>
                    <div class="" style="width:50%; height: 50px;">
                        <!--<i style="font-size: 13px; font-style: normal;">Date<i>_________________________________</i></i>-->
                    </div>
                </div>
            </div>
            </div>
            
        </div>

            
        @endforeach






	</body>
</html>					
