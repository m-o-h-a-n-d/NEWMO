@extends('layouts.frontend.app')

{{-- title --}}
@section('title')
 Home
@endsection

{{--  Breadcrumb start  --}}
@section('breadcrumb')
    {{--  empty to prevent breadcrumb in home page  --}}
@endsection
{{--  Breadcrumb End  --}}

@section('content')
    @php
        $latest_news = $posts->take(3);
    @endphp
    <!-- Top News Start-->
    <div class="top-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 tn-left">

                    {{-- this loop from Home Controller --}}
                    <div class="row tn-slider">
                        @foreach ($latest_news as $post)
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img src="{{ asset($post->images->first()->path) }}"  />
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 tn-right">
                    {{-- this is used to choose Four posts --}}
                    @php
                        $four_news = $posts->take(4);
                    @endphp
                    <div class="row">
                        {{-- this loop from Home Controller --}}
                        @foreach ($four_news as $post)
                            <div class="col-md-6">
                                <div class="tp-img">
                                    <img src="{{ asset($post->images->first()->path) }}" />
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End-->

    <!-- Category News Start-->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                {{-- this loop from Home Controller --}}

                @foreach ($categories_with_posts as $category)
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h2>{{ $category->name }}</h2>
                            <div class="slider-buttons">
                                <button class="btn btn-dark cn-prev-{{ $loop->index }}">
                                    <i class="fa fa-angle-left"></i>
                                </button>
                                <button class="btn btn-dark cn-next-{{ $loop->index }}">
                                    <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                        </div>

                        <div class="row cn-slider cn-slider-{{ $loop->index }}">
                            @foreach ($category->posts as $Post)
                                <div class="col-md-6">
                                    <div class="cn-img">
                                        <img src="{{ asset($Post->images->first()->path) }}"  />
                                        <div class="cn-title">
                                            <a
                                                href="{{ route('frontend.single.posts', $Post->slug) }}">{{ $Post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Category News End-->



    <!-- Tab News Start-->
    <div class="tab-news">
        <div class="container">
            <div class="row">
                {{--  Oldest & Popular --}}
                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#featured">Oldest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular">Popular News</a>
                        </li>

                    </ul>
                    {{-- oldest News --}}
                    <div class="tab-content">
                        <div id="featured" class="container tab-pane active">
                            @foreach ($oldest as $old)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ asset($old->images->first()->path) }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="{{ route('frontend.single.posts', $old->slug) }}">{{ $old->title }}</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        {{-- Popular News --}}
                        <div id="popular" class="container tab-pane fade">
                            @foreach ($popular as $pop)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ asset($pop->images->first()->path) }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a
                                            href="{{ route('frontend.single.posts', $pop->slug) }}">{{ $pop->title }}({{ $pop->comments_count }})</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
                {{-- Latest & Most --}}

                <div class="col-md-6">
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#m-viewed">Latest News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-read">Most Read</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        {{-- Latest News --}}
                        <div id="m-viewed" class="container tab-pane active">
                            {{-- this loop from Home Controller --}}
                            @foreach ($latest_news as $last)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ asset($last->images->first()->path) }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a
                                            href="{{ route('frontend.single.posts', $last->slug) }}">{{ $last->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Most read --}}
                        <div id="m-read" class="container tab-pane fade">
                            {{-- this loop from Home Controller --}}
                            @foreach ($greatest as $great)
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="{{ asset($great->images->first()->path) }}" />
                                    </div>
                                    <div class="tn-title">
                                        <a
                                            href="{{ route('frontend.single.posts', $great->slug) }}">{{ $great->title }}({{ $great->views->count() }})</a>
                                    </div>
                                </div>
                            @endforeach



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab News Start-->

    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                {{-- Posts --}}
                <div class="col-lg-9">
                    <div class="row">
                        {{-- this loop from Home Controller --}}
                        @foreach ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ asset($post->images->first()->path) }}"  style="height: 10rem " />
                                    <div class="mn-title">
                                        <a
                                            href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{ $posts->links() }} {{-- we use paginator to choose the type of pagination (bootstrap ) --}}
                </div>

                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Read More</h2>
                        <ul>
                            {{-- this loop from ViewServiceProvider from Cache and connect to app.php in config by using redis   --}}
                            @foreach ($read_more_posts as $post)
                                <li><a href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
