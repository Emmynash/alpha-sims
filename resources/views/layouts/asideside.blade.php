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
            {{-- <button id="button" style="position: absolute; top: 0; bottom: 0; right: 0; left: 0; border: none; background: transparent; outline: none; color: white;"><i class="fas fa-camera"></i></button> --}}
            <form id="pixupdatelater" action="javascript:console.log('submited')" method="POST">
              @csrf
              <input id="profilepix" name="profilepix" type="file" style="visibility: hidden; position: absolute;" />
            </form>
            {{-- <button id="button">trigger file selection</button> --}}
          </div>
          <img id="profileimgmainpix" src="{{ asset(Auth::user()->profileimg != null ? Auth::user()->profileimg : 'https://gravatar.com/avatar/?s=200&d=retro') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('myprofile') }}" class="d-block">{{ Auth::user()->firstname }}
            {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}</a>
        </div>
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

          @if (Auth::user()->hasRole('HeadOfSchool') || Auth::user()->hasRole('Bursar'))
          <li class="nav-item has-treeview">
            <a id="accountscroll" href="#" class="nav-link">
              <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
                Accounts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
              @can('view account summary')
              <li class="nav-item">
                <a id="summarylistscroll" href="{{ route('summary') }}" class="nav-link">
                  <i class="fa fa-list-alt nav-icon"></i>
                  <p>
                    Summary
                  </p>
                </a>
              </li>
              @endcan

              @can('fee management')
              <li class="nav-item">
                <a id="feesetup" href="{{ route('index_fees') }}" class="nav-link">
                  <i class="fas fa-chart-line nav-icon"></i>
                  <p>
                    Fees Management
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a id="studentdiscountlistscroll" href="{{ route('student_dicount') }}" class="nav-link">
                  <i class="fa fa-percent nav-icon"></i>
                  <p>
                    Student Discount
                  </p>
                </a>
              </li>
              @endcan

              @can('invoice management')
              <li class="nav-item">
                <a id="invoicelistscroll" href="{{ route('invoices') }}" class="nav-link">
                  <i class="fas fa-file-invoice nav-icon"></i>
                  <p>
                    Invoice Management
                  </p>
                </a>
              </li>
              @endcan

              @can('can send or receive request')
              <li class="nav-item">
                <a id="requestlistscroll" href="{{ route('order_request') }}" class="nav-link">
                  <i class="fas fa-money-check nav-icon"></i>
                  <p>
                    Requests
                  </p>
                </a>
              </li>
              @endcan

              @can('fee collection')
              <li class="nav-item">
                <a id="feecollection" href="{{ route('feecollection') }}" class="nav-link">
                  <i class="fa fa-compress nav-icon"></i>
                  <p>
                    Fee Collection
                  </p>
                </a>
              </li>
              @endcan

              @can('access inventory')
              <li class="nav-item">
                <a id="inventory" href="{{ route('inventory') }}" class="nav-link">
                  <i class="fas fa-wallet nav-icon"></i>
                  <p>
                    Inventory
                  </p>
                </a>
              </li>
              @endcan

              {{-- <li class="nav-item">
                <a id="studentsmainview" href="/viewstudentbyclass" class="nav-link">
                    <i class="fas fa-clipboard-list nav-icon"></i>
                  <p>Student List</p>
                </a>
              </li>
              <li class="nav-item">
                <a id="studentsmainview" href="{{ route('reasign_class') }}" class="nav-link">
              <i class="fas fa-clipboard-list nav-icon"></i>
              <p>Reassign Class</p>
              </a>
          </li> --}}
        </ul>
        </li>
        @endif

        @can('view edit class')
        <li class="nav-item has-treeview">
          <a id="classpage" href="{{ route('viewclasslist') }}" class="nav-link">
            <i class="nav-icon fas fa-school"></i>
            <p>
              Classes
            </p>
          </a>
        </li>
        @endcan

        @can('assign subjects')
        <li class="nav-item has-treeview">
          <a id="subjectsmainAdd" href="{{ route('addsubject') }}" class="nav-link">
            <i class="nav-icon fas fa-poll-h"></i>
            <p>
              Subjects
              {{-- <i class="right fas fa-angle-left"></i> --}}
            </p>
          </a>
        </li>
        @endcan

        {{-- -------------------------------------------------------------------------------- --}}

        {{-- @can('view account summary')
            <li class="nav-item has-treeview">
              <a id="summarylistscroll" href="{{ route('summary') }}" class="nav-link">
        <i class="fa fa-list-alt nav-icon"></i>
        <p>
          Summary
        </p>
        </a>
        </li>
        @endcan --}}

        {{-- @can('fee management')
            <li class="nav-item">
              <a id="feesetup" href="{{ route('index_fees') }}" class="nav-link">
        <i class="fas fa-money-check nav-icon"></i>
        <p>
          Fees Management
        </p>
        </a>
        </li>
        @endcan --}}
        {{-- @can('invoice management')
            <li class="nav-item has-treeview">
              <a id="invoicelistscroll" href="{{ route('invoices') }}" class="nav-link">
        <i class="fas fa-file-invoice nav-icon"></i>
        <p>
          Invoice Management
        </p>
        </a>
        </li>
        @endcan --}}
        {{-- @can('can send or receive request')
            <li class="nav-item has-treeview">
              <a id="requestlistscroll" href="{{ route('order_request') }}" class="nav-link">
        <i class="fas fa-th-list nav-icon"></i>
        <p>
          Requests
        </p>
        </a>
        </li>
        @endcan --}}

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
        {{-- @can('fee collection')
            <li class="nav-item has-treeview">
              <a id="feecollection" href="{{ route('feecollection') }}" class="nav-link">
        <i class="fas fa-hand-holding-usd nav-icon"></i>
        <p>
          Fee Collection
        </p>
        </a>
        </li>
        @endcan --}}

        {{-- @can('access inventory')
            <li class="nav-item has-treeview">
              <a id="inventory" href="{{ route('inventory') }}" class="nav-link">
        <i class="fas fa-dolly-flatbed nav-icon"></i>
        <p>
          Inventory
        </p>
        </a>
        </li>
        @endcan --}}

        {{-- ------------------------------------------------------------------------------- --}}

        @can('add students')
        <li class="nav-item has-treeview">
          <a id="studentsmain" href="#" class="nav-link">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>
              Student
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
            @can('student attendance')
            <li class="nav-item has-treeview">
              <a id="studentattendanceaside" href="#" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>
                  Student Attendance
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                <li class="nav-item">
                  <a id="addstudentattendanceaside" href="{{ route('studentattendance') }}" class="nav-link">
                    <i class="nav-icon fas fa-plus"></i>
                    <p>Add</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="viewstudentattendance" href="{{ route('viewallstudents') }}" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>View</p>
                  </a>
                </li>
              </ul>
            </li>
            @endcan
            <li class="nav-item">
              <a id="studentsmainadd" href="{{ route('addstudent') }}" class="nav-link">
                <i class="nav-icon fas fa-plus"></i>
                <p>Add New</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="viewstudentaside" href="{{ route('viewstudent') }}" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Student list</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan

        @if (Auth::user()->hasRole('Teacher'))
        {{-- <li class="nav-item has-treeview">
                <a id="editteacher" href="{{ route('editprofileteacher') }}" class="nav-link">
        <i class="nav-icon fas fa-user-edit"></i>
        <p>
          Edit Profile
        </p>
        </a>
        </li> --}}
        <li class="nav-item">
          <a id="markmanageoption" href="{{ route('teacher_sec_remark') }}" class="nav-link">
            <i class="far fa-comment-alt nav-icon"></i>
            <p>
              Result Remark
            </p>
          </a>
        </li>
        @can('form teacher')
        <li class="nav-item has-treeview">
          <a id="formmasteroption" href="#" class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
              Form Master
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
            @can('form teacher')
            <li class="nav-item">
              <a id="formmasteroption" href="{{ route('form_teacher_multiple') }}" class="nav-link">
                <i class="fas fa-school nav-icon"></i>
                <p>
                  Manage Classes
                </p>
              </a>
            </li>
            @endcan
            @can('form teacher')
            <li class="nav-item has-treeview">
              <a id="studentattendanceaside" href="#" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>
                  Student Attendance
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                <li class="nav-item">
                  <a id="addstudentattendanceaside" href="{{ route('studentattendance') }}" class="nav-link">
                    <i class="nav-icon fas fa-plus"></i>
                    <p>Add</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="viewstudentattendance" href="{{ route('viewallstudents') }}" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>View</p>
                  </a>
                </li>
              </ul>
            </li>
            @endcan
          </ul>
        </li>
        @endcan

        @can('form teacher')
        <li class="nav-item">
          <a id="formmasteroptionelective" href="{{ route('add_student_electives') }}" class="nav-link">
            <i class="fas fa-user-plus nav-icon"></i>
            <p>
              Assigned Electives
            </p>
          </a>
        </li>
        @endcan
        <li class="nav-item">
          <a href="{{ route('assignment_teachers') }}" class="nav-link">
            <i class="fas fa-tasks nav-icon"></i>
            <p>Assignment</p>
          </a>
        </li>
        @can('form teacher')
        <li class="nav-item has-treeview">
          <a id="viewteacherattendanceaside" href="/viewallteachers" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>View Attendance</p>
          </a>
        </li>
        @endcan
        {{-- @can('form teacher')
        <li class="nav-item has-treeview">
          <a id="viewteacherattendanceaside" href="/viewallteachers" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Mark Manage</p>
          </a>

        </li>
        @endcan --}}
        {{-- @can('form teacher')
        <li class=" nav-item has-treeview">
          <a id="psyhcomoto" href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Psychomotor
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
            @can('add psychomotor')
            <li class="nav-item">
              <a id="psyhcomotoadd" href="{{ route('student_moto') }}" class="nav-link">
        <i class="nav-icon fas fa-plus"></i>
        <p>add</p>
        </a>
        </li>
        @endcan
        @can('add moto settings')
        <li class="nav-item">
          <a id="psyhcomotosettings" href="{{ route('setting_moto') }}" class="nav-link">
            <i class=" nav-icon fas fa-cog"></i>
            <p>set psychomotor</p>
          </a>
        </li>
        @endcan

        </ul>
        </li>
        @endcan --}}
        @endif

        @can('manage staff')
        <li class="nav-item has-treeview">
          <a id="managestaffscroll" href="#" class="nav-link">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>
              Manage Staff
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
            @can('manage staff')
            <li class="nav-item">
              <a id="addStaff" href="{{ route('addstaff') }}" class="nav-link">
                <i class="nav-icon fas fa-user-plus"></i>
                <p>Add Non-Academic Staff</p>
              </a>
            </li>
            @endcan
            @can('assign form teacher')
            <li class="nav-item has-treeview">
              <a id="teachersmain" href="#" class="nav-link">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                  Teacher
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                <li class="nav-item">
                  <a id="addteachersmain" href="{{ route('addteacher') }}" class="nav-link">
                    <i class="nav-icon fas fa-plus"></i>
                    <p>Add New</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="formmasteroptionadd" href="/form_teacher_sec_index" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Form Teacher</p>
                  </a>
                </li>
              </ul>
            </li>
            @endcan
            @can('take teachers attendance')
            <li class="nav-item has-treeview">
              <a id="teachersattendanceaside" href="#" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>
                  Teacher Attendance
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                <li class="nav-item">
                  <a id="addteacherattendanceaside" href="{{ route('teachersattendance') }}" class="nav-link">
                    <i class="nav-icon fas fa-plus"></i>
                    <p>Add</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a id="viewteacherattendanceaside" href="/viewallteachers" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>View</p>
                  </a>
                </li>
              </ul>
            </li>
            @endcan

          </ul>
        </li>
        @endcan


        <li class="nav-item">
          <a id="calender" href="{{ route('calender_index') }}" class="nav-link">
            <i class="fas fa-calendar-day nav-icon"></i>
            <p>
              Calender
            </p>
          </a>
        </li>

        @can('psychomotor module')
        <li class=" nav-item has-treeview">
          <a id="psyhcomoto" href="#" class="nav-link">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Psychomotor
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
            @can('add psychomotor')
            <li class="nav-item">
              <a id="psyhcomotoadd" href="{{ route('student_moto') }}" class="nav-link">
                <i class="nav-icon fas fa-plus"></i>
                <p>add</p>
              </a>
            </li>
            @endcan
            @can('add moto settings')
            <li class="nav-item">
              <a id="psyhcomotosettings" href="{{ route('setting_moto') }}" class="nav-link">
                <i class=" nav-icon fas fa-cog"></i>
                <p>set psychomotor</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endcan



        @can('result module')
        <li class="nav-item has-treeview">
          <a id="resultaside" href="#" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
              Result
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">

            @can('manage marks')
            <li class="nav-item has-treeview">
              <a id="managemarkscroll" href="{{ route('managemarks') }}" class="nav-link">
                <i class="nav-icon fas fa-check-double"></i>
                <p>
                  Mark Manage
                </p>
              </a>
            </li>
            @endcan

            @can('view student result')
            <li class="nav-item">
              <a id="resultmaingenscroll" href="{{ route('result_by_class') }}" class="nav-link">
                <i class="far fa-eye nav-icon"></i>
                <p>Result By Class</p>
              </a>
            </li>
            @endcan

            @can('generate student result')
            <li class="nav-item">
              <a id="resultmaingenscrollgenerate" href="{{ route('generate_result') }}" class="nav-link">
                <i class="fa fa-print nav-icon"></i>
                <p>Generate</p>
              </a>
            </li>
            @endcan

            {{-- <li class="nav-item">
              <a href="" class="nav-link">
                  <i class="fas fa-clipboard-list nav-icon"></i> 
                <p>Admin Comment</p>
              </a>
            </li> --}}

            @can('setup comment')
            <li class="nav-item">
              <a id="commentsetup" href="{{ route('setupcomment') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>SetUp Comments</p>
              </a>
            </li>
            @endcan

          </ul>
        </li>
        @endcan

        @can('student promotion')
        <li class="nav-item has-treeview">
          <a id="promotionscroll" href="{{ route('promotion') }}" class="nav-link">
            <i class="nav-icon fas fa-exchange-alt"></i>
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
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
            <li class="nav-item">
              <a id="gradesaside" href="{{ route('grades_sec') }}" class="nav-link">
                <i class="nav-icon fas fa-graduation-cap"></i>
                <p>Grade</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="usersaside" href="{{ route('allusers_sec') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="schoolsetupaside" href="{{ route('setupschool') }}" class="nav-link">
                <i class="nav-icon fas fa-university"></i>
                <p>Set Up Shool</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="schoolsetupaside" href="{{ route('payment_details') }}" class="nav-link">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Payment Details</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="institutionaside" href="/addschool" class="nav-link">
                <i class="nav-icon fa fa-building"></i>
                <p>Institute</p>
              </a>
            </li>
            <li class="nav-item">
              <a id="institutionaside" href="/sub_index" class="nav-link">
                <i class="nav-icon fas fa-rocket"></i>
                <p>Subscription</p>
              </a>
            </li>
          </ul>
        </li>
        @endcan








        @if (Auth::user()->hasRole('Student'))
        <li class="nav-item has-treeview">
          <a id="resultmainscroll" href="#" class="nav-link">
            <i class="fas fa-list-alt nav-icon"></i>
            <p>
              Result
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
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
            <i class="fas fa-file-invoice nav-icon"></i>
            <p>Transactions</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('manage_subject_student') }}" class="nav-link">
            <i class="fas fa-poll-h nav-icon"></i>
            <p>Registered Subjects</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('assignment_student') }}" class="nav-link">
            <i class="fas fa-tasks nav-icon"></i>
            <p>Assignment</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a id="viewstudentattendance" href="{{ route('viewallstudents') }}" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>View Attendance</p>
          </a>
        </li>
        @endif

        {{-- ---------------------------------------------------------------------------------- --}}
        {{-- teachers role --}}
        {{-- ---------------------------------------------------------------------------------- --}}
        {{-- @if (Auth::user()->role == 'Teacher')
        
                  <li class="nav-item has-treeview">
                    <a id="studentattendanceaside" href="#" class="nav-link">
                      <i class="nav-icon fas fa-clock"></i> 
                      <p>
                        Student Attendance
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                      <li class="nav-item">
                        <a id="addstudentattendanceaside" href="/studentattendance" class="nav-link">
                           <i class="nav-icon fas fa-plus"></i> 
                          <p>Add</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a id="viewstudentattendance" href="/viewallstudents" class="nav-link">
                           <i class="nav-icon fas fa-clipboard-list"></i> 
                          <p>View</p>
                        </a>
                      </li>
                    </ul>
                    <li class="nav-item has-treeview">
                    <a id="viewmarks" href="#" class="nav-link">
                      <i class="nav-icon fas fa-check-double"></i> 
                      <p>
                        Mark Manage
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                      <li class="nav-item">
                        <a id="viewmarksadd" href="/managemarks" class="nav-link">
                           <i class="nav-icon fas fa-plus"></i> 
                          <p>Add New</p>
                        </a>
                      </li>
                     
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="pychomotoraside" href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i> 
                      <p>
                        Psychomotor
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                      <li class="nav-item">
                        <a id="affectivedomainaside" href="/moto" class="nav-link">
                           <i class="nav-icon fas fa-plus"></i> 
                          <p>affective domain</p>
                        </a>
                      </li>
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="resultaside" href="#" class="nav-link">
                      <i class="nav-icon fas fa-vials"></i> 
                      <p>
                        Result
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                      <li class="nav-item">
                        <a id="geberateresultaside" href="/result" class="nav-link">
                           <i class="nav-icon fas fa-clipboard-list"></i> 
                          <p>Generate</p>
                        </a>
                      </li>
                     
                    </ul>
                  </li>
        
                  <li class="nav-item has-treeview">
                    <a id="promotionaside" href="/promotion" class="nav-link">
                      <i class="nav-icon fas fa-exchange-alt"></i> 
                      <p>
                        Promotion
                        
                      </p>
                    </a>
                  </li>

                  <li class="nav-item has-treeview">
                    <a id="promotionaside" href="/promotion" class="nav-link">
                      <i class="nav-icon fas fa-tasks"></i> 
                      <p>
                        Assignment
                      </p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
          SignOut
        </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        </li>
        @endif --}}
        {{-- ------------------------------------------------------------------------------- --}}
        {{-- supervisor --}}
        {{-- ------------------------------------------------------------------------------- --}}
        @if (Auth::user()->role == 'Supervisor')
        {{-- <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-address-card"></i> 
                    <p>
                      Teacher Attendance
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style=" color: #90ada7; padding-left: 10px !important;  border-bottom: 1px solid #585858;  font-size: 14px;">
                    <li class="nav-item">
                      <a href="/teachersattendance" class="nav-link">
                         <i class="nav-icon fas fa-plus"></i> 
                        <p>Add</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="/viewallteachers" class="nav-link">
                         <i class="nav-icon fas fa-clipboard-list"></i> 
                        <p>View</p>
                      </a>
                    </li>
                  </ul>
                </li> --}}
        @endif

        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              SignOut
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