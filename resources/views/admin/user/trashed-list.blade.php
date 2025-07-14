@extends('admin.layouts.app')
@section('title', 'Trashed Users')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Trashed Users</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Trashed Users</li>
    </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h4 class="card-title">Trashed Users Management</h4>
              <div class="admin-filters">
                <form id="filter">
                  <div class="row align-items-center justify-content-end mb-3">
                      <div class="col-6 d-flex gap-2">
                          <input type="text" class="form-control"  placeholder="Search" name="search_keyword" value="{{request()->filled('search_keyword') ? request()->search_keyword : ''}}">            
                      </div>
                      <div class="col-6">
                          <button type="submit" class="btn btn-primary">Filter</button>
                          @if(request()->filled('search_keyword') || request()->filled('status') || request()->filled('category_id'))
                              <button class="btn btn-danger" id="clear_filter">Clear Filter</button>
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
                  <th> Name </th>
                  <th> Email </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $user)
                  <tr data-id="{{$user->id}}">
                    <td> {{$user->full_name}} </td>
                    <td>{{$user->email}}</td>
                    <td> 
                      <span class="menu-icon">
                        <a href="#" title="Restore" class="text-success restoreUser" data-id="{{$user->id}}"><i class="mdi mdi-backup-restore"></i></a>
                      </span> 
                    </td>
                  </tr>
                @empty
                    <tr>
                      <td colspan="6" class="no-record"> <center>No record found </center></td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
            <div class="custom_pagination">
              {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
  $('.restoreUser').on('click', function() {
    var user_id = $(this).data('id');
      Swal.fire({
          title: "Are you sure?",
          text: "You want to restore the deleted user?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2ea57c",
          cancelButtonColor: "#d33",                        

          confirmButtonText: "Yes, restore it!"
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: "/admin/user/restore/" + user_id,
                  type: "GET", 
                  success: function(response) {
                    if (response.status == "success") {
                        toastr.success(response.message);
                        $(`tr[data-id="${user_id}"]`).remove();
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
