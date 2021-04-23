@extends('layouts.app_dash')

@section('content')

{{-- aside menu --}}
  <!-- Main Sidebar Container -->
  @include('layouts.asideside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div style="width: 90%; margin: 0 auto; padding-top: 10px;">
      @include('layouts.message')
    </div>
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Subject</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- SELECT2 EXAMPLE -->

        <div class="card card-default">
            <!-- /.card-header -->
            <div id="subjectform" class="card-body">
              <div id="subjectprocess" style="display:none;">
                <div style="position: absolute; top: 0; bottom: 0; right: 0; left:0; background-color: #fff; z-index: 999; opacity: 0.5; display: flex; align-items: center; justify-content: center;">
                  <div style="width: 100px; height: 100px;" class="spinner-border"></div>
                </div>
              </div>

              @if (count($addsubject) < 1)
                  <div id="projectalert" class="alert alert-info alert-block">
                    {{-- <button type="button" class="close" data-dismiss="alert">×</button>	 --}}
                    <i class="fas fa-exclamation-circle"></i><strong id="subjectalertmessage"> It seem you haven't added a subject. Add using the form below</strong>
                  </div>
              @endif
              
              <div class="row">
                <div class="col-md-6">
                      <form action="javascript:console.log('submitted');" method="post" id="addsubject">
                          @csrf
                              <div class="form-group">
                              <input id="subjectcode" name="subjectcode" style="border: none; background-color:#EEF0F0; text-transform:uppercase" class="form-control form-control-lg" type="text" placeholder="Subject Code" required>
                              </div>
                              <div class="form-group">
                              <input id="subjectname" name="subjectname" style="border: none; background-color:#EEF0F0; text-transform:uppercase" class="form-control form-control-lg" type="text" placeholder="Subject Name">
                              </div>
                              <div class="form-group">
                              <select id="selectclass" name="selectclass" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Mobile Number">
                                  <option value="">Select Class</option>
                                  @foreach ($classList as $item)
                                  <option value="{{$item->id}}">{{$item->classnamee}}</option>
          
                                  @endforeach
                              </select>
                              </div>
                          </div>
                          <!-- /.col -->
                          <div class="col-md-6">
                              <div class="form-group">
                                  <select id="subjecttype" name="subjecttype" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Website">
                                      <option value="">Subject Type</option>
                                      <option value="core">Core</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <select id="gradesystem" name="gradesystem" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Establish">
                                    <option value="">Grade System</option>
                                    <option value="100">100 Marks</option>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <select id="studentgroup" name="studentgroup" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Student Group">
                                    <option value="">Student Group</option>
                                    <option value="N/A">N/A</option>
                                  </select>
                              </div>
                              
                        </div>
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <h4 style="padding-top: 10px;">Exams Details</h4>
              <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="schoolExamsFullMarkTotal" style="font-weight: normal;">Fullmark, Passmark (eg. 100, 50)</label>
                        <input id="schoolExamsFullMarkTotal" name="schoolExamsFullMarkTotal" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Fullmark, Passmark" required>
                    </div>
                    <div class="form-group">
                        <label for="schoolExamsFullMark" style="font-weight: normal;">Exams fullmark, Exams passmark (eg. 60, 30)</label>
                        <input id="schoolExamsFullMark" name="schoolExamsFullMark" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="Exams fullmark, Exams passmark" required>
                        <div class="invalid-feedback">Please fill out this field.</div>
                    </div>
                    <div class="form-group">
                        <label for="schoolca1" style="font-weight: normal;">CA1 fullmark, CA1 passmark (eg. 15, 8)</label>
                        <input id="schoolca1" name="schoolca1" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="CA1 fullmark, CA1 passmark" required>
                    </div>
                    <div class="form-group">
                        <label for="schoolca2" style="font-weight: normal;">CA2 fullmark, CA2 passmark (eg. 10, 5)</label>
                        <input id="schoolca2" name="schoolca2" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="CA2 fullmark, CA2 passmark" required>
                    </div>
                    <div class="form-group">
                        <label for="schoolca3" style="font-weight: normal;">CA3 fullmark, CA3 passmark (eg. 5, 3)</label>
                        <input id="schoolca3" name="schoolca3" style="border: none; background-color:#EEF0F0;" class="form-control form-control-lg" type="text" placeholder="CA3 fullmark, CA3 passmark" required>
                    </div>
                  </div>
                  <div class="col-md-6">

                  </div>
              </div> 
            </form>
              {{-- <button id="formVerify" onclick="verifyForm()" class="btn btn-warning">Verify</button> --}}
              <button id="formSubmit" type="button" class="btn btn-info">Submit</button>
              
  
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
              the plugin. --}}
            </div>
          </div>

        </div><!-- /.container-fluid -->
      </section>
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.3-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
    
@endsection

@push('custom-scripts')

<script>
  function scrollocation(){
    document.getElementById('subjectpage').className = "nav-link active"
    document.getElementById('addnewsubject').className = "nav-link active"
  }
</script>
    
@endpush