@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title"> Dashboard </h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
    </nav>
</div>
@endsection
@section('content')
<div>
    <div class="row">
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('admin.user.list')}}">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{$responseData['total_registered_user'] ?? 0}}</h3>
                        </div>
                        </div>
                        <div class="col-3">
                        <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Registered Users</h6>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
        <div class="card">
            <a href="{{route('admin.user.list',['status' => 1])}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{$responseData['total_active_user'] ?? 0}}</h3>
                        </div>
                        </div>
                        <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Active Users</h6>
                </div>
            </a>
        </div>
        </div>
        <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
        <div class="card">
                <a href="#">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{$responseData['total_active_post'] ?? 0}}</h3>
                            </div>
                            </div>
                            <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Posts Created</h6>
                    </div>
                </a>
            </div>
        </div>
        {{--<div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('admin.transaction.list')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{$responseData['total_active_post'] ?? 0}}</h3>
                            </div>
                            </div>
                            <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Revenue Earned</h6>
                    </div>
                </a>
            </div>
        </div> --}}
       {{--<div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('admin.category.list')}}">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">{{$responseData['total_category'] ?? 0}}</h3>
                        </div>
                        </div>
                        <div class="col-3">
                        <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Categories </h6>
                    </div>
                </a>
            </div>
        </div>--}}
        {{-- <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <a href="{{route('admin.card.list')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">{{$responseData['total_cards'] ?? 0}}</h3>
                            </div>
                            </div>
                            <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total Scratch Cards on the Platform  </h6>
                    </div>
                </a>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <h4 class="card-title">User chart</h4>
                <canvas id="userStatusChart" width="300" height="300"></canvas>
            </div>
            </div>
        </div>
       <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Post Creation Chart</h4>
            <canvas id="postChart" style="height:250px"></canvas>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('admin/js/dashboard.js')}}"></script>
<script src="{{asset('admin/js/chart.js')}}"></script>
<script>
  
    const ctx = document.getElementById('userStatusChart').getContext('2d');

    const data = {
        labels: ['Active Users', 'Inactive Users'],
        datasets: [{
            label: 'User Status',
            data: [{{ $responseData['total_active_user'] }}, {{ $responseData['total_inactive_user'] ?? 0 }}],
            backgroundColor: [
                'rgba(54, 162, 235, 0.7)',  // Blue - active
                'rgba(255, 99, 132, 0.7)'   // Red - inactive
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    };

    new Chart(ctx, config);

  </script>
<script>
    const postCtx = document.getElementById('postChart').getContext('2d');

    const postData = {
       labels: {!! json_encode($responseData['months']) !!},
        datasets: [{
            label: 'Posts Created',
            data: {!! json_encode($responseData['post_counts']) !!},

            fill: false,
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.3,
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
        }]
    };

    const postConfig = {
        type: 'line',
        data: postData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    };

    new Chart(postCtx, postConfig);
</script>
@endsection