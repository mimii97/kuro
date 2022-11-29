<!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
<li class="nav-header"></li>
<li class="nav-item">
  <a href="{{ url('user/dashboard') }}" class="nav-link {{ active_link(null,'active') }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      {{ trans('user.dashboard') }}
    </p>
  </a>
</li>

@if(auth()->user())


  <!--voteplans_start_route-->
@if(auth()->user()->role("voteplans_show"))
<li class="nav-item {{active_link('voteplans','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('voteplans','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('user.voteplans')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('user/voteplans')}}" class="nav-link  {{active_link('voteplans','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('user.voteplans')}} </p>
      </a>
    </li>
    
  </ul>
  </li>
  @endif
  <!--voteplans_end_route-->

  <!--bfotplans_start_route-->
  @if(auth()->user()->role("bfotplans_show"))
  <li class="nav-item {{active_link('bfotplans','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('bfotplans','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('user.bfotplans')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{url('user/bfotplans')}}" class="nav-link  {{active_link('bfotplans','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('user.bfotplans')}} </p>
        </a>
      </li>

    </ul>
  </li>
  @endif
  <!--bfotplans_end_route-->

  <!--icousers_start_route-->
@if(auth()->user()->role("icousers_show"))
<li class="nav-item {{active_link('icousers','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('icousers','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('user.icousers')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{url('user/icousers')}}" class="nav-link  {{active_link('icousers','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('user.icousers')}} </p>
      </a>
    </li>

  </ul>
</li>
@endif
<!--icousers_end_route-->

  <!--This endif for check if the user is User Role-->
@endif

