<!--admingroups_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ App\Models\AdminGroup::count() }}</h3>
        <p>{{ trans('admin.admingroups') }}</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="{{ aurl('admingroups') }}" class="small-box-footer">{{ trans('admin.admingroups') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
<!--admingroups_end-->
<!--admins_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ App\Models\Admin::count() }}</h3>
        <p>{{ trans('admin.admins') }}</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="{{ aurl('admins') }}" class="small-box-footer">{{ trans('admin.admins') }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
<!--admins_end-->



<!--pages_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Page::count()) }}</h3>
        <p>{{ trans("admin.pages") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("pages") }}" class="small-box-footer">{{ trans("admin.pages") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--pages_end-->
<!--slides_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Slide::count()) }}</h3>
        <p>{{ trans("admin.slides") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("slides") }}" class="small-box-footer">{{ trans("admin.slides") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--slides_end-->
<!--banners_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Banner::count()) }}</h3>
        <p>{{ trans("admin.banners") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("banners") }}" class="small-box-footer">{{ trans("admin.banners") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--banners_end-->
<!--infos_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Info::count()) }}</h3>
        <p>{{ trans("admin.infos") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("infos") }}" class="small-box-footer">{{ trans("admin.infos") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--infos_end-->
<!--socials_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Social::count()) }}</h3>
        <p>{{ trans("admin.socials") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("socials") }}" class="small-box-footer">{{ trans("admin.socials") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--socials_end-->
<!--voteplans_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\VotePlan::count()) }}</h3>
        <p>{{ trans("admin.voteplans") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("voteplans") }}" class="small-box-footer">{{ trans("admin.voteplans") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--voteplans_end-->
<!--bfotplans_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\BFOTPlan::count()) }}</h3>
        <p>{{ trans("admin.bfotplans") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("bfotplans") }}" class="small-box-footer">{{ trans("admin.bfotplans") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--bfotplans_end-->
<!--blogs_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Blog::count()) }}</h3>
        <p>{{ trans("admin.blogs") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("blogs") }}" class="small-box-footer">{{ trans("admin.blogs") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--blogs_end-->

<!--comments_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Comment::count()) }}</h3>
        <p>{{ trans("admin.comments") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("comments") }}" class="small-box-footer">{{ trans("admin.comments") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--comments_end-->
<!--reactions_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\Reaction::count()) }}</h3>
        <p>{{ trans("admin.reactions") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("reactions") }}" class="small-box-footer">{{ trans("admin.reactions") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--reactions_end-->
<!--icos_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\ICO::count()) }}</h3>
        <p>{{ trans("admin.icos") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("icos") }}" class="small-box-footer">{{ trans("admin.icos") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--icos_end-->
<!--icousers_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\IcoUser::count()) }}</h3>
        <p>{{ trans("admin.icousers") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ aurl("icousers") }}" class="small-box-footer">{{ trans("admin.icousers") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--icousers_end-->