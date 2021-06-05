  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 5px; border-bottom: 1px solid #fff;">

    </div>

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

            @can('view edit class')
              <li class="nav-item has-treeview">
                <a id="classpage" href="{{ route('viewclasslist') }}" class="nav-link">
                    <i class="fas fa-home"></i> 
                  <p>
                    Class
                  </p>
                </a>
              </li>
            @endcan

            @can('assign subjects')
              <li class="nav-item has-treeview">
                <a id="subjectsmainAdd" href="{{ route('addsubject') }}" class="nav-link">
                  <i class="fas fa-poll-h"></i> 
                  <p>
                    Subject
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                  </p>
                </a>
              </li>
            @endcan

            {{-- -------------------------------------------------------------------------------- --}}

            @can('view account summary')
            <li class="nav-item has-treeview">
              <a id="summarylistscroll" href="{{ route('summary') }}" class="nav-link">
                <i class="fas fa-coins nav-icon"></i>
                <p>
                  Summary
                </p>
              </a>
            </li>
          @endcan

          @can('fee management')
            <li class="nav-item">
              <a id="feesetup" href="{{ route('index_fees') }}" class="nav-link">
                  <i class="fas fa-money-check nav-icon"></i>
                <p>
                  Fees Management
                </p>
              </a>
            </li>
          @endcan

          @can('invoice management')
            <li class="nav-item has-treeview">
              <a id="invoicelistscroll" href="{{ route('invoices') }}" class="nav-link">
                <i class="fas fa-file-invoice nav-icon"></i>
                <p>
                  Invoice Management
                </p>
              </a>
            </li>
          @endcan

          @can('can send or receive request')
            <li class="nav-item has-treeview">
              <a id="requestlistscroll" href="{{ route('order_request') }}" class="nav-link">
                <i class="fas fa-th-list nav-icon"></i>
                <p>
                  Requests
                </p>
              </a>
            </li>
          @endcan

          {{-- @can('view payment record')
            <li class="nav-item has-treeview">
              <a id="requestlistscroll" href="{{ route('order_request') }}" class="nav-link">
                <i class="fas fa-money-bill-wave-alt nav-icon"></i>
                <p>
                  Payment Record
                </p>
              </a>
            </li>
          @endcan --}}

          @can('fee collection')
            <li class="nav-item has-treeview">
              <a id="feecollection" href="{{ route('feecollection') }}" class="nav-link">
                <i class="fas fa-hand-holding-usd nav-icon"></i>
                <p>
                  Fee Collection
                </p>
              </a>
            </li>
          @endcan

          @can('access inventory')
            <li class="nav-item has-treeview">
              <a id="inventory" href="{{ route('inventory') }}" class="nav-link">
                <i class="fas fa-dolly-flatbed nav-icon"></i>
                <p>
                  Inventory
                </p>
              </a>
            </li>
          @endcan

          {{-- ------------------------------------------------------------------------------- --}}

            @can('add students')
              <li class="nav-item has-treeview">
                <a id="studentsmain" href="#" class="nav-link">
                  <i class="fas fa-user-graduate"></i> 
                  <p>
                    Student
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="studentsmainadd" href="{{ route('addstudent') }}" class="nav-link">
                      <i class="fas fa-plus"></i> 
                      <p>Add New</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="viewstudentaside" href="{{ route('viewstudent') }}" class="nav-link">
                      <i class="fas fa-clipboard-list"></i> 
                      <p>Student list</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan

            @can('assign form teacher')
              <li class="nav-item has-treeview">
                <a id="teachersmain" href="#" class="nav-link">
                  <i class="fas fa-chalkboard-teacher"></i> 
                  <p>
                    Teacher
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="addteachersmain" href="{{ route('addteacher') }}" class="nav-link">
                      <i class="fas fa-plus"></i> 
                      <p>Add New</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="formmasteroptionadd" href="/form_teacher_sec_index" class="nav-link">
                      <i class="fas fa-clipboard-list"></i> 
                      <p>Form Teacher</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan

            @if (Auth::user()->hasRole('Teacher'))
              <li class="nav-item has-treeview">
                <a id="editteacher" href="{{ route('editprofileteacher') }}" class="nav-link">
                  <i class="fas fa-user-edit"></i> 
                  <p>
                    Edit Profile
                  </p>
                </a>
              </li>
            @endif

            @can('take teachers attendance')

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
                    <a id="addteacherattendanceaside" href="{{ route('teachersattendance') }}" class="nav-link">
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
              
            @endcan

            @can('student attendance')
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
                    <a id="addstudentattendanceaside" href="{{ route('studentattendance') }}" class="nav-link">
                      <i class="fas fa-plus"></i> 
                      <p>Add</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="viewstudentattendance" href="{{ route('viewallstudents') }}" class="nav-link">
                      <i class="fas fa-clipboard-list"></i> 
                      <p>View</p>
                    </a>
                  </li>
                </ul>
            </li>
            @endcan

              @can('manage marks')
                <li class="nav-item has-treeview">
                  <a id="managemarkscroll" href="{{ route('managemarks') }}" class="nav-link">
                    <i class="fas fa-check-double"></i> 
                    <p>
                      Mark Manage
                    </p>
                  </a>
                </li>
              @endcan

              @can('manage staff')
                <li class="nav-item has-treeview">
                  <a id="managestaffscroll" href="{{ route('addstaff') }}" class="nav-link">
                    <i class="fas fa-user-tie"></i> 
                    <p>
                      Manage Staff
                    </p>
                  </a>
                </li>
              @endcan

            @can('add psychomotor')
              <li class="nav-item has-treeview">
                <a id="psyhcomoto" href="#" class="nav-link">
                    <i class="fas fa-home"></i> 
                  <p>
                    Pychomotor
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="psyhcomotoadd" href="{{ route('student_moto') }}" class="nav-link">
                      <i class="fas fa-plus"></i> 
                      <p>add</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="psyhcomotosettings" href="{{ route('setting_moto') }}" class="nav-link">
                      <i class="fas fa-plus"></i> 
                      <p>settings</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan
  

  
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

            @can('student promotion')
              <li class="nav-item has-treeview">
                <a id="promotionscroll" href="{{ route('promotion') }}" class="nav-link">
                  <i class="fas fa-exchange-alt"></i> 
                  <p>
                    Promotion
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                  </p>
                </a>
              </li>
            @endcan
  

  
            {{-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="far fa-newspaper"></i> 
                <p>
                  News/updates
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
            </li> --}}


            @can('settings')
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
                    <a id="gradesaside" href="{{ route('grades') }}" class="nav-link">
                      <i class="fas fa-plus"></i> 
                      <p>Grade</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="usersaside" href="{{ route('allusers') }}" class="nav-link">
                      <i class="fas fa-clipboard-list"></i> 
                      <p>Users</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="schoolsetupaside" href="{{ route('setupschool') }}" class="nav-link">
                      <i class="fas fa-clipboard-list"></i> 
                      <p>SetUp Shool</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="schoolsetupaside" href="{{ route('payment_details') }}" class="nav-link">
                      <i class="fas fa-clipboard-list"></i> 
                      <p>Payment Details</p>
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
            @endcan
  




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









            {{-- @if (isset($studentDetails)) --}}

         
                @if (Auth::user()->hasRole('Student'))

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
                        <a href="{{ route('student_fees') }}" class="nav-link">
                          <i class="fas fa-plus"></i> 
                          <p>Invoices</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('payment_history') }}" class="nav-link">
                           <i class="fas fa-clipboard-list"></i> 
                          <p>Transactions</p>
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
                    
                @endif
              @endif


          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>