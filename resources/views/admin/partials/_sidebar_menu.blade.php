<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
    <div class="menu-item menu-accordion">
        <a class="menu-link @if (request()->is('admin/ticket-categories/*') || request()->is('admin/ticket-categories')) active @endif" href="{{ url('/admin/ticket-categories') }}">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <img src="{{asset('/assets/media/svg/voting.svg')}}" alt="">
                </span>
            </span>
            <span class="menu-title">{{__('Tickets Category')}}</span>
        </a>
    </div>
    <div class="menu-item menu-accordion">
        <a class="menu-link @if (request()->is('admin/tickets/*') || request()->is('admin/tickets')) active @endif" href="{{ url('/admin/tickets') }}">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-2">
                    <img src="{{asset('/assets/media/svg/message.svg')}}" alt="">
                </span>
            </span>
            <span class="menu-title">{{__('Tickets')}}</span>
        </a>
    </div>
</div>
