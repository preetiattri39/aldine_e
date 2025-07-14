@extends('admin.auth.layout')
@section('title','Reset Password')
@section('content')
<div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
  <div class="card col-lg-4 mx-auto">
    <div class="card-body px-5 py-5">
      <h3 class="card-title text-left mb-3">Reset Password</h3>
        {{-- <x-alert /> --}}
      <form action="{{ route('reset-password',['token' => $token]) }}" method="POST" id="loginForm">
          @csrf
          <div class="form-group">
              <label for="password">{{ __('Password') }} *</label>
              <input name="password" id="password" type="password" class="form-control  @error('password') is-invalid @enderror" autocomplete="current-password">
              <span class="togglePassword eye-icon" data-toggle="password">
                <i class="fa fa-eye-slash"></i>
              </span>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="form-group">
              <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  <span class="togglePassword eye-icon" data-toggle="password-confirm">
                    <i class="fa fa-eye-slash"></i>
                  </span>
                  @error('password_confirmation')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
          </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-block enter-btn">{{ __('Reset Password') }}</button>
        </div>
        
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $('#loginForm').validate({
    rules: {
        password: {
          required: true,
          noSpace: true,
          minlength: 8,
        },
        password_confirmation: {
          required: true,
          noSpace: true,
          minlength: 8,
          equalTo: "#password",
        },
    },
    messages: {
        password: {
        required: 'Password is required.',
        minlength: 'Password length must contain 8 charcter.',
        },
        password_confirmation: {
            required: 'Confirm password is required.',
            minlength: 'Confirm password length must contain 8 charcter.',
            equalTo: "Password and confirm password must be same"
        },
    },
    submitHandler: function (form) {
      form.submit();
    }
  });
</script>
@endsection