@extends('layouts.frontend.app')

@section('title','Trang tin tức')

@push('css')

<link href="{{ asset('assets/frontend/css/home/styles.css') }}" rel="stylesheet">

<link href="{{ asset('assets/frontend/css/home/responsive.css') }}" rel="stylesheet">

@endpush

@section('content')
<div class="main-slider">
    <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
    data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
    data-swiper-breakpoints="true" data-swiper-loop="true" >
    <div class="swiper-wrapper">
        @foreach($categories as $category)

        <div class="swiper-slide">
            <a class="slider-category" href="{{ route('category.posts',$category->slug) }}">
                <div class="blog-image"><img src="{{ Storage::disk('public')->url('category/slider/'.$category->image) }}" alt="{{ $category->name }}"></div>

                <div class="category">
                    <div class="display-table center-text">
                        <div class="display-table-cell">
                            <h3><b>{{ $category->name }}</b></h3>
                        </div>
                    </div>
                </div>

            </a>
        </div><!-- swiper-slide -->

        @endforeach

    </div><!-- swiper-wrapper -->

</div><!-- swiper-container -->

</div><!-- slider -->

<section class="blog-area section">
    <div class="container">

        <div class="row">
           @foreach($posts as $post)
           <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="single-post post-style-1">

                    <div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'.$post->image) }}" alt="{{ $post->title }}"></div>

                    <a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ Storage::disk('public')->url('profile/'.$post->user->avatar) }}" alt="Profile Image"></a>

                    <div class="blog-info">

                        <h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                        <ul class="post-footer">
                            <li>
                                @guest
                                <a href="javascript:void(0);" onclick="toastr.info('Bạn cần đăng nhập để thêm danh sách yêu thích tin.','Info',{
                                    closeButton: true,
                                    progressBar: true,
                                })"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>
                                @else
                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                 class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                 <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}" style="display: none;">
                                    @csrf
                                </form>
                                @endguest

                            </li>
                            <li>
                             <a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a>

                            </li>
                            <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                        </ul>

                    </div><!-- blog-info -->
                </div><!-- single-post -->
            </div><!-- card -->
        </div><!-- col-lg-4 col-md-6 -->
        @endforeach

    </div><!-- row -->

    {{--  <a class="load-more-btn" href="#"><b>LOAD MORE</b></a> --}}
    {{ $posts->links() }}

    <script>
      $('.pagination a').unbind('click').on('click', function(e) {
         e.preventDefault();
         var page = $(this).attr('href').split('page=')[1];
         getPosts(page);
     });
      
      function getPosts(page)
      {
        $.ajax({
         type: "GET",
         url: '?page='+ page
     })
        .success(function(data) {
         $('body').html(data);
     });
    }
</script>

</div><!-- container -->
</section><!-- section -->
@endsection

@push('js')

@endpush