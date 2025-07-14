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
    mails
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
                    <h2 class="h3 mb-2 text-gray-800">mails </h2>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">mails DataTable</h6>
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
                                            <option value="Not seen">Not Seen</option>
                                            <option value="Read">Read</option>
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
                                            <th>Role</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($mails as $mail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $mail->admin->name }}</td>
                                                <td>{{ $mail->admin->email }}</td>
                                                <td>{{ $mail->admin->authorization?->role??''}}</td>
                                                <td>{{ Str::limit($mail->title,15) }}</td>
                                                <td class="text-center">
                                                    <span
                                                        style="display: none;">{{ $mail->status == 0 ? 'Not seen' : 'Read' }}</span>
                                                    <span
                                                        class="badge {{ $mail->status == 0 ? 'badge-danger' : 'badge-success' }}"
                                                        style="min-width: 80px;">
                                                        {{ $mail->status == 0 ? 'Not seen' : 'Read' }}
                                                    </span>
                                                </td>



                                                <td data-order="{{ $mail->created_at->timestamp }}">
                                                    {{ $mail->created_at->diffForHumans() }}
                                                </td>

                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        {{-- Show mail --}}
                                                        <a href="{{ route('admin.mails.show', $mail->id) }}"
                                                            title="see mail">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        {{-- Delete --}}
                                                        <form action="{{ route('admin.mails.destroy', $mail->id) }}"
                                                            method="POST" id="deleteForm_{{ $mail->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="delete-mail-btn"
                                                                data-id="{{ $mail->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </form>

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
        $(document).on('click', '.delete-mail-btn', function(e) {
            e.preventDefault();
            const mailId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This Information will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + mailId).submit();
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
                        targets: 7,
                        searchable: false
                    }]
                });

                // لو فيه فلترة أو بحث
                $('#statusFilter').on('change', function() {
                    table.column(5).search(this.value).draw();
                });

                $('#customSearch').on('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
