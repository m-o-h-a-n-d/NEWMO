@extends('layouts.backend.app')

@section('admin_title')
    Edit Post
@endsection

@push('css')
    <style>
        .com-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .com-overlay.active {
            display: flex;
            animation: fadeIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .com-box {
            background: white;
            width: 400px;
            max-height: 70vh;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(-30px);
            opacity: 0;
            animation: slideIn 0.4s ease forwards;
        }

        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .com-scroll {
            overflow-y: auto;
            padding: 10px;
            flex: 1;
        }

        .com-item {
            display: flex;
            align-items: flex-start;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .com-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .com-body strong {
            display: block;
            font-weight: bold;
        }
    </style>
@endpush

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center w-100 my-4" style="font-size: 36px; font-weight: bold;">Edit Post</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow mb-5">
                    <div class="card-body">

                        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    value="{{ $post->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="small_desc" class="font-weight-bold">Small Description</label>
                                <input type="text" name="small_desc" id="small_desc" class="form-control"
                                    value="{{ $post->small_desc }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description" class="font-weight-bold">Full Description</label>
                                <textarea class="form-control" name="description" id="postContent" rows="6">{{ $post->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Upload Images</label>
                                <input type="file" name="image[]" id="postImage" class="form-control" multiple
                                    accept="image/*">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($category->id == $post->category_id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ $post->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $post->status == 0 ? 'selected' : '' }}>Non Available</option>
                                </select>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" name="comment_able" id="comment_able" class="form-check-input"
                                    @checked($post->comment_able == 1)>
                                <label class="form-check-label" for="comment_able">Enable Comments</label>
                            </div>

                            <div class="form-group d-flex justify-content-between border p-3 rounded mb-4 bg-light">
                                <span><strong>Views:</strong> {{ $post->views->count() }}</span>
                                <span><strong>Comments:</strong> {{ $post->comments->count() }}</span>
                            </div>

                            <div class="form-group  align-items-end gap-3 w-100">
                                <button type="submit" class="btn btn-success px-4">Save</button>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary px-4">Cancel</a>
                                @php $commentId = 'comOverlay' . $post->id; @endphp
                                <button type="button" class="btn btn-primary btn-show-comments "
                                    data-target="#{{ $commentId }}">
                                    <i class="fas fa-comment"></i> Show Comments
                                </button>
                            </div>


                        </form>

                        {{-- Comments Section --}}
                        @php $commentId = 'comOverlay' . $post->id; @endphp
                        <div id="{{ $commentId }}" class="com-overlay">
                            <div class="com-box">
                                <div class="com-scroll">
                                    @foreach ($post->comments->sortByDesc('created_at') as $comment)
                                        <div class="com-item">
                                            <img src="{{ asset($comment->user->image ?? 'default-user.png') }}"
                                                alt="User">
                                            <div class="com-body w-100">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <strong>{{ $comment->user->username }}</strong>
                                                        <p class="comment-text mb-0">{{ $comment->comment }}</p>
                                                    </div>
                                                    <div class="delete-btn d-flex align-items-center gap-2">
                                                        <form
                                                            action="{{ route('admin.posts.deleteComment', $comment->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-delete-comment btn-outline-danger"
                                                                data-id="{{ $comment->id }}">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                            
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#postImage").fileinput({
                allowedFileTypes: ['image'],
                showCancel: true,
                initialPreviewAsData: true,
                overwriteInitial: false,
                enableResumableUpload: false,
                maxFileCount: 7,
                showUpload: false,
                initialPreview: [
                    @foreach ($post->images as $image)
                        "{{ asset($image->path) }}",
                    @endforeach
                ],
                initialPreviewConfig: [
                    @foreach ($post->images as $image)
                        {
                            caption: "{{ $image->name }}",
                            width: "120px",
                            url: "{{ route('admin.posts.EditImagePost', $image->id) }}",
                            key: "{{ $image->id }}",
                        },
                    @endforeach
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

        // Show/hide comment overlay
        document.querySelectorAll('.btn-show-comments').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.dataset.target);
                target.classList.add('active');
            });
        });

        document.addEventListener('click', function(e) {
            document.querySelectorAll('.com-overlay.active').forEach(overlay => {
                const box = overlay.querySelector('.com-box');
                const toggleBtn = document.querySelector(`[data-target="#${overlay.id}"]`);

                if (!box.contains(e.target) && !toggleBtn.contains(e.target)) {
                    overlay.classList.remove('active');
                }
            });
        });

        // Delete Comment
        $(document).on('click', '.btn-delete-comment', function(e) {
            e.preventDefault();

            const commentId = $(this).data('id');
            const button = $(this);

            $.ajax({
                url: "/admin/delete/comment/" + commentId,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function(res) {
                    // احذف العنصر من DOM
                    button.closest('.com-item').fadeOut(300, function() {
                        $(this).remove();
                    });
                },
                error: function(xhr) {
                    console.error("Error deleting comment:", xhr.responseText);
                }
            });
        });
    </script>
@endpush
