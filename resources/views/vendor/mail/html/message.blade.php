<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
    {{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
    {{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
{{ __('Qxgpt is a trademark of Qxgpt Inc with the registered address at') }} <a href="" target="_blank" rel="noopener noreferrer">127, Grinzinger Street, 1130 Vienna, Austria.</a>
<br><br>
© {{ date('Y') }} {{ config('app.name') }} Inc. {{ __('All rights reserved.') }}
<br><br>
<a href="https://qxgpt.com" target="_blank" rel="noopener noreferrer">www.qxgpt.com</a> | <a href="mailto:info@qxgpt.com">info@qxgpt.com></a>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
