@extends('admin.layouts.app')
@section('title', 'SMTP Information')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Config Setting</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">SMTP Information</li>
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
            <h4 class="card-title">SMTP Information</h4>
             
            <form class="forms-sample" id="smtp-information" action="{{route('admin.config-setting.smtp')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputFromEmail">From Email</label>
                        <input type="email" class="form-control  @error('from_email') is-invalid @enderror" id="exampleInputFromEmail" placeholder="From Email" name="from_email" value="{{$smtpDetail['from_email'] ?? ''}}">
                        @error('from_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputHost">Host</label>
                        <input type="text" class="form-control @error('host') is-invalid @enderror" id="exampleInputHost" placeholder="Host" name="host" value="{{$smtpDetail['host'] ?? ''}}">
                        @error('host')
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
                        <label for="exampleInputPort">Port</label>
                        <input type="number" class="form-control @error('port') is-invalid @enderror" id="exampleInputPort"  min=0 max=9999  placeholder="Port" name="port" value="{{$smtpDetail['port'] ?? ''}}">
                        @error('port')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputUserName">User Name</label>
                        <input type="email" class="form-control  @error('username') is-invalid @enderror" id="exampleInputUserName" placeholder="User Name" name="username" value="{{$smtpDetail['username'] ?? ''}}">
                        @error('username')
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
                        <label for="exampleInputFromName">From Name</label>
                        <input type="text" class="form-control @error('from_name') is-invalid @enderror" id="exampleInputFromName" placeholder="From Name" name = "from_name" value="{{$smtpDetail['from_name'] ?? ''}}">
                        @error('from_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputPassword">Password</label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password" name="password" value="{{$smtpDetail['password'] ?? ''}}">
                        @error('password')
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
                        <label for="card_type">Encryption</label>
                        <select class="js-example-basic-single select2-hidden-accessible @error('encryption') is-invalid @enderror" name="encryption" style="width:100%" data-select2-id="1" tabindex="-1" aria-hidden="true" id="card_type">
                            <option value="tls" {{ $smtpDetail['encryption'] == 'tls' ? 'selected' : ''}}>tls</option>
                            <option value="ssl"{{ $smtpDetail['encryption'] == 'ssl' ? 'selected' : ''}}>ssl</option>
                        </select>
                        @error('encryption')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $type }}</strong>
                            </span>
                        @enderror    
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
<script>
  $(document).ready(function() {
    $("#smtp-information").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            from_email: {
                required: true,
                email: true,
                noSpace: true,
            },
            host: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            port: {
                number: true,
                minlength:3,
                maxlength: 5,
            },
            username: {
                required: true,
                email: true,
                noSpace: true,
            },
            from_name: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            password: {
                required: true,
                noSpace: true,
            },
            encryption: {
                required: true,
            },
            
        },
        messages: {
            from_email: {
                required: 'From email is required.',
                email: "Please enter a valid email address"
            },
            host: {
                required: "Host is required",
                minlength: "Host must consist of at least 3 characters"
            },
            port: {
                number:     'Only numeric value is acceptable',
                minlength:  'Port must be 3 digits',
                maxlength:  'Port not be greater than 5 digits'
            },
            username: {
                required: 'User name is required.',
                email: "Please enter a valid email address"
            },
            from_name: {
                required: "From name is required",
                minlength: "From name must consist of at least 3 characters"
            },
            password: {
                required: "Password is required",
            },
            encryption: {
                required: "Password is required",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop