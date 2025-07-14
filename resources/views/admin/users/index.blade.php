@extends('layouts.backend.app')

{{-- CSS --}}
@push('css')
    <style>
        #dataTable_wrapper .row:first-child {
            display: none;
        }
    </style>
@endpush

@section('admin_title')
    Users
@endsection



@section('body')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h2 class="h3 mb-2 text-gray-800">Users</h2>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users DataTable</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                {{-- Filter Active --}}
                                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                    {{-- Number --}}
                                    <div class="number">
                                        <label>
                                            Show
                                            <select id="customLength"
                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select> entries
                                        </label>
                                    </div>



                                    <div class="status mb-2">
                                        <label class="font-weight-bold mb-0 mr-2">Filter by Status:</label>
                                        <select id="statusFilter" class="form-control form-control-sm"
                                            style="width: 150px;">
                                            <option value="">All</option>
                                            <option value="Active">Active</option>
                                            <option value="Not Available">Not Available</option>
                                        </select>
                                    </div>

                                    <div class="Search">
                                        <label class="mb-0">Search:
                                            <input type="search" class="form-control form-control-sm" placeholder=""
                                                id="customSearch">
                                        </label>
                                    </div>
                                </div>
                                {{-- End Filter Active --}}
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Country</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Country</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">
                                                    @if ($user->status == 0)
                                                        <span class="d-none">Not Available</span>
                                                        <span class="badge badge-danger" style="min-width: 80px;">
                                                            Not Available</span>
                                                    @else
                                                        <span class="d-none">Active</span>
                                                        <span class="badge badge-success"
                                                            style="min-width: 80px;">Active</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->country }}</td>
                                                <td data-order="{{ $user->created_at->timestamp }}">
                                                    {{ $user->created_at->diffForHumans() }}
                                                </td>

                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        {{-- Show user --}}
                                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                                            title="see user">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        {{-- Delete --}}
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" id="deleteForm_{{ $user->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="delete-user-btn"
                                                                data-id="{{ $user->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </form>
                                                        {{-- Block Or UnBlock --}}
                                                        @if ($user->status == 0)
                                                            <a href="{{ route('admin.users.BlockUser', $user->id) }}"
                                                                title="Active user">

                                                                <i class="fa fa-unlock"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.users.BlockUser', $user->id) }}"
                                                                title="Block user">
                                                                <i class="fa fa-ban a"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
@endsection

{{-- Sweet alart --}}
@push('js')
    <script>
        $(document).on('click', '.delete-user-btn', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + userId).submit();
                }
            });
        });

        // Filter users
        $(document).ready(function() {
            const tableEl = $('#dataTable');
            if (!$.fn.DataTable.isDataTable(tableEl)) {
                const table = tableEl.DataTable({
                    // الإعدادات الخاصة بالصفحة دي
                    ordering: false,
                    columnDefs: [{
                        targets: 5,
                        searchable: false
                    }]
                });

                // لو فيه فلترة أو بحث
                $('#statusFilter').on('change', function() {
                    table.column(3).search(this.value).draw();
                });

                $('#customSearch').on('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
