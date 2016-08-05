<div class="lang-opt ">
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
            <a href="/lang/{{ session('appLanguage','en') }}"><img border="0" alt="" src="/images/flags/{{ session('appLanguage','en') }}.png" width="50" height="30"></a>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            {{--<li><a href="/lang/ar"><img border="0" alt="" src="/images/flags/ar.png" width="50" height="30"></a></li>--}}
            <li ng-hide="{{ (session('appLanguage') == 'id') }}"><a href="/lang/id"><img alt="" src="/images/flags/id.png"> {!! trans('messages.bahasa_indonesia') !!}</a></li>
            {{--<li><a href="/lang/ms"><img border="0" alt="" src="/images/flags/ms.png" width="50" height="30"></a></li>--}}
            <li ng-hide="{{ (session('appLanguage') == 'my') }}"><a href="/lang/my"><img alt="" src="/images/flags/my.png"> {!! trans('messages.burmese') !!}</a></li>
            {{--<li><a href="/lang/es"><img border="0" alt="" src="/images/flags/es.png" width="50" height="30"></a></li>--}}
            <li ng-hide="{{ (session('appLanguage') == 'en') }}"><a href="/lang/en"><img alt="" src="/images/flags/en.png"> {!! trans('messages.english_uk') !!}</a></li>
            <li ng-hide="{{ (session('appLanguage') == 'pt') }}"><a href="/lang/pt"><img alt="" src="/images/flags/pt.png"> {!! trans('messages.portuguese') !!}</a></li>
            <li ng-hide="{{ (session('appLanguage') == 'th') }}"><a href="/lang/th"><img alt="" src="/images/flags/th.png"> {!! trans('messages.thai') !!}</a></li>
            <li ng-hide="{{ (session('appLanguage') == 'vi') }}"><a href="/lang/vi"><img alt="" src="/images/flags/vi.png"> {!! trans('messages.vietnamese') !!}</a></li>
        </ul>
    </div>
</div>