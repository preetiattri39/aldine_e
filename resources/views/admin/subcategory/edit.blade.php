@extends('admin.layouts.app')
@section('title', 'Edit Subject')
@section('breadcrum')
<div class="page-header">
  <h3 class="page-title">Subject</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="#">Subject</a></li>
      <li class="breadcrumb-item"><a href="{{route('admin.subcategory.list')}}">Subcategory</a></li>
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
          <h4 class="card-title">Edit Subcategory</h4>

          <form class="forms-sample" id="Edit-Subcategory" action="{{route('admin.subcategory.edit',['id' => $subcategory->id])}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <div class="row">
                <div class="col-12">
                  <label for="exampleInputName">Category</label>
                  <select name="category_id" id="category_id" class="form-control select2" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (old('category_id', $subcategory->category_id) == $category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-6">
                  <label for="exampleInputName">Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder=" Name" name="name" value="{{$subcategory->name ?? ''}}">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="col-6">
                  <label for="exampleCardLimit">Description</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" id="exampleCardLimit" placeholder="Enter a description " name="description" rows="3">{{ old('description', $subcategory->description ?? '') }}</textarea>
                  @error('description')
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