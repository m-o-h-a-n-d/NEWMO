{{-- Start Update Category Modal --}}
<div class="modal fade" id="UpdateCategory_{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category
                </h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="POST" id="updateCategoryForm" action="{{ route('admin.categories.update', $category->id) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="update-name-{{ $category->id }}" class="form-label">Name</label>
                            <input type="text" value="{{ $category->name }}" name="name"
                                id="update-name-{{ $category->id }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="update-status-{{ $category->id }}" class="form-label">Status</label>
                            <select name="status" id="update-status-{{ $category->id }}" class="form-control" required>
                                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>
                                    Active</option>
                                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>
                                    Not Available</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End Update Category Modal --}}
