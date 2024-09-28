<!--begin::Javascript-->
<script>
    var hostUrl = "assets/";
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
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
<!--end::Custom Javascript-->
<!--end::Javascript-->

<script src="{{ asset('assets/js/custom/custom.js') }}"></script>

@php echo Toastr::message(); @endphp

<script>
    function sendFile(files, editor = '#summernote') {
            var url = "{{url('/')}}";
            var formData = new FormData();
            $.each(files, function (i, v) {
                formData.append("files[" + i + "]", v);
            })
            formData.append("_token","{{csrf_token()}}");

            $.ajax({
                url: url + '/summer-note-file-upload',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function (response) {
                    var $summernote = $(editor);
                    $.each(response, function (i, v) {
                        $summernote.summernote('insertImage', v);
                    })
                },
                error: function (data) {
                    if (data.status === 404) {
                        toastr.error("What you are looking is not found", 'Opps!');
                        return;
                    } else if (data.status === 500) {
                        toastr.error('Something went wrong.', 'Opps');
                        return;
                    } else if (data.status === 200) {
                        toastr.error('Something is not right', 'Error');
                        return;
                    }
                    let jsonValue = $.parseJSON(data.responseText);
                    let errors = jsonValue.errors;
                    if (errors) {
                        let i = 0;
                        $.each(errors, function (key, value) {
                            let first_item = Object.keys(errors)[i];
                            let error_el_id = $('#' + first_item);
                            if (error_el_id.length > 0) {
                                error_el_id.parsley().addError('ajax', {
                                    message: value,
                                    updateClass: true
                                });
                            }
                            toastr.error(value, 'Validation Error');
                            i++;
                        });
                    } else {
                        toastr.error(jsonValue.message, 'Opps!');
                    }

                }
            });
    }

        function senytiseBuilder(form){
            form = JSON.parse(form);
            form.forEach(element => {
                
                if([null, undefined, 'undefined', 'null'].includes(element.label)){
                    element.label = ' ';
                }
            });
            return JSON.stringify(form);
        }
</script>

@stack('scripts')
