<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sales User Wise Report</title>
    <link rel="stylesheet" href="{{ asset('css/report-view.css') }}">
</head>

<div class="font-color-black">

    <center style="float:none;">
        <h4><b>Sales User Wise Report</b></h4>
    </center>
    <div>
        <div style="float:left;">
            <b>{{config('enum.company_name')}}</b><br>
            <b>Email: </b>{{config('enum.company_email')}} <br>
            <b>Phone No: </b>{{config('enum.company_phone')}}
        </div>
        <div style="float: right;">
            <b>Date: </b>{{ $parms->start_date ?? '' }} To {{ $parms->end_date ?? '' }} <br>
            <b>User: </b>{{ $parms->user ?? 'All' }} <br>
        </div>
    </div>
    <br><br><br><br>

    <div class="tableFixHead font-color-black">

        <table class="font-x-medium" border="1" style="border: 0.5px solid black;" width="100%">

            <thead>
                <tr class="border-black">
                    <th class="text-center">Sr.</th>
                    <th class="text-center">Sale No</th>
                    <th class="text-center">Sale Date</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Contact#</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">QTY</th>
                    <th class="text-center">Discount</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Advance Amt.</th>
                    <th class="text-center">Cash Amt.</th>
                    <th class="text-center">Card Amt.</th>
                    <th class="text-center">Bank Amt.</th>
                    <th class="text-center">Gold Impurity Amt.</th>
                    <th class="text-center">Total Received</th>
                </tr>
            </thead>
            <tbody>
                @if(count($parms->data)>0)
                @php

                $grand_qty=0;
                $grand_discount=0;
                $grand_subtotal=0;
                $grand_total=0;
                $grand_advance=0;
                $grand_cash=0;
                $grand_card=0;
                $grand_bank=0;
                $grand_gold=0;
                $grand_received=0;

                @endphp
                @foreach ($parms->data as $item1)
                <tr>
                    <td colspan="16" class="text-left"><b>{{ucwords($item1['user_name']??'')}}</b></td>
                </tr>

                @php

                $qty=0;
                $discount=0;
                $subtotal=0;
                $total=0;
                $advance=0;
                $cash=0;
                $card=0;
                $bank=0;
                $gold=0;
                $received=0;

                @endphp

                @if(count($item1['sales'])>0)
                @foreach ($item1['sales'] as $index=>$item)
                <!-- Sale Detail -->
                <tr>
                    <td class="text-left">{{ $index+1 }}</td>
                    <td class="text-left">{{ $item->sale_no ?? '' }}</td>
                    <td class="text-left">{{ date('d-M-Y', strtotime($item->sale_date??'')) }}</td>
                    <td class="text-left">{{ ucwords($item->customer_name ?? '') }}</td>
                    <td class="text-left">{{ $item->customer_contact??'' }}</td>
                    <td class="text-left">{{ ($item->posted==1)?'Posted':'Unposted' }}</td>
                    <td class="text-right">{{ number_format($item->total_qty ?? 0,2) }}</td>
                    <td class="text-right">{{ number_format($item->discount_amount??0,2)  }}</td>
                    <td class="text-right">{{ number_format($item->sub_total??0,2)  }}</td>
                    <td class="text-right">{{ number_format($item->total??0,2)  }}</td>
                    <td class="text-right">{{ number_format($item->advance_amount??0,2) }}</td>
                    <td class="text-right">{{ number_format($item->cash_amount??0,2) }}</td>
                    <td class="text-right">{{ number_format($item->card_amount??0,2) }}</td>
                    <td class="text-right">{{ number_format($item->bank_transfer_amount??0,2) }}</td>
                    <td class="text-right">{{ number_format($item->gold_impure_amount??0,2) }}</td>
                    <td class="text-right">{{ number_format($item->total_received??0,2) }}</td>
                </tr>
                <!-- merge user sale -->
                @php

                $qty=$qty+$item->total_qty;
                $discount=$discount+$item->discount_amount;
                $subtotal=$subtotal+$item->sub_total;
                $total=$total+$item->total;
                $advance=$advance+$item->advance_amount;
                $cash=$cash+$item->cash_amount;
                $card=$card+$item->card_amount;
                $bank=$bank+$item->bank_transfer_amount;
                $gold=$gold+$item->gold_impure_amount;
                $received=$received+$item->total_received;

                @endphp

                @endforeach
                <!-- Total User Sale -->
                <tr>
                    <td class="text-left" colspan="6"><b>Total</b></td>
                    <td class="text-right">{{ number_format($qty ?? 0,2) }}</td>
                    <td class="text-right">{{ number_format($discount??0,2)  }}</td>
                    <td class="text-right">{{ number_format($subtotal??0,2)  }}</td>
                    <td class="text-right">{{ number_format($total??0,2)  }}</td>
                    <td class="text-right">{{ number_format($advance??0,2) }}</td>
                    <td class="text-right">{{ number_format($cash??0,2) }}</td>
                    <td class="text-right">{{ number_format($card??0,2) }}</td>
                    <td class="text-right">{{ number_format($bank??0,2) }}</td>
                    <td class="text-right">{{ number_format($gold??0,2) }}</td>
                    <td class="text-right">{{ number_format($received??0,2) }}</td>
                </tr>

                <!-- Grand total -->
                @php

                $grand_qty=$grand_qty+$qty;
                $grand_discount=$grand_discount+$discount;
                $grand_subtotal=$grand_subtotal+$subtotal;
                $grand_total=$grand_total+$total;
                $grand_advance=$grand_advance+$advance;
                $grand_cash=$grand_cash+$cash;
                $grand_card=$grand_card+$card;
                $grand_bank=$grand_bank+$bank;
                $grand_gold=$grand_gold+$gold;
                $grand_received=$grand_received+$received;

                @endphp

                @else
                <tr>
                    <td colspan="16" class="text-center">Data Not Found!</td>
                </tr>
                @endif
                @endforeach
                <!-- Grand Total User Sale -->
                <tr>
                    <td class="text-left" colspan="6"><b>Grand Total</b></td>
                    <td class="text-right">{{ number_format($grand_qty ?? 0,2) }}</td>
                    <td class="text-right">{{ number_format($grand_discount??0,2)  }}</td>
                    <td class="text-right">{{ number_format($grand_subtotal??0,2)  }}</td>
                    <td class="text-right">{{ number_format($grand_total??0,2)  }}</td>
                    <td class="text-right">{{ number_format($grand_advance??0,2) }}</td>
                    <td class="text-right">{{ number_format($grand_cash??0,2) }}</td>
                    <td class="text-right">{{ number_format($grand_card??0,2) }}</td>
                    <td class="text-right">{{ number_format($grand_bank??0,2) }}</td>
                    <td class="text-right">{{ number_format($grand_gold??0,2) }}</td>
                    <td class="text-right">{{ number_format($grand_received??0,2) }}</td>
                </tr>
                @else
                <tr>
                    <td colspan="16" class="text-center">Data Not Found!</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

</html>

{{-- @php
    exit();
@endphp --}}