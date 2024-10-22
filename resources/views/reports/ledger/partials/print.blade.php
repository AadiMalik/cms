<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ledger Report</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/css/pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/report-view.css') }}">
</head>

<div class="font-color-black">

    <center style="float:none;">
        <h4><b>Ledger Report</b></h4>
    </center>
    <div>
        <div style="float:left;">
            <b>Al Saeed</b><br>
            <b>Email: </b>alsaeed@gmail.com <br>
            <b>Phone No: </b>030021547845
        </div>
        <div style="float: right;">
            <b>Date: </b>{{ $start ?? '' }} To {{ $end ?? '' }} <br>

            @if ($account != '')
            <b>Account: </b>{{ $account }}
            @elseif($supplier != '')
            <b>Supplier/Karigar: </b>{{ $supplier }}
            @elseif($customer != '')
            <b>Customer: </b>{{ $customer }}
            @elseif($voucher != '')
            <b>Voucher No: </b>{{ $voucher }}
            @else
            <b>All Ledger</b>
            @endif
        </div>
    </div>
    <br><br><br>
    <div class="tableFixHead font-color-black">
        <table class="font-x-medium" style="border: 0.5px solid black;" style="width:100%;">
            <thead>
                <tr class="border-black">
                    <th style="text-align: center;">Date</th>
                    <th style="text-align: center;">Voucher No</th>
                    <th style="text-align: center;">Account</th>
                    <th style="text-align: center;">Reference</th>
                    <th style="text-align: center;">Debit</th>
                    <th style="text-align: center;">Credit</th>
                    <th style="text-align: center;">Balance</th>
                    <th style="text-align: center;">Debit</th>
                    <th style="text-align: center;">Credit</th>
                    <th style="text-align: center;">Balance</th>
                    <th style="text-align: center;">Debit</th>
                    <th style="text-align: center;">Credit</th>
                    <th style="text-align: center;">Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                $sum_drbal = 0;
                $sum_crbal = 0;
                $rBal = 0;
                $opening = 0;

                @endphp
                @foreach ($opening_balance as $item)
                @php
                $opening = $opening + ($item->debit - $item->credit);
                $rBal = $opening;
                @endphp
                @endforeach
                <tr class="border-black" style="font-weight: bold;">
                    <td colspan="6" style="text-align: left;">Opening Balance</td>
                    <td style="color:black;text-align:right;">
                        {{ number_format($opening, 2, '.', ',') }}
                    </td>
                    <td colspan="2" style="color:black;text-align:right;">
                        {{ number_format($opening, 2, '.', ',') }}
                    </td>
                    <td colspan="2" style="color:black;text-align:right;">
                        {{ number_format($opening, 2, '.', ',') }}
                    </td>
                </tr>
                <tr class="border-black" style="font-weight: bold;">
                    <td colspan="6" style="text-align: center;">AU</td>
                    <td colspan="3" style="text-align: center;">Dollar</td>
                    <td colspan="3" style="text-align: center;">PKR</td>
                </tr>
                @if ($data!=null)
                @foreach ($data as $loop => $ledger)
                @php

                $au_sum_drbal += $ledger->debit;
                $au_sum_crbal += $ledger->credit;
                $auBal = $auBal + ($ledger->debit - $ledger->credit);

                @endphp
                <tr>
                    <td>{{ $ledger->date_post }}</td>
                    <td id="example2">{{ $ledger->entryNum }}
                        <input type="hidden" value="{{ $ledger->entryNum }}">
                    </td>
                    <td>{{ $ledger->code ?? '' }} {{ $ledger->name ?? '' }}</td>
                    <td>{{ $ledger->reference ?? 'N/A' }}</td>
                    <td style="font-family:tahoma;color:black;text-align:right;">
                        {{ number_format($ledger->debit, 2, '.', ',') }}
                    </td>
                    <td style="font-family:tahoma;color:black;text-align:right;">
                        {{ number_format($ledger->credit, 2, '.', ',') }}
                    </td>
                    <td style="font-family:tahoma;color:black;text-align:right;">

                        {{ number_format($rBal, 2, '.', ',') }}

                    </td>

                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7">No Data/Record found</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
                <tr style="font-weight: bold;">
                    <td colspan="4" style="text-align: left;">Total</td>
                    <td style="text-align: right;"> <span id='sum_debit'>{{ number_format($sum_drbal, 2, '.', ',') }}</span></td>
                    <td style="text-align: right;"> <span id='sum_credit'>{{ number_format($sum_crbal, 2, '.', ',') }}</span></td>
                    <td style="text-align: right;"> <span id='sum_bal'>{{ number_format($rBal, 2, '.', ',') }}</span>
                    </td>

                </tr>
            </tfoot>
        </table>
    </div>

</div>

</html>