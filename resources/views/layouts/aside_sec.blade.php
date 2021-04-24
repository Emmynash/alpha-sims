  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
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
          <a href="#" class="d-block">{{Auth::user()->firstname}} {{Auth::user()->middlename}} {{Auth::user()->lastname}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a id="dashboard_secs" href="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          {{-- //account department --}}

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
              <a id="feecollection" href="{{ route('inventory') }}" class="nav-link">
                <i class="fas fa-dolly-flatbed nav-icon"></i>
                <p>
                  Inventory
                </p>
              </a>
            </li>
          @endcan

          @can('view edit class')
            <li class="nav-item">
              <a id="classlistscroll" href="/classes" class="nav-link">
                  <i class="fas fa-warehouse nav-icon"></i>
                <p>
                  Class
                </p>
              </a>
            </li>
          @endcan

            @can('assign subjects')
              <li class="nav-item has-treeview">
                <a id="subjectsmain" href="#" class="nav-link">
                    <i class="fas fa-book nav-icon"></i>
                  <p>
                    Subjects
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="subjectsmainAdd" href="/addsubject_sec" class="nav-link">
                        <i class="far fa-plus-square nav-icon"></i>
                      <p>Add New</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="subjectsmainview" href="/subject_sec_index" class="nav-link">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                      <p>Subject List</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan

            @can('add students')
              <li class="nav-item has-treeview">
                <a id="studentsmain" href="#" class="nav-link">
                    <i class="fas fa-user-graduate nav-icon"></i>
                  <p>
                    Student
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="studentsmainadd" href="/student_sec_index" class="nav-link">
                        <i class="far fa-plus-square nav-icon"></i>
                      <p>Add New</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="studentsmainview" href="/viewstudentbyclass" class="nav-link">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                      <p>Student List</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan

            @can('assign form teacher')
              <li class="nav-item has-treeview">
                <a id="teachersmain" href="#" class="nav-link">
                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                  <p>
                    Teacher
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="addteachersmain" href="/teacher_sec_index" class="nav-link">
                        <i class="far fa-plus-square nav-icon"></i>
                      <p>Add New</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="pages/UI/buttons.html" class="nav-link">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                      <p>Teacher Lists</p>
                    </a>
                  </li> --}}
                </ul>
              </li>
            @endcan

            @can('take teachers attendance')
              <li class="nav-item has-treeview">
                <a id="attendancemain" href="#" class="nav-link">
                    <i class="fas fa-id-card nav-icon"></i>
                  <p>
                    Teachers Attendance
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="attendancemain_add" href="/teacher_add_attendance" class="nav-link">
                        <i class="far fa-plus-square nav-icon"></i>
                      <p>Add</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-eye nav-icon"></i>
                      <p>View</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan

            @can('student attendance')
              <li class="nav-item has-treeview">
                <a id="studentatt_sec" href="#" class="nav-link">
                    <i class="fas fa-id-card nav-icon"></i>
                  <p>
                    Student Attendance
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a id="studentatt_sec_add" href="student_attendance_sec" class="nav-link">
                        <i class="far fa-plus-square nav-icon"></i>
                      <p>Add</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a id="studentatt_sec_view" href="/view_all_at_route_sec" class="nav-link">
                        <i class="far fa-eye nav-icon"></i>
                      <p>View</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan

            @can('elearning')
              <li class="nav-item has-treeview">
                <a href="{{ route('elearning') }}" class="nav-link">
                  <i class="fas fa-chalkboard nav-icon"></i>
                  <p>
                    eLearning
                  </p>
                </a>
              </li>
            @endcan

            @can('access library')
              <li class="nav-item has-treeview">
                <a href="{{ route('school_library') }}" class="nav-link">
                  <i class="fas fa-chalkboard nav-icon"></i>
                  <p>
                    Visit Library
                  </p>
                </a>
              </li>
            @endcan

            @if (Auth::user()->hasRole('Teacher'))
            <li class="nav-item has-treeview">
              <a id="teacheredit" href="/editteacherprofile" class="nav-link">
                <i class="fas fa-user-edit nav-icon"></i>
                <p>
                  Edit Profile
                </p>
              </a>
            </li>

            <li class="nav-item">
                <a id="markmanageoption" href="{{ route('teacher_sec_remark') }}" class="nav-link">
                    <i class="fas fa-check-double nav-icon"></i>
                  <p>
                    Result Remark
                  </p>
                </a>
            </li>

            @can('form teacher')
              <li class="nav-item">
                <a id="formmasteroption" href="{{ route('form_teacher') }}" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                  <p>
                    Form Master
                  </p>
                </a>
              </li>
            @endcan

            @endif

            @can('elearning')
              <li class="nav-item">
                <a href="{{ route('dowloads_videos') }}" class="nav-link">
                  <i class="fas fa-video nav-icon"></i>
                  <p>Videos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/dowloads_pdf" class="nav-link">
                  <i class="far fa-file-pdf nav-icon"></i>
                  <p>PDF downloads</p>
                </a>
              </li>
            @endcan
              
          @if(Auth::user()->hasRole('Student'))
          <li class="nav-item has-treeview">
            <a id="resultmainscroll" href="#" class="nav-link">
                <i class="fas fa-vials nav-icon"></i>
              <p>
                Result
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a id="resultmaingenscroll" href="/result_view_sec" class="nav-link">
                  <i class="far fa-eye nav-icon"></i>
                  <p>Generate</p> 
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('student_fees') }}" class="nav-link">
              <i class="fas fa-wallet nav-icon"></i>
              <p>Fee Payment</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('payment_history') }}" class="nav-link">
              <i class="fas fa-wallet nav-icon"></i>
              <p>Transactions</p>
            </a>
          </li>
          @endif

          @can('manage marks')
            <li class="nav-item">
              <a id="managemarkscroll" href="/student_add_marks" class="nav-link">
                  <i class="fas fa-check-double nav-icon"></i>
                <p>
                  Mark Manage
                </p>
              </a>
            </li>
          @endcan

          @can('accommodation')
            <li class="nav-item has-treeview">
              <a id="managestaffaside" href="/dom_index" class="nav-link">
                <i class="fas fa-user-tie nav-icon"></i> 
                <p>
                  Accomodation
                </p>
              </a>
            </li>
          @endcan

          @can('manage staff')
            <li class="nav-item">
              <a id="managestaffscroll" href="/manage_saff_sec" class="nav-link">
                  <i class="fas fa-user-circle nav-icon"></i>
                <p>
                  Manage Staff
                </p>
              </a>
            </li>
          @endcan

          @can('add psychomotor')
            <li class="nav-item has-treeview">
              <a id="psyhcomoto" href="" class="nav-link">
                  <i class="fas fa-balance-scale nav-icon"></i>
                <p>
                  psychomotor
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a id="psyhcomotoadd" href="{{ route('student_moto') }}" class="nav-link">
                    <i class="far fa-plus-square nav-icon"></i>
                    <p>Add</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="psyhcomotosettings" href="{{ route('setting_moto') }}" class="nav-link">
                    <i class="far fa-plus-square nav-icon"></i>
                    <p>Settings</p>
                  </a>
                </li>
              </ul>
            </li>
          @endcan

          @can('result module')
            <li class="nav-item has-treeview">
              <a id="resultmainscroll" href="#" class="nav-link">
                  <i class="fas fa-vials nav-icon"></i>
                <p>
                  Result
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a id="resultmaingenscroll" href="{{ route('result_by_class') }}" class="nav-link">
                    <i class="far fa-eye nav-icon"></i>
                    <p>Result By Class</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="resultmaingenscroll" href="/result_view_sec" class="nav-link">
                    <i class="far fa-eye nav-icon"></i>
                    <p>Result By Class</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="resultmaingenscrollgenerate" href="{{ route('generate_result') }}" class="nav-link">
                    <i class="far fa-eye nav-icon"></i>
                    <p>Generate</p>
                  </a>
                </li>
              </ul>
            </li>
          @endcan

          @can('student promotion')
            <li class="nav-item has-treeview">
              <a id="promotionscroll" href="/promotion_student_sec" class="nav-link">
                  <i class="fas fa-exchange-alt nav-icon"></i>
                <p>
                  Promotion
                </p>
              </a>
            </li>
          @endcan


          @can('settings')
            <li class="nav-item has-treeview">
              <a id="setupmain" href="#" class="nav-link">
                  <i class="fas fa-cogs nav-icon"></i>
                <p>
                  Settings
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a id="gradesscroll" href="{{ route('grades_sec') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Grade</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="usersscroll" href="{{ route('allusers_sec') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="setupmainsetupage" href="{{ route('setupschool_sec') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SetUp School</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('addschool_sec') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Institution</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="resultmaingenscroll" href="{{ route('payment_details') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Payment Details</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sub_index" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Subscription</p>
                  </a>
                </li>
              </ul>
            </li>
          @endcan

          @can('admin accounting')
            <li class="nav-item has-treeview">
              <a id="managestaffaside" href="{{ route('account_index') }}" class="nav-link">
                <i class="fas fa-user-tie nav-icon"></i> 
                <p>
                  Accounting
                </p>
              </a>
            </li>
          @endcan

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