@extends('admin.layouts.app')
@section('title', 'Edit Banner')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Banners</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.banner.list')}}">Banners</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
            <h4 class="card-title">Edit Banner</h4>
             
            <form class="forms-sample" id="edit-banner" action="{{route('admin.banner.edit',['id' => $banner->id])}}" method="POST" enctype="multipart/form-data">
              @csrf
              
                <div class="form-group">
                    <div class="row">
                        <label for="exampleInputTitle">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle" placeholder="Title" name="title" value="{{$banner->title ?? ''}}">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>  
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="card_type">Type</label>
                        <select class="js-example-basic-single select2-hidden-accessible  form-control @error('type') is-invalid @enderror" name="type" style="width:100%" data-select2-id="1" tabindex="-1" aria-hidden="true" id="card_type">
                            <option value="default" {{$banner->type == 'default' ? 'selected' : ''}}>Default</option>
                            <option value="subscription" {{$banner->type == 'subscription' ? 'selected' : ''}}>Subscription</option>
                            <option value="contact-Aldine E" {{$banner->type == 'contact-Aldine E' ? 'selected' : ''}}>Contact Aldine E</option>
                        </select>
                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $type }}</strong>
                            </span>
                        @enderror   
                    </div> 
                </div>
                {{-- <div class="form-group">
                    <div class="row">
                        <label for="exampleInputdescription">Description</label>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="exampleInputdescription" placeholder="Description" name="description">{{$banner->description ?? ''}}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> --}}

                <div class="form-group">
                    <div class="row">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control file-upload-info" placeholder="Upload Image" accept="image/*" value="{{$banner->path}}">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

              <button type="submit" class="btn btn-primary mr-2" >Update</button>
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
    
    $("#edit-banner").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            title: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            type: {
                required: true,
            },
            
            // file: {
            //     required: true,
            // },
        },
        messages: {
            title: {
                required: "Title is required.",
                minlength: "Title must consist of at least 3 characters."
            },
            type: {
                required: "Please select type.",
            },
            // file:{
            //     required: "Please select banner image."
            // },
        },
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            if (element.prop('type') === 'file') {
                error.appendTo(element.closest('.row'));
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