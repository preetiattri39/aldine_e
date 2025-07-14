@extends('admin.layouts.app')
@section('title', 'Avatars')
@section('breadcrum')
<div class="page-header">
  <h3 class="page-title">Users</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Avatars</li>
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
		<h4 class="card-title">Avatar Management</h4>
		<a href="{{route('admin.avatar.add')}}"><button type="button" class="btn default-btn btn-md">
		      <span class="menu-icon">+ Add Avatar</span></button></a>
	</div>
        <div class="d-flex justify-content-between">
          <div class="admin-filters" style="width:100%;">
            <form id="filter">
		    <div class="row align-items-center justify-content-end mb-3">

		
		    </div>
		</form>
          </div>
          
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> Avatar </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @forelse ($avatars as $avatar)
              <tr data-id="{{$avatar->id}}">
                <td class="py-1">
                  <img src="{{ $avatar->avatar_path }}" alt="Avatar" style="width:80px; height:80px; object-fit:cover;">
                </td>
              
                <td>

                  <span class="menu-icon">
                    <a href="#" title="Delete" class="text-danger deleteUser" data-id="{{$avatar->id}}"><i class="mdi mdi-delete"></i></a>
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
          {{ $avatars->appends(request()->query())->links('pagination::bootstrap-4') }}
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
    
    var avatarDeleteRoute = "{{ route('admin.avatar.delete', ['id' => '__ID__']) }}";
    var finalUrl = avatarDeleteRoute.replace('__ID__', user_id);

    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete the Avatar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2ea57c",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: finalUrl,
                type: "GET",
                success: function(response) {
                    if (response.status === "success") {
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

 
</script>

@stop
