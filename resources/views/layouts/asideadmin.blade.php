    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
               style="opacity: .8">
          <span class="brand-text font-weight-light">
            {{Auth::user()->role}}
          </span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
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
                <a href="/superadmin" id="dashboardadmin" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/order" id="orderoption" class="nav-link">
                  <i class="nav-icon fas fa-graduation-cap"></i>
                  <p>
                    Orders
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/manageadmin" id="managerole" class="nav-link">
                  <i class="nav-icon fas fa-network-wired"></i>
                  <p>
                    Manage Role
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/technicalsupport" id="technicalsupport" class="nav-link">
                  <i class="nav-icon fas fa-dharmachakra"></i>
                  <p>
                    Technical Support
                    <span class="right badge badge-danger">New</span>
                  </p>
                </a>
              </li>
                <li class="nav-item">
                <a href="/add_feedback_admin" id="feed_back" class="nav-link">
                  <i class="nav-icon fas fa-dharmachakra"></i>
                  <p>
                    Feed-Back
                    <!--<span class="right badge badge-danger">New</span>-->
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/callrequest" id="callrequest" class="nav-link">
                  <i class="nav-icon fas fa-headset"></i>
                  <p>
                    Call Requests
                    {{-- <span id="callRequestCountNotify" class="right badge badge-danger">0</span> --}}
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/rolesmanage" class="nav-link">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Manage Permission</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('role_list') }}" class="nav-link">
                  <i class="nav-icon far fa-circle text-info"></i>
                  <p>Roles</p>
                </a>
              </li>
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
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>