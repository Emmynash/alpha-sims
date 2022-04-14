@extends('layouts.app_sec')

@section('content')

@include('layouts.aside_sec')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Form Teacher Setting</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Form Teacher"
                data-content="Form teachers can manage there students subject record and ensure all data for each record has been entered before result is generated.">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">My Subjects</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          
          @include('layouts.message')


        <div class="card" style="border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">

            <div class="card" style="margin: 10px; border-radius: 0px;">
              <div class="row">
                <div class="col-12 col-md-4">
                  <div class="card" style="margin: 5px;">
                    <div style="display: flex; flex-direction: column; align-items: left;">
                      <i style="padding: 10px 0px 0px 10px; font-style: normal; font-size: 12px;">Classname</i>
                      <i style="padding: 5px 0px 5px 10px; font-style: normal;">{{ $formClass->getClassName->classname }}</i>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4"> 
                  <div class="card" style="margin: 5px;">
                    <div style="display: flex; flex-direction: column; align-items: left;">
                      <i style="padding: 10px 0px 0px 10px; font-style: normal; font-size: 12px;">Section</i>
                      <i style="padding: 5px 0px 5px 10px; font-style: normal;">{{ $formClass->getSectionName->sectionname }}</i>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-4"> 
                  <div class="card" style="margin: 5px;">
                    <div style="display: flex; flex-direction: column; align-items: left;">
                      <i style="padding: 10px 0px 0px 10px; font-style: normal; font-size: 12px;">Class Count</i>
                      <i style="padding: 5px 0px 5px 10px; font-style: normal;">{{ $formClass->getClassCount($formClass->class_id) }}</i>
                    </div>
                  </div>
                </div>

              </div>
            </div>


            <div class="container">
              <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Info!</strong> Click on the notify button below to send a notification the admin that all results in your class has been processed...
              </div>
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#notifymodal">Notify</button>
              <a href="{{ route('view_student_form', ['classid'=>$formClass->class_id, 'sectionid'=>$formClass->form_id]) }}"><button class="btn btn-success btn-sm">View Student </button></a>
              <hr>
            </div>


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">My Subjects</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append"> 
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Subject</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($formClass->getSubjectList($formClass->class_id)) > 0)
                      @foreach ($formClass->getSubjectList($formClass->class_id) as $subjects)
                        <tr>
                          <td>{{$subjects->subjectname}} {{$subjects->subjectcode}}</td>
                          @if (in_array($subjects->id, $arrayOfSubjectId))
                          <td>Done</td>
                          <td><button class="btn btn-sm btn-success" data-toggle="modal" data-target=""><i class="fas fa-check"></i></button> </td>
                          @else
                          <td>Pending</td>
                          <td><button class="btn btn-sm btn-danger"><i class="fas fa-stop"></i></button> </td>
                          @endif
                      

                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->


        </div>


          <!-- The Modal -->
          <div class="modal fade" id="notifymodal">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Send Notification</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  <p>Notify the admin that all marks for each subject has been entered</p>
                  <form action="{{ route('form_teacher_result_confirm') }}" method="post" id="formTeachSubjectEnteredConfirm">
                    @csrf
                    <input type="hidden" name="classid" value="{{ $formClass->getClassName->id }}">
                    <input type="hidden" name="sectionid" value="{{ $formClass->getSectionName->id }}" id="">
                  </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-info btn-sm" form="formTeachSubjectEnteredConfirm">Proceed</button>
                  <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
                
              </div>
            </div>
          </div>




  
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('formmasteroption').className = "nav-link active"
      }
  </script>
    
@endsection