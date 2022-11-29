@extends('admin.index')
@section('content')


<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
		<div class="">
			<span>
			{{ !empty($title)?$title:'' }}
			</span>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only"></span>
			</a>
			<div class="dropdown-menu" role="menu">
				<a href="{{ aurl('socials') }}"  style="color:#343a40"  class="dropdown-item">
				<i class="fas fa-list"></i> {{ trans('admin.show_all') }}</a>
			</div>
		</div>
		</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
			<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
		</div>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
								
{!! Form::open(['url'=>aurl('/socials'),'id'=>'socials','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
<div class="row">

<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('name',trans('admin.name'),['class'=>' control-label']) !!}
            {!! Form::text('name',old('name'),['class'=>'form-control','placeholder'=>trans('admin.name')]) !!}
    </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 logo">
    <div class="form-group">
        <label for="'logo'">{{ trans('admin.logo') }}</label>
        <div class="input-group">
            <div class="custom-file">
                {!! Form::file('logo',['class'=>'custom-file-input','placeholder'=>trans('admin.logo'),"accept"=>it()->acceptedMimeTypes("image"),"id"=>"logo"]) !!}
                {!! Form::label('logo',trans('admin.logo'),['class'=>'custom-file-label']) !!}
            </div>
            <div class="input-group-append">
                <span class="input-group-text" id="">{{ trans('admin.upload') }}</span>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('link',trans('admin.link'),['class'=>'control-label']) !!}
        {!! Form::url('link',old('link'),['class'=>'form-control','placeholder'=>trans('admin.link')]) !!}
    </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 file">
    <div class="form-group">
        <label for="'file'">{{ trans('admin.file') }}</label>
        <div class="input-group">
            <div class="custom-file">
                {!! Form::file('file',['class'=>'custom-file-input','placeholder'=>trans('admin.file'),"accept"=>it()->acceptedMimeTypes(""),"id"=>"file"]) !!}
                {!! Form::label('file',trans('admin.file'),['class'=>'custom-file-label']) !!}
            </div>
            <div class="input-group-append">
                <span class="input-group-text" id="">{{ trans('admin.upload') }}</span>
            </div>
        </div>
    </div>
</div>

</div>
		<!-- /.row -->
	</div>
	<!-- /.card-body -->
	<div class="card-footer"><button type="submit" name="add" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
<button type="submit" name="add_back" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add_back') }}</button>
{!! Form::close() !!}	</div>
</div>
@endsection