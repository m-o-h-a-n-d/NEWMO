@extends('layouts.backend.app')
{{-- Title Of Page  --}}
@section('admin_title')
    Create Post
@endsection

{{-- Body of the Page  --}}
@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center  w-100" style="font-size: 40px">Create Posts</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-5 shadow">
                    <div class="card-body ">

                        @if (Session()->has('errors'))
                            <div class="alert alert-danger">
                                @foreach (Session('errors')->all() as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </div>
                        @endif

                        <!-- Add Post Section -->
                        <form action="{{ route('admin.posts.store') }}" method="Post" enctype="multipart/form-data">
                            @csrf
                            <section id="add-post" class="add-post-section mb-5">
                                <h2>Add Post</h2>
                                <div class="post-form p-3 border rounded">
                                    <!-- Post Title -->


                                    {{-- small_desc --}}
                                    <textarea type="text" id="title" class="form-control mb-2" name="title" placeholder="Title"
                                        required></textarea>

                                    <div class="tn-slider mb-2">
                                        <div id="imagePreview" class="slick-slider"></div>
                                    </div>


                                    <!-- status  -->
                                    <div class="col-md-12 mb-1 mt-3 ">

                                        <div class="row w-100">
                                            <div class="col-md-6 mt-3">
                                                <select name="admin_id" id="admin_id" class="form-control " required>
                                                    <option value="" selected>Select Status</option>
                                                    <option value="0">Not Available</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Category Dropdown -->

                                    <br>



                                    <!-- Post Button -->
                                    <div class="row w-100  d-flex justify-content-lg-between align-items-center">
                                        <div class="col-md-6">
                                            <!-- Enable Comments Checkbox -->
                                            <label class=" label pt-2 pb-2 align-items-center d-grid justify-between">
                                                Enable Comments : <input name="comment_able" type="checkbox"
                                                    class="" />
                                            </label><br />
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end ">
                                            <button type="submit" class="btn btn-primary w-25 post-btn">Post</button>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('js')
    <script>
        // Initialize File Input and Summernote
        $(document).ready(function() {
            // initialize with defaults
            $("#postImage").fileinput({
                theme: "fas", // Theme خاص بـ Font Awesome 5
                allowedFileTypes: ['image'],
                showCancel: true,
                initialPreviewAsData: true,
                overwriteInitial: false,
                enableResumableUpload: false,
                maxFileCount: 7,
                showUpload: false,
            });


            $('#postContent').summernote({
                height: 300,
            });
        });
    </script>
@endpush
