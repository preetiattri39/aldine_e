<div>
    @if ($error = session('error'))
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @elseif ($success = session('success'))
        <div class="alert alert-success" role="alert">
            {{ $success }}
        </div>
    @endif
</div>