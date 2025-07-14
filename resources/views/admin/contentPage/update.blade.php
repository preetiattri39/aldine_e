@extends('admin.layouts.app')
@section('title', $content_detail->slug)
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title"> Content Page </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item">{{ucwords(str_replace('-', ' ', $content_detail->slug))}}</li>
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
            <h4 class="card-title">{{ucwords(str_replace('-', ' ', $content_detail->slug))}}</h4>
             
            <form class="forms-sample" id="update-content" action="{{ route('admin.contentPages.detail',['slug' => $content_detail->slug]) }}" method="POST" enctype="multipart/form-data">
              @csrf
             
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="exampleInputTitle">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputTitle" placeholder="Title" name = "title" value="{{$content_detail->title}}">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> 
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <textarea id="editor" name="content">{{$content_detail->content}}</textarea>
                        </div>
                    </div>
                </div>

              <button type="submit" class="btn btn-primary mr-2">Update</button>
              {{-- <button class="btn btn-dark">Cancel</button> --}}
            </form>
          </div>
        </div>
      </div>
    </div>
</div>    
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
  $(document).ready(function() {
    ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
    $("#update-content").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            title: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            content: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Title is required",
                minlength: "Title must consist of at least 3 characters"
            },
            content: {
                required: "Content is required",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop