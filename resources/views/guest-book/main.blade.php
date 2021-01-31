<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Guest book</title>

    <script async src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Guest book</h1>

    @if (count($messages) > 0)
        @foreach ($messages as $message)
            @include('guest-book.message')
        @endforeach
    @else
        No messages. You will be first.
    @endif

    @include('guest-book.form')

</div>

</body>
</html>
