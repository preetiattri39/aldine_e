@extends('admin.layouts.app')
@section('title', 'Question Response')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Question Response List</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.user.list')}}">Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">Question Response</li>
    </ol>
    </nav>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
         {{-- <x-alert /> --}}
         {{-- <div class="flash-message"></div> --}}
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <h4 class="card-title">Question Response List</h4>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Id </th>
                  <th> Email </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($response as $data)
                  <tr>
                    <td> {{$data->uuid}} </td>
                    <td>{{ convertDate($data->created_at,'d M,Y') }}</td>
                    <td> 
                      <span class="menu-icon">
                        <span class="menu-icon">
                            <a href="{{route('admin.user.response.list',['user_id' => $data->user_id,'id' => $data->id])}}" title="View" class="text-primary"><i class="mdi mdi-eye"></i></a>
                      </span> 
                    </td>
                  </tr>
                @empty
                    <tr>
                      <td colspan="6" class="no-record"> <center>No record found </center></td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
            <div class="custom_pagination">
             {{ $response->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
