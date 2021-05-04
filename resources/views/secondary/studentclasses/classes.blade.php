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
            <h1 class="m-0 text-dark">Class Lists</h1>

                <!--<i class="far fa-question-circle" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?" style="font-size: 25px;">-->
                
                <button type="button" class="btn btn-sm btn-info" data-toggle="popover-hover" title="Class lists"
                data-content="View all classes in your school and the number of student in each class. You can change a class name incase of any mistake, however you have to be sure of what you are doing. Note: ensure classes are arranged in ascending order">Need help?</button>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Class list</li>
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


        <div class="card" style="height: 200px; border-top: 2px solid #0B887C;">

                  <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Class List</h3>

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
                      <th>Code</th>
                      <th>class</th>
                      <th>Number of student</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (count($classesAll) > 0)
                    @php $count = method_exists($classesAll, 'links') ? 1 : 0; @endphp
                      @foreach ($classesAll as $classesall)
                      @php $count = method_exists($classesAll, 'links') ? ($classesAll ->currentpage()-1) * $classesAll ->perpage() + $loop->index + 1 : $count + 1; @endphp
                        <tr>
                          <td>{{$count}}</td>
                          <td>{{$classesall->classname}}</td>
                          <td>{{$classesall->getClassCount($classesall->id)}}</td>
                  
                          
                          
                          <!-- Central Modal Small -->
                            <div class="modal fade" id="editclassname{{$classesall->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                              aria-hidden="true">
                            
                              <!-- Change class .modal-sm to change the size of the modal -->
                              <div class="modal-dialog modal-sm" role="document">
                            
                            
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title w-100" id="myModalLabel">Class id: {{$classesall->id}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                      <i style="font-style: normal; font-size: 12px;">Classes are arraged in asending order and schould not be tempered with. Corrections are only allowed if the name was wrongly entered...</i>
                                    <form id="editclassnameform{{$classesall->id}}" action="/editclassname" method="post">
                                        @csrf
                                        <input type="text" class="form-control form-control-sm" value="{{$classesall->classname}}" name="classname">
                                        
                                        <input type="hidden" class="form-control form-control-sm" value="{{$classesall->id}}" name="classid">
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                      <i style="font-style: normal; font-size: 12px;">CLick on close if you are not sure of what to do</i>
                                      <br>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                    <button type="submit" form="editclassnameform{{$classesall->id}}" class="btn btn-success btn-sm">Proceed</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Central Modal Small -->


                              <!-- The Modal -->
                              <div class="modal fade" id="viewsectioncount{{ $classesall->id }}">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                  
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Section Count</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <ul class="list-group">

                                          @foreach ($classesall->getArmCount($classesall->id) as $item)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                              {{$classesall->classname}} {{ $item->sectionname }}
                                              <span class="badge badge-primary badge-pill">{{ $item->sectioncount }}</span>
                                            </li>
                                          @endforeach

                                        </ul>
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                          
                          
                          
                          <td><button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#viewsectioncount{{$classesall->id}}"><i class="fas fa-eye"></i></button> <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editclassname{{$classesall->id}}"><i class="fas fa-edit"></i></button></td>
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




  
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2012-2019 <a href="http://adminlte.io">Brightosoft</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 0.0.1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <script>
      function scrollocation(){
        document.getElementById('classlistscroll').className = "nav-link active"
      }
  </script>
    
@endsection