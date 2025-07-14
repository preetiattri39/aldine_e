@extends('admin.layouts.app')

    
@section('title', 'Announcements')
    
  
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">Announcements</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Announcements</li>
    </ol>
    </nav>
</div>
@endsection


@section('content')
<div class="row">
  <div class="col-lg-8 offset-lg-2 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Send Announcement to Subscribers</h4>
        <form action="{{ route('admin.announcements.send') }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea class="summernote" name="message" rows="5" class="form-control" required></textarea>
          </div>
          <button type="submit" class="btn btn-success">Send Announcement</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')

 <script type="text/javascript">

        $(document).ready(function() {

          $('.summernote').summernote();

        });

    </script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const button = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function () {
      // Disable the button to prevent multiple clicks
      button.disabled = true;
      button.innerHTML = 'Sending...';

    });
  });
</script>

@stop