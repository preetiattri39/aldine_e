@extends('admin.auth.layout')
@section('title','Foget Password')
@section('content')
<div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
  <div class="card col-lg-4 mx-auto">
    <div class="card-body px-5 py-5">
      <h3 class="card-title text-left mb-3">{{ __('Reset Password') }}</h3>
        {{-- <x-alert /> --}}
      <form action="{{ route('forget-password') }}" method="POST" id="loginForm">
          @csrf
          <div class="form-group">
              <label for="email">{{ __('Email Address') }} *</label>
              <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-block enter-btn">{{ __('Send Password Reset Link') }}</button>
        </div>
        <div class="text-center">
          <a href="{{route('login')}}"><i class="fa-solid fa-arrow-left"></i> Back to login </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function () {
    $('#loginForm').validate({
      rules: {
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        email: {
          required: 'Please enter Email Address.',
          email: 'Please enter a valid Email Address.',
        },
      },
      submitHandler: function (form) {
        form.submit();
      }
    });
  });
</script>
@endsection