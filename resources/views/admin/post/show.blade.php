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
	<a href="{{ route('admin.post.index') }}" class="btn btn-danger waves-effect">BACK</a>
	@if($post->is_approved == false)
	<button type="button" class="btn btn-danger waves-effect pull-right">
		<i class="material-icons">pending</i>
         <a href="{{ route('admin.post.approve', $post->id) }}"> 
		<span style="color:white;">Pending</span></a>
	</button>
	<!-- Vertical Layout | With Floating Label -->
	<!-- <form action="{{ route('admin.post.approve',$post->id) }}" method="POST" id="approval-form" style="display: none"">  -->
		 <!-- @csrf  -->
		 <!-- @method('PUT')  -->
	<!-- </form>   -->
	@else
	<button type="button" class="btn btn-success pull-right" disabled>
		<i class="material-icons">done</i>
         <a href="{{ route('admin.post.approve', $post->id) }}">
		<span style="color:white;">Approved</span></a>
	</button>
	@endif
	<br>
	<br>
	<div class="row clearfix">
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						{{ $post->title }}
						<small>Posted By <strong> <a href="">{{ $post->user->name }}</a></strong> on {{ $post->created_at->format('d/m/Y H:i:s') }}</small>
					</h2>
				</div>
				<div class="body">
					{!! $post->description !!} <br><br>
					{!! $post->body !!}
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header bg-cyan">
					<h2>
						Categories
					</h2>
				</div>
				<div class="body">
					@foreach($post->categories as $category)
					<span class="label bg-cyan">{{ $category->name }}</span>
					@endforeach
				</div>
			</div>

			<div class="card">
				<div class="header bg-green">
					<h2>
						Tags
					</h2>
				</div>
				<div class="body">
					@foreach($post->tags as $tag)
					<span class="label bg-green">{{ $tag->name }}</span>
					@endforeach
				</div>
			</div>

			<div class="card">
				<div class="header bg-amber">
					<h2>
						Featured Image
					</h2>
				</div>
				<div class="body">
					<img class="img-responsive thumbnail" src="{{ Storage::disk('public')->url('post/'.$post->image) }}" alt="">
				</div>
			</div>

		</div>
	</div>
</div>


</div>
@endsection

@push('js')
<!-- Select Plugin Js -->
<script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<!-- TinyMCE -->
<!-- <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script> -->
<script src="{{ asset('assets/backend/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
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
	// $(document).ready(function(){
	// 	setTimeout(function() {
	// 		$('.alert-success').fadeOut('fast');
	// 		$('.alert-danger').fadeOut('fast');
	// 	}, 3000);
	// });
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

     <script type="text/javascript">
    	function approvePost(id) {
    		swal({
    			title: 'Are you sure?',
    			text: "You went to approve this post ",
    			type: 'warning',
    			showCancelButton: true,
    			confirmButtonColor: '#3085d6',
    			cancelButtonColor: '#d33',
    			confirmButtonText: 'Yes, approve it!',
    			cancelButtonText: 'No, cancel!',
    			confirmButtonClass: 'btn btn-success',
    			cancelButtonClass: 'btn btn-danger',
    			buttonsStyling: false,
    			reverseButtons: true
    		}).then((result) => {
    			if (result.value) {
    				event.preventDefault();
    				document.getElementById('approval-form').submit();
    			} else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                    ) {
    				swal(
    					'Cancelled',
    					'The post remain pending :)',
    					'info'
    					)
    			}
    		})
    	}
    </script> 

    @endpush