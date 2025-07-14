@extends('admin.layouts.app')
@section('title', 'View Contact Message')
@section('breadcrum')
<div class="page-header">
    <h3 class="page-title">View Contact Message</h3>
    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contact.list') }}">Contact Messages</a></li>
        <li class="breadcrumb-item active" aria-current="page">View</li>
    </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Message Details</h4>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th>Subject:</th>
                            <td>{{ $contact->subject ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Message:</th>
                            <td>{{ $contact->message }}</td>
                        </tr>
                    </table>
                </div>

                <hr>

                <h5>Reply to User</h5>
                <form action="{{ route('admin.contact.edit', ['id' => $contact->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="reply">Your Message</label>
                        <textarea name="reply" class="form-control" rows="6" required>{{ old('reply', $contact->reply) }}
                        </textarea>
                    </div>
                    @if ($contact->is_replied == 0)
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                    @endif
                    <a href="{{ route('admin.contact.list') }}" class="btn btn-light">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
