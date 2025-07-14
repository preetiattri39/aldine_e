@extends('admin.layouts.app')
@section('title', 'Subject')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Subject</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Subject</a></li>
      <li class="breadcrumb-item active" aria-current="page">SubCategories</li>
    </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
         {{-- <x-alert /> --}}
         {{-- <div class="flash-message"></div> --}}
        <div class="card-body">
          <div class="heading d-flex justify-content-between">
            <h4 class="card-title"> Subcategory Management</h4>
            <a href="{{route('admin.subcategory.add')}}"><button type="button" class="btn default-btn btn-md">
            <span class="menu-icon">+ Add Subcategory</span></button></a>
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
                  <th> Category </th>
                  <th> Name </th>
                  <th> Status </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($subcategory as $key => $data)
                  <tr data-id="{{$data->id}}">
                    <td>{{++$key}}</td>
                    <td>{{$data->category->name}}</td>
                    <td> {{$data->name}} </td>
                   
                    <td> 
                        <div class="toggle-user dark-toggle">
                        <input type="checkbox" name="is_active" data-id="{{$data->id}}" class="switch" @if ($data->status == 1) checked @endif data-value="{{$data->status}}">
                        </div> 
                    </td>
                    <td> 
                      <span class="menu-icon">
                        <a href="{{route('admin.subcategory.edit',['id' => $data->id])}}" title="Edit" class="text-success"><i class="mdi mdi-pencil"></i></a>
                      </span>&nbsp;&nbsp;
                      <span class="menu-icon">
                        <a href="#" title="Delete" class="text-danger deleteSubcategory" data-id="{{$data->id}}"><i class="mdi mdi-delete"></i></a>
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
            {{ $subcategory->appends(request()->query())->links('pagination::bootstrap-4') }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
  // CSRF setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('.deleteSubcategory').on('click', function() {
    var subcategory_id = $(this).data('id');

    Swal.fire({
      title: "Are you sure?",
      text: "You want to delete the Subject Subcategory?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#2ea57c",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/admin/subcategory/delete/${subcategory_id}`,
          type: "POST",
          success: function(response) {
            if (response.status === "success") {
              $(`tr[data-id="${subcategory_id}"]`).remove();
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
    var action = status == 1 ? 0 : 1;
    var id = $(this).data('id');

    Swal.fire({
      title: "Are you sure?",
      text: "Do you want to change the status of the Subject Subcategory?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#2ea57c",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, change it!"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/admin/subcategory/changeStatus",
          type: "GET",
          data: { id: id, status: action },
          success: function(response) {
            if (response.status === "success") {
              toastr.success(response.message);
              $(`.switch[data-id="${id}"]`)
                .data('value', action)
                .prop('checked', action === 1);
            } else {
              toastr.error(response.message);
            }
          },
          error: function(error) {
            console.log('error', error);
          }
        });
      } else {
        // Restore switch state on cancel
        $(this).prop('checked', status == 1);
      }
    });
  });
</script>

@stop
