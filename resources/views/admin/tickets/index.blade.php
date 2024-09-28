@extends('layouts.layout')

@section('title')
    {{ __('Support Tickets') }}
@endsection

@section('mainContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Support Tickets')}}</h1>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="{{__('Search Support Tickets')}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive py-4">
                        <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('Support Ticket ID')}}</th>
                                    <th>{{__('Subject')}}</th>
                                    <th>{{__('Priority')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        "use strict";

        $(document).ready(function(){
            $(document).on('click', '.reject_ticket', function(event){
                let id = $(this).data('id');
                Swal.fire({
                    text: "{{__('Are you sure you want to reject selected ticket?')}}",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "{{__('Yes, reject!')}}",
                    cancelButtonText: "{{__('No, cancel')}}",
                    customClass: { confirmButton: "btn fw-bold btn-danger", cancelButton: "btn fw-bold btn-active-light-primary" },
                }).then(function (o) {
                    if(o.value){
                        $.ajax({
                            url: '{{url("admin/tickets/reject")}}'+'/'+id,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if(response.msg == 'success'){
                                    Swal.fire({ text: "{{__('You have reject selected ticket!')}}", icon: "success", buttonsStyling: !1, confirmButtonText: "{{__('Ok, got it!')}}", customClass: { confirmButton: "btn fw-bold btn-primary" } }).then(
                                        function(){
                                            location.reload();
                                        }
                                    );
                                }
                            },
                            error: function(response) {
                                if(response.status){
                                    toastr.warning(response.responseJSON.msg, "{{ __('Warning') }}");
                                }
                            }
                        });
                    }
                });
            });
        });

        var KTDatatablesServerSide = function () {
            // Shared variables
            var table;
            var dt;
            var filterPayment;

            // Private functions
            var initDatatable = function () {
                dt = $("#kt_datatable_example_1").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    // order: [[5, 'desc']],

                    "language": {
                        "emptyTable": "{{ __('No ticket available') }}",
                        "info": "{{ __('Viewing') }} _START_ {{ __('to') }} _END_ {{ __('of') }} _TOTAL_ {{ strtolower(__('Tickets')) }}"
                    },
                    info: true,
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: "{{route('admin.tickets.get-list')}}"
                    },
                    columns: [
                        // { data: 'DT_RowIndex',name:'id' },
                        { data: 'date', name:'created_at' },
                        { data: 'ticket_id', name:'ticket_id' },
                        { data: 'subject', name:'subject' },
                        { data: 'priority', name:'priority' },
                        { data: 'status', name:'status' },
                        { data: 'action', name:'action' }
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function (row, data, dataIndex) {
                        $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
                    }
                });

                table = dt.$;

                // Re-init functions on every table re-draw
                dt.on('draw', function () {
                    KTMenu.createInstances();
                });
            }

            // Search Datatable
            var handleSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt.search(e.target.value).draw();
                });
            }

            // Public methods
            return {
                init: function () {
                    initDatatable();
                    handleSearchDatatable();
                }
            }
        }();

        function resetAfterChange(){
            location.reload();
        }

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTDatatablesServerSide.init();
        });
    </script>
@endpush
