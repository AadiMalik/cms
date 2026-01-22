<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Employee Leave Report</title>
    <link rel="stylesheet" href="{{ asset('css/report-view.css') }}">
</head>

<div class="font-color-black">

    <center style="float:none;">
        <h4><b>Employee Leave Report</b></h4>
    </center>
    <div>
        <div style="float:left;">
            <b>{{ config('enum.company_name') }}</b><br>
            <b>Email: </b>{{ config('enum.company_email') }} <br>
            <b>Phone No: </b>{{ config('enum.company_phone') }}
        </div>
        <div style="float: right;">
            <b>Date: </b>{{ $parms->start_date ?? '' }} To {{ $parms->end_date ?? '' }} <br>
            <b>Department: </b>{{ $parms->department ?? 'All' }}<br>
            <b>Leave Type: </b>{{ $parms->leave_type ?? 'All' }}<br>
            <b>Employee: </b>{{ $parms->employee ?? 'All' }}<br>
        </div>
    </div>
    <br><br><br><br>

    <table border="1" width="100%">

        <thead>
            <tr class="border-black">
                <th style="text-align: center;">Sr.</th>
                <th style="text-align: center;">Employee Name</th>
                <th style="text-align: center;">Department</th>
                <th style="text-align: center;">Designation</th>
                <th style="text-align: center;">Leave Type</th>
                <th style="text-align: center;">Paid / Unpaid</th>
                <th style="text-align: center;">From Date</th>
                <th style="text-align: center;">To Date</th>
                <th style="text-align: center;">No. of Days</th>
                <th style="text-align: center;">Reason</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Applied On</th>
            </tr>
        </thead>
        <tbody>
            @if (count($parms->data) > 0)
                @foreach ($parms->data as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td style="text-align: center;">{{ $item->employee->name ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->employee->department->name ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->employee->designation->name ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->leave_type->name ?? '' }}</td>
                        <td style="text-align: center;">{{ ($item->leave_type->is_paid==1)?'Paid':'Unpaid' }}</td>
                        <td style="text-align: center;">{{ $item->from_date ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->to_date ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->no_of_days ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->reason ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->status ?? '' }}</td>
                        <td style="text-align: center;">{{ $item->created_at->format('d-m-Y') ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12" class="text-center">No Data/Record found</td>
                </tr>
            @endif
        </tbody>
    </table>

</div>

</html>

{{-- @php
    exit();
@endphp --}}
