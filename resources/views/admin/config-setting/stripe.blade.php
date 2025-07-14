@extends('admin.layouts.app')
@section('title', 'Stripe')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Config Setting</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">STRIPE Information</li>
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
            <h4 class="card-title">STRIPE Information</h4>
             
            <form class="forms-sample" id="stripe-information" action="{{route('admin.config-setting.stripe')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputFromName">Stripe Key</label>
                        <input type="text" class="form-control @error('STRIPE_KEY') is-invalid @enderror" id="exampleInputFromName" placeholder="Stripe Key" name = "STRIPE_KEY" value="{{$stripeDetail['STRIPE_KEY'] ?? ''}}">
                        @error('STRIPE_KEY')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputSTRIPE_SECRET">Stripe Secret</label>
                        <input type="text" class="form-control @error('STRIPE_SECRET') is-invalid @enderror" id="exampleInputSTRIPE_SECRET" placeholder="Stripe Secret" name="STRIPE_SECRET" value="{{$stripeDetail['STRIPE_SECRET'] ?? ''}}">
                        @error('STRIPE_SECRET')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
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
    $("#stripe-information").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            STRIPE_KEY: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
            STRIPE_SECRET: {
                required: true,
                noSpace: true,
                minlength: 3,
            },
        },
        messages: {
            STRIPE_KEY: {
                required: "Stripe key is required",
                minlength: "Stripe key must consist of at least 3 characters"
            },
            STRIPE_SECRET: {
                required: "Stripe secret is required",
                minlength: "Stripe secret must consist of at least 3 characters"
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop