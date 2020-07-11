@extends('layouts.backend.app')

@section('title','Post')

@push('css')
<!-- Bootstrap Select Css -->
<link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
<style>
	.hidden{display:none;}
</style>
@endpush

@section('content')
<div class="container-fluid">
	<!-- Vertical Layout | With Floating Label -->
	<form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="row clearfix">
			<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							ADD NEW POST
						</h2>
					</div>
					<div class="body">
						<div class="form-group form-float">
							<div class="form-line">
								<input type="text" id="title" class="form-control" name="title" required>
								<label class="form-label">Post Title</label>
							</div>
						</div>
						<div class="form-group form-float">
							<div class="form-line">
								<textarea  id="description" class="form-control" rows="10" name="description" style="resize:none;" required></textarea>
								<label class="form-label">Post description</label>
							</div>
						</div>

						

					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							Categories and Tags
						</h2>
					</div>
					<div class="body">
						<div class="form-group form-float">
							<!-- <div class="form-line {{ $errors->has('categories') ? 'focused error' : '' }}"> -->
								<label for="category">Select Category</label>
								<select name="categories[]" id="category" class="form-control show-tick" data-live-search="true"  multiple required>
									@foreach($categories as $category)
									<option style="text-align: center" value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group form-float">
							<!-- <div class="form-line {{ $errors->has('tags') ? 'focused error' : '' }}"> -->
								<label for="tag">Select Tags</label>
								<select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true" multiple required>
									@foreach($tags as $tag)
									<option style="text-align: center" value="{{ $tag->id }}">{{ $tag->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					
						<div class="form-group form-float {{ $errors->first('image') ? 'has-error' : '' }}">
							<div class="form-group">
							<label for="image">Featured Image</label>
							<input type="file" name="image">
							@if ($errors->first('image'))
									<span class="text-danger">{{ $errors->first('image') }} </span>
									@endif
						</div>
						
						<div class="form-group">
							<input type="checkbox" id="publish" class="filled-in" name="status" value="1">
							<label for="publish">Publish</label>
						</div>
						</div>

						

					</div>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>
							BODY
						</h2>
					</div>
					<div class="body">
						<textarea id="content" name="body" required></textarea>
						<a  class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.post.index') }}">BACK</a>
						<button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
						<!-- <textarea id="tinymce"></textarea> -->
						<!-- <textarea id="tinymce" name="body"></textarea> -->
						
					</div>

				</div>
			</div>
		</div>
	</form>
</div>
@endsection

@push('js')
<!-- Select Plugin Js -->
<script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<!-- TinyMCE -->
<!-- <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script> -->
<script src="{{ asset('assets/backend/plugins/ckeditor/ckeditor.js') }}"></script>

<!-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->

<script>
	var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
	CKEDITOR.replace( 'content', options );
</script>


    <script>
			$(document).ready(function(){
				setTimeout(function() {
					$('.alert-success').fadeOut('fast');
					$('.alert-danger').fadeOut('fast');
				}, 3000);
			});
		</script>

 <!-- <script>
	$(function () {
            //TinyMCE
            tinymce.init({
            	selector: "textarea#tinymce",
            	theme: "modern",
            	height: 300,
            	plugins: [
            	'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            	'searchreplace wordcount visualblocks visualchars code fullscreen',
            	'insertdatetime media nonbreaking save table contextmenu directionality',
            	'emoticons template paste textcolor colorpicker textpattern imagetools'
            	],
            	toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            	toolbar2: 'print preview media | forecolor backcolor emoticons',
            	image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('assets/backend/plugins/tinymce') }}';
        });
    </script>  -->

    <!-- <script>
    	$(document).ready(function() {
    		tinymce.init({
    			selector: "textarea",
    			theme: "modern",
    			paste_data_images: true,
    			plugins: [
    			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
    			"searchreplace wordcount visualblocks visualchars code fullscreen",
    			"insertdatetime media nonbreaking save table contextmenu directionality",
    			"emoticons template paste textcolor colorpicker textpattern"
    			],
    			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    			toolbar2: "print preview media | forecolor backcolor emoticons",
    			image_advtab: true,
    			file_picker_callback: function(callback, value, meta) {
    				if (meta.filetype == 'image') {
    					$('#upload').trigger('click');
    					$('#upload').on('change', function() {
    						var file = this.files[0];
    						var reader = new FileReader();
    						reader.onload = function(e) {
    							callback(e.target.result, {
    								alt: ''
    							});
    						};
    						reader.readAsDataURL(file);
    					});
    				}
    			},
    			templates: [{
    				title: 'Test template 1',
    				content: 'Test 1'
    			}, {
    				title: 'Test template 2',
    				content: 'Test 2'
    			}]
    		});
    	});
    </script> -->

    @endpush