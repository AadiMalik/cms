<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Diamond Purchase Order</title>
    <link rel="stylesheet" href="{{ asset('assets/styles/css/pdf.css') }}">
</head>

<body>
    <center style="float:none; margin-top:20px;">
        <h3>Diamond Purchase Order</h3>
    </center>
    <div>
        <div style="float:left;">
            <b style="font-size: 13px;">{{config('enum.company_name')}}</b><br>
            <small><b>Email: </b>{{config('enum.company_email')}}</small> <br>
            <small><b>Phone No: </b>{{config('enum.company_phone')}}</small><br>
        </div>
        <div style="float: right;">
            <small><b>Purchase No: </b>{{ $diamond_purchase->diamond_purchase_no??'' }}</small> <br>
            <small><b>Purchase Date: </b>{{ date('d-M-Y', strtotime($diamond_purchase->diamond_purchase_date)) }} </small> <br>
            <small><b>Vendor: </b>{{ $diamond_purchase->vendor->first_name??'' }} {{ $diamond_purchase->vendor->last_name??'' }}</small> <br>
            <small><b>Purchase In: </b>{{ ($diamond_purchase->is_pkr==1)?'PKR':'Dollar' }}</small> <br>
            <small><b>Payment: </b>@if($diamond_purchase->paid>0 && $diamond_purchase->paid_account_id!=null) <span style="color:green;">Paid</span> @else <span style="color:red;">Unpaid</span> @endif </small><br>
        </div>
    </div>
    <br><br><br><br><br>
    <table border="1" style="border:1px dotted #000; float:none; width:100%;">
        <thead>
            <tr style="background: #87CEFA;color: #000;">
                <th style="text-align:center; font-size:11px;">Sr.No</th>
                <th style="text-align:center; font-size:11px;">Type</th>
                <th style="text-align:center; font-size:11px;">Cut</th>
                <th style="text-align:center; font-size:11px;">Color</th>
                <th style="text-align:center; font-size:11px;">Clarity</th>
                <th style="text-align:center; font-size:11px;">Carat</th>
                <th style="text-align:center; font-size:11px;">Carat Price(Rs.)</th>
                <th style="text-align:center; font-size:11px;">Tax Amount</th>
                <th style="text-align:center; font-size:11px;">QTY</th>
                <th style="text-align:center; font-size:11px;">Total (PKR)</th>
                <th style="text-align:center; font-size:11px;">Total ($)</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($diamond_purchase_detail as $index=>$item)
            <tr>
                <td style="text-align:center; font-size:10px;">{{ $index+1 }}</td>
                <td style="text-align:center; font-size:10px;">{{ $item->diamond_type->name??'' }}</td>
                <td style="text-align:center; font-size:10px;">{{ $item->diamond_cut->name??'' }}</td>
                <td style="text-align:center; font-size:10px;">{{ $item->diamond_color->name??'' }}</td>
                <td style="text-align:center; font-size:10px;">{{ $item->diamond_clarity->name??'' }}</td>
                <td style="text-align:center; font-size:10px;">{{ $item->carat??'' }}</td>
                <td style="text-align:right; font-size:10px;">{{ number_format($item->carat_price??0.00,2) }}</td>
                <td style="text-align:right; font-size:10px;">{{ number_format($item->tax_amount??0.00,2) }}</td>
                <td style="text-align:right; font-size:10px;">{{ number_format($item->qty??0.00,2) }}</td>
                <td style="text-align:right; font-size:10px;">{{ number_format($item->total_amount??0.00,2) }}</td>
                <td style="text-align:right; font-size:10px;">{{ number_format($item->total_dollar??0.00,2) }}</td>
            </tr>
            @endforeach

        </tbody>
        <tfoot>
            <tr style="background: #87CEFA;color: #000;">
                <td colspan="4" style=" font-size:11px;"><b>Total</b></td>
                <td style="text-align:right; font-size:11px;"><b>{{number_format($diamonfd_purchase->total_qty??0.00,2)}}</b></td>
                <td style="text-align:right; font-size:11px;"><b>{{number_format($diamonfd_purchase->total??0.00,2)}} PKR</b></td>
                <td style="text-align:right; font-size:11px;"><b>{{number_format($diamonfd_purchase->total_dollar??0.00,2)}} $</b></td>
            </tr>
            <tr style="background: #87CEFA;color: #000;">
                <td colspan="6" style=" font-size:11px;"><b>Paid Amount</b></td>
                <td style="text-align:right; font-size:11px;"><b> @if($diamond_purchase->paid>0 && $diamond_purchase->paid_account!=null) {{number_format($diamond_purchase->paid??0.00,2)}} @else 0.00 @endif</b></td>
            </tr>
        </tfoot>

    </table>
    <small><b>Description:</b> {{ $diamond_purchase->referenece??'' }}</small><br>
    <small><b>Generate By:</b> {{ $diamond_purchase->created_by->name ?? '' }}</small>
</body>

</html>