@extends('layouts.backend.app')

@section('admin_title')
    {{ config('app.name') }}
@endsection

@section('body')
    <!-- Content Wrapper -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>

        <!-- Statistics Row -->
        @livewire('admin.statistics')

        <!-- Charts Row -->
        <div class="row">

            <!-- Posts Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h3>{{ $chart1->options['chart_title'] }}</h3>
                        {!! $chart1->renderHtml() !!}
                    </div>
                </div>
            </div>

            <!-- Users Chart (Pie) -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body ">

                        <h3>{{ $chart2->options['chart_title'] }}</h3>
                        {!! $chart2->renderHtml() !!}

                    </div>
                </div>
            </div>

        </div>

        @can('posts')
            @livewire('admin.posts-comments')
        @endcan
    </div>
    <!-- End of Content Wrapper -->
@endsection


@push('js')
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
    {!! $chart2->renderJs() !!}
@endpush
