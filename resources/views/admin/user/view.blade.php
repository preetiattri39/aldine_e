@extends('admin.layouts.app')
@section('title', 'View User')
@section('breadcrum')
    <div class="page-header">
        <h3 class="page-title">Users</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.user.list') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">View User</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <div>
        <h4 class="user-title">View User</h4>
        <div class="card">
            <div class="card-body">
                <form class="forms-sample">
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3">
                                <div class="view-user-details">
                                    {{-- <h5 class="text-center mb-2">Profile Image</h5> --}}
                                    <div class="text-center">
                                        <img class="user-image"
                                            @if (isset($user->profile_pic) && !is_null($user->profile_pic)) 
                                              src="{{$user->profile_pic }}"
                                            @else
                                              src="{{ asset('images/user_dummy.png') }}" 
                                            @endif
                                            alt="User profile picture">
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-8">
                            
                            
                                <div class="response-data ml-4">
                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Name :</span> 
                                      <span class="text-muted">{{ $user->full_name }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Email :</span> 
                                      <span class="text-muted">{{ $user->email ?? '' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Gender :</span> 
                                      <span class="text-muted">{{ $user->gender ? $user->gender ?? 'N/A' : 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Date Of Birth:</span> 
                                      <span class="text-muted">{{ $user->birthday ? $user->birthday ? strtoupper($user->birthday): 'N/A' : 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Phone Number :</span> 
                                      <span class="text-muted"  class="userPhone">{{ $user->phone_number ? $user->phone_number ?? 'N/A' : 'N/A' }}</span>
                                    </h6>
                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Country Short Code :</span> 
                                      <span class="text-muted">{{ $user->country_short_code ? $user->country_short_code ? strtoupper($user->country_short_code): 'N/A' : 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Address :</span> 
                                      <span class="text-muted">{{ $user->address ? $user->address ?? 'N/A' : 'N/A' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Pin Code :</span>
                                       <span class="text-muted" >{{ $user->zip_code ? $user->zip_code ?? 'N/A' : 'N/A  ' }}</span>
                                    </h6>

                                    <h6 class="f-14 mb-1">
                                      <span class="semi-bold qury">Date &amp; time :</span> 
                                      <span class="text-muted" id="userDateTime">{{ convertDate($user->created_at) }}</span>
                                    </h6>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        

       
    </div>
@endsection
