@if(count(config('panel.available_languages', [])) > 1)
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="flag-icon flag-icon-{{ app()->getLocale() ? app()->getLocale() : 'us'}} mt-1" title="{{ app()->getLocale() ? app()->getLocale() : 'us'}}"></i>
        <span class="font-weight-medium ml-1 mr-1 d-none d-md-inline-block">{{ strtoupper(app()->getLocale()) }}</span>
    </a>
    <div class="dropdown-menu" aria-labelledby="languageDropdown">
        @foreach(config('panel.available_languages') as $langLocale => $langName)
        <a href="{{ url()->current() }}?change_language={{ $langLocale }}" class="dropdown-item py-2"><i
                class="flag-icon flag-icon-{{ $langLocale ? $langLocale : 'us'}}" title="{{ $langLocale ? $langLocale : 'us'}}" id="{{ $langLocale ? $langLocale : 'us'}}"></i>
            <span class="ml-1"> {{ strtoupper($langLocale) }} ({{ $langName }}) </span></a>
        @endforeach
    </div>
</li>
@endif
