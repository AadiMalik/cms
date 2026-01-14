@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>Attendance Summary</h1>
            <ul>
                <li>List</li>
                <li>All</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <!-- end of row -->
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card text-left">
                        <div class="card-header">
                            <h4 class="card-inside-title mt-2">Filters</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">From:<span class="text-danger">*</span></label>
                                        <input type="date" id="start_date" name="start_date" class="form-control date"
                                            value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">To:<span class="text-danger">*</span></label>
                                        <input type="date" id="end_date" name="end_date" class="form-control date"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Employee</label>
                                        <select id="employee_id" name="employee_id" class="form-control"
                                            style="width:100%;">
                                            <option value="">--Select Employee--</option>
                                            @foreach ($employees as $item)
                                                <option value="{{ $item->id }}">{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-4">
                                        <button class="btn btn-primary waves-effect" id="search_button"
                                            type="submit">Search</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered" id="attendance_summary_table"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Total Days</th>
                                            <th>Present</th>
                                            <th>Absent</th>
                                            <th>Late</th>
                                            <th>Leave</th>
                                        </tr>
                                    </thead>
                                    <tbody id="summary_body">
                                        <tr>
                                            <td colspan="7" class="text-center">No found data</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end of col -->
                    </div>
                    <!-- end of row -->
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        let summaryTable;

        $(document).ready(function() {

            $('#employee_id').select2();

            summaryTable = $('#attendance_summary_table').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                ordering: false,
                paging: true,
                lengthChange: true,

                dom: 'Bfrtip', // 👈 Buttons position
                buttons: [{
                        extend: 'excel',
                        title: 'Attendance Summary'
                    },
                    {
                        extend: 'csv',
                        title: 'Attendance Summary'
                    },
                    {
                        extend: 'pdf',
                        title: 'Attendance Summary'
                    },
                    {
                        extend: 'print',
                        title: 'Attendance Summary'
                    }
                ],

                ajax: {
                    url: "{{ url('attendance/summary-data') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.employee_id = $('#employee_id').val();
                    },
                    dataSrc: function(json) {

                        if (!json.Success) {
                            alert(json.Message);
                            return [];
                        }

                        return json.Data;
                    }
                },

                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'employee.name',
                        defaultContent: '-'
                    },
                    {
                        data: 'total_days',
                        defaultContent: 0
                    },
                    {
                        data: 'present',
                        defaultContent: 0
                    },
                    {
                        data: 'absent',
                        defaultContent: 0
                    },
                    {
                        data: 'late',
                        defaultContent: 0
                    },
                    {
                        data: 'leave',
                        defaultContent: 0
                    }
                ]
            });

            // 🔍 Search button reloads table
            $('#search_button').on('click', function() {

                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();

                if (!start_date || !end_date) {
                    alert('Please select date range');
                    return;
                }

                summaryTable.ajax.reload();
            });

        });
    </script>
@endsection
