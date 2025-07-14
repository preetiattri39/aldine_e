<form id="filter">
    <div class="row align-items-center justify-content-end mb-3">
        <!-- Search Keyword -->
        <div class="col-3 d-flex gap-2">
            <input type="text" class="form-control" placeholder="Search" name="search_keyword" value="{{ request()->filled('search_keyword') ? request()->search_keyword : '' }}">
        </div>

        <!-- Status Filter -->
        <div class="col-2">
            <select class="form-control" name="status" style="width:100%">
                <option value="">All</option>
                <option value="1" {{ (request()->filled('status') && request()->status == "1") ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (request()->filled('status') && request()->status == "0") ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Date Range Filter -->
        <div class="col-2">
            <input type="date" class="form-control" name="start_date" value="{{ request()->start_date }}" title="From date">
        </div>
        <div class="col-2">
            <input type="date" class="form-control" name="end_date" value="{{ request()->end_date }}" title="To date">
        </div>

        <!-- Filter & Clear Buttons -->
        <div class="col-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request()->filled('search_keyword') || request()->filled('status') || request()->filled('category_id') || request()->filled('start_date') || request()->filled('end_date'))
                <button type="button" class="btn btn-danger ml-2" id="clear_filter">Clear Filter</button>
            @endif
        </div>
    </div>
</form>
