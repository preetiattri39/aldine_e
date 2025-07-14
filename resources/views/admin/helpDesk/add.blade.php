@extends('admin.layouts.app')
@section('title', 'Add Query')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Help Desk</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.helpDesk.list',['type' => 'open'])}}">Help Desk</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Query</li>
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
            <h4 class="card-title">Add Query</h4>
             
            <form class="forms-sample" id="add-query" action="{{route('admin.helpDesk.add')}}" method="POST">
              @csrf

              <div class="form-group">
                <div class="row">
                  <div class="col-6">
                    <label for="exampleInputUserName">User Name</label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="exampleInputUserName" placeholder="User Name" name="user_name">
                    @error('user_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-6">
                    <label for="exampleInputEmail">Email</label>
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email" name="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputPhoneNumber">Phone Number</label>
                        <input type="number" class="form-control  @error('phone_number') is-invalid @enderror" id="exampleInputPhoneNumber" placeholder="Phone Number" name="phone_number">
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputdescription">Query</label>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="exampleInputdescription" placeholder="Query" name="description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
              </div>
              
              <button type="submit" class="btn btn-primary mr-2">Add</button>
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
    $("#add-query").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            user_name: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            email: {
                required: true,
                email: true,
                noSpace: true,
            },
            phone_number: {
                number: true,
                minlength:10,
                maxlength: 10,
            },
            description: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
        },
        messages: {
            user_name: {
                required: "User name is required.",
                minlength: "User name must consist of at least 3 characters."
            },
            phone_number: {
                number: 'Only numeric value is acceptable',
                minlength:  'Phone number must be 10 digits',
                maxlength:  'Phone number must be 10 digits'
            },
            email: {
                required: 'Email is required.',
                email: "Please enter a valid email address"
            },
            description: {
                required: "Query is required.",
                minlength: "Query must consist of at least 3 characters."
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop