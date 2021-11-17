 
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("public/admin/bower_components/AdminLTE/dist/img/avatar5.png") }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="treeview {{(Request::segment(2) == 'event-days' || Request::segment(2) == 'blog')? 'active' : '' }}">
          <a href="#"><i class="fa fa-link"></i> <span>Quản lý sự kiện</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{(Request::segment(2) == 'event-days')? 'active' : '' }}">
              <a href="{{ url('admin/event-days') }}">Ngày sự kiện</a>
            </li>
            <li class="{{(Request::segment(2) == 'blog')? 'active' : '' }}">
              <a href="{{ url('admin/blog') }}">Danh sách</a>
            </li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>