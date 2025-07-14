@extends('admin.layouts.app')
@section('title', 'Users')
@section('breadcrum')
<div class="page-header">
  <h3 class="page-title">Users</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Users</li>
    </ol>
  </nav>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      	<div class="heading d-flex justify-content-between">
		<h4 class="card-title">User Management</h4>
		<a href="{{route('admin.user.add')}}"><button type="button" class="btn default-btn btn-md">
		      <span class="menu-icon">+ Add User</span></button></a>
	</div>
        <div class="d-flex justify-content-between">
          <div class="admin-filters" style="width:100%;">
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
          </div>
          
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> Profile </th>
                <th> Name </th>
                <th> Email </th>
             
                <th> Status </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @forelse ($users as $user)
              <tr data-id="{{$user->id}}">
                <td class="py-1">
                  <img src="{{userImageById($user->id)}}" onerror="this.src = '{{ asset('admin/images/faces/face15.jpg') }}'"
                    alt="User profile picture">
                </td>
                <td> {{$user->full_name}} </td>
                <td>{{$user->email}}</td>
               

                <td>
                  <div class="toggle-user dark-toggle">
                    <input type="checkbox" name="is_active" data-id="{{$user->id}}" class="switch" @if ($user->status == 1) checked @endif data-value="{{$user->status}}">

                  </div>
                </td>
                <td>

                  <span class="menu-icon">
                    <a href="{{route('admin.user.view',['id' => $user->id])}}" title="View" class="text-primary"><i class="mdi mdi-eye"></i></a>
                  </span>&nbsp;&nbsp;&nbsp;
                  <span class="menu-icon">
                    <a href="{{route('admin.user.edit',['id' => $user->id])}}" title="Edit" class="text-success"><i class="mdi mdi-pencil"></i></a>
                  </span>&nbsp;&nbsp;
                  <span class="menu-icon">
                    <a href="#" title="Delete" class="text-danger deleteUser" data-id="{{$user->id}}"><i class="mdi mdi-delete"></i></a>
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="no-record">
                  <center>No record found </center>
                </td>
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
  $('.deleteUser').on('click', function() {
    var user_id = $(this).data('id');
    Swal.fire({
      title: "Are you sure?",
      text: "You want to delete the User?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#2ea57c",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/admin/user/delete/" + user_id,
          type: "GET",
          success: function(response) {
            if (response.status == "success") {
              $(`tr[data-id="${user_id}"]`).remove();
              toastr.success(response.message);
            } else {
              toastr.error(response.message);
            }
          }
        });
      }
    });
  });

  $('.changeUserSubscription').on('click', function() {
    var user_id = $(this).data('id');
    Swal.fire({
      title: "Are you sure?",
      text: "Do you want to change the user subscription from Basic to Premium?",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#2ea57c",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proceed it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/admin/user/changeSubscription/" + user_id,
          type: "GET",
          success: function(response) {
            if (response.status == "success") {
              toastr.success(response.message);
              setTimeout(() => {
                location.reload();
              }, 1000);
            } else {
              toastr.error(response.message);
            }
          }
        });
      }
    });
  });

  $('.switch').on('click', function() {
    var status = $(this).data('value');
    var action = (status == 1) ? 0 : 1;
    var id = $(this).data('id');

    Swal.fire({
      title: "Are you sure?",
      text: "Do you want to change the status of the user?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#2ea57c",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, mark as status"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/admin/user/changeStatus",
          type: "GET",
          data: {
            id: id,
            status: action
          },
          success: function(response) {
            if (response.status == "success") {
              toastr.success(response.message);
              $('.switch[data-id="' + id + '"]').data('value', !action);
            } else {
              $('.switch[data-id="' + id + '"]').data('value', action);
              toastr.error(response.message);
            }
          },
          error: function(error) {
            console.log('error', error);
          }
        });
      } else {
        var switchToToggle = $('.switch[data-id="' + id + '"]');
        switchToToggle.prop('checked', !switchToToggle.prop('checked'));
      }
    });
  });
</script>

@stop
