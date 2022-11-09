<div>
    @if($shown)
        <div class="alert alert-primary alert-dismissible border-0 {{ $styles['bg-color'] }} {{ $styles['text-color'] }}" role="alert">
            {!! $message['message'] !!}
            <button type="button" class="btn-close {{ $styles['text-color'] }}" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>
