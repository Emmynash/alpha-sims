<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alpha-Sims Result Print</title>
    <link rel="stylesheet" href="{{ asset('css/print_sec.css') }} ">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <style>
        @media print {

            #btnPrintback,
            #btnPrint {
                display: none;
            }
        }
    </style>
</head>

<body>


    <div class="card" style="height: 35px; display: flex; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; border-radius: 0px; z-index: 999;">
        <div style="display: flex; flex-direction: row;">
            <a href="/sec/result/result_by_class"><button class="btn btn-sm btn-danger" id="btnPrintback" style="margin-right: 10px;">Back</button></a>
            <button class="btn btn-sm btn-success" id="btnPrint" onclick="window.print();return false">Print Result</button>
        </div>
    </div>

    <div id="resultspinner" style="display: none; justify-content: center; align-content: center; margin-top: 120px;">
        <div class="spinner-border"></div>
    </div>


    <div class="container" id="alertresult" style="display: none;">
        <div class="alert alert-danger" style="margin-top: 60px;">
            <strong>Info!</strong> your result is not ready yet. Please, bear with us.
        </div>
    </div>

    <div id="printJS-form">

        <div class="" style="margin-top: 20px;" id="printnotready">
            <div class="" class="" style="width: 794px; margin: 0 auto;">
                <div class="print-container" style="width: 794px; margin: 0;">
                    <div style="display: flex;">
                        <div id="imagelogo" style="width: 25%; height: 100px; display: flex; align-items: center; justify-content: center;">

                            @if ($addschool->schoolLogo != Null)
                            <img src="{{ $addschool->schoolLogo }}" alt="" width="90px" height="90px">
                            @endif

                        </div>
                        <div style="width: 75%; height: 100px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <div style="width: 75%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                <center><i style="font-size: 25px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold; text-transform: uppercase;">{{$addschool->schoolname}}</i></center>
                                <i style="font-size: 12px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">{{$addschool->schooladdress}}, {{$addschool->mobilenumber}}</i>
                                <i style="font-size: 15px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;"></i>
                                <div>
                                    <i style="font-size: 20px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">Termly Report Sheet</i>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>

                    <div style="display:flex; width: 95%; margin: 0 auto;">
                        <div style="width: 50%;">
                            <div class="" style="width: 95%; display: flex; flex-direction: column; margin: 0 auto;">
                                <table>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">Name of Student:</i></td>
                                        <td><i id="studentname" style="font-size: 14px; font-style: normal; font-weight: bold; text-transform:uppercase;">Name</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">Class:</i></td>
                                        <td><i id="studentclass" style="font-size: 14px; font-style: normal; font-weight: bold;">{{ $studentdetails->getClassName->classname }} {{ $studentdetails->getSectionName->sectionname }}</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">Next Term Resumes:</i></td>
                                        <td>
                                            {{$nextTermBegins}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">Sex:</i></td>
                                        <td><i id="studentgender" style="font-size: 14px; font-style: normal; font-weight: bold;">{{ $studentdetails->gender }}</i></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div style="width: 50%;">
                            <div style="width: 95%; display: flex; flex-direction: column; margin: 0 auto;">
                                <table>
                                    <tr>
                                        <td style="width: 40%;"><i style="font-size: 14px; font-style: normal;">Term:</i></td>
                                        <td><i id="resultterm" style="font-size: 14px; font-style: normal; font-weight: bold;">
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">Admission No:</i></td>
                                        <td><i id="regno" style="font-size: 14px; font-style: normal; font-weight: bold;">{{ $studentdetails->admission_no }}</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">No in Class : </i></td>
                                        <td><i id="studentposition" style="font-size: 14px; font-style: normal; font-weight: bold;">{{$studentClass->getClassCount($classid)}} </i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 14px; font-style: normal;">Session:</i></td>
                                        <td><i id="querysession" style="font-size: 14px; font-style: normal; font-weight: bold;">{{ $schoolsession }}</i></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <i style="text-decoration: underline; font-style: normal; font-weight: bold;">ACADEMIC RECORDS</i>
                    </div>
                    <br>
                    <div>
                        <table style="width: 95%; margin: 0 auto;" id="category">
                            <thead style="text-align: center;">
                                <tr>
                                    <th style="font-size: 14px;">SUBJECTS</th>
                                    @foreach ($assessment as $item)
                                    @if( $item->name === "Assignment" && $item->getAssessment($item->id) <= 1) <th class="text-center" colspan="{{ $item->getAssessment($item->id) }}">
                                        <i style="margin: 0px; padding: 5px; font-size: 14px;">Ass</i>
                                        </th>
                                        @endif
                                        @if(str_word_count($item->name) > 1)
                                        <th class="text-center" colspan="{{ $item->getAssessment($item->id) }}">
                                            <i style="margin: 0px; padding: 5px; font-size: 14px;">
                                                {{explode(' ', $item->name)[0] }}
                                                </br>
                                                {{explode(' ', $item->name)[1]}}
                                            </i>
                                        </th>
                                        @elseif(str_word_count($item->name) == 1)
                                        <th class="text-center" colspan="{{ $item->getAssessment($item->id) }}">
                                            <i style="margin: 0px; padding: 5px; font-size: 14px;">{{$item->name}}</i>
                                        </th>
                                        @endif
                                        @endforeach
                                        <th class="text-center"><i style="margin: 0px; padding: 5px; font-size: 14px;">Total</i></th>
                                        <th class="text-center"><i style="margin: 0px; padding: 5px; font-size: 14px;">Average</i></th>
                                        <th class="text-center"><i style="margin: 0px; padding: 5px; font-size: 14px;">Grade</i></th>
                                        <th class="text-center"><i style="margin: 0px; padding: 5px; font-size: 14px;">Pos</i></th>
                                </tr>
                            </thead>
                            <tbody id="resultprinttable">
                                <tr style='font-size: 14px;'>
                                    <th style='font-size: 14px; text-align:center; font-weight:bold;'></th>
                                    @foreach ($subCatAss as $ass)
                                    <th style='font-size: 14px; text-align:center;'>{{$ass->maxmarks}}</th>
                                    @endforeach
                                    <th class='' style='font-size: 14px;'></th>
                                    <th class='' style='font-size: 14px;'></th>
                                    <th class='' style='font-size: 14px;'></th>
                                    <th class='' style='font-size: 14px;'></th>
                                </tr>


                                @foreach ($resultMain as $item)

                                <tr style='font-size: 14px;'>
                                    <td class='' style='font-size: 14px;'>{{ $item->subjectname }}</td>
                                    @foreach ($assessment as $itemA)
                                    @foreach ($itemA->getAssessmentForScore($itemA->id) as $itemB)
                                    <td class='text-center' style='font-size: 14px;'>
                                        <center>{{ $itemB->getScore($itemB->id, $classid, $regNo, $item->subjectid, $schoolsession ) == NULL ? "---":$itemB->getScore($itemB->id, $classid, $regNo, $item->subjectid, $schoolsession )->scrores }}</center>
                                    </td>
                                    @endforeach
                                    @endforeach
                                    <td class='text-center thdesign' style='font-size: 14px;'>
                                        <center>{{ $item->getAssessmentsTotal($item->id) == NULL ? "---":$item->getAssessmentsTotal($item->id)->total }}</center>
                                    </td>
                                    <td class='text-center thdesign' style='font-size: 14px;'>
                                        <center>{{ $item->getAssessmentsTotal($item->id) == NULL ? "---":round($item->getAssessmentsTotal($item->id)->average, 1) }}</center>
                                    </td>
                                    <td class='text-center thdesign' style='font-size: 14px;'>
                                        <center>{{ $item->getAssessmentsTotal($item->id) == NULL ? "---":$item->getAssessmentsTotal($item->id)->grade }}</center>
                                    </td>
                                    <td class='text-center thdesign' style='font-size: 14px;'>
                                        <center>{{ $item->getStudentRecord($item->subjectid, $schoolsession, $regNo) == NULL ? "---":$item->getStudentRecord($item->subjectid, $schoolsession, $regNo)->position }}</center>
                                    </td>
                                <tr>

                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div>
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Grand Total: {{ $computedAverage == NULL ? "N.A": round($computedAverage->examstotal, 2)}}</i>
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Student/Pupil Average: {{ $computedAverage == NULL ? "N.A": round($computedAverage->studentaverage, 2)}}</i>
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Class Average: {{ $scoresGrandTotal == NULL ? "N.A": round(($scoresGrandTotal / (count($studentdetails->getStudentsArray($classid, $studentdetails->studentsection)) * count($resultMain))), 2)}}</i>
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Position: Nill</i>
                    </div>
                    <center>
                        <div class="text-center" style="width: 95%; margin: 10px auto;">
                            @if ($addschool->getGradeDetails($addschool->id, $studentClass->classtype)->count() > 0)
                            @foreach ($addschool->getGradeDetails($addschool->id, $studentClass->classtype) as $item)
                            <i style="font-size: 13px; font-style: normal;">{{ $item->gpaname }} = ({{ $item->marksfrom }}-{{ $item->marksto }}),</i>
                            @endforeach
                            @endif
                        </div>
                    </center>
                    <!-- <div style="width: 95%; margin: 3px auto;">
                        @if ($addschool->getGradeDetails($addschool->id, $studentClass->classtype)->count() > 0)
                        @foreach ($addschool->getGradeDetails($addschool->id, $studentClass->classtype) as $item)
                        <i style="font-size: 10px; font-style: normal;">{{ $item->gpaname }} = {{ $item->remark }}</i>
                        @endforeach
                        @endif
                    </div> -->
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <i style="text-decoration: underline; font-style: normal; font-weight: bold;">RATINGS</i>
                    </div>
                    <br>

                    <center>
                        <div style="width: 95%; margin: 3px auto;">
                            <i style="font-size: 13px; font-style: normal;">Excellent = <b>5</b>,</i>
                            <i style="font-size: 13px; font-style: normal;">Very good = <b>4</b>,</i>
                            <i style="font-size: 13px; font-style: normal;">Good = <b>3</b>,</i>
                            <i style="font-size: 13px; font-style: normal;">Average = <b>2</b>,</i>
                            <i style="font-size: 13px; font-style: normal;">Fair = <b>1</b></i>
                        </div>
                    </center>

                    <div>

                        <div>
                            <div style="display: flex; flex-direction: row; width: 95%; margin: 0 auto;">
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

                                                @foreach ($motolistbeha as $item)
                                                <tr>
                                                    <td class="thdesign1">{{ $item->name }}</td>
                                                    <td id="punctuation" class="thdesign1">{{ $item->getmotoscore($item->id, $studentdetails->id, $schoolsession, $term) }}</td>
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

                                                @foreach ($motolistskills as $item)
                                                <tr>
                                                    <td class="thdesign1">{{ $item->name }}</td>
                                                    <td id="punctuation" class="thdesign1">{{ $item->getmotoscore($item->id, $studentdetails->id, $schoolsession, $term) }}</td>
                                                </tr>
                                                @endforeach

                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <br>
                    <div>
                        {{-- <div data-toggle="collapse" data-target="#teachersremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            Form Teacher Remark: <i style="font-style: normal;" id="teacherscommentMain"></i>
                        </div> --}}

                        {{-- <div style="width: 95%; margin: 0 auto;" id="teachersremark" class="collapse">
                            <center><input type="text" onkeydown="teachercomment(this)" style="width: 95%; margin-top: 2px;" placeholder="From teacher comment"></center>
                        </div> --}}

                        <br>
                        {{-- <div data-toggle="collapse" data-target="#housemastersremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            House Master Remark: <i style="font-style: normal;" id="housemastercommentMain"></i>
                        </div> --}}
                        {{-- <div style="width: 95%; margin: 0 auto;" id="housemastersremark" class="collapse">
                            <center><input type="text" onkeydown="housemastercomment(this)" style="width: 95%; margin-top: 2px;" placeholder="From teacher comment"></center>
                        </div> --}}

                        <br>
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            FORM TEACHER'S REMARK:
                            <i style="font-style: normal;" id="honourorpricesremarkmain">
                                {{ $addschool->getStudentComment($regNo, $classid, $term, $schoolsession) == null ? "":$addschool->getStudentComment($regNo, $classid, $term, $schoolsession)->comments }}
                            </i>
                        </div>
                        <br>
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            HEAD OF SCHOOL'S COMMENT:
                            <i style="font-style: normal;" id="honourorpricesremarkmain">
                                @if ($computedAverage != NULL)

                                @if($computedAverage->studentaverage >= 90 && $computedAverage->studentaverage <= 100) An excellent performance. @elseif($computedAverage->studentaverage >= 70 && $computedAverage->studentaverage <= 89.9) A good performance, reinforce. @elseif($computedAverage->studentaverage >= 50 && $computedAverage->studentaverage <= 69.9) An average performance, reinforce. @elseif($computedAverage->studentaverage >= 0 && $computedAverage->studentaverage <= 49.9) A fairly good performance, advised to repeat. @endif @endif </i>
                        </div>

                    </div>
                    <br>
                    <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                        HEAD OF SCHOOL'S SIGNATURE:
                        <i style="font-style: normal;" id=""><img src="{{$addschool->schoolprincipalsignature}}" alt="" srcset="" height="50px"></i>
                    </div>

                    <br>
                    <div style="display: flex;">
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 45%; margin: 0 auto; border-bottom: 1px solid black;">
                            NEXT TERM BEGINS:
                            <i style="font-style: normal;" id="honourorpricesremarkmain">
                                {{$nextTermBegins}}
                            </i>
                        </div>
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 45%; margin: 0 auto; border-bottom: 1px solid black;">
                            NEXT TERM ENDS:
                            <i style="font-style: normal;" id="honourorpricesremarkmain">
                                {{$nextTermEnds}}
                            </i>
                        </div>
                    </div>
                    {{-- <div style="width: 95%; display: flex; flex-direction: row; margin: 0 auto;">
                        <div class="" style="width: 50%; height: 50px; display: flex; flex-direction: row; align-items: center;">
                            <i style="font-size: 13px; font-style: normal;">Head of School's Signature</i></i>
                            <img src="{{ $addschool->schoolprincipalsignature }}" alt="" height="50px">

                </div> --}}
                {{-- <div class="" style="width:50%; height: 50px;"> --}}
                <!--<i style="font-size: 13px; font-style: normal;">Date<i>_________________________________</i></i>
                        </div>
                    </div>
    
    
    
                </div>
    
            </div>
        </div>
    
        {{-- <div class="card" style="height: 50px; margin-top: 20px; border-radius: 0px;">
    
        </div> --}}
            
        
    </div>

    
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function () {
            $("#btnPrint").click(function () {
                var contents = $("#printJS-form").html();
                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({ "position": "absolute", "top": "-1000000px" });
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                //Create a new HTML document.
                frameDoc.document.write('<html><head><title></title>');
                frameDoc.document.write('</head><body>');
                //Append the external CSS file.
                frameDoc.document.write('<link href="{{ asset('css/print_sec.css') }}" rel="stylesheet" type="text/css" />');
                //Append the DIV contents.
                frameDoc.document.write(contents);
                frameDoc.document.write('</body></html>');
                frameDoc.document.close();
                setTimeout(function () {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                }, 500);
            });
        });

        function teachercomment(comment){

            document.getElementById('teacherscommentMain').innerHTML = comment.value
            
        }

        function housemastercomment(comment){

            document.getElementById('housemastercommentMain').innerHTML = comment.value

        }

        function honourorprices(comment){
            document.getElementById('honourorpricesremarkmain').innerHTML = comment.value
        }

        var sum1 = 0;

        $("#category tr").not(':first').not(':last').each(function() {
        sum1 +=  getnum($(this).find("td:eq(4)").text());

        function getnum(t){
            if(isNumeric(t)){
                return parseInt(t,10);
            }
            return 0;
                function isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
                }
        }
        });

        $("#sum1").text(sum1);


    </script>
</body>
</html>