@extends('user.index')
@section('content')
<div class="error-page">
    <h2 class="headline text-info">403</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-info"></i> {{ trans('admin.error_permission_1') }}</h3>
        <p>
          {{ trans('user.error_permission_2') }}
        </p>
         <p> {{ trans('user.error_permission_4') }}
                <br/>
                <a href="{{ url('/') }}"> {{ trans('user.error_permission_5') }} </a>
            {{ trans('user.error_permission_6') }} </p>

    </div>
</div>
<!-- /.error-page -->
@endsection