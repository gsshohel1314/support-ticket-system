<script>
    var hostUrl = "assets/";
</script>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/type.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/budget.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/settings.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/team.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/targets.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/files.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/complete.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-project/main.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/new-target.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/new-address.js') }}"></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
<script src="{{ asset('assets/vendors/spectrum-2.0.5/dist/spectrum.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom.js') }}"></script>

@php echo Toastr::message(); @endphp

@stack('scripts')
