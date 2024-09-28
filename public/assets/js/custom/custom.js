// for automatice slug create
function processSlug(value, slug_id){
    value = value.trim();
    let data =  value.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
    $(slug_id).val('');
    $(slug_id).val(data);
}

const editorFontList = [
    "ABeeZee",
    "Abel",
    "Abhaya Libre",
    "Abril Fatface",
    "Aclonica",
    "Acme",
    "Actor",
    "Adamina",
    "Advent Pro",
    "Aguafina Script",
    "AkayaKanadaka",
    "AkayaTelivigala",
    "Akronim",
    "Aladin",
    "Alata",
    "Alatsi",
    "Aldrich",
    "Alef",
    "Alegreya",
    "Alegreya Sans",
    "Alegreya Sans SC",
    "Alegreya SC",
    "Aleo",
    "Alex Brush",
    "Alfa Slab One",
    "Alice",
    "Alike",
    "Alike Angular",
    "Allan",
    "Allerta",
    "Allerta Stencil",
    "Allura",
    "Almarai",
    "Almendra",
    "Almendra Display",
    "Almendra SC",
    "Amarante",
    "Amaranth",
    "Amatic SC",
    "Amethysta",
    "Amiko",
    "Amiri",
    "Amita",
    "Anaheim",
    "Andada",
    "Andada Pro",
    "Andale Mono",
    "Andika",
    "Andika+New+Basic",
    "Angkor",
    "Anonymous Pro",
    "Antic",
    "Antic Didone",
    "Antic Slab",
    "Anton",
    "Antonio",
    "Arapey",
    "Arbutus",
    "Arbutus Slab",
    "Architects Daughter",
    "Archivo",
    "Archivo Black",
    "Archivo Narrow",
    "Aref Ruqaa",
    "Arial",
    "Arima Madurai",
    "ASAP Condensed",
    "Assistant",
    "Barlow",
    "BioRhyme",
    "Bitter",
    "Brawler",
    "Caladea",
    "Cardo",
    "Carme",
    "Chivo",
    "Comic Sans MS",
    "Cormorant",
    "Eczar",
    "Encode Sans",
    "Encode Sans Semi Condensed",
    "Enriqueta",
    "Epilogue",
    "Fira Sans",
    "Frank Ruhl Libre",
    "Gelasio",
    "Georgia",
    "Hahmlet",
    "Headland One",
    "Impact",
    "Inconsolata",
    "Inknut Antiqua",
    "Inter",
    "JetBrains Mono",
    "Karla",
    "Lato",
    "Libre Baskerville",
    "Libre Franklin",
    "Lora",
    "Manrope",
    "Merriweather",
    "Montserrat",
    "Neuton",
    "Nunito",
    "Nunito Sans",
    "Old Standard TT",
    "Open Sans",
    "Oswald",
    "Oxygen",
    "Playfair Display",
    "Poppins",
    "Proza Libre",
    "PT Sans",
    "PT Serif",
    "Raleway",
    "Roboto",
    "Roboto Slab",
    "Rokkitt",
    "Rubik",
    "Sora",
    "Source Sans Pro",
    "Source Serif Pro",
    "Space Grotesk",
    "Space Mono",
    "Spectral",
    "Symbol",
    "Tahoma",
    "Times New Roman",
    "Verdana",
    "Work Sans"

];

