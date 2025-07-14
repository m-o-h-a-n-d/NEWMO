<!-- Content Row -->

<div class="row" wire:poll.500ms>

    <!-- Posts Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Latest Posts</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Comments</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Post_latest as $latest)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                @if ($latest->admin)
                                    <th>

                                        <a href="{{ route('admin.posts.edit', $latest->id) }}"
                                            class=" text-decoration-none">{{ $latest->title }}</a>



                                    </th>
                                @else
                                    <th>
                                        <a href="{{ route('admin.posts.show', $latest->id) }}"
                                            class=" text-decoration-none">{{ $latest->title }}</a>
                                    </th>
                                @endif
                                <th>{{ $latest->category->name }}</th>
                                <th>{{ $latest->comments->count() }}</th>
                                <th>{{ $latest->status == 0 ? 'Non Available' : 'Active' }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Latest Comments</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Posts</th>
                            <th>Comments</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Comments as $Comment)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $Comment->admin ? Str::before($Comment->admin->name, ' ') . '(Admin)' : Str::before($Comment->user->name, ' ') }}
                                </th>
                                @if ($Comment->post->admin)
                                    <th>
                                        <a href="{{ route('admin.posts.edit', $Comment->post->id) }}"
                                            class=" text-decoration-none">{{ Str::limit($Comment->post->title, 15) }}</a>
                                    </th>
                                @else
                                    <th>
                                        <a href="{{ route('admin.posts.show', $Comment->post->id) }}"
                                            class=" text-decoration-none">{{ Str::limit($Comment->post->title, 15) }}</a>
                                    </th>
                                @endif


                                <th>{{ Str::limit($Comment->comment, 15) }}</th>

                                <th>{{ $Comment->status == 0 ? 'Non Available' : 'Active' }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</div>
