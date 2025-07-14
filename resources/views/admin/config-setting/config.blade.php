@extends('admin.layouts.app')
@section('title', 'Config')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Config Setting</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">General Information</li>
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
            <h4 class="card-title">General Information</h4>
             
            <form class="forms-sample" id="config-information" action="{{route('admin.config-setting.config')}}" method="POST">
              @csrf
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputCardLimit">Instagarm Link </label>
                        <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="exampleInputCardLimit" placeholder="Instagram Link " name = "instagram" value="{{$configDetail['instagram'] ?? ''}}">
                        @error('instagram')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputQuestionLimit">Reddit Link</label>
                        <input type="text" class="form-control @error('reddit') is-invalid @enderror" id="exampleInputQuestionLimit" placeholder="Reddit Link" name = "reddit"  value="{{$configDetail['reddit'] ?? ''}}">
                        @error('reddit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div> 
              </div>

              <div class="form-group">
               <div class="col-6">
                        <label for="exampleInputQuestionLimit">Tiktok Link</label>
                        <input type="text" class="form-control @error('tiktok') is-invalid @enderror" id="exampleInputQuestionLimit" placeholder="Tiktok Link" name = "tiktok"  value="{{$configDetail['tiktok'] ?? ''}}">
                        @error('reddit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
    $("#config-information").submit(function(e){
        e.preventDefault();
    }).validate({
        rules: {
            instagram: {
                required: true,
            },
            reddit: {
                required: true,
              
            },
            tiktok:{
              required: true,
            
            }
           
        },
        messages: {
            instagram: {
              required: "Instagram link is required"
             
            },
            tiktok: {
              required: "Tiktok link is required"
             
            },
            reddit: {
              required: "Reddit link is required"
             
            }
           
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
  });
  </script>
@stop