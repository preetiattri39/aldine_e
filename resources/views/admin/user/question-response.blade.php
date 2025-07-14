@extends('admin.layouts.app')
@section('title', 'Question Response')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Question Response</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.user.list')}}">Users</a></li>
        <li class="breadcrumb-item"><a href="{{route('admin.user.response.list',['user_id' => $response->user_id])}}">Question Response</a></li>
        <li class="breadcrumb-item active" aria-current="page">Response</li>
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
            <h4 class="card-title">Question Response</h4>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Question </th>
                  <th> Answer </th>
                  {{-- <th> Category Name </th> --}}
                </tr>
              </thead>
              <tbody>
                @forelse (json_decode($response->response) as $data)
                  <tr>
                    <td> {{$data->question}} </td>
                    <td>{{$data->answer  != "" && $data->answer != null?$data->answer :'N/A'}} </td>
                    {{-- <td>{{$data->category_id ? CategoryNameById($data->category_id) : ''}}</td> --}}
                  </tr>
                @empty
                    <tr>
                      <td colspan="6" class="no-record"> <center>No record found </center></td>
                    </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
