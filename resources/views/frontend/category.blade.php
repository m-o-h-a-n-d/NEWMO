@extends('layouts.frontend.app')


{{--  Breadcrumb start  --}}
@section('breadcrumb')
    @parent

    <li class="breadcrumb-item">{{ $category->name }}</li>
@endsection
{{--  Breadcrumb End  --}}

@section('title')
    {{ $category->name }}
@endsection



@section('content')
    <!-- Main News Start-->
    <div class="main-news pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @if ($posts->count() > 0)
                            @foreach ($posts as $post)
                                <div class="col-md-4">
                                    <div class="mn-img">
                                        @if ($post->images->isNotEmpty())
                                            <img src="{{ asset($post->images->first()->path) }}" class="img-fluid rounded " style="height: 11rem"
                                                alt="Post image" />
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" class="img-fluid rounded"
                                                alt="Default image" style="height: 10rem "   />
                                        @endif
                                        <div class="mn-title mt-2">
                                            <a
                                                href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-warning text-center p-4 rounded shadow-sm" role="alert">
                                    <h4 class="alert-heading mb-2">{{ __('No Posts Available') }}</h4>
                                    <p class="mb-0">
                                        {{ __('We couldn\'t find any posts at the moment. Please check back later.') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{ $posts->links() }}
                </div>


                <div class="col-lg-3">
                    <div class="mn-list">
                        <h2>Other Category</h2>
                        <ul>
                            {{-- the categories come from the view provider Or category come from controller --}}
                            @foreach ($categories as $category)
                                <li><a
                                        href="{{ route('frontend.category.posts', $category->slug) }}">{{ $category->name }}</a>
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
