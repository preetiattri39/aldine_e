@extends('admin.layouts.app')
@section('title', 'Langauges')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Langauges</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Language</li>
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
          <h4 class="card-title">Languages Management</h4>
          <a href="{{route('admin.language.add')}}">
            <button type="button" class="btn default-btn btn-md">
              <span class="menu-icon">+ Add Language</span>
            </button>
          </a>
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
                <th> Name </th>
                <th> Code </th>
               
                <th> Status </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @forelse ($category as $key => $data)
                <tr data-id="{{$data->id}}">
                  <td>{{++$key}}</td>
                 
                  <td> {{$data->name}} </td>
                    <td>{{ucfirst($data->code)}}</td>
                  
                  <td> 
                      <div class="toggle-user dark-toggle">
                      <input type="checkbox" name="is_active" data-id="{{$data->id}}" class="switch" @if ($data->status == 1) checked @endif data-value="{{$data->status}}">
                      </div> 
                  </td>
                  <td> 
                    <span class="menu-icon">
                      <a href="{{route('admin.language.edit',['id' => $data->id])}}" title="Edit" class="text-success"><i class="mdi mdi-pencil"></i></a>
                    </span>&nbsp;&nbsp;
                    <span class="menu-icon">
                      <a href="#" title="Delete" class="text-danger deleteLanguage" data-id="{{$data->id}}"><i class="mdi mdi-delete"></i></a>
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
          {{ $category->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $('.deleteLanguage').on('click', function() {
    var language_id = $(this).data('id');
    var languageRow = $(this).closest('tr'); // Assuming the button is in a table row

    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete this language?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2ea57c",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/language/delete/" + language_id,
                type: "get", 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success") {
                        // Remove the row from the table
                        languageRow.fadeOut(300, function() {
                            $(this).remove();
                        });
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error("An error occurred while deleting the language");
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
                url: "/admin/language/changeStatus",
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
