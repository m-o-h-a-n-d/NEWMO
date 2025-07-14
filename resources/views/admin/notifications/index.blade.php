@extends('layouts.backend.app')
@section('admin_title')
    Notifications
@endsection
@section('body')
    <!-- Dashboard Start-->
    <div class="dashboard container">
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6   ">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.notifications.markAsRead') }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button type="submit" class="btn btn-sm btn-danger " style="margin-left:270px"> Clear All
                            </button>
                        </form>
                    </div>
                </div>


                <div style="max-height: 600px; overflow-y: auto;" class="custom-scroll">
                    @forelse (Auth::guard('admin')->user()->notifications->where('data.notification_type','notification') as $notify)
                        <a href="{{ $notify->data['link'] ?? ($notify->data['url'] ?? '#') }}?notify_admin={{ $notify->id }}"
                            class="text-decoration-none text-dark ">

                            <div class="d-flex align-items-start bg-white shadow-lg rounded p-3 mb-3"
                                style="border-left: 5px solid #28a745;">
                                <div class="flex-grow-1">

                                    <strong class="d-block mb-1 fs-6">
                                        {{ $notify->data['user_name'] ?? ($notify->data['sender_name'] ?? 'Unknown') }}
                                    </strong>

                                    <div class="small mb-1">
                                        At:
                                        <strong>
                                            {{ \Carbon\Carbon::parse($notify->data['contact_time'] ?? $notify->created_at)->diffForHumans() }}
                                        </strong>
                                    </div>

                                    <div class="small mb-1">
                                        title of :
                                        <strong>{{ $notify->data['contact_title'] ?? ($notify->data['title'] ?? 'No Title') }}</strong>
                                    </div>
                                </div>
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
