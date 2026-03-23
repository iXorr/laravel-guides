@if (session('message'))

<div class="alert alert-info top-0 end-0 alert-dismissible fade show shadow" role="alert">
    {{ session('message') }}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
