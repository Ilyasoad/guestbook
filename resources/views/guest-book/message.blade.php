<div class="row">
    <h4> {{ $message->getNick() }}</h4>
    <div>{{ $message->getCreatedAt()->format('d/m/Y') }}</div>
    <div>{{ $message->getText() }}</div>
</div>
