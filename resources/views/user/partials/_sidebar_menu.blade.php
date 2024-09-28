<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
    <div class="menu-item menu-accordion">
        <a class="menu-link @if (request()->is('user/tickets/*') || request()->is('user/tickets')) active @endif" href="{{ url('/user/tickets') }}">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <img src="{{asset('/assets/media/svg/message.svg')}}" alt="">
                </span>
            </span>
            <span class="menu-title">{{__('Tickets')}}</span>
        </a>
    </div>
</div>
