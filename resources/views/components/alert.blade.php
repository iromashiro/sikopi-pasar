@props(['type' => 'info', 'message' => null])

<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert" x-data
    x-init="setTimeout(() => $el.remove(), 5000)">
    @if($message)
    {{ $message }}
    @else
    {{ $slot }}
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>