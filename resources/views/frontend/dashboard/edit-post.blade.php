@extends('layouts.frontend.app')


{{--  Breadcrumb start  --}}
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Edit_post</li>
@endsection
{{--  Breadcrumb End  --}}


@section('title')
    Edit
@endsection


@section('content')
    <div class="dashboard container">
        <!-- Sidebar -->
        @include('frontend.dashboard._slider', ['profile_slide' => 'active'])

        <!-- Main Content -->
        <div class="main-content col-md-9">
            <!-- Show/Edit Post Section -->
            @if (Session()->has('errors'))
                <div class="alert alert-danger">
                    <ul>
                        @foreach (Session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('frontend.dashboard.post.update', $post->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('Patch')
                <section id="posts-section" class="posts-section">
                    <h2>Your Posts</h2>
                    <ul class="list-unstyled user-posts">
                        <!-- Example of a Post Item -->
                        <li class="post-item">
                            <!-- Editable Title -->
                            <input type="text" name="title" value="{{ $post->title }}" class="form-control mb-2 " />
                            <!-- Editable small_desc -->
                            <input type="text" name="small_desc" value="{{ $post->small_desc }}"
                                class="form-control mb-2 " />

                            <!-- Editable Content -->
                            <textarea class="form-control mb-2 post-content" name="description" id="postContent">{!! $post->description !!}</textarea>

                            <!-- Post Images Slider -->

                            <!-- Image Upload -->
                            <input type="file" id="postImage" name="image[]" class="form-control " accept="image/*"
                                multiple />



                            <!-- Editable Category Dropdown -->
                            <select name="category_id" class="form-control mt-4 post-category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $post->category_id)>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Editable Enable Comments Checkbox -->
                            <div class="form-check mb-2 pl-0">
                                <label class="label pt-2  pb-2 align-items-center d-grid justify-between">
                                    Enable Comments : <input name="comment_able" type="checkbox"
                                        @checked($post->comment_able == 1) />
                                </label>
                            </div>

                            <!-- Post Meta: Views and Comments -->
                            <div class="post-meta d-flex justify-content-between">
                                <span class="views"> <i class="bi bi-eye-fill"></i> {{ $post->views->count() }} </span>
                                <span class="post-comments">
                                    <i class="bi bi-chat"></i>{{ $post->comments->count() }}
                                </span>
                            </div>

                            <!-- Post Actions -->
                            <div class="post-actions mt-2">

                                <button class="btn btn-success save-post-btn " type="submit">
                                    Save
                                </button>
                                <a href="{{ route('frontend.dashboard.profile') }}"
                                    class="btn btn-danger delete-post-btn">Cancel</a>


                            </div>
                        </li>
                        <!-- Additional posts will be added dynamically -->
                    </ul>
                </section>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Initialize File Input and Summernote
        $(document).ready(function() {
            // initialize with defaults
            $("#postImage").fileinput({
                allowedFileTypes: ['image'],
                showCancel: true,
                initialPreviewAsData: true,
                overwriteInitial: false,
                enableResumableUpload: false,
                maxFileCount: 7,
                showUpload: false,
                initialPreview: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            "{{ asset($image->path) }}",
                        @endforeach
                    @endif

                ],
                initialPreviewConfig: [
                    @if ($post->images->count() > 0)
                        @foreach ($post->images as $image)
                            {
                                caption: "{{ $image->name }}", // IMage name
                                width: "120px",
                                url: "{{ route('frontend.dashboard.post.image.delete', [' $image->id', '_token' => csrf_token()]) }}", // delete url
                                key: "{{ $image->id }}",
                            },
                        @endforeach
                    @endif
                ],
                deleteExtraData: {
                    _token: "{{ csrf_token() }}"
                },
                fileActionSettings: {
                    showRotate: false
                }
            });


            $('#postContent').summernote({
                height: 300,
            });
        });
    </script>
@endpush
