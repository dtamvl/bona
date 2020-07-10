@extends('layouts.backend.app')

@section('title','Add new Tag')

@push('css')


@endpush

@section('content')


<div class="container-fluid">

	<!-- Vertical Layout | With Floating Label -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2 style="color:blue; font-weight: bold; text-transform: uppercase;">
						Add new Tag
					</h2>
					<div class="body">
						<form action="{{ route('admin.tag.store') }}" method="POST">
							@csrf
							<div class="form-group form-float {{ $errors->first('name') ? 'has-error' : '' }}">
								<div class="form-line">
									<input type="text" id="name" class="form-control" name="name">
									<label class="form-label">Add new tag...<span class="text-danger">(*)</label>
									</div>
									@if ($errors->first('name'))
									<span class="text-danger">{{ $errors->first('name') }} </span>
									@endif
								</div>
								
								<a class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.tag.index') }}">Back</a>
								<button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>

		@endsection

		@push('js')

		<script>
			$(document).ready(function(){
				setTimeout(function() {
					$('.alert-success').fadeOut('fast');
				}, 3000);
			});
		</script>
		@endpush