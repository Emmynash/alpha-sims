@extends('layouts.app_dash')

@section('content')

<div class="wrapper">

  @include('layouts.asideadmin')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{$allSchoolDetails['addpost'][0]['schoolname']}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">sdsds</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        @include('layouts.message')


        <div class="row">
          <div class="col-md-4">
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <!--<h3 class="widget-user-username">Alexander Pierce</h3>-->
                <!--<h5 class="widget-user-desc">Principal</h5>-->
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{asset('storage/schimages/'.$allSchoolDetails['addpost'][0]['schoolLogo'])}}" alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">{{$allSchoolDetails['addpost'][0]['schoolemail']}}</h5>
                      <span class="description-text">EMAIL</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">{{$allSchoolDetails['addpost'][0]['mobilenumber']}}</h5>
                      <span class="description-text">PHONE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
          </div>
          <div class="col-md-8">

            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{count($allSchoolDetails['studentCount'])}}</h3>

                    <p>Students</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{count($allSchoolDetails['addteachers'])}}</h3>

                    <p>Teachers</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{count($allSchoolDetails['addsubjects'])}}</h3>

                    <p>Subjects</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{count($allSchoolDetails['classlists'])}}</h3>

                    <p>Class</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->

          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <div class="card" style="height: 200px;">
              <div class="card-header">
                <i style="font-style: normal;">Class Lists</i>
              </div>
              <div class="card-body" style="height: 150px; width: 100%; margin: 0px; overflow-y: scroll;">
                @foreach($allSchoolDetails['classlists'] as $class)
                <div class="card" style="margin: 4px 0px 4px 0px; background-color: #33b5e5;">
                  <div style="display: flex; align-items: center;">
                    <i style="font-style: normal; font-size: 12px; padding: 2px;">{{$allSchoolDetails['addpost'][0]['schooltype'] == "Primary" ? $class->classnamee : $class->classname}}</i>
                    <div style="flex: 1;"></div>
                    <i class="fas fa-times" style="padding-right: 2px;"></i>

                  </div>
                </div>
                @endforeach


              </div>

            </div>
          </div>
          <div class="col-md-3">
            <div class="card" style="height: 200px;">
              <div class="card-header">
                <i style="font-style: normal;">School Type</i>
              </div>
              <div class="card-body">
                <span class="badge badge-pill badge-primary">{{$allSchoolDetails['addpost'][0]['schooltype']}}</span>
              </div>

            </div>
          </div>
          <div class="col-md-3">
            <div class="card" style="height: 200px;">
              <div class="card-header">
                <i style="font-style: normal;">Subscriptions</i>
              </div>
              <div class="card-body">
                <span class="badge badge-pill badge-success">{{$allSchoolDetails['addpost'][0]['status']}}</span>
                <div style="display: flex; flex-direction: column;">
                  <i style="font-style: normal; font-size: 12px;">Date from: {{$allSchoolDetails['addpost'][0]['periodfrom']}}</i>
                  <i style="font-style: normal; font-size: 12px;">Date To: {{$allSchoolDetails['addpost'][0]['periodto']}}</i>
                  <button class="btn btn-sm btn-info">Deactivate</button>

                </div>
              </div>

            </div>
          </div>
          <div class="col-md-3">
            <div class="card" style="height: 200px;">
              <div class="card-header">
                <i style="font-style: normal;">Features</i>
              </div>
              <div class="card-body">
                <form action="javascript:console.log('submited')">
                  @csrf
                  <div class="form-group">
                    <i style="font-style: normal; font-size: 12px;">Select a feature</i>
                    <select class="form-control form-control-sm">
                      <option value="">Select a feature</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-sm btn-info">On</button>
                  <button type="submit" class="btn btn-sm btn-danger">Off</button>
                </form>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card" style="height: 400px;">
              <div class="card-header">
                <i style="font-style: normal;">Teachers</i>
              </div>
              <div class="card-body">
                @foreach($allSchoolDetails['addteachers'] as $teachers)
                <div class="card" style="background-color: gray; display: flex; flex-direction: row; align-items: center;">
                  <i style="font-style: normal; color: white; padding-left: 5px;">{{$teachers->firstname}} {{$teachers->middlename}} {{$teachers->lastname}}</i>
                  <div style="flex:1;"></div>
                  <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                </div>
                @endforeach

              </div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="card" style="height: 400px;">
              <div class="card-header">
                <i style="font-style: normal;">Students</i>
              </div>
              <div class="card-body" style="overflow-y: scroll;">
                @foreach($allSchoolDetails['studentCount'] as $students)
                <div class="card" style="background-color: gray; display: flex; flex-direction: row; align-items: center;">
                  <i style="font-style: normal; color: white; padding-left: 5px;">{{$students->firstname}} {{$students->middlename}} {{$students->lastname}}</i>
                  <div style="flex:1;"></div>
                  <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                </div>
                @endforeach
              </div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="card" style="height: 400px;">
              <div class="card-header">
                <i style="font-style: normal;">Events</i>
              </div>
              <div class="card-body" style="overflow-y: scroll;">
                @foreach($allSchoolDetails['eventsdetails'] as $events)
                <div class="card" style="background-color: #FFC300; display: flex; flex-direction: row; align-items: center;">
                  <div style="display: flex; flex-direction: column;">
                    <i style="font-style: normal; color: black; padding-left: 5px; font-size: 12px;">Subject: {{$events->eventtitle}}</i>
                    <i style="font-style: normal; color: black; padding-left: 5px; font-size: 12px;">Status: {{$events->status}}</i>
                    <i style="font-style: normal; color: black; padding-left: 5px; font-size: 12px;">Start Date: {{$events->eventstart}}</i>
                    <i style="font-style: normal; color: black; padding-left: 5px; font-size: 12px;">End Dtate: {{$events->eventend}}</i>
                  </div>
                  <div style="flex:1;"></div>
                  <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#viewevent{{$events->id}}"><i class="fas fa-plus-circle"></i></button>
                </div>

                <!-- Central Modal Small -->
                <div class="modal fade" id="viewevent{{$events->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                  <!-- Change class .modal-sm to change the size of the modal -->
                  <div class="modal-dialog modal-sm" role="document">


                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title w-100" id="myModalLabel">Events</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div style="width: 97%; border: 1px solid #EFECDD; margin-bottom: 3px;">
                          <i style="font-style: normal; font-size: 13px; padding: 3px;"><b>Subject: </b> {{$events->eventtitle}}</i>
                        </div>
                        <div style="width: 97%; border: 1px solid #EFECDD; margin-bottom: 3px;">
                          <i style="font-style: normal; font-size: 13px; padding: 3px;"><b>Details: </b> {{$events->eventdetails}}</i>
                        </div>
                        <div style="width: 97%; border: 1px solid #EFECDD; margin-bottom: 3px;">
                          <i style="font-style: normal; font-size: 13px; padding: 3px;"><b>starts on: </b> {{$events->eventstart}}</i>
                        </div>
                        <div style="width: 97%; border: 1px solid #EFECDD; margin-bottom: 3px;">
                          <i style="font-style: normal; font-size: 13px; padding: 3px;"><b>Ends on: </b>{{$events->eventend}}</i>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <!--<button type="button" class="btn btn-primary btn-sm">Save changes</button>-->
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Central Modal Small -->
                @endforeach

              </div>

            </div>
          </div>
        </div>




        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">





            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019-2022 <a href="https://www.bluealgorithmtechnologies.com/">Blue Algorithm technologies.</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });

  function scrollocation() {
    document.getElementById('orderoption').className = "nav-link active"
  }
</script>

@endsection