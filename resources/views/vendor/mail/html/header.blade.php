@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Qxgpt')
                <img width="100" src="{{ asset('wp-content/uploads/2023/05/qxgpt.png') }}" alt="Qxgpt Logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
