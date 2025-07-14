@extends('layouts.frontend.app')


{{--  Breadcrumb start  --}}
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Notification</li>
@endsection
{{--  Breadcrumb End  --}}


@section('title')
    Notification
@endsection


@section('content')
    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._slider', ['notify_slide' => 'active'])
        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6   ">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('frontend.dashboard.notification.delete') }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button type="submit" class="btn btn-sm btn-danger " style="margin-left:270px"> Clear All
                            </button>
                        </form>
                    </div>
                </div>


                <div style="max-height: 600px; overflow-y: auto;" class="custom-scroll">
                    @forelse (auth()->user()->notifications as $notify)
                        <a href="{{ $notify->data['url'] }}?notify={{ $notify->id }}"
                            class="text-decoration-none text-dark ">
                            <div class="d-flex align-items-start bg-white shadow-lg rounded p-3 mb-3"
                                style="border-left: 5px solid #28a745;">
                                <img src="{{ $notify->data['commenter_image'] ?? '/default-user.png' }}"
                                    class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;"
                                    alt="User Image" />

                                <div class="flex-grow-1">
                                    <strong class="d-block mb-1 fs-6">
                                        {{ $notify->data['commenter_name'] ?? 'Unknown User' }}
                                    </strong>

                                    <div class="small mb-1">
                                        علق على: <strong>{{ $notify->data['post_title'] }}</strong>
                                    </div>

                                    <div class="text-dark" style="font-size: 14px;">
                                        {{ Str::limit($notify->data['comment'] ?? '', 50) }}
                                    </div>
                                </div>
                                <form action="{{ route('frontend.dashboard.notification.delete', $notify->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('Delete')
                                    <button type="submit" class="btn btn-sm btn-danger " style="margin-left:270px"> Delete
                                    </button>
                                </form>
                            </div>

                        </a>


                    @empty
                        <div class="col-12 text-center my-4">
                            <div class="alert alert-warning text-center p-4 rounded shadow-sm mb-0" role="alert">
                                <h4 class="alert-heading mb-2">No Notification Available</h4>
                                <p class="mb-0">We couldn't find any Notification at the moment</p>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
    <!-- Dashboard End-->
@endsection
