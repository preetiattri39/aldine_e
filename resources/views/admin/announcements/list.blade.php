@extends('admin.layouts.app')
@section('title', 'Announcements')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Announcements</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Announcements</li>
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
            <h4 class="card-title">Announcements Management</h4>
            <a href="{{route('admin.announcements.create')}}"><button type="button" class="btn default-btn btn-md">
            <span class="menu-icon">+ Add Annoucement</span></button></a>
          </div>
          <div class="d-flex justify-content-between">
              <div class="admin-filters" style="width: 100%">
                <x-filter />
              </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Sr. No. </th>
                  <th> Title </th>
                  <th> Message </th>
                  <th> Status </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($announcement as $key => $data)
                  <tr data-id="{{$data->id}}">
                    <td>{{++$key}}</td>
                    <td> {{Str::limit($data->title,50, '...')}} </td>
                    <td> {{ Str::limit(strip_tags($data->message), 50, '...') }} </td>


                   
                      <td> 
                        <div class="toggle-user dark-toggle">
                        <input type="checkbox" name="status" data-id="{{$data->id}}" class="switch" @if ($data->status == 1) checked @endif data-value="{{$data->status}}">
                        </div> 
                    </td>
                      <td> 
                      <span class="menu-icon">
                        <a href="#" title="Delete" class="text-danger deleteCategory" data-id="{{$data->id}}"><i class="mdi mdi-delete"></i></a>
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
            {{ $announcement->appends(request()->query())->links('pagination::bootstrap-4') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
  $('.deleteCategory').on('click', function() {
    var category_id =  $(this).data('id');
      Swal.fire({
          title: "Are you sure?",
          text: "You want to delete the announcement?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#2ea57c",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  url: "/admin/announcements/delete/" + category_id,
                  type: "GET", 
                  success: function(response) {
                    if (response.status == "success") {
                       
                          $(`tr[data-id="${category_id}"]`).remove();
                          toastr.success(response.message); 
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
        text: "Do you want to change the status of the announcement?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2ea57c",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, mark as status"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/announcements/changeStatus",
                type: "GET",
                data: { id: id, status: action },
                success: function(response) {
                    if (response.status == "success") {
                      toastr.success(response.message);
                      $('.switch[data-id="' + id + '"]').data('value',!action);
                    } else {
                      $('.switch[data-id="' + id + '"]').data('value',action);
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

