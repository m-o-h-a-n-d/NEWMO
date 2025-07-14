@extends('layouts.frontend.app')


{{-- title --}}

@section('title')
    Show {{ $SinglePost->title }}
@endsection
{{-- end title --}}

{{-- Meta content --}}

@section('small_desc')
    {{ $SinglePost->small_desc }}
@endsection


{{--  Breadcrumb start   --}}
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">{{ $SinglePost->title }}</li>
@endsection
{{--  Breadcrumb End  --}}


@section('content')
    {{--  Breadcrumb start  --}}


    @php
        $post_belong_to_category_limit = $post_belong_to_category->posts()->active()->take(5)->get();
    @endphp


    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <div class="post-meta d-flex align-items-center gap-3 my-3">
                            <div class="author-img">

                                <img src="{{ $SinglePost->user->image_url ?? $SinglePost->admin->image_url }}"
                                    alt="User Image" style="width: 50px; height: 50px; border-radius: 50%;">
                            </div>
                            {{-- User Publish Post --}}
                            <div class="author-info">
                                @if ($SinglePost->user)
                                    <h6 class="mb-1"> {{ $SinglePost->user->username }}</h6>
                                @elseif($SinglePost->admin)
                                    <h6 class="mb-1"> {{ $SinglePost->admin->username }} <i
                                            class="fas fa-check-circle text-success" title="Verified Admin"></i></h6>
                                @endif

                                <small class="text-muted">
                                    @if ($SinglePost->created_at->diffInDays() > 7)
                                        {{ $SinglePost->created_at->format('d M Y') }}
                                    @else
                                        {{ $SinglePost->created_at->diffForHumans() }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        <ol class="carousel-indicators">
                            @foreach ($SinglePost->images as $index => $image)
                                <li data-target="#newsCarousel" data-slide-to="{{ $index }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($SinglePost->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->path) }}" class="d-block w-100" style="height: 30rem ">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 class="tit-h">{{ $SinglePost->title }}</h5>
                                        <p class="tit-p">
                                            {{ Str::limit(html_entity_decode(strip_tags($SinglePost->description)), 80) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($SinglePost->images->count() > 1)
                            <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        @endif
                    </div>



                    <div class="sn-content" style="word-break: break-word;">
                        {!! $SinglePost->description !!}
                    </div>

                    <!-- Comment Section -->
                    <div class="comment-section">
                        <!-- Comment Input -->
                        @if ($SinglePost->comment_able == true)
                            <form id="commentForm">
                                <div class="comment-input d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="text" name="comment" placeholder="Add a comment..." id="commentBox"
                                        class="form-control" />
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="post_id" value="{{ $SinglePost->id }}">
                                    <button id="addCommentBtn" type="submit" class="btn btn-primary">Comment</button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-warning d-flex align-items-center mt-3" role="alert"
                                style="border-left: 4px solid #ffc107;">
                                <i class="fa fa-exclamation-circle mr-2" aria-hidden="true"></i>
                                <span><strong>Note:</strong> Comments are disabled for this post.</span>
                            </div>
                        @endif


                        <!-- Display Comments -->

                        <div class="comments comments-scrollable">
                            @foreach ($SinglePost->comments->take(3) as $comment)
                                <div class="comment">
                                    <img src="{{ $comment->user->image_url }}" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">{{ $comment->user->username }}</span>
                                        <p class="comment-text">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>



                        <!-- Add more comments here for demonstration -->


                        <!-- Show More Button -->
                        @if ($SinglePost->comments->count() > 2)
                            <button id="showMoreBtn" class="show-more-btn">Show more</button>
                        @endif
                    </div>

                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="slider-buttons mb-3 text-right">
                            <button class="btn btn-dark sn-prev"><i class="fa fa-angle-left"></i></button>
                            <button class="btn btn-dark sn-next"><i class="fa fa-angle-right"></i></button>

                        </div>
                        <div class="row sn-slider">
                            @foreach ($post_belong_to_category_limit as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src="{{ asset($post->images->first()->path) }}" class="img-fluid"
                                            alt="Related News 1" />
                                        <div class="sn-title">
                                            <a
                                                href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In this Category:</h2>
                            <div class="news-list">

                                <div class="news-list">
                                    @foreach ($post_belong_to_category_limit as $cat)
                                        <div class="nl-item">
                                            <div class="nl-img">
                                                <img src="{{ asset($cat->images->first()->path) }}"
                                                    style="height: 70px " />
                                            </div>
                                            <div class="nl-title">
                                                <a
                                                    href="{{ route('frontend.single.posts', $cat->slug) }}">{{ $cat->title }}</a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </div>


                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#feature">Latest</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#popular">Popular</a>
                                    </li>

                                </ul>

                                <div class="tab-content">
                                    {{-- Latest  --}}
                                    <div id="feature" class="container news-list tab-pane active">
                                        @foreach ($latest_posts as $latest_post)
                                            <div class="tn-news nl-item">
                                                <div class="tn-img nl-img">
                                                    <img src="{{ asset($latest_post->images->first()->path) }}"
                                                        style="height: 80px " />
                                                </div>
                                                <div class="tn-title">
                                                    <a
                                                        href="{{ route('frontend.single.posts', $latest_post->slug) }}">{{ $latest_post->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Popular --}}
                                    <div id="popular" class="container news-list tab-pane ">
                                        @foreach ($popular as $pop)
                                            <div class="nl-item">
                                                <div class="nl-img">
                                                    <img src="{{ asset($pop->images->first()->path) }}"
                                                        style="height: 80px " />
                                                </div>
                                                <div class="tn-title">
                                                    <a
                                                        href="{{ route('frontend.single.posts', $pop->slug) }}">{{ $pop->title }}</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="sidebar-widget">
                            <h2 class="sw-title">Our Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a
                                                href="{{ route('frontend.category.posts', $category->slug) }}">{{ $category->name }}</a><span>({{ $category->posts_count }})</span>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->
@endsection

{{-- Ajax --}}
@push('js')
    <script>
        let initialCommentsHtml = '';
        let commentsExpanded = false;

        $(document).ready(function() {
            // خزّن أول 3 تعليقات في البداية
            initialCommentsHtml = $('.comments').html();
        });

        // زرار Show More
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('frontend.single.post.comments', $SinglePost->slug) }}",
                type: "GET",
                success: function(data) {
                    if (data.status === 200 && data.comments.length > 0) {
                        $('.comments').empty();

                        $.each(data.comments, function(key, comment) {
                            $('.comments').append(`
                        <div class="comment">
                            <img src="${comment.user.image_url || '/default-user.png'}" alt="User Image" class="comment-img" />
                            <div class="comment-content">
                                <span class="username">${comment.user.username}</span>
                                <p class="comment-text" style="word-break: break-word; white-space: pre-wrap; overflow-wrap: break-word;">${comment.comment}</p>
                            </div>
                        </div>
                    `);
                        });

                        $('#showMoreBtn').hide();
                        commentsExpanded = true;
                    } else {
                        console.warn("No comments found or post inactive");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching comments:", error);
                }
            });
        });

        // استرجاع أول 3 تعليقات لما المستخدم يضغط في أي مكان خارج التعليقات أو الزرار
        $(document).on('click', function(e) {
            if (commentsExpanded) {
                if (!$(e.target).closest('.comments, #showMoreBtn').length) {
                    $('.comments').html(initialCommentsHtml);
                    $('#showMoreBtn').show();
                    commentsExpanded = false;
                }
            }
        });

        // إرسال تعليق جديد
        $(document).on('submit', '#commentForm', function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "{{ route('frontend.single.comments.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.comments').prepend(`
                <div class="comment">
                    <img src="${data.comment.user.image_url || '/default-user.png'}" alt="User Image" class="comment-img" />
                    <div class="comment-content">
                        <span class="username">${data.comment.user.username}</span>
                        <p class="comment-text" style="word-break: break-word; white-space: pre-wrap; overflow-wrap: break-word;">${data.comment.comment}</p>
                    </div>
                </div>
            `);

                    if (!$('#showMoreBtn').is(':hidden')) {
                        if ($('.comments .comment').length > 3) {
                            $('.comments .comment').last().remove();
                        }
                        // تحديث نسخة العرض الأولي
                        initialCommentsHtml = $('.comments').html();
                    }

                    $('#commentForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                },
            });
        });
    </script>
@endpush
