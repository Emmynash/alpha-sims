@extends('layouts.app_dash')

@section('content')
{{-- aside menu --}}
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="">
        </div>
        <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->firstname }} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</a>
        </div>
        {{-- <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->role }}</a>
        </div> --}}
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2 sidebar1">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
            @if (Auth::user()->schoolid == null)

            <li class="nav-item has-treeview">
              <a href="/addschool" class="nav-link">
                 <i class="fas fa-plus-square"></i> 
                <p>
                  Add institution
                </p>
              </a>
            </li>
                
            @else

              @if (count($studentDetails['userschool']) >0)
                @if (Auth::user()->role == "Student")

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Students Options
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                          <i class="fas fa-plus"></i> 
                          <p>Get class routine</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Get exams marks</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Get attendance status</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Payments
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                          <i class="fas fa-plus"></i> 
                          <p>Invoices</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Other</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                    
                @endif
                @if (Auth::user()->role == "Admin")
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Class
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                          <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Class list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="/addsubject" class="nav-link active">
                      <i class="fas fa-poll-h"></i> 
                      <p>
                        Subject
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/addsubject" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/subjectlist" class="nav-link active">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Subject list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-user-graduate"></i> 
                      <p>
                        Student
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/addstudent" class="nav-link active">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/viewstudent" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Student list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher"></i> 
                      <p>
                        Teacher
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/addteacher" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Teacher list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-address-card"></i> 
                      <p>
                        Teacher Attendance
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>View</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-address-card"></i> 
                      <p>
                        Student Attendance
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>View</p>
                        </a>
                      </li>
                    </ul>
                    <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-check-double"></i> 
                      <p>
                        Mark Manage
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Mark list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Pychomotor
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>affective domain</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-vials"></i> 
                      <p>
                        Result
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Generate</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Search</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-exchange-alt"></i> 
                      <p>
                        Promotion
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="far fa-newspaper"></i> 
                      <p>
                        News/updates
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Reports
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>MarkSheet</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Account by type</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Account balance</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="fas fa-cogs"></i> 
                      <p>
                        Settings
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Grade</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Users</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/setupschool" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>SetUp Shool</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="pages/charts/chartjs.html" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Institute</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                @endif

              @endif

            @endif

          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
{{-- asidemenuends --}}

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
            <h1 class="m-0 text-dark">Affective Domain</h1>
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
        @if ($studentDetails['userschool'][0]['status'] != "Pending" && $studentDetails['userschool'][0]['schooltype'] != "Primary")
        <div class="card card-default">
          <!-- /.card-header -->
          <div class="card-body">

            <p>card body</p>


          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            {{-- Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information about
            the plugin. --}}
          </div>
        </div>
        <!-- /.card -->

        @else

        <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Add Psycomoto</h3>
  
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
                        <th>RegNo</th>
                        <th>Roll No</th>
                        <th>Class</th>
                        <th>Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                        @if (count($studentDetails['studentsCategory']) > 0)
  
                        @foreach ($studentDetails['studentsCategory'] as $student)
                        <tr>
                          <td>{{strtoupper($student->id)}}</td>
                          <td>{{$student->renumberschoolnew}}</td>
                          <td>{{$student->classnamee}}</td>
                          <td>{{$student->firstname}} {{$student->middlename}} {{$student->lastname}}</td>

                            <form action="/deletesubject" method="post" id="deleteSubject{{$student->id}}">
                              @csrf
                              <input type="hidden" name="subjectid" value="{{$student->id}}">
                            </form>

                              <!-- The Modal -->
                                <div class="modal" id="addmotomodal{{$student->id}}">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                    
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                        <h4 class="modal-title">{{$student->firstname}} {{$student->middlename}} {{$student->lastname}}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                    <form action="/addmoto" method="POST" id="addmotoform{{$student->id}}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">Reg No</i>
                                                    <input type="text" name="regno" class="form-control form-control-sm" value="{{$student->id}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">Session</i>
                                                    <input type="text" name="sessionmoto" class="form-control form-control-sm" value="{{$studentDetails['userschool'][0]['schoolsession']}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">Reg No</i>
                                                    <select name="schooltermmoto" class="form-control form-control-sm">
                                                        <option value="">Select term</option>
                                                        <option value="1">First term</option>
                                                        <option value="2">Second term</option>
                                                        <option value="3">Third term</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <i>AFFECTIVE DOMAIN :</i>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">NEATNESS</i>
                                                    <select name="neatness" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">PUNTUALITY</i>
                                                    <select name="punctuality" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">RELIABILITY</i>
                                                    <select name="reliability" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">POLITENESS</i>
                                                    <select name="politeness" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">HONESTY</i>
                                                    <select name="honesty" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">SELF CONTROL</i>
                                                    <select name="selfcontrol" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">COOPERATION</i>
                                                    <select name="cooperation" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">ATTENTIVENESS</i>
                                                    <select name="attentiveness" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">INITIATIVE</i>
                                                    <select name="initiative" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">ORGANISATION ABILITY</i>
                                                    <select name="organisation" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">PERSEVERANCE</i>
                                                    <select name="perseverance" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">FLEXIBILITY</i>
                                                    <select name="flexibility" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <i>PSYCHOMOTOR DOMAIN :</i>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">HANDWRITING</i>
                                                    <select name="handwriting" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">GAMES/SPORT</i>
                                                    <select name="gamessport" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">CREATIVITY</i>
                                                    <select name="creativity" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">HANDLING OF TOOLS</i>
                                                    <select name="handlingoftools" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">DEXTERITY</i>
                                                    <select name="dexterity" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <i style="font-size: 12px;">NOTE COPYING</i>
                                                    <select name="notecopying" id="" class="form-control form-control-sm">
                                                        <option value="">Select a value</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                        
                                        </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button class="btn btn-success btn-sm" form="addmotoform{{$student->id}}">Submit</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                        </div>
                                        
                                    </div>
                                    </div>
                                </div>

                          <td><span class="tag tag-success"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addmotomodal{{$student->id}}"><i class="fas fa-plus-square"></i></button> <button type="submit" class="btn btn-danger btn-sm" form="deleteSubject{{$student->id}}"><i class="far fa-trash-alt"></i></button></span></td>
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
        
        @endif

          @if ($studentDetails['userschool'][0]['status'] == "Pending")
                      <!-- /.row -->
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Status</h3>
  
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
                        <th>School Id</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Active From</th>
                        <th>End On</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        {{-- @if (count($userschool) > 0)
  
                        @foreach ($userschool as $schools)
                          <td>{{$userschool[0]['schoolId']}}</td>
                          <td>{{$userschool[0]['schoolemail']}}</td>
                          <td>{{$userschool[0]['mobilenumber']}}</td>
                          <td>{{$userschool[0]['periodfrom']}}</td>
                          <td>{{$userschool[0]['periodto']}}</td>
                          <td><span class="tag tag-success">{{$userschool[0]['status']}}</span></td>
                        @endforeach
                          
                        @endif --}}
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          @endif

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