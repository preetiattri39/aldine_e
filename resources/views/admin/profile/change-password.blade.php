@extends('admin.layouts.app')
@section('title', 'Change Password')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Change Password</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="#"> Settings</a></li>  
        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
      </ol>
    </nav>
</div>
@endsection
@section('content')
<div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Change Password</h4>
                 {{-- <div class="flash-message"></div> --}}
                <form class="forms-sample" action={{route('admin.changePassword')}} method="post" id="change-password">
                  @csrf
                  <div class="form-group row">
                      <label for="exampleInputPassword" class="col-sm-3 col-form-label">Current Password</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="exampleInputPassword" placeholder="Current Password" name="current_password">
                        <span class="togglePassword eye-icon" data-toggle="exampleInputPassword">
                          <i class="fa fa-eye-slash"></i>
                        </span>
                        @error('current_password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>    
                  </div>

                  <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">New Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="New Password" name="password">
                      <span class="togglePassword eye-icon" data-toggle="password">
                        <i class="fa fa-eye-slash"></i>
                      </span>
                        @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id = "confirm_password" name="password_confirmation" placeholder="Confirm Password">
                      <span class="togglePassword eye-icon" data-toggle="confirm_password">
                        <i class="fa fa-eye-slash"></i>
                      </span>
                      @error('confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
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
<script>
  $.validator.addMethod("strongPassword", function(value, element) {
    return this.optional(element) || /^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/.test(value);
  }, "Password must be at least 8 characters long and include one uppercase letter, one number, and one special character.");

  $("#change-password").submit(function(e){
      e.preventDefault();
  }).validate({
      rules: {
          current_password: {
              required: true,
              noSpace: true,
              minlength: 8,
          },
          password: {
            required: true,
            noSpace: true,
            strongPassword: true,
          },
          password_confirmation: {
            required: true,
            noSpace: true,
            strongPassword: true,
            equalTo: "#password",
          },
      },
      messages: {
          current_password: {
            required: 'Current password is required.',
            noSpace: 'Current password cannot be empty.',
            minlength: 'Current password length must contain 8 charcter.'
          },
          password: {
            required: 'New password is required.',
            strongPassword: 'Password must include one uppercase letter, one number, one special character and 8 character long.'
          },
          password_confirmation: {
            required: 'Confirm password is required.',
            strongPassword: 'Password must include one uppercase letter, one number, one special character and 8 character long.',
            equalTo: "New password and confirm password must be same"
          },
      },
      submitHandler: function(form) {
        var formData = new FormData(form);
        var action = $(form).attr('action'); // Corrected to use jQuery
        $.ajax({
            url: action, // Use the form's action attribute
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              console.log(response);  
                // Handle success
                if (response.status == "success") {
                  toastr.success(response.message);
                    
                  setTimeout(function() {
                      location.reload();
                  }, 2000);
                } else {
                  toastr.error(response.message);
                }
            },
            error: function(xhr) {
                // Handle error
                // let errors = xhr.responseJSON;
                let response = xhr.responseJSON;
                toastr.error(response.message);
            }
        });
    }

  });
</script>
@stop