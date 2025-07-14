    @extends('layouts.frontend.app')


    {{--  Breadcrumb start  --}}
    @section('breadcrumb')
        @parent
        <li class="breadcrumb-item">Profile</li>
    @endsection
    {{--  Breadcrumb End  --}}


    @section('title')
        Profile
    @endsection


    @section('content')
        <div class="dashboard container">
            @include('frontend.dashboard._slider', ['profile_slide' => 'active'])
            <!-- Main Content -->
            <div class="main-content">
                <!-- Profile Section -->
                <section id="profile" class="content-section active">
                    <h2>User Profile</h2>
                    <div class="user-profile mb-3 d-flex flex-column align-items-center">
                        {{-- User Image --}}
                        <img src="{{ Auth::guard('web')->user()->image_url }}" alt="User Image"
                            class="profile-img rounded-circle" style="width: 180px; height: 130px" />
                        <span class="username d-block">{{ Auth::guard('web')->user()->name }}</span>
                        <p class="text-muted"> {{ Auth::guard('web')->user()->username }} </p>

                    </div>
                    <br />


                    {{-- Start Error POST --}}
                    @if (Session()->has('errors'))
                        <div class="alert alert-danger">
                            @foreach (Session('errors')->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </div>
                    @endif
                    {{-- End Error POST --}}

                    <!-- Add Post Section -->
                    <form action="{{ route('frontend.dashboard.post.store') }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        <section id="add-post" class="add-post-section mb-5">
                            <h2>Add Post</h2>
                            <div class="post-form p-3 border rounded">
                                <!-- Post Title -->

                                <input type="text" id="postTitle" class="form-control mb-2" name="title"
                                    placeholder="Post Title" />

                                {{-- small_desc --}}
                                <textarea type="text" id="small_desc" class="form-control mb-2" name="small_desc" placeholder="Small Description"></textarea>


                                <!-- Post Content -->
                                <textarea id="postContent" class="form-control mb-2" name="description" rows="3"
                                    placeholder="What's on your mind?"></textarea>


                                <!-- Image Upload -->
                                <input type="file" id="postImage" name="image[]" class="form-control mb-2"
                                    accept="image/*" multiple />

                                <div class="tn-slider mb-2">
                                    <div id="imagePreview" class="slick-slider"></div>
                                </div>

                                <!-- Category Dropdown -->
                                <select id="postCategory" name="category_id" class="form-select mb-2">
                                    <option value="" selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <br>

                                <!-- Enable Comments Checkbox -->
                                <label class="label pt-2 pb-2 align-items-center d-grid justify-between">
                                    Enable Comments : <input name="comment_able" type="checkbox" class="" />
                                </label><br />

                                <!-- Post Button -->
                                <button type="submit" class="btn btn-primary post-btn">Post</button>
                            </div>
                        </section>

                    </form>

                    {{-- ========================================================================================== --}}
                    <!-- Posts Section -->
                    <section id="posts" class="posts-section">
                        <h2>Recent Posts</h2>
                        <div class="scrollable-posts post-list ">
                            <!-- Post Item -->
                            @forelse ($MyPosts as $post)
                                <div class="post-item mb-4 p-3 border rounded">
                                    <div class="post-header d-flex align-items-center mb-2">
                                        <a href="{{ route('frontend.dashboard.profile') }}"
                                            class="d-flex align-items-center">
                                            {{-- User Image --}}
                                            <img src="{{ Auth::user()->image }}" alt="User Image" class="rounded-circle"
                                                style="width: 50px; height: 50px" />
                                            <div class="ms-3">

                                                <h5 class="mb-0 pl-3">{{ Auth::user()->username }}</h5>

                                                <small class="pl-4 text-muted">
                                                    {{-- Display the post creation date --}}
                                                    @if ($post->created_at->diffInDays() > 7)
                                                        {{ $post->created_at->format('d M Y') }}
                                                    @else
                                                        {{ $post->created_at->diffForHumans() }}
                                                    @endif
                                                </small>

                                            </div>
                                        </a>
                                    </div>


                                    <h4>{{ $post->title }}</h4>
                                    <p style="word-break: break-word;">{!! $post->description !!}</p>

                                    {{-- انا عامل دي عشان أمنع التضارب --}}
                                    @php $carouselId = 'carouselPost' . $post->id; @endphp


                                    {{-- MyPosts --}}
                                    <div id="{{ $carouselId }}" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @foreach ($post->images as $index => $image)
                                                <li data-target="#{{ $carouselId }}" data-slide-to="{{ $index }}"
                                                    class="{{ $index == 0 ? 'active' : '' }}"></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach ($post->images as $index => $image)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    <img src="{{ asset($image->path) }}" class="d-block w-100"
                                                        style="height: 30rem">
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($post->images->count() > 1)
                                            <a class="carousel-control-prev" href="#{{ $carouselId }}" role="button"
                                                data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#{{ $carouselId }}" role="button"
                                                data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        @endif
                                    </div>

                                    <div class="post-actions d-flex justify-content-between">
                                        <div class="post-stats">
                                            <!-- View Count -->
                                            <span class="me-3">
                                                <i class="fas fa-eye"></i> {{ $post->views->count() }}
                                            </span>
                                        </div>

                                        <div class="post-buttons  d-flex  width-100 justify-content-end">


                                            {{-- Edit --}}
                                            <a href="{{ route('frontend.dashboard.post.edit', $post->slug) }}"
                                                class="btn btn-sm btn-outline-primary mr-2 ">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            {{-- Delete --}}

                                            <form action="{{ route('frontend.dashboard.post.delete', $post->id) }}"
                                                method="POST" class="form-delete d-inline mr-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>

                                            {{-- Comments --}}
                                            @if ($post->comment_able == true)
                                                @php $commentId = 'comOverlay' . $post->id; @endphp

                                                <button class="btn btn-sm btn-outline-secondary btn-show-comments"
                                                    data-target="#{{ $commentId }}">
                                                    <i class="fas fa-comment"></i>
                                                    Comments
                                                </button>

                                                <div id="{{ $commentId }}" class="com-overlay d-none">
                                                    <div class="com-box">
                                                        <div class="com-scroll">
                                                            @foreach ($post->comments as $comment)
                                                                <div class="com-item">
                                                                    <img src="{{ asset($comment->user->image) }}"
                                                                        alt="User">
                                                                    <div class="com-body">
                                                                        <strong>{{ $comment->user->username }}</strong>
                                                                        <p class="comment-text">
                                                                            {{ $comment->comment }}</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <form class="com-form">
                                                            @csrf
                                                            <input type="hidden" name="post_id"
                                                                value="{{ $post->id }}">
                                                            <input type="text" name="comment"
                                                                placeholder="Add a comment..." required>
                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::guard('web')->user()->id }}">
                                                            <button type="submit"
                                                                class="btn btn-primary">Comment</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Display Comments -->
                                    <div class="comments">
                                        <div class="comment">
                                            <img src="{{ Auth::guard('web')->user()->image }}" alt="User Image"
                                                class="comment-img" />
                                            <div class="comment-content">
                                                <span class="username"></span>
                                                <p class="comment-text">first comment</p>
                                            </div>
                                        </div>
                                        <!-- Add more comments here for demonstration -->
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    No posts available. Please create a post.
                                </div>
                            @endforelse




                            <!-- Add more posts here dynamically -->
                        </div>
                    </section>
                </section>
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
                });

                $('#postContent').summernote({
                    height: 300,
                });
            });



            // Sweet Alert Delete
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form'); // get the parent form of the clicked button

                Swal.fire({
                    title: 'Are you sure you want to Delete Post?',
                    text: "You Can't undo this action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });




            // إرسال تعليق جديد داخل تصميم com-box
            $(document).on('submit', '.com-form', function(e) { // يعني اي form داخل com-box تعمل submit
                e.preventDefault(); // يمنع انوا يعمل refresh للصفحه

                const form = $(this); // هنا بدخل form نفسه الي عمل عليه Submit

                const formData = new FormData(
                    this); //بنجهز البيانات اللي جوه الفورم عشان نبعتها في AJAX باستخدام FormData

                const commentBox = form.closest('.com-box').find(
                    '.com-scroll'); // هنا بنجيب ال com-scroll الي جوه com-box عشان نضيف التعليق الجديد فيه

                $.ajax({
                    url: "{{ route('frontend.single.comments.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        commentBox.prepend(`
                <div class="com-item">
                    <img src="${data.comment.user.image_url ?? '/default-user.png'}" alt="User">
                    <div class="com-body">
                        <strong>${data.comment.user.username}</strong>
                        <p>${data.comment.comment}</p>
                    </div>
                </div>
            `);
                        form[0].reset(); // هنا بنمسح الفورم بعد ما نضيف التعليق
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
                    },
                });
            });


            // Show Comments Overlay  After press in Comments Button

            document.querySelectorAll('.btn-show-comments').forEach(
                button => { // بنختار كل الأزرار اللي فيها الكلاس .btn-show-comments.

                    button.addEventListener('click', () => { //على كل زر، بنضيف event لما المستخدم يدوس عليه (click).
                        //كل زر عنده خاصية data-target="#comOverlayID"، واللي بتحدد الـ div اللي جواه التعليقات الخاصة بالبوست.

                        const target = document.querySelector(button.dataset
                            .target); //بتروح تجيب الـ div اللي المفروض يفتح.

                        target.classList.remove(
                            'd-none'); // نخليه يبان (يظهر) عن طريق إزالة الكلاس d-none (اللي كان مخفيه).
                    });
                });


            // Close Comments Overlay when clicking outside the box
            document.addEventListener('click', function(e) {
                document.querySelectorAll('.com-overlay').forEach(overlay => {
                    const box = overlay.querySelector('.com-box');
                    const toggleBtn = document.querySelector(`[data-target="#${overlay.id}"]`);

                    if (!box.contains(e.target) && !toggleBtn.contains(e.target)) {
                        overlay.classList.add(
                            'd-none'); //لو المستخدم مدسّش جوا التعليقات نفسها ولا على الزر بتاع إظهارها
                    }
                });
            });
        </script>
    @endpush
