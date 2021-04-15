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
              <i class="nav-icon fas fa-arrow-alt-circle-left"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a id="dashboard_dash" href="{{ route('account_dash') }}" class="nav-link">
                <i class="fas fa-tachometer-alt nav-icon"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a id="summarylistscroll" href="{{ route('summary') }}" class="nav-link">
              <i class="fas fa-coins nav-icon"></i>
              <p>
                Summary
              </p>
            </a>
          </li>

            <li class="nav-item">
              <a id="feesetup" href="{{ route('index_fees') }}" class="nav-link">
                  <i class="fas fa-money-check nav-icon"></i>
                <p>
                  Fees Management
                </p>
              </a>
            </li>
            
            <li class="nav-item has-treeview">
              <a id="invoicelistscroll" href="{{ route('invoices') }}" class="nav-link">
                <i class="fas fa-file-invoice nav-icon"></i>
                <p>
                  Invoice Management
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a id="requestlistscroll" href="{{ route('order_request') }}" class="nav-link">
                <i class="fas fa-th-list nav-icon"></i>
                <p>
                  Requests
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a id="requestlistscroll" href="{{ route('order_request') }}" class="nav-link">
                <i class="fas fa-money-bill-wave-alt nav-icon"></i>
                <p>
                  Payment Record
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a id="feecollection" href="{{ route('feecollection') }}" class="nav-link">
                <i class="fas fa-hand-holding-usd nav-icon"></i>
                <p>
                  Fee Collection
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a id="feecollection" href="{{ route('inventory') }}" class="nav-link">
                <i class="fas fa-dolly-flatbed nav-icon"></i>
                <p>
                  Inventory
                </p>
              </a>
            </li>

            <li class="nav-item has-treeview">
              <a id="feecollection" href="{{ route('mail_main') }}" class="nav-link">
                <i class="fas fa-envelope nav-icon"></i>
                <p>
                  Mail
                </p>
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
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>