@extends('admin.layouts.app')
@section('title', 'Contact Messages')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Contact Messages</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact Messages</li>
    </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        
        <div class="card-body">
        <h4 class="card-title">Contact Messages Management</h4>

          <div class="d-flex justify-content-between">
              <div class="admin-filters">
                  <form id="filter">
                    <div class="row align-items-center justify-content-end mb-3">
                        <!-- Search Keyword -->
                        <div class="col-3 d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Search" name="search_keyword" value="{{ request()->filled('search_keyword') ? request()->search_keyword : '' }}">
                        </div>
                
                        <!-- Date Range Filter -->
                        <div class="col-3">
                            <input type="date" class="form-control" name="start_date" value="{{ request()->start_date }}" title="From date">
                        </div>
                        <div class="col-3">
                            <input type="date" class="form-control" name="end_date" value="{{ request()->end_date }}" title="To date">
                        </div>
                
                        <!-- Filter & Clear Buttons -->
                        <div class="col-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            @if(request()->filled('search_keyword') || request()->filled('status') || request()->filled('category_id') || request()->filled('start_date') || request()->filled('end_date'))
                                <button type="button" class="btn btn-danger" id="clear_filter">Clear Filter</button>
                            @endif
                        </div>
                    </div>
                </form>
              </div>
              
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Sr. No. </th>
                  <th> Name </th>
                  <th> Email </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($faq as $key => $data)
                  <tr data-id="{{$data->id}}">
                    <td>{{++$key}}</td>
                    <td> {{Str::limit($data->name,50, '...')}} </td>
                    <td> {{Str::limit($data->email,50, '...')}} </td>
                    <td> 
                      
                    <span class="menu-icon">
                <a href="{{ route('admin.contact.edit', ['id' => $data->id]) }}" 
                  title="{{ $data->is_replied ? 'View Reply' : 'Send Reply' }}" 
                  class="{{ $data->is_replied ? 'text-info' : 'text-success' }}">
                  
                    @if($data->is_replied ==1)
                        <i class="mdi mdi-message-reply-text"></i> {{-- or mdi-check-circle-outline --}}
                    @else
                        <i class="mdi mdi-send"></i>
                    @endif

                </a>
            </span>

                      <span class="menu-icon">
                        <a href="#" title="Delete" class="text-danger deleteFaq" data-id="{{$data->id}}"><i class="mdi mdi-delete"></i></a>
                      </span> 
                    </td>
                  </tr>
                @empty
                    <tr>
                      <td colspan="6" class="no-record"> <center>No record found </center></td>
                    </tr>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="custom_pagination">
            {{ $faq->appends(request()->query())->links('pagination::bootstrap-4') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
  $('.deleteFaq').on('click', function() {
    var id = $(this).data('id');
      Swal.fire({
          title: "Are you sure?",
          text: "You want to delete the contact?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2ea57c",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: "/admin/contact/delete/" + id,
                  type: "GET", 
                  success: function(response) {
                    if (response.status == "success") {
                      $(`tr[data-id="${id}"]`).remove();
                      toastr.success(response.message);
                       
                      } else {
                        toastr.error(response.message);
                      }
                  }
              });
          }
      });
  });


</script>

@stop
