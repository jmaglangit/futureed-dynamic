<div class="lang-opt ">
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
            <a href="/lang/{{ session('appLanguage','en') }}"><img border="0" alt="" src="/images/flags/{{ session('appLanguage','en') }}.png" width="50" height="30"></a>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            @foreach(config('futureed.language_options' ) as $lang)
             <li ng-hide="{!! session('appLanguage','en') == $lang !!}"><a href="{!! "/lang/" . $lang !!}"><img alt="" src="{!! "/images/flags/" . $lang . ".png" !!}"> {!! trans('messages.' . $lang) !!}</a></li>
            @endforeach
        </ul>
    </div>
</div>