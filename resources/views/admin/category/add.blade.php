@extends('admin.layouts.app')
@section('title', 'Add Subject')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title"> Subject</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.category.list')}}">Subject</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
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
            <h4 class="card-title">Add Subject</h4>
             
            <form class="forms-sample" id="add-category" action="{{route('admin.category.add')}}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="form-group">
                
                <div class="row">
                  <div class="col-6">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" placeholder="Name" name="name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                     <div class="col-6">
                  <label for="exampleCardLimit">Description</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" id="exampleCardLimit" placeholder="Enter a description " name="description" rows="3"></textarea>
                  @error('description')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
                </div>
              </div>

            

              <button type="submit" class="btn btn-primary mr-2 mt-3">Add</button>

              {{-- <button class="btn btn-dark">Cancel</button> --}}
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
    $("#add-category").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            name: {
                required: true,
                noSpace: true,
                minlength: 3,
                maxlength: 50
            },
            description: {
                required: true,
               
            },
           
        },
        messages: {
            name: {
                required: "Name is required.",
               
            },
            description: {
                required: "description is required",
               
            },
            
        },
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'file') {
                error.appendTo(element.closest('.col-6'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop