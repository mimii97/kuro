
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\VotePlan::count()) }}</h3>
        <p>{{ trans("user.voteplans") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ url("user/voteplans") }}" class="small-box-footer">{{ trans("user.voteplans") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--voteplans_end-->

<!--bfotplans_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\BFOTPlan::count()) }}</h3>
        <p>{{ trans("user.bfotplans") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ url("user/bfotplans") }}" class="small-box-footer">{{ trans("user.bfotplans") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--bfotplans_end-->

<!--icousers_start-->
<div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>{{ mK(App\Models\IcoUser::count()) }}</h3>
        <p>{{ trans("user.icousers") }}</p>
      </div>
      <div class="icon">
        <i class="fa fa-icons"></i>
      </div>
      <a href="{{ url("/user/icousers") }}" class="small-box-footer">{{ trans("user.icousers") }} <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<!--icousers_end-->
