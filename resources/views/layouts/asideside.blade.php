  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 5px; border-bottom: 1px solid #fff;">
      <img src="{{ isset($studentDetails) ? count($studentDetails['userschool']) > 0 ? asset('storage/schimages/'.$studentDetails['userschool'][0]['schoolLogo']) : " " : ""}}" alt="" class="brand-image img-circle elevation-3"
           style="opacity: .8" width="60px" height="60px">
           <span class="brand-text font-weight-light" style="color: #fff;">{{isset($studentDetails['userschool']) ? count($studentDetails['userschool']) > 0 ? $studentDetails['userschool'][0]['schoolname'] : " NA" : "NA"}}</span>
    </div>
    {{-- <a href="/" class="brand-link">
      <img src="{{ isset($studentDetails) ? count($studentDetails['userschool']) > 0 ? asset('storage/schimages/'.$studentDetails['userschool'][0]['schoolLogo']) : " " : ""}}" alt="" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{isset($studentDetails['userschool']) ? count($studentDetails['userschool']) > 0 ? $studentDetails['userschool'][0]['schoolname'] : " NA" : "NA"}}</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div id="profileimgdiv" class="image">
          <div id="spinnerimageupload" style="position: absolute; display: none;">
            <div class="spinner-border" style="width: 20px; height: 20px;"></div>
          </div>
          <div>
            <button id="button" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; border: none; background: transparent; outline: none; color: white;"><i class="fas fa-camera"></i></button>
            <form id="pixupdatelater" action="javascript:console.log('submited')" method="POST">
              @csrf
              <input id="profilepix" name="profilepix" type="file" style="visibility: hidden; position: absolute;"/>
            </form>
            {{-- <button id="button">trigger file selection</button> --}}
          </div>
          <img id="profileimgmainpix" src="{{asset('storage/schimages/'.Auth::user()->profileimg)}}" class="img-circle elevation-2" alt="User Image">
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
            <a id="dashboardlink" href="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
            @if (Auth::user()->schoolid == null)

            <li class="nav-item has-treeview">
              <a id="addinstitution" href="/addschool" class="nav-link">
                 <i class="fas fa-plus-square"></i> 
                <p>
                  Add institution
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); 
              document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> 
                <p>
                  SignOut
                </p>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
                
            @else

            @if (isset($studentDetails))

              @if ($studentDetails['userschool'][0]['status'] == "Approved")
                @if (Auth::user()->role == "Student")

                <li class="nav-item has-treeview">
                    <a id="studentoptions" href="#" class="nav-link">
                      <i class="fas fa-align-left"></i> 
                      <p>
                        Students Options
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="examsmarkstudent" href="/exammark" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Get exams marks</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/viewallstudents" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Get attendance status</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/result" class="nav-link">
                          <i class="fas fa-vials"></i> 
                          <p>Result</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="far fa-money-bill-alt"></i> 
                      <p>
                        Payments
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="fas fa-plus"></i> 
                          <p>Invoices</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Other</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();">
                      <i class="fas fa-sign-out-alt"></i> 
                      <p>
                        SignOut
                      </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                    
                @endif
                @if (Auth::user()->role == "Admin")
                <li class="nav-item has-treeview">
                    <a id="classpage" href="/viewclasslist" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Class
                      </p>
                    </a>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="subjectpage" href="/addsubject" class="nav-link">
                      <i class="fas fa-poll-h"></i> 
                      <p>
                        Subject
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="addnewsubject" href="/addsubject" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewsubjectside" href="/subjectlist" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Subject list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="studentaside" href="#" class="nav-link">
                      <i class="fas fa-user-graduate"></i> 
                      <p>
                        Student
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="addstudentaside" href="/addstudent" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewstudentaside" href="/viewstudent" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Student list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="teachersaside" href="#" class="nav-link">
                      <i class="fas fa-chalkboard-teacher"></i> 
                      <p>
                        Teacher
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="addteacheraside" href="/addteacher" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewteacheraside" href="/viewteachers" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Teacher list</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="teachersattendanceaside" href="#" class="nav-link">
                      <i class="fas fa-address-card"></i> 
                      <p>
                        Teacher Attendance
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="addteacherattendanceaside" href="/teachersattendance" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewteacherattendanceaside" href="/viewallteachers" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>View</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="studentattendanceaside" href="#" class="nav-link">
                      <i class="fas fa-address-card"></i> 
                      <p>
                        Student Attendance
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="addstudentattendanceaside" href="/studentattendance" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewstudentattendance" href="/viewallstudents" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>View</p>
                        </a>
                      </li>
                    </ul>
                    <li class="nav-item has-treeview">
                    <a id="viewmarks" href="#" class="nav-link">
                      <i class="fas fa-check-double"></i> 
                      <p>
                        Mark Manage
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="viewmarksadd" href="/managemarks" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      {{-- <li class="nav-item">
                        <a id="viewmarkslist" href="/viewmarks" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Mark list</p>
                        </a>
                      </li> --}}
                    </ul>
                  </li>

                  <li class="nav-item has-treeview">
                    <a id="managestaffaside" href="/addstaff" class="nav-link">
                      <i class="fas fa-user-tie"></i> 
                      <p>
                        Manage Staff
                      </p>
                    </a>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="pychomotoraside" href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Pychomotor
                        {{-- <i class="right fas fa-angle-left"></i> --}}
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="affectivedomainaside" href="/moto" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>affective domain</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="resultaside" href="#" class="nav-link">
                      <i class="fas fa-vials"></i> 
                      <p>
                        Result
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="geberateresultaside" href="/result" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Generate</p>
                        </a>
                      </li>
                      {{-- <li class="nav-item">
                        <a href="" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Search</p>
                        </a>
                      </li> --}}
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="promotionaside" href="/promotion" class="nav-link">
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
                    <a id="settingsaside" href="#" class="nav-link">
                      <i class="fas fa-cogs"></i> 
                      <p>
                        Settings
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="gradesaside" href="/grades" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Grade</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="usersaside" href="/allusers" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Users</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="schoolsetupaside" href="/setupschool" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>SetUp Shool</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="institutionaside" href="/addschool" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Institute</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="institutionaside" href="/sub_index" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Subscription</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();">
                      <i class="fas fa-sign-out-alt"></i> 
                      <p>
                        SignOut
                      </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                @endif

