@extends('admin.layouts.app')
@section('title', 'Help Desk')
@section('styles')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
@endsection
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Help Desk</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item "><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Help Desk</li>
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
        <!-- BEGIN TICKET -->
        <div class="grid support-content">
            <div class="grid-body help-desk">
              <div class="btn-group">
              
              <a href="{{route('admin.helpDesk.list',['type' => 'open'])}}">
                <button type="button" class="btn ticket btn-default {{ $type == "open" ? "active" : ''}}">{{$openCount  ?? 0}} Open</button></a>
              <a href="{{route('admin.helpDesk.list',['type' => 'close'])}}"><button type="button" class="btn ticket btn-default {{ $type == "close" ? "active" : ''}}">{{$closeCount ?? 0}} Closed</button></a>
            </div>
              
            <div class="padding"></div>
              
            <div class="row">
              <!-- BEGIN TICKET CONTENT -->
              <div class="col-md-12">
                <ul class="list-group fa-padding">
                  @forelse ($data as $ticket)
                    <li class="list-group-item ticket-list" >
                      <div class="media">
                        <div class="media-body">
                          <a href="{{route('admin.helpDesk.response',['id' => $ticket->id])}}">
                              <strong>{{$ticket->title}}</strong>
                          </a>
                            <span class="number pull-right d-flex">
                              @if($type == "open")
                              <span class="label label-danger">
                                {{-- @switch($ticket->priority)
                                    @case('Low')
                                        <button type="button" class="btn btn-primary btn-rounded btn-sm">Low</button>
                                      @break
                                    @case('Medium')
                                        <button type="button" class="btn btn-info btn-rounded btn-sm">Medium</button>
                                      @break
                                    @case('High')
                                        <button type="button" class="btn btn-warning btn-rounded btn-sm">High</button>
                                      @break
                                    @default
                                    <button type="button" class="btn btn-primary btn-rounded btn-sm">Low</button>
                                @endswitch --}}
                                
                                  @switch($ticket->status)
                                      @case('Done')
                                          <button type="button" class="btn default-btn btn-rounded btn-sm">Done</button>
                                        @break
                                      @case('In Progress')
                                          <button type="button" class="btn btn-info btn-rounded btn-sm">In Progress</button>
                                        @break
                                      @case('Pending')
                                        <button type="button" class="btn btn-danger btn-rounded btn-sm">Pending</button>
                                        @break
                                      @default
                                        <button type="button" class="btn btn-danger btn-rounded btn-sm">Pending</button>
                                  @endswitch
                              </span> 
                              <a href="#" title="Mark as Done" class="text-success markAsComplete" data-id="{{$ticket->id}}">
                                Close <i class="fa-solid fa-delete-left"></i>
                              </a>
                            @endif
                          # {{$ticket->ticket_id}}
                        </span>
                          <p class="info">Opened by  <a href="{{route('admin.helpDesk.response',['id' => $ticket->id])}}">{{userNameById($ticket->user_id)}}</a>  
                            @if($ticket->response()->where('user_id',$ticket->user_id)->get()->last())
                            {{replyDiffernceCalculate($ticket->response()->where('user_id',$ticket->user_id)->get()->last()->created_at)}}  ago 
                            @endif
                            <i class="fa fa-comments"></i>  
                            <a href="{{route('admin.helpDesk.response',['id' => $ticket->id])}}">{{$ticket->response()->count()}} comments</a></p>
                        </div>
                      </div>
                    </li>
                   
                  @empty
                      <li class="list-group-item">
                          <strong class="no-record"><center>No record Found</center></strong> 
                      </li>
                  @endforelse
                  <!-- BEGIN DETAIL TICKET -->
                  <div class="modal fade" id="issue" tabindex="-1" role="dialog" aria-labelledby="issue" aria-hidden="true">
                    <div class="modal-wrapper">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-blue">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title"><i class="fa fa-cog"></i> Add drag and drop config import closes</h4>
                          </div>
                          <form action="#" method="post">
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-2">
                                  <img src="assets/img/user/avatar01.png" class="img-circle" alt="" width="50">
                                </div>
                                <div class="col-md-10">
                                  <p>Issue <strong>#13698</strong> opened by <a href="#">jqilliams</a> 5 hours ago</p>
                                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                  <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                              </div>
                              <div class="row support-content-comment">
                                <div class="col-md-2">
                                  <img src="assets/img/user/avatar02.png" class="img-circle" alt="" width="50">
                                </div>
                                <div class="col-md-10">
                                  <p>Posted by <a href="#">ehernandez</a> on 16/06/2014 at 14:12</p>
                                  <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                  <a href="#"><span class="fa fa-reply"></span> &nbsp;Post a reply</a>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- END DETAIL TICKET -->
              </div>
              <!-- END TICKET CONTENT -->
            </div>
          </div>
        </div>
        <!-- END TICKET -->
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $('.markAsComplete').on('click', function() {
    var id = $(this).data('id');
  
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to mark as complete?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2ea57c",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, mark as Complete"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/helpDesk/changeStatus",
                type: "GET",
                data: { id: id},
                success: function(response) {
                    if (response.status == "success") {
                      toastr.success(response.message);
                         
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    console.log('error', error);
                }
            });
        } 
    });
  });
</script>
@stop