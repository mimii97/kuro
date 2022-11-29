<!-- Add icons to the links using the .nav-icon class
with font-awesome or any other icon font library -->
<li class="nav-header"></li>
<li class="nav-item">
  <a href="{{ aurl('') }}" class="nav-link {{ active_link(null,'active') }}">
    <i class="nav-icon fas fa-home"></i>
    <p>
      {{ trans('admin.dashboard') }}
    </p>
  </a>
</li>
@if(admin()->user())

  @if(admin()->user()->role('settings_show'))
  <li class="nav-item">
    <a href="{{ aurl('settings') }}" class="nav-link  {{ active_link('settings','active') }}">
      <i class="nav-icon fas fa-cogs"></i>
      <p>
        {{ trans('admin.settings') }}
      </p>
    </a>
  </li>
  @endif
  @if(admin()->user()->role("admins_show"))
  <li class="nav-item {{ active_link('admins','menu-open') }}">
    <a href="#" class="nav-link  {{ active_link('admins','active') }}">
      <i class="nav-icon fas fa-users"></i>
      <p>
        {{trans('admin.admins')}}
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('admins')}}" class="nav-link {{ active_link('admins','active') }}">
          <i class="fas fa-users nav-icon"></i>
          <p>{{trans('admin.admins')}}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('admins/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}}</p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  @if(admin()->user()->role("admingroups_show"))
  <li class="nav-item {{ active_link('admingroups','menu-open') }}">
    <a href="#" class="nav-link  {{ active_link('admingroups','active') }}">
      <i class="nav-icon fas fa-users"></i>
      <p>
        {{trans('admin.admingroups')}}
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('admingroups')}}" class="nav-link {{ active_link('admingroups','active') }}">
          <i class="fas fa-users nav-icon"></i>
          <p>{{trans('admin.admingroups')}}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('admingroups/create') }}" class="nav-link ">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}}</p>
        </a>
      </li>
    </ul>
  </li>
  @endif




  <!--pages_start_route-->
  @if(admin()->user()->role("pages_show"))
  <li class="nav-item {{active_link('pages','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('pages','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.pages')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('pages')}}" class="nav-link  {{active_link('pages','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.pages')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('pages/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--pages_end_route-->

  <!--slides_start_route-->
  @if(admin()->user()->role("slides_show"))
  <li class="nav-item {{active_link('slides','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('slides','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.slides')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('slides')}}" class="nav-link  {{active_link('slides','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.slides')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('slides/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--slides_end_route-->

  <!--banners_start_route-->
  @if(admin()->user()->role("banners_show"))
  <li class="nav-item {{active_link('banners','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('banners','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.banners')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('banners')}}" class="nav-link  {{active_link('banners','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.banners')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('banners/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--banners_end_route-->

  <!--infos_start_route-->
  @if(admin()->user()->role("infos_show"))
  <li class="nav-item {{active_link('infos','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('infos','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.infos')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('infos')}}" class="nav-link  {{active_link('infos','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.infos')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('infos/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--infos_end_route-->

  <!--socials_start_route-->
  @if(admin()->user()->role("socials_show"))
  <li class="nav-item {{active_link('socials','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('socials','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.socials')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('socials')}}" class="nav-link  {{active_link('socials','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.socials')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('socials/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--socials_end_route-->


  <!--users_start_route-->
  @if(admin()->user()->role("users_show"))
  <li class="nav-item {{active_link('users','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('users','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.users')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('users')}}" class="nav-link  {{active_link('users','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.users')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('users/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--users_end_route-->
  <!--voteplans_start_route-->
@if(admin()->user()->role("voteplans_show"))
<li class="nav-item {{active_link('voteplans','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('voteplans','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.voteplans')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('voteplans')}}" class="nav-link  {{active_link('voteplans','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.voteplans')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('voteplans/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
  </li>
  @endif
  <!--voteplans_end_route-->

  <!--bfotplans_start_route-->
  @if(admin()->user()->role("bfotplans_show"))
  <li class="nav-item {{active_link('bfotplans','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('bfotplans','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.bfotplans')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('bfotplans')}}" class="nav-link  {{active_link('bfotplans','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.bfotplans')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('bfotplans/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--bfotplans_end_route-->

  <!--blogs_start_route-->
  @if(admin()->user()->role("blogs_show"))
  <li class="nav-item {{active_link('blogs','menu-open')}} ">
    <a href="#" class="nav-link {{active_link('blogs','active')}}">
      <i class="nav-icon fa fa-icons"></i>
      <p>
        {{trans('admin.blogs')}} 
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{aurl('blogs')}}" class="nav-link  {{active_link('blogs','active')}}">
          <i class="fa fa-icons nav-icon"></i>
          <p>{{trans('admin.blogs')}} </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ aurl('blogs/create') }}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>{{trans('admin.create')}} </p>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <!--blogs_end_route-->

 


<!--comments_start_route-->
@if(admin()->user()->role("comments_show"))
<li class="nav-item {{active_link('comments','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('comments','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.comments')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('comments')}}" class="nav-link  {{active_link('comments','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.comments')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--comments_end_route-->

<!--reactions_start_route-->
@if(admin()->user()->role("reactions_show"))
<li class="nav-item {{active_link('reactions','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('reactions','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.reactions')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('reactions')}}" class="nav-link  {{active_link('reactions','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.reactions')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--reactions_end_route-->
  <!--This endif for check if the user is admin-->
@endif


<!--icos_start_route-->
@if(admin()->user()->role("icos_show"))
<li class="nav-item {{active_link('icos','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('icos','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.icos')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('icos')}}" class="nav-link  {{active_link('icos','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.icos')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('icos/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--icos_end_route-->

<!--icousers_start_route-->
@if(admin()->user()->role("icousers_show"))
<li class="nav-item {{active_link('icousers','menu-open')}} ">
  <a href="#" class="nav-link {{active_link('icousers','active')}}">
    <i class="nav-icon fa fa-icons"></i>
    <p>
      {{trans('admin.icousers')}} 
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
      <a href="{{aurl('icousers')}}" class="nav-link  {{active_link('icousers','active')}}">
        <i class="fa fa-icons nav-icon"></i>
        <p>{{trans('admin.icousers')}} </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ aurl('icousers/create') }}" class="nav-link">
        <i class="fas fa-plus nav-icon"></i>
        <p>{{trans('admin.create')}} </p>
      </a>
    </li>
  </ul>
</li>
@endif
<!--icousers_end_route-->
