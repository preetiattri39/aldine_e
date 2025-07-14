@extends('admin.layouts.app')
@section('title', 'PayPal')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Config Setting</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">PAYPAL Information</li>
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
            <h4 class="card-title">PAYPAL Information</h4>
             
            <form class="forms-sample" id="paypal-information" action="{{route('admin.config-setting.paypal')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputFromCLIENT_ID">PayPal Client Id</label>
                        <input type="text" class="form-control @error('PAYPAL_CLIENT_ID') is-invalid @enderror" id="exampleInputFromCLIENT_ID" placeholder="PayPal Client Id" name = "PAYPAL_CLIENT_ID" value="{{$paypalDetail['PAYPAL_CLIENT_ID'] ?? ''}}">
                        @error('PAYPAL_CLIENT_ID')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputCLIENT_SECRET">PayPal Client Secret</label>
                        <input type="text" class="form-control @error('PAYPAL_CLIENT_SECRET') is-invalid @enderror" id="exampleInputCLIENT_SECRET" placeholder="PaylPal Client Secret" name="PAYPAL_CLIENT_SECRET" value="{{$paypalDetail['PAYPAL_CLIENT_SECRET'] ?? ''}}">
                        @error('PAYPAL_CLIENT_SECRET')
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
                        <label for="card_type">PayPal Mode</label>
                        <select class="js-example-basic-single select2-hidden-accessible @error('PAYPAL_MODE') is-invalid @enderror" name="PAYPAL_MODE" style="width:100%" data-select2-id="1" tabindex="-1" aria-hidden="true" id="card_type">
                            <option value="sandbox" {{ (isset($paypalDetail['PAYPAL_MODE']) && $paypalDetail['PAYPAL_MODE'] == 'sandbox') ? 'selected' : ''}}>sandbox</option>
                            <option value="live"{{ (isset($paypalDetail['PAYPAL_MODE']) && $paypalDetail['PAYPAL_MODE'] == 'live')  ? 'selected' : ''}}>live</option>
                        </select>
                        @error('PAYPAL_MODE')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $type }}</strong>
                            </span>
                        @enderror    
                    </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2">Update</button>
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
    $("#paypal-information").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            PAYPAL_CLIENT_ID: {
              required: true,
              noSpace: true,
              minlength: 3,
            },
            PAYPAL_CLIENT_SECRET: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            PAYPAL_MODE: {
                required: true,
            },
        },
        messages: {
            PAYPAL_CLIENT_ID: {
              required: "Client Id is required",
              minlength: "Client Id must consist of at least 3 characters"
            },
            PAYPAL_CLIENT_SECRET: {
              required: "Client secret is required",
              minlength: "Client secret must consist of at least 3 characters"
            },
            PAYPAL_MODE: {
              required: "Please select paypal mode",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop