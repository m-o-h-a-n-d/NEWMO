@extends('layouts.backend.app')

@section('admin_title')
    Show Post
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
            /* ❗ مخفي تمامًا */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .com-overlay.active {
            display: flex;
            /* ❗ هيظهر فقط مع الكلاس */
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

        .com-form {
            display: flex;
            gap: 5px;
            padding: 10px;
            border-top: 1px solid #eee;
        }

        .com-form input[type="text"] {
            flex: 1;
        }
    </style>
@endpush
@section('body')
    <div class="container-fluid">
        <h2 class="text-center my-4" style="font-size: 40px">Show Post</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5>{{ $post->user->name }}</h5>
                        <h5>{{ $post->created_at->diffForHumans() }}</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control mb-3" value="{{ $post->title }}" readonly>
                        <textarea class="form-control mb-3" readonly>{{ $post->small_desc }}</textarea>
                        <textarea class="form-control mb-3" rows="6" readonly>{{ $post->description }}</textarea>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control"
                                    value="{{ $post->status ? 'Active' : 'Non Available' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" value="{{ $post->category->name }}" readonly>
                            </div>
                        </div>

                        <a href="#" class="btn btn-danger delete-post-btn" data-id="{{ $post->id }}">Delete</a>

                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                            id="deleteForm_{{ $post->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <a href="{{ route('admin.posts.BlockPost', $post->id) }}" class="btn btn-primary">
                            {{ $post->status ? 'Non Available' : 'Active' }}
                        </a>


                        @php $commentId = 'comOverlay' . $post->id; @endphp
                        <button class="btn btn-outline-secondary btn-show-comments" data-target="#{{ $commentId }}">
                            <i class="fas fa-comment"></i> Comments
                        </button>

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


                                                    <div class="delete-btn d-inline-flex align-items-center">
                                                        <form
                                                            action="{{ route('admin.posts.deleteComment', $comment->id) }}"
                                                            method="POST" id="deleteCommentForm_{{ $comment->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger btn-delete-comment"
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
            {{-- Image Slide  --}}
            <div class="col-md-6">
                <div class="card shadow h-100">
                    @php $carouselId = 'carouselPost' . $post->id; @endphp
                    <div id="{{ $carouselId }}" class="carousel slide h-100" data-ride="carousel">
                        <div class="carousel-inner h-100">
                            @foreach ($post->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                    <img src="{{ asset($image->path) }}" class="d-block w-100 h-100"
                                        style="object-fit: cover; border-radius: .5rem;">
                                </div>
                            @endforeach
                        </div>
                        @if ($post->images->count() > 1)
                            <a class="carousel-control-prev" href="#{{ $carouselId }}" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#{{ $carouselId }}" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Delete Post Alert
        $(document).on('click', '.delete-post-btn', function(e) {
            e.preventDefault();
            const postId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This post will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + postId).submit();
                }
            });
        });
       // show comments
        document.querySelectorAll('.btn-show-comments').forEach(button => {
            button.addEventListener('click', () => {
                const target = document.querySelector(button.dataset.target);
                target.classList.add('active');
            });
        });

        // close the comments When clicking outside the box
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
