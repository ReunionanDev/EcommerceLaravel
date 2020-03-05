<form action="{{ route('products.search') }}" class="d-flex mr-3">
    <div class="form-group mb-0 mr-1">
        <input type="text" name="search" class="form-control" value="{{ request()->search ?? '' }}">
    </div>
    <button type="submit" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>