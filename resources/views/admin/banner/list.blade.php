@extends('admin.layouts.app')
@section('title', 'Banners')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Banners</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Banners</li>
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
          <h4 class="card-title">Banner Management</h4>
            <div class="admin-filters">
              <x-filter />
            </div>
            <a href="{{route('admin.banner.add')}}">
              <button type="button" class="btn default-btn btn-md">
                <span class="menu-icon">+ Add Banner</span>
              </button>
            </a>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> Sr. No. </th>
                <th> Image </th>
                <th> Title </th>
                <th> Type </th>
                {{-- <th> Discount Code </th> --}}
                <th> Status </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @forelse ($banners as $key => $data)
                <tr data-id="{{$data->id}}">
                  <td>{{++$key}}</td>
                  <td class="py-1">
                    <img src="{{(!is_null($data->path) && file_exists(public_path('storage/images/' .$data->path))) ? asset('storage/images/' . $data->path) : asset('admin/images/faces/face15.jpg') }}" onerror="this.src = '{{ asset('admin/images/faces/face15.jpg') }}'"
                    alt="Banner picture">
                  </td>
                  <td> {{$data->title}} </td>
                    <td>{{ucfirst($data->type)}}</td>
                  {{-- <td>{{$data->discount_code}}</td> --}}
                  <td> 
                      <div class="toggle-user dark-toggle">
                      <input type="checkbox" name="is_active" data-id="{{$data->id}}" class="switch" @if ($data->status == 1) checked @endif data-value="{{$data->status}}">
                      </div> 
                  </td>
                  <td> 
                    <span class="menu-icon">
                      <a href="{{route('admin.banner.edit',['id' => $data->id])}}" title="Edit" class="text-success"><i class="mdi mdi-pencil"></i></a>
                    </span>&nbsp;&nbsp;
                    <span class="menu-icon">
                      <a href="#" title="Delete" class="text-danger deleteBanner" data-id="{{$data->id}}"><i class="mdi mdi-delete"></i></a>
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
          {{ $banners->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $('.deleteBanner').on('click', function() {
    var category_id = $(this).data('id');
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete the Banner?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2ea57c",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/banner/delete/" + category_id,
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
        text: "Do you want to change the status of the banner?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2ea57c",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, mark as status"
    }).then((result) => {
        if (result.isConfirmed) {
          $('.preloader').show();
            $.ajax({
                url: "/admin/banner/changeStatus",
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
