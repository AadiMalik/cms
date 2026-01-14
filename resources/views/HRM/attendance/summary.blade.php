@extends('layouts.master')
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
                                        <select id="employee_id" name="employee_id" class="form-control" style="width:100%;">
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
                                <table class="table display" style="width:100%">
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
    <script>
        $(document).ready(function() {
            $('#employee_id').select2();
        });
        $('#search_button').on('click', function() {

            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let employee_id = $('#employee_id').val();

            if (!start_date || !end_date) {
                alert('Please select date range');
                return;
            }

            $.ajax({
                url: "{{ url('attendance/summary-data') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    start_date: start_date,
                    end_date: end_date,
                    employee_id: employee_id
                },
                beforeSend: function() {
                    $('#summary_body').html(`
                    <tr>
                        <td colspan="7" class="text-center">Loading...</td>
                    </tr>
                `);
                },
                success: function(res) {

                    if (!res.Success) {
                        alert(res.Message);
                        return;
                    }

                    let html = '';

                    if (res.Data.length === 0) {
                        html = `
                        <tr>
                            <td colspan="7" class="text-center">No data found</td>
                        </tr>`;
                    } else {
                        $.each(res.Data, function(index, item) {
                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.employee?.name ?? '-'}</td>
                                <td>${item.total_days}</td>
                                <td>${item.present}</td>
                                <td>${item.absent}</td>
                                <td>${item.late}</td>
                                <td>${item.leave}</td>
                            </tr>`;
                        });
                    }

                    $('#summary_body').html(html);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        alert(xhr.responseJSON.message);
                    } else {
                        alert('Something went wrong');
                    }
                }
            });
        });
    </script>
@endsection
