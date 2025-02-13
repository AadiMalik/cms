<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <style>
            body {
                  font-family: Arial, sans-serif;
                  display: flex;
                  flex-wrap: wrap;
                  justify-content: center;
                  margin: 20px;
            }

            

      </style>
</head>

<body>
      <table>
            <tbody>
                  <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><img style="width:220px; height: 30px;" src="{{ asset($finish_product->barcode) }}" alt=""></td>
                  </tr>
                  <tr>
                        <td></td>
                        <td></td>
                        <td style="min-width: 120px;text-align: left;">{{$finish_product->product->name??''}}</td>
                        <td style="text-align: center;">Al Saeed Jewellers</td>
                  </tr>
                  <tr>
                        <td style="display: flex
;
    flex-direction: column;
    transform: translateY(-35%) rotate(-90deg);
    transform-origin: center;">
                              <b>{{ $finish_product->tag_no ?? '' }}</b> 
                              <b>Ntw {{$finish_product->net_weight??0.00}}</b>
                              <b>Wst {{$finish_product->waste??0.00}}</b> 
                              <b>Gw {{$finish_product->gross_weight??0.00}}</b> <br><br>
                              <b>Dw {{$finish_product->diamond_weight??0.00}} Ct</b> <br>
                              <b>Kt {{$finish_product->waste_per??0.00}}</b>
                        </td>
                        <td></td>
                        <td></td>
                        <td style="display: flex; flex-direction: column; transform: translateY(35%) rotate(-270deg); transform-origin: center;">
                              <b>{{ $finish_product->tag_no ?? '' }}</b> 
                              <b>Ntw {{$finish_product->net_weight??0.00}}</b>
                              <b>Wst {{$finish_product->waste??0.00}}</b> 
                              <b>Gw {{$finish_product->gross_weight??0.00}}</b> <br><br>
                              <b>Dw {{$finish_product->diamond_weight??0.00}} Ct</b> <br>
                              <b>Kt {{$finish_product->waste_per??0.00}}</b>
                        </td>
                  </tr>
                  <tr>
                        <td><img style="width:220px; height: 30px;" src="{{ asset($finish_product->barcode) }}" alt=""></td>
                        <td></td>
                        <td></td>
                        <td></td>
                  </tr>
                  <tr>
                        <td style="text-align: center;">Al Saeed Jewellers</td>
                        <td style="min-width: 120px;text-align: right;">{{$finish_product->product->name??''}}</td>
                        <td></td>
                        <td></td>
                  </tr>
            </tbody>
      </table>
      <!-- <div id="printableArea" class="print-area">
            <div class="tag">
                  <div class="barcode"></div>
                  <div class="weight-container">
                        <div>{{ $finish_product->tag_no ?? '' }}</div>
                        <div>Ntw 5.342</div>
                        <div>Wst 1.200</div>
                        <div>Gw 6.542</div>
                        <div>DW 0.00 Ct</div>
                        <div>Kt 21</div>
                  </div>
                  <div class="product-name">Ladies Rings</div>
                  <div class="store">Al Saeed Jewellers</div>
            </div>

            <div class="tag">
                  <div class="barcode">*LR00011*</div>
                  <div class="weight-container">
                        <div>LR00011</div>
                        <div>Ntw 6.746</div>
                        <div>Wst 1.349</div>
                        <div>Gw 8.095</div>
                        <div>DW 0.00 Ct</div>
                        <div>Kt 21</div>
                  </div>
                  <div class="product-name">Ladies Rings</div>
                  <div class="store">Al Saeed Jewellers</div>
            </div>
      </div> -->
      <!-- <button onclick="printDiv('printableArea')">Print</button> -->

      <script>
            function printDiv(divId) {
                  var printContents = document.getElementById(divId).innerHTML;
                  var originalContents = document.body.innerHTML;

                  document.body.innerHTML = printContents;
                  window.print();
                  document.body.innerHTML = originalContents;
                  location.reload(); // Refresh to restore the original page
            }
      </script>
</body>

</html>