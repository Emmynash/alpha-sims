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
        .rotated {
                writing-mode: tb-rl;
                transform: rotate(-180deg);
            }
    </style>

</head>
<body>
    

    <div class="card" style="height: 50px; display: flex; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; right: 0; border-radius: 0px; z-index: 999;">
        <div style="display: flex; flex-direction: row;">
            <a href="/result_view_sec"><button class="btn btn-sm btn-danger" id="btnPrintback" style="margin-right: 10px;">Back</button></a>
            <button class="btn btn-sm btn-success" id="btnPrint">Print Result</button>
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

        <div class="" style="margin-top: 60px;" id="printnotready">
            <div class="" class="" style="width: 794px; margin: 0 auto;">
                <div class="print-container" style="width: 794px;">
                    <div style="display: flex;">
                        <div id="imagelogo" style="width: 25%; height: 100px; display: flex; align-items: center; justify-content: center;">
    
                                {{-- @if ($addschool->schoolLogo != Null) --}}
                                    <img src="https://drive.google.com/thumbnail?id=1BggdEUjriRhGioI0EBUe9X42qFFsJ1jg" alt="" width="90px" height="90px">
                                {{-- @endif --}}
                            
                        </div>
                        <div style="width: 75%; height: 100px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                            <i style="font-size: 30px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">{{$addschool->schoolname}}</i>
                            <i style="font-size: 12px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">{{$addschool->schooladdress}}, {{$addschool->mobilenumber}}</i>
                            <i style="font-size: 15px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;"></i>
                            <div>
                                <i style="font-size: 20px; font-style: normal; font-family: Times New Roman, Times, serif; font-weight: bold;">Junior Secondary School Termly Report</i>
                            </div>
                        </div>
                        
                    </div>
                    <br>
        
                    <div style="display:flex; width: 95%; margin: 0 auto;">
                        <div style="width: 50%;">
                            <div class="" style="width: 95%; display: flex; flex-direction: column; margin: 0 auto;">
                                <table>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Name of Student:</i></td>
                                        <td><i id="studentname" style="font-size: 12px; font-style: normal; font-weight: bold; text-transform:uppercase;">{{ $studentdetails->getStudentName->firstname }} {{ $studentdetails->getStudentName->middlename }} {{ $studentdetails->getStudentName->lastname }}</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Class:</i></td>
                                        <td><i id="studentclass" style="font-size: 12px; font-style: normal; font-weight: bold;">{{ $studentdetails->getClassName->classname }} {{ $studentdetails->getSectionName->sectionname }}</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Next Term Resumes:</i></td>
                                        <td>
                                            @if ($term == 1)
                                                <i style="font-style: normal; font-weight: bold;">{{ $addschool->secondtermstarts }}</i> 
                                            @elseif ($term == 2)
                                                <i style="font-style: normal; font-weight: bold;">{{ $addschool->thirdtermstarts }}</i>
                                            @elseif ($term == 3)
                                                <i style="font-style: normal; font-weight: bold;">{{ $addschool->firsttermstarts }}</i>
                                            @else
                                                <i style="font-style: normal; font-weight: bold;">NAN</i>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Sex:</i></td>
                                        <td><i id="studentgender" style="font-size: 12px; font-style: normal; font-weight: bold;">{{ $studentdetails->gender }}</i></td>
                                    </tr>
                                </table>
                            </div>
        
                        </div>
                        <div style="width: 50%;">
                            <div style="width: 95%; display: flex; flex-direction: column; margin: 0 auto;">
                                <table>
                                    <tr>
                                        <td style="width: 40%;"><i style="font-size: 12px; font-style: normal;">Term:</i></td>
                                        <td><i id="resultterm" style="font-size: 12px; font-style: normal; font-weight: bold;">
                                            @if ($term == 1)
                                                <i style="font-style: normal;">First</i> 
                                            @elseif ($term == 2)
                                                <i style="font-style: normal;">Second</i>
                                            @elseif ($term == 3)
                                                <i style="font-style: normal;">Third</i>
                                            @else
                                                <i style="font-style: normal;">NAN</i>
                                            @endif
                                        </i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Addmission No:</i></td>
                                        <td><i id="regno" style="font-size: 12px; font-style: normal; font-weight: bold;">{{ $studentdetails->admission_no }}</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Position: {{ $resultAverage == NULL ? "NAN":$resultAverage->position }}</i></td>
                                        <td><i id="studentposition" style="font-size: 12px; font-style: normal; font-weight: bold;"> No. in Class {{ $studentdetails->getClassCount($studentdetails->classid, $studentdetails->schoolsession, $studentdetails->studentsection)->count() }}</i></td>
                                    </tr>
                                    <tr>
                                        <td><i style="font-size: 12px; font-style: normal;">Session:</i></td>
                                        <td><i id="querysession" style="font-size: 12px; font-style: normal; font-weight: bold;">{{ $schoolsession }}</i></td>
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
                    <div style="display: flex;">
                        <div style="width: 30%; height: 500px; border: 1px solid black;">
                            <div style="border-bottom: 1px solid black">
                                <i style="font-style: normal;">Subjects</i>
                            </div>
                            <div style="margin-top: 70px; border-top: 1px solid black;">
                                @foreach ($subjects as $item)
                                    <div style="height: 30px; border-bottom: 1px solid black;">
                                        <i style="font-style: normal; font-size: 15px; padding-left: 10px;">{{ $item->subjectname }}</i>
                                    </div>
                                    
                                @endforeach
                            </div>

                        </div>
                        @foreach ($assessments as $item)
                            <div style="height: 500px; border-top: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
                                <div style="border-bottom: 1px solid black">
                                    <center><i style="font-style: normal;">{{ $item->name }}</i></center>
                                </div>
                                <div style="height: 100%; display: flex;">
                                    @foreach ($item->getSubassessments as $itemSub)
                                        
                                        <div style="height: 100%; width:100%; border-right: 1px solid black;">
                                            <div style="border-bottom: 1px solid black; height: 70px;">
                                                <center><i class="rotated" style="writing-mode: vertical-lr; margin: 0px; padding: 5px; font-size: 10px;">{{ $itemSub->subname }}</i></center>
                                            </div>
                                            @foreach ($subjects as $itemsubmarks)
                                            <div style="height: 30px; width: 100%; border-bottom: 1px solid black;">
                                                <center><i style="font-style: normal; padding: 0px 5px 0px 5px;">{{ $itemsubmarks->getSubjectMark($studentdetails->id, $itemsubmarks->id, $schoolsession, $item->id, $itemSub->id) == null ? 0: $itemsubmarks->getSubjectMark($studentdetails->id, $itemsubmarks->id, $schoolsession, $item->id, $itemSub->id)->scrores }}</i></center>
                                            </div>
                                            @endforeach
                                            

                                        </div>
                                    @endforeach

                                    
                                </div>
                            </div>
                        @endforeach
                        <div style="width: 10%; height: 500px; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black;">
                            <div style="border-bottom: 1px solid black">
                                <i style="font-style: normal;">Total</i>
                            </div>
                            <div style="margin-top: 70px; border-top: 1px solid black;">
                                @foreach ($subjects as $itemsubmarks)
                                    <div style="height: 30px; width: 100%; border-bottom: 1px solid black;">
                                        <center><i style="font-style: normal; padding: 0px 5px 0px 5px;">0</i></center>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <div style="width: 10%; height: 500px; border: 1px solid black;">
                            <div style="border-bottom: 1px solid black">
                                <i style="font-style: normal;">Grades</i>
                            </div>

                        </div>
                        
                    </div>
                    <br>
                    <div style="">
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Exam Total: {{ round(empty($resultAverage) ? "NAN":$resultAverage->sumofmarks, 2) }}</i>
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Student Average: {{ round(empty($resultAverage) ? "NAN":$resultAverage->average, 2) }}</i>
                        <i style="margin: 10px 0px 0px 50px; font-style: normal;">Final Grade: {{ $addschool->getGrade(empty($resultAverage) ? "NAN":$resultAverage->average, $studentClass->classtype) }}</i>
                    </div>
                    <center><div class="text-center" style="width: 95%; margin: 10px auto;">
                        @if ($addschool->getGradeDetails($addschool->id, $studentClass->classtype)->count() > 0)
                            @foreach ($addschool->getGradeDetails($addschool->id, $studentClass->classtype) as $item)
                                <i style="font-size: 10px; font-style: normal;">{{ $item->gpaname }} = ({{ $item->marksfrom }}-{{ $item->marksto }})</i>
                            @endforeach
                        @endif
                    </div></center>
                    {{-- <div style="width: 95%; margin: 3px auto;">
                        @if ($addschool->getGradeDetails($addschool->id, $studentClass->classtype)->count() > 0)
                            @foreach ($addschool->getGradeDetails($addschool->id, $studentClass->classtype) as $item)
                                <i style="font-size: 10px; font-style: normal;">({{ $item->marksfrom }}-{{ $item->marksto }}) = {{ $item->point }}</i>
                            @endforeach
                        @endif
                    </div> --}}
                    {{-- <div style="width: 95%; margin: 3px auto;">
                        @if ($addschool->getGradeDetails($addschool->id, $studentClass->classtype)->count() > 0)
                            @foreach ($addschool->getGradeDetails($addschool->id, $studentClass->classtype) as $item)
                            <i style="font-size: 10px; font-style: normal;">{{ $item->gpaname }} = {{ $item->remark }}</i>
                            @endforeach
                        @endif
                    </div> --}}
                    <div style="display: flex; align-items: center; justify-content: center;">
                        <i style="text-decoration: underline; font-style: normal; font-weight: bold;">RATINGS</i>
                    </div>
                    <br>
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
                        <div data-toggle="collapse" data-target="#housemastersremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            House Master Remark: <i style="font-style: normal;" id="housemastercommentMain"></i>
                        </div>
                        {{-- <div style="width: 95%; margin: 0 auto;" id="housemastersremark" class="collapse">
                            <center><input type="text" onkeydown="housemastercomment(this)" style="width: 95%; margin-top: 2px;" placeholder="From teacher comment"></center>
                        </div> --}}
    
                        <br>
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            Honours Or Prizes Won: <i style="font-style: normal;" id="honourorpricesremarkmain"></i>
                        </div>
                        {{-- <div style="width: 95%; margin: 0 auto;" id="honourorpricesremark" class="collapse">
                            <center><input type="text" onkeydown="honourorprices(this)" style="width: 95%; margin-top: 2px;" placeholder="From teacher comment"></center>
                        </div> --}}
                        <br>
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            Form Master's Remarks <i style="font-style: normal;" id="honourorpricesremarkmain"></i>
                        </div>
                        <br>
                        <div data-toggle="collapse" data-target="#honourorpricesremark" style="width: 95%; margin: 0 auto; border-bottom: 1px solid black;">
                            Principal's Comments: 
                            <i style="font-style: normal;" id="honourorpricesremarkmain">
                            @if ($resultAverage != NULL)
    
                                @if ($resultAverage->average >= 90 && $resultAverage->average <= 100)
                                    An Outstanding performance. Keep it up.
                                @elseif($resultAverage->average >= 80 && $resultAverage->average <= 89.9)
                                    An excellent performance. Keep it up.
    
                                @elseif($resultAverage->average >= 75 && $resultAverage->average <= 79.9)
                                    A very good performance. Keep it up.
    
                                @elseif($resultAverage->average >= 70 && $resultAverage->average <= 74.9)
                                    A good performance but can still do better
    
                                @elseif($resultAverage->average >= 65 && $resultAverage->average <= 69.9)
                                    A good performance but can still do better
    
                                @elseif($resultAverage->average >= 60 && $resultAverage->average <= 64.5)
                                    Fairly good performance but can still do better
    
                                @elseif($resultAverage->average >= 55 && $resultAverage->average <= 59.9)
                                    A fair performance. Needs to pay more attention to studies.
    
                                @elseif($resultAverage->average >= 50 && $resultAverage->average <= 54.9)
                                    An average performance. Needs to pay more attention to studies.
    
                                @elseif($resultAverage->average >= 45 && $resultAverage->average <= 49.9)
                                    An average performance. Needs to pay more attention to studies.
    
                                @elseif($resultAverage->average >= 40 && $resultAverage->average <= 44.9)
                                    A poor performance. Please sit up.
    
                                @elseif($resultAverage->average/$subjects->count() >= 0 && $resultAverage->average/$subjects->count() <= 39.9)
                                    A very poor performance. Please sit up.
                                @endif
    
                                
                            @endif
                            
                            </i>
                        </div>
                        
                    </div>
                    <br>
                    <div style="width: 95%; display: flex; flex-direction: row; margin: 0 auto;">
                        <div class="" style="width: 50%; height: 50px; display: flex; flex-direction: row; align-items: center;">
                            {{-- <img src="{{asset('storage/schimages/'.$allDetails['addpost'][0]['schoolprincipalsignature'])}}" alt="" width="90px" height="90px"> --}}
                            <i style="font-size: 13px; font-style: normal;">Principal Signature's</i></i>
                            <img src="{{asset('storage/schimages/'.$addschool->schoolprincipalsignature)}}" alt="" height="50px">
    
                        </div>
                        <div class="" style="width:50%; height: 50px;">
                            <!--<i style="font-size: 13px; font-style: normal;">Date<i>_________________________________</i></i>-->
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