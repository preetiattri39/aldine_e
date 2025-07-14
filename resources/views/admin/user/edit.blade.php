@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.6.1/build/css/intlTelInput.css">
@endsection
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title"> Users</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>  
        <li class="breadcrumb-item"><a href="{{route('admin.user.list')}}">Users</a></li>
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
            <h4 class="card-title">Edit User</h4>
             
            <form class="forms-sample" id="editPatientForm" action="{{route('admin.user.edit',['id' => $user->id])}}" method="POST" enctype="multipart/form-data">
              @csrf
              
              <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputFirstName">Profile</label>
                        <img 
                            class=" img-lg  rounded-circle"
                            @if(isset($user->profile_pic) && !is_null($user->profile_pic))
                                src="{{$user->profile_pic}}"
                            @else
                                src="{{ asset('images/user_dummy.png') }}"
                            @endif
                            alt="User profile picture">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="exampleInputFirstName">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleInputFirstName" placeholder="First Name" name="first_name" value="{{$user->first_name ?? ''}}">
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputLastName">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleInputLastName" placeholder="Last Name" name="last_name" value="{{$user->last_name ?? ''}}">
                        @error('last_name')
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
                        <label for="exampleInputEmail">Email address</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email" name="email" value="{{$user->email ?? ''}}" readonly>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputGender">Gender</label>
                        <select name="gender" id="exampleInputGender" class="form-control  @error('gender') is-invalid @enderror" >
                            <option value="">Select Gender</option>
                            <option value="male" {{$user->gender ? (($user->gender == 'male' ) ? 'selected': '') : ''}}>Male</option>
                            <option value="female" {{$user->gender ? (($user->gender == 'female' ) ? 'selected': '') : ''}}>Female</option>
                            <option value="other" {{$user->gender ? (($user->gender == 'other' ) ? 'selected': '') : ''}}>Other</option>
                        </select>
                        @error('gender')
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
                        <label for="dob">Date Of Birth</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"  name = "birthday" value = "{{$user->birthday ? ($user->birthday ? ($user->birthday) : '') : ''}}" max="{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}">
                        @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6 select_country_code">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone" placeholder="Phone Number" name="phone_number" value="{{$user->phone_number ? ($user->phone_number ?? '') : ''}}">
                        <input type="hidden" name="country_code" value="">
                        <input type="hidden" name="country_short_code" value="{{$user->country_short_code ? ($user->country_short_code ?? 'us') : 'us'}}">
                        @error('phone_number')
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
                        <label for="address">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Address" name = "address" value = {{$user->address ? ($user->address ?? '') : ''}}>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="exampleInputPinCode">Pin Code</label>
                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="exampleInputPinCode" placeholder="Pin Code" name="zip_code" value = {{$user->zip_code ?($user->zip_code ?? '') : ''}}>
                        @error('zip_code')
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
                        <label>Profile upload</label>
                          <input type="file" name="profile_pic" class="form-control file-upload-info" placeholder="Upload Image" accept="image/*">
                    </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2" >Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>    
@endsection
@section('scripts')



<script>
$(document).ready(function () {
    // Add custom method to prevent only spaces
    $.validator.addMethod("noOnlySpace", function (value, element) {
        return $.trim(value).length > 0;
    }, "This field cannot be empty or only spaces.");

    // Add custom method to disallow future date
    $.validator.addMethod("noFutureDate", function (value, element) {
        if (!value) return true; // allow empty if not required
        const inputDate = new Date(value);
        const today = new Date();
        today.setHours(0,0,0,0); // ignore time
        return inputDate <= today;
    }, "Birth date cannot be in the future.");

    // Add custom rule for file size
    $.validator.addMethod("filesize", function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param * 1024);
    }, "File is too large.");

    // Initialize form validation
    $("#editPatientForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
                noOnlySpace: true
            },
            email: {
                required: true,
                email: true,
                noOnlySpace: true
            },
            password: {
                required: true,
                minlength: 6,
                noOnlySpace: true
            },
            gender: {
                required: true
            },
            birth_date: {
                date: true,
                noFutureDate: true
            },
            profile_pic: {
                extension: "jpg|jpeg|png",
                filesize: 2048 // KB
            },
            id_proof: {
                extension: "jpg|jpeg|png|pdf",
                filesize: 4096 // KB
            },
            mobile_no: {
                digits: true,
                maxlength: 20
            },
            country_code: {
                maxlength: 10
            }
        },
        messages: {
            profile_pic: {
                extension: "Only JPG, JPEG, PNG files are allowed.",
                filesize: "Profile picture must be less than 2MB."
            },
            id_proof: {
                extension: "Only JPG, JPEG, PNG, or PDF files are allowed.",
                filesize: "ID proof must be less than 4MB."
            }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            const checkForbiddenExt = function (fileInputName) {
                const fileInput = document.getElementsByName(fileInputName)[0];
                if (fileInput && fileInput.files.length > 0) {
                    const ext = fileInput.files[0].name.split('.').pop().toLowerCase();
                    if (ext === "felis") {
                        alert(".felis files are not allowed.");
                        return false;
                    }
                }
                return true;
            };

            if (!checkForbiddenExt("profile_pic") || !checkForbiddenExt("id_proof")) {
                return false;
            }

            form.submit();
        }
    });
});
  </script>
@stop