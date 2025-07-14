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
    Categories
@endsection



@section('body')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid " style="width: 85%">

                    <!-- Page Heading -->
                    <h2 class="h3 mb-2 text-gray-800">Categories</h2>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 ">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Categories DataTable</h6>
                            {{-- Create --}}
                            <div class="create">
                                <a href="#" data-toggle="modal" data-target="#CreateCategory"
                                    class="btn btn-primary p-2 border-redis-3">
                                    {{ __('Create Category') }}
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



                                    <div class="status">
                                        <label class="font-weight-bold mb-0 ">Filter by Status: </label>
                                        <select id="statusFilter" class="form-control form-control-sm "
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
                                            <th>Post Cont</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Post Cont</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        {{-- Categories --}}
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- Name --}}
                                                <td class="col-md-4">{{ $category->name }}</td>
                                                {{-- Post Count --}}
                                                <td>{{ $category->posts_count }}</td>
                                                {{-- Status --}}
                                                <td class="text-center col-md-3">
                                                    @if ($category->status == 1)
                                                        <span class="d-none">Active</span>
                                                        <span class="badge badge-success"
                                                            style="min-width: 80px;">Active</span>
                                                    @else
                                                        <span class="d-none">Not Available</span>
                                                        <span class="badge badge-danger" style="min-width: 80px;">Not
                                                            Available</span>
                                                    @endif
                                                </td>
                                                {{-- Times --}}
                                                <td data-order="{{ $category->created_at->timestamp }}">
                                                    {{ $category->created_at->diffForHumans() }}
                                                </td>
                                                {{-- Actions --}}
                                                <td>
                                                    <div class="d-flex justify-content-around">
                                                        {{-- Update --}}
                                                        <a href="#" class="edit-category-btn" data-toggle="modal"
                                                            data-target="#UpdateCategory_{{ $category->id }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form
                                                            action="{{ route('admin.categories.destroy', $category->id) }}"
                                                            method="POST" id="deleteForm_{{ $category->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="{}" class="delete-category-btn"
                                                                data-id="{{ $category->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </form>


                                                        {{-- Block --}}
                                                        @if ($category->status == 0)
                                                            <a href="{{ route('admin.categories.BlockCategory', $category->id) }}"
                                                                title="Activate">
                                                                <i class="fa fa-unlock"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.categories.BlockCategory', $category->id) }}"
                                                                title="Block">
                                                                <i class="fa fa-ban"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- Start Update --}}
                                            @include('admin.categories.update')
                                            {{-- End Update --}}
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

    {{-- Start Create --}}
    @include('admin.categories.create')
    {{-- End Create   --}}
@endsection




{{-- js --}}
@push('js')
    <script>
        //Sweet alert
        $(document).on('click', '.delete-category-btn', function(e) {
            e.preventDefault();
            const categoryId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This category will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + categoryId).submit();
                }
            });
        });

        // Filter Category
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

                $('#statusFilter').on('change', function() {
                    table.column(3).search(this.value).draw(); // ✅ ده العمود الصحيح لــ Status
                });


                $('#customSearch').on('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
