@extends('admin.layouts.app')
@section('title', 'Add Languages')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Languages</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.language.list')}}">Languages</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add</li>
      </ol>
    </nav>
</div>
@endsection
@section('content')
<div>
    <div class="row justify-content-center">
      <div class="col-5 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Add Language</h4>
             
            <form class="forms-sample" id="add-language" action="{{route('admin.language.add')}}" method="POST" enctype="multipart/form-data">
              @csrf
                
                <div class="form-group">
                    <div class="row">
                        <label for="inputName">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Language Name" name="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <label for="inputCode">Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="inputCode" placeholder="Language Code" name="code">
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary mr-2">Add</button>
                    <a href="{{route('admin.language.list')}}" class="btn btn-dark">Cancel</a>
                </div>
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
    $("#add-language").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            name: {
                required: true,
                noSpace: true,
                minlength: 2,
            },
            code: {
                required: true,
                noSpace: true,
                minlength: 2,
            }
        },
        messages: {
            name: {
                required: "Language name is required.",
                minlength: "Language name must consist of at least 2 characters."
            },
            code: {
                required: "Language code is required.",
                minlength: "Language code must consist of at least 2 characters."
            }
        },
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
</script>
@stop