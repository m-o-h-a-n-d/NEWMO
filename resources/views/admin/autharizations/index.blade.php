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
    Authorization
@endsection



@section('body')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container">

                    <!-- Page Heading -->
                    <h2 class="h3 mb-2 text-gray-800">Authorization</h2>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 ">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center ">
                            <h6 class="m-0 font-weight-bold text-primary">Authorization DataTable</h6>
                            <div class="create">
                                <a href="{{ route('admin.authorize.create') }}" class="btn btn-primary p-2 border-redis-3">
                                    {{ __('Create Role') }}
                                </a>
                            </div>
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



                                    {{-- Search --}}

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
                                            <th>Role</th>
                                            <th>permissions</th>
                                            <th>Related</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Role</th>
                                            <th>permissions</th>
                                            <th>Related</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse ($authorizations as $authorization)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $authorization->role }}</td>
                                                <td>

                                                    @foreach ($authorization->permissions as $permission)
                                                        {{ $permission }},
                                                    @endforeach
                                                </td>
                                                <td>{{$authorization->admins->count()}}</td>

                                                <td data-order="{{ $authorization->created_at->timestamp }}">
                                                    {{ $authorization->created_at->diffForHumans() }}
                                                </td>

                                                <td class="col-md-1">
                                                    <div class="d-flex justify-content-between">
                                                        {{-- Show authorization --}}
                                                        <a href="{{ route('admin.authorize.edit', $authorization->id) }}"
                                                            title="see authorization">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        {{-- Delete --}}
                                                        <form
                                                            action="{{ route('admin.authorize.destroy', $authorization->id) }}"
                                                            method="POST" id="deleteForm_{{ $authorization->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="delete-authorization-btn"
                                                                data-id="{{ $authorization->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center ">No Data Found</td>
                                            </tr>
                                        @endforelse
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
        $(document).on('click', '.delete-authorization-btn', function(e) {
            e.preventDefault();
            const authorizationId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This authorization will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + authorizationId).submit();
                }
            });
        });

        // Filter authorizations
        $(document).ready(function() {
            const tableEl = $('#dataTable');
            if (!$.fn.DataTable.isDataTable(tableEl)) {
                const table = tableEl.DataTable({
                    // الإعدادات الخاصة بالصفحة دي
                    ordering: false,
                    columnDefs: [{
                        targets: 4,
                        searchable: false
                    }]
                });



                $('#customSearch').on('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
