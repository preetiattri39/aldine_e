@extends('admin.layouts.app')
@section('title', 'Edit Program')
@section('breadcrum')
<div class="page-header">
  <h3 class="page-title">Program</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{route('admin.program.list')}}">Program</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>
</div>
@endsection
@section('content')
<div>
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Edit Program</h4>

          <form class="forms-sample" id="Edit-Category" action="{{route('admin.program.edit',['id' => $category->id])}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <div class="row">
                <div class="col-6">
                  <label for="exampleInputName">Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder=" Name" name="name" value="{{$category->name ?? ''}}">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
               
              </div>
            </div>


            <button type="submit" class="btn btn-primary mr-2">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    $("#Edit-Category").submit(function(e) {
      e.preventDefault();
    }).validate({
      rules: {
        name: {
          required: true,
          minlength: 3,
          maxlength: 50
        },

      },
      messages: {
        first_name: {
          required: "Name is required",

        },

      },
      submitHandler: function(form) {
        form.submit();
      }

    });
  });
</script>
@stop