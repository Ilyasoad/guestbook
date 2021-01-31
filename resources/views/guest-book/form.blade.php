{{--<x-form :action="route('guestbook.store')" v-on:submit="checkForm">--}}
{{--    @bind($message)--}}
{{--    <x-form-input name="nick" :label="trans('forms.nick')" />--}}
{{--    <x-form-textarea name="text" :label="trans('forms.text')" />--}}
{{--    <x-form-submit />--}}
{{--    @endbind--}}
{{--</x-form>--}}

<form method="POST" action="/profile">
    @csrf


</form>
