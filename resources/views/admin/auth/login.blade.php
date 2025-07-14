@extends('admin.auth.layout')
@section('title','Log in')
@section('content')
<div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
  <div class="card col-lg-4 mx-auto">
    <div class="card-body px-5 py-5">
      <h3 class="card-title text-left mb-3">{{ __('Login') }}</h3>
        {{-- <x-alert /> --}}
      <form action="{{ route('login') }}" method="POST" id="loginForm">
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

          <div class="form-group">
            <label for="password">{{ __('Password') }} *</label>
            <input name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password">
            <span class="togglePassword eye-icon" data-toggle="password">
                <i class="fa fa-eye-slash"></i>
            </span>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>   

        <div class="form-group d-flex align-items-center justify-content-between">
          <div class="form-check">
              {{--<input type="checkbox" class="form-check-input" name="remember" id="remember"  {{ old('remember') ? 'checked' : ''}}> Remember me </label>--}}
            <label class="form-check-label">
          </div> 
          <a href="{{route('forget-password')}}" class="forgot-pass">{{ __('Forgot Your Password?') }}</a>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-block enter-btn">{{ __('Login') }}</button>
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
            email: {
              required: true,
              email: true
            },
            password: {
              required: true,
              //minlength: 8
            },
          },
          messages: {
            email: {
              required: 'Please enter Email Address.',
              email: 'Please enter a valid Email Address.',
            },
            password: {
              required: 'Please enter Password.',
            },
          },
          submitHandler: function (form) {
            form.submit();
          }
        });
    </script>
@endsection
