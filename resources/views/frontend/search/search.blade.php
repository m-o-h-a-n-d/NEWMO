@extends('layouts.frontend.app')

{{--  Breadcrumb start  --}}
@section('breadcrumb')
    {{--  empty to prevent breadcrumb in home page  --}}
@endsection
{{--  Breadcrumb End  --}}

{{-- title --}}

@section('title')

Search News
@endsection

@section('content')
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                {{-- Posts --}}
                <div class="col-lg-12">
                    <div class="row" id='post-results'>
                        {{-- this loop from Home Controller --}}
                        @if ($posts->count() > 0)
                            @foreach ($posts as $post)
                                <div class="col-md-4  my-5">
                                    <div class="mn-img">
                                        <img src="{{ asset($post->images->first()->path) }}"   style="height: 13rem" />
                                        <div class="mn-title">
                                            <a
                                                href="{{ route('frontend.single.posts', $post->slug) }}">{{ $post->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center my-5">
                                <div class="alert alert-warning text-center p-4 rounded shadow-sm" role="alert">
                                    <h4 class="alert-heading mb-2">{{ __('No Posts Available') }}</h4>
                                    <p class="mb-0">
                                        {{ __('We couldn\'t find any posts at the moment') }}</p>
                                </div>
                            </div>
                        @endif


                    </div>
                    {{ $posts->links() }} {{-- we use paginator to choose the type of pagination (bootstrap ) --}}
                </div>

            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
