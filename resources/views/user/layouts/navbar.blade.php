  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand
 {{ !empty(setting()->theme_setting) &&
    !empty(setting()->theme_setting->navbar)?
    setting()->theme_setting->navbar:'navbar-dark' }}
{{ !empty(setting()->theme_setting) &&
   !empty(setting()->theme_setting->main_header)?
    setting()->theme_setting->main_header:'' }}
    ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
       
        @if (auth()->user())
          <a href="{{ url('user/logout') }}" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i> {{ trans('user.logout') }}</a>

        @endif
        
      </li>
     
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}


    
  </nav>
  <!-- /.navbar -->
<!-- /.navbar -->
<!-- Main Sidebar Menu Container -->
<aside class="main-sidebar {{ !empty(setting()->theme_setting) && !empty(setting()->theme_setting->sidebar_class)?setting()->theme_setting->sidebar_class:'sidebar-dark-primary' }} elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link {{ !empty(setting()->theme_setting) && !empty(setting()->theme_setting->brand_color)?setting()->theme_setting->brand_color:'' }}">
    @if(!empty(setting()->logo))
    <img src="{{ url('/storage/'.setting()->logo) }}" alt="{{ setting()->{l('sitename')} }}" class="brand-image img-circle elevation-3" style="opacity: .8">
    @endif
    <span class="brand-text font-weight-light">{{ setting()->{l('sitename')} }}</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