function dataTable(table_id='#kt_table_users', searchbox_id='[data-kt-user-table-filter="search"]',emptyMessage="No data found", column_fixed=null, info=null){
    var KTDatatablesExample = function () {
        // Shared variables
        var table;
        var datatable;

        let lang;
        if (info != null) {
            lang = {
                "emptyTable": emptyMessage,
                "info": info
            };
        } else {
            lang = {
                "emptyTable": emptyMessage,
            };
        }
        
        // Private functions
        var initDatatable = function () {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                const dateRow = row.querySelectorAll('td');
                const realDate = moment(dateRow[3].innerHTML, "DD MMM YYYY, LT").format(); // select date from 4th column in table
                dateRow[3].setAttribute('data-order', realDate);
            });

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            if(column_fixed){
                datatable = $(table).DataTable({
                    destroy: true,
                    searching: true,
                    "info": true,
                    'order': [],
                    "language": lang,
                    'pageLength': 10,
                    'stateSave':true,
                    fixedColumns: column_fixed
                });
            }else{
                datatable = $(table).DataTable({
                    destroy: true,
                    searching: true,
                    "info": true,
                    'order': [],
                    "language": lang,
                    'pageLength': 10,
                    'stateSave':true
                });
            }
            
        }

        // Hook export buttons
        var exportButtons = (button_selector) => {
            const documentTitle = 'Customer Orders Report';
            var buttons = new $.fn.dataTable.Buttons(table, {
                buttons: [
                    {
                        extend: 'copyHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'excelHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'csvHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'pdfHtml5',
                        title: documentTitle
                    }
                ]
            }).container().appendTo($(button_selector));

            // Hook dropdown menu click event to datatable export buttons
            const exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
            exportButtons.forEach(exportButton => {
                exportButton.addEventListener('click', e => {
                    e.preventDefault();

                    // Get clicked export value
                    const exportValue = e.target.getAttribute('data-kt-export');
                    const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                    // Trigger click event on hidden datatable export buttons
                    target.click();
                });
            });
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = (searchbox_id) => {
            const filterSearch = document.querySelector(searchbox_id);
            filterSearch.addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
        }

        // Public methods
        return {
            init: function (table_id, searchbox_id, button_selector = null) {
                table = document.querySelector(table_id);

                if ( !table ) {
                    return;
                }

                initDatatable();
                exportButtons(button_selector);
                handleSearchDatatable(searchbox_id);
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function () {
        KTDatatablesExample.init(table_id, searchbox_id);
    });
}

function errorShow(response){
    $.each(response.responseJSON.errors, function (key, message) {
        $("#" + key).addClass('is-invalid');
        $("#" + "error_" + key).html(message[0]);
    });
}

function summernoteSubmitCodeView(form){
    let summernote = form.find('.summernote');
    let summernote1 = form.find('.summernote1');
    let summernote2 = form.find('.summernote2');
    let summernote3 = form.find('.summernote3');
    let summernote4 = form.find('.summernote4');
    let summernote5 = form.find('.summernote5');
    let summernote6 = form.find('.summernote6');
    let summernote7 = form.find('.summernote7');
    let summernote8 = form.find('.summernote8');
    let summernote9 = form.find('.summernote9');
    let summernote10 = form.find('.summernote10');
    let summernote11 = form.find('.summernote11');
    let summernote12 = form.find('.summernote12');
    let summernote13 = form.find('.summernote13');
    let summernote14 = form.find('.summernote14');
    let summernote15 = form.find('.summernote15');
    let summernote16 = form.find('.summernote16');
    let summernote17 = form.find('.summernote17');
    if (summernote.length) {
        if (summernote.summernote('codeview.isActivated')) {
            summernote.summernote('codeview.deactivate');
        }
    }
    if (summernote1.length) {
        if (summernote1.summernote('codeview.isActivated')) {
            summernote1.summernote('codeview.deactivate');
        }
    }
    if (summernote2.length) {
        if (summernote2.summernote('codeview.isActivated')) {
            summernote2.summernote('codeview.deactivate');
        }
    }
    if (summernote3.length) {
        if (summernote3.summernote('codeview.isActivated')) {
            summernote3.summernote('codeview.deactivate');
        }
    }
    if (summernote4.length) {
        if (summernote4.summernote('codeview.isActivated')) {
            summernote4.summernote('codeview.deactivate');
        }
    }
    if (summernote5.length) {
        if (summernote5.summernote('codeview.isActivated')) {
            summernote5.summernote('codeview.deactivate');
        }
    }
    if (summernote6.length) {
        if (summernote6.summernote('codeview.isActivated')) {
            summernote6.summernote('codeview.deactivate');
        }
    }
    if (summernote7.length) {
        if (summernote7.summernote('codeview.isActivated')) {
            summernote7.summernote('codeview.deactivate');
        }
    }
    if (summernote8.length) {
        if (summernote8.summernote('codeview.isActivated')) {
            summernote8.summernote('codeview.deactivate');
        }
    }
    if (summernote9.length) {
        if (summernote9.summernote('codeview.isActivated')) {
            summernote9.summernote('codeview.deactivate');
        }
    }
    if (summernote10.length) {
        if (summernote10.summernote('codeview.isActivated')) {
            summernote10.summernote('codeview.deactivate');
        }
    }
    if (summernote11.length) {
        if (summernote11.summernote('codeview.isActivated')) {
            summernote11.summernote('codeview.deactivate');
        }
    }
    if (summernote12.length) {
        if (summernote12.summernote('codeview.isActivated')) {
            summernote12.summernote('codeview.deactivate');
        }
    }
    if (summernote13.length) {
        if (summernote13.summernote('codeview.isActivated')) {
            summernote13.summernote('codeview.deactivate');
        }
    }
    if (summernote14.length) {
        if (summernote14.summernote('codeview.isActivated')) {
            summernote14.summernote('codeview.deactivate');
        }
    }
    if (summernote15.length) {
        if (summernote15.summernote('codeview.isActivated')) {
            summernote15.summernote('codeview.deactivate');
        }
    }
    if (summernote16.length) {
        if (summernote16.summernote('codeview.isActivated')) {
            summernote16.summernote('codeview.deactivate');
        }
    }
    if (summernote17.length) {
        if (summernote17.summernote('codeview.isActivated')) {
            summernote17.summernote('codeview.deactivate');
        }
    }
}

$(document).ready(function(){
    $(document).on('change','#event_from_sidebar', function(event){
        let id = $(this).val();
        let url = $('#set_event_url').val();
        let data = {
            _token: $('meta[name="_token"]').attr('content'),
            id: id
        }

        $.post(url, data, function(res){
            if(res.msg == 'success'){
                if(location.search){
                    let full_url = location.href;
                    full_url = full_url.split('?');
                    location.href = full_url[0];
                }else{
                    location.reload();
                }
            }
        });
    });
    $(document).on('click', '#kt_sign_in_submit', function(){
        $(this).find('.indicator-label').hide();
        $(this).find('.indicator-progress').show();
    });

    $(document).on('submit', '#kt_sign_in_form', function(){
        $(this).find('#kt_sign_in_submit').attr('disabled', true);
    });

    $('#zmmtg-root').addClass('d-none');
});
