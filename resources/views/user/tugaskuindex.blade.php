@extends('layout.layout')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
    <div class="card">
        <h5 class="card-header">Daftar Tugas</h5>
        @include('layout.notif')
        <div class="row text-end">
            <div class="col-sm-12 text-end">
                <a href="{{ route('tugaskucreate') }}" class="btn btn-sm btn-primary float-right mb-3 me-3">+ Tambah Tugas</a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tenggat</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($tugasku as $tgs)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $tgs->judul }}</strong>
                            </td>
                            <td>{{ date('D, d F Y', strtotime($tgs->tenggat)) }}</td>
                            <td>
                                @if ($tgs->status == 0)
                                    <span class="badge bg-label-primary me-1">Active</span>
                                @else
                                    <span class="badge bg-label-success me-1">Complete</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <form onsubmit="return confirm('Anda yakin ingin menghapus tugas ini  ?');"
                                            action="{{ route('tugaskudestroy', $tgs->id) }}" method="POST">
                                            <a class="dropdown-item" href="{{ route('tugaskushow', $tgs->id) }}"><i
                                                    class="bx bx-search-alt me-1"></i>
                                                Show</a>
                                            <a class="dropdown-item" href="{{ route('tugaskuedit', $tgs->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" type="button"><i
                                                    class="bx bx-trash me-1"></i>Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
<script>
    $(function() {
        'use strict';

        var dt_basic_table = $('.table');

        // DataTable with buttons
        // --------------------------------------------------------------------

        if (dt_basic_table.length) {
            var dt_basic = dt_basic_table.DataTable({
                ajax: assetsPath + '/json/table-datatable.json',
                columns: [{
                        data: ''
                    },
                    {
                        data: 'judul'
                    },
                    {
                        data: 'tenggat'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: ''
                    }
                ],
                columnDefs: [{
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        searchable: false,
                        targets: 0,
                        render: function(data, type, full, meta) {
                            return '';
                        }
                    },

                    {
                        targets: 2,
                        searchable: false,
                        visible: false
                    },
                    {
                        // Avatar image/badge, Name and post
                        targets: 3,
                        responsivePriority: 4,
                        render: function(data, type, full, meta) {
                            var $user_img = full['avatar'],
                                $name = full['full_name'],
                                $post = full['post'];
                            if ($user_img) {
                                // For Avatar image
                                var $output =
                                    '<img src="' + assetsPath + '/img/avatars/' + $user_img +
                                    '" alt="Avatar" class="rounded-circle">';
                            } else {
                                // For Avatar badge
                                var stateNum = Math.floor(Math.random() * 6);
                                var states = ['success', 'danger', 'warning', 'info', 'dark',
                                    'primary', 'secondary'
                                ];
                                var $state = states[stateNum],
                                    $name = full['full_name'],
                                    $initials = $name.match(/\b\w/g) || [];
                                $initials = (($initials.shift() || '') + ($initials.pop() ||
                                    '')).toUpperCase();
                                $output =
                                    '<span class="avatar-initial rounded-circle bg-label-' +
                                    $state + '">' + $initials + '</span>';
                            }
                            // Creates full output for row
                            var $row_output =
                                '<div class="d-flex justify-content-start align-items-center">' +
                                '<div class="avatar-wrapper">' +
                                '<div class="avatar me-2">' +
                                $output +
                                '</div>' +
                                '</div>' +
                                '<div class="d-flex flex-column">' +
                                '<span class="emp_name text-truncate">' +
                                $name +
                                '</span>' +
                                '<small class="emp_post text-truncate text-muted">' +
                                $post +
                                '</small>' +
                                '</div>' +
                                '</div>';
                            return $row_output;
                        }
                    },
                    {
                        responsivePriority: 1,
                        targets: 4
                    },
                    {
                        // Label
                        targets: -2,
                        render: function(data, type, full, meta) {
                            var $status_number = full['status'];
                            var $status = {
                                1: {
                                    title: 'Current',
                                    class: 'bg-label-primary'
                                },
                                2: {
                                    title: 'Professional',
                                    class: ' bg-label-success'
                                },
                                3: {
                                    title: 'Rejected',
                                    class: ' bg-label-danger'
                                },
                                4: {
                                    title: 'Resigned',
                                    class: ' bg-label-warning'
                                },
                                5: {
                                    title: 'Applied',
                                    class: ' bg-label-info'
                                }
                            };
                            if (typeof $status[$status_number] === 'undefined') {
                                return data;
                            }
                            return (
                                '<span class="badge rounded-pill ' +
                                $status[$status_number].class +
                                '">' +
                                $status[$status_number].title +
                                '</span>'
                            );
                        }
                    },
                    {
                        // Actions
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return (
                                '<div class="d-inline-block">' +
                                '<a href="javascript:;" class="btn btn-sm text-primary btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>' +
                                '<ul class="dropdown-menu dropdown-menu-end">' +
                                '<li><a href="javascript:;" class="dropdown-item">Details</a></li>' +
                                '<li><a href="javascript:;" class="dropdown-item">Archive</a></li>' +
                                '<div class="dropdown-divider"></div>' +
                                '<li><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></li>' +
                                '</ul>' +
                                '</div>' +
                                '<a href="javascript:;" class="btn btn-sm text-primary btn-icon item-edit"><i class="bx bxs-edit"></i></a>'
                            );
                        }
                    }
                ],
                order: [
                    [2, 'desc']
                ],
                dom: '<"card-header"<"head-label text-center"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 7,
                lengthMenu: [7, 10, 25, 50, 75, 100],
                buttons: [{
                        extend: 'collection',
                        className: 'btn btn-label-primary dropdown-toggle me-2',
                        text: '<i class="bx bx-show me-1"></i>Export',
                        buttons: [{
                                extend: 'print',
                                text: '<i class="bx bx-printer me-1" ></i>Print',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="bx bx-file me-1" ></i>Csv',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'copy',
                                text: '<i class="bx bx-copy me-1" ></i>Copy',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            }
                        ]
                    },
                    {
                        text: '<i class="bx bx-plus me-1"></i> <span class="d-none d-lg-inline-block">Add New Record</span>',
                        className: 'create-new btn btn-primary'
                    }
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                return 'Details of ' + data['full_name'];
                            }
                        }),
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !==
                                    '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                }
            });
            $('div.head-label').html('<h5 class="card-title mb-0">DataTable with Buttons</h5>');
        }
    });
</script>