{{--------------------------------------------------------------------------------------}}
{{--                                 teachers role                                    --}}
{{--------------------------------------------------------------------------------------}}

              @if (Auth::user()->role == "Teacher")
        
                  <li class="nav-item has-treeview">
                    <a id="studentattendanceaside" href="#" class="nav-link">
                      <i class="fas fa-address-card"></i> 
                      <p>
                        Student Attendance
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="addstudentattendanceaside" href="/studentattendance" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewstudentattendance" href="/viewallstudents" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>View</p>
                        </a>
                      </li>
                    </ul>
                    <li class="nav-item has-treeview">
                    <a id="viewmarks" href="#" class="nav-link">
                      <i class="fas fa-check-double"></i> 
                      <p>
                        Mark Manage
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="viewmarksadd" href="/managemarks" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                      {{-- <li class="nav-item">
                        <a id="viewmarkslist" href="/viewmarks" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Mark list</p>
                        </a>
                      </li> --}}
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="pychomotoraside" href="#" class="nav-link">
                        <i class="fas fa-home"></i> 
                      <p>
                        Pychomotor
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="affectivedomainaside" href="/moto" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>affective domain</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="resultaside" href="#" class="nav-link">
                      <i class="fas fa-vials"></i> 
                      <p>
                        Result
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a id="geberateresultaside" href="/result" class="nav-link">
                           <i class="fas fa-plus"></i> 
                          <p>Generate</p>
                        </a>
                      </li>
                      {{-- <li class="nav-item">
                        <a href="/result" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Search</p>
                        </a>
                      </li> --}}
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="promotionaside" href="/promotion" class="nav-link">
                      <i class="fas fa-exchange-alt"></i> 
                      <p>
                        Promotion
                        {{-- <i class="right fas fa-angle-left"></i> --}}
                      </p>
                    </a>
                  </li>

                  <li class="nav-item has-treeview">
                    <a id="editteacher" href="/editprofileteacher" class="nav-link">
                      <i class="fas fa-user-edit"></i> 
                      <p>
                        Edit Profile
                      </p>
                    </a>
                  </li>
        
                  <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); 
                    document.getElementById('logout-form').submit();">
                      <i class="fas fa-sign-out-alt"></i> 
                      <p>
                        SignOut
                      </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                  @endif
{{-----------------------------------------------------------------------------------}}
{{--                              supervisor                                       --}}
{{-----------------------------------------------------------------------------------}}
                @if (Auth::user()->role == "Supervisor")

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
                      <a href="/teachersattendance" class="nav-link">
                         <i class="fas fa-plus"></i> 
                        <p>Add</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/viewallteachers" class="nav-link">
                         <i class="fas fa-clipboard-list"></i> 
                        <p>View</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--<li class="nav-item">-->
                <!--  <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); -->
                <!--  document.getElementById('logout-form').submit();">-->
                <!--    <i class="fas fa-sign-out-alt"></i> -->
                <!--    <p>-->
                <!--      SignOut-->
                <!--    </p>-->
                <!--  </a>-->
                <!--  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">-->
                <!--    @csrf-->
                <!--  </form>-->
                <!--</li>-->
                    
                @endif
              @endif

            @endif
          @endif
         <li class="nav-item has-treeview">
            <a href="#" class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-in-alt nav-icon"></i>
              <p>
                Signout
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>