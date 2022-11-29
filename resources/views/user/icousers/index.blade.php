@extends('user.index')
@section('content')
{!! Form::open(["method" => "post","url" => [aurl('/icousers/multi_delete')]]) !!}
<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">{{!empty($title)?$title:''}}</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
			<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
		</div>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<div class="row">
			<div class="table-responsive">
			{!! $dataTable->table(["class"=> "table table-striped table-bordered table-hover table-checkable dataTable no-footer"],true) !!}
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
</div>

{!! Form::close() !!}

@push('js')
{!! $dataTable->scripts() !!}
@endpush
		@endsection
		