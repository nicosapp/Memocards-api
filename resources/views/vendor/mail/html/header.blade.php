<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
            <img src="{{ asset('images/logo-default.png') }}" class="logo" alt="Default Logo">
            <p>{{ config('app.name')}}</p>
            @else
            {{ $slot }}
            @endif
        </a>
    </td>
</tr>