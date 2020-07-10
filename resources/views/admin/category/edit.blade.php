@extends('layouts.backend.app')

@section('title','Edit category')

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
						Edit category
					</h2>
					<div class="body">
						<form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="form-group form-float {{ $errors->first('name') ? 'has-error' : '' }}">
								<div class="form-line">
									<input type="text" id="name" class="form-control" name="name" value="{{ $category->name }}">
									<label class="form-label">Add new category name...<span class="text-danger">(*)</label>
									</div>
									@if ($errors->first('name'))
									<span class="text-danger">{{ $errors->first('name') }} </span>
									@endif
								</div>

								<div class="form-group {{ $errors->first('image') ? 'has-error' : '' }}">
									

                                <input type="file" name="image">
                                
                                
                                @if ($errors->first('image'))
									<span class="text-danger">{{ $errors->first('image') }} </span>
									@endif
                            	</div>
								
								<a class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.category.index') }}">Quay lại</a>
								<button type="submit" class="btn btn-primary m-t-15 waves-effect">Lưu</button>
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