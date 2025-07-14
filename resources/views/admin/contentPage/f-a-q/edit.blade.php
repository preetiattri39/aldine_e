@extends('admin.layouts.app')
@section('title', 'Edit FAQ')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title"> FAQ</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.f-a-q.list')}}">FAQ</a></li>
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
            <h4 class="card-title">Edit FAQ</h4>
             
            <form class="forms-sample" id="add-faq" action="{{route('admin.f-a-q.edit',['id' => $faq->id])}}" method="POST" >
              @csrf

              <div class="form-group">
                  <div class="row">
                    <div class="col-12">
                        <label for="exampleInputName">Question</label>
                        <textarea name="question" id="question" rows="3" class="form-control">{{$faq->question}}</textarea>
                        @error('question')
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
                        <label>Answer</label>
                        <textarea name="answer" id="answer" rows="6" class="form-control">{{$faq->answer}}</textarea>
                        @error('answer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2 mt-2">Update</button>
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
    $("#edit-faq").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            question: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            answer: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
        },
        messages: {
            question: {
                required: "Question is required.",
                minlength: "Question must consist of at least 3 characters."
            },
            answer: {
                required: "Answer is required.",
                minlength: "Answer must consist of at least 3 characters."
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop