<div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1" id="kt_app_header_wrapper">
    <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
        data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
        data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
        data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
        data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
        <div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
            <div  class="menu-item here show menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
                <a href="{{ route('logout') }}" class="menu-link">
                    <span class="menu-title">{{__('Sign Out')}}</span>
                </a>
            </div>
        </div>
    </div>
</div>