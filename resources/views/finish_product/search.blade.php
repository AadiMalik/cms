@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
      <div class="breadcrumb">
            <h1>Search Tagging</h1>
            <ul>
                  <li>Search</li>
                  <li>Show</li>
            </ul>
      </div>
      <div class="separator-breadcrumb border-top"></div>
      @if (session()->has('error'))
      <div class="alert alert-danger">
            {{ session()->get('error') }}
      </div>
      @endif

      <section class="contact-list">
            <div class="row">
                  <div class="col-md-12 mb-4">
                        <div class="card">
                              <div class="card-header bg-transparent">
                                    <div class="row">
                                          <div class="col-md-6">
                                                <div class="form-group">
                                                      <label class="form-label">Tag:<span
                                                                  class="text-danger">*</span></label>
                                                      <select name="search" class="form-control show-tick" id="search">
                                                            <option value="" selected disabled>--Select Tag--</option>
                                                            @foreach($tags as $item)
                                                            <option value="{{ $item->id }}">{{ $item->tag_no ?? '' }} @if($item->is_parent==1) (Parent) @endif</option>
                                                            @endforeach
                                                      </select>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                              <div class="card-body d-none" id="dataContainer" style="font-size: 14px;">
                                    <div class="row">
                                          <div class="col-md-9">
                                                <table class="table table-bordered">
                                                      <tbody>
                                                            <tr>
                                                                  <td class="font-weight-bold">Product:</td>
                                                                  <td data-field="product"></td>
                                                                  <td class="font-weight-bold">Purchase:</td>
                                                                  <td data-field="purchase"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Tag No:</td>
                                                                  <td data-field="tag_no"></td>
                                                                  <td class="font-weight-bold">Warehouse:</td>
                                                                  <td data-field="warehouse"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Karat:</td>
                                                                  <td data-field="karat"></td>
                                                                  <td class="font-weight-bold">Scale Weight:</td>
                                                                  <td data-field="scale_weight"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Bead Weight:</td>
                                                                  <td data-field="bead_weight"></td>
                                                                  <td class="font-weight-bold">Stones Weight:</td>
                                                                  <td data-field="stones_weight"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Diamond Weight:</td>
                                                                  <td data-field="diamond_weight"></td>
                                                                  <td class="font-weight-bold">Net Weight:</td>
                                                                  <td data-field="net_weight"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Waste (%):</td>
                                                                  <td data-field="waste_per"></td>
                                                                  <td class="font-weight-bold">Waste:</td>
                                                                  <td data-field="waste"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Gross Weight:</td>
                                                                  <td data-field="gross_weight"></td>
                                                                  <td class="font-weight-bold">Laker:</td>
                                                                  <td data-field="laker"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Making/gram:</td>
                                                                  <td data-field="making_gram"></td>
                                                                  <td class="font-weight-bold">Making:</td>
                                                                  <td data-field="making"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Total Bead Price:</td>
                                                                  <td data-field="total_bead_price"></td>
                                                                  <td class="font-weight-bold">Total Stones Price:</td>
                                                                  <td data-field="total_stones_price"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Total Diamond Price:</td>
                                                                  <td data-field="total_diamond_price"></td>
                                                                  <td class="font-weight-bold">Gold Rate/gram:</td>
                                                                  <td data-field="gold_rate"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Total Gold Price:</td>
                                                                  <td data-field="total_gold_price"></td>
                                                                  <td class="font-weight-bold">Other Amount:</td>
                                                                  <td data-field="other_amount"></td>
                                                            </tr>
                                                            <tr>
                                                                  <td class="font-weight-bold">Total Amount:</td>
                                                                  <td data-field="total_amount"></td>
                                                                  <td class="font-weight-bold">Saled:</td>
                                                                  <td data-field="is_saled"></td>
                                                            </tr>
                                                      </tbody>
                                                </table>
                                          </div>

                                          <div class="col-md-3">
                                                <table class="table table-bordered">
                                                      <tbody>
                                                            <tr>
                                                                  <td><img id="barcode_img" src="" alt=""><br><span style="font-family: fantasy;"></span></td>
                                                            </tr>
                                                            <tr>
                                                                  <td><img id="main_img" src="" alt=""></td>
                                                            </tr>

                                                      </tbody>
                                                </table>
                                          </div>
                                    </div>

                                    <div class="row" id="beadSection" style="display:none;">
                                          <div class="col-md-12">
                                                <h5 class="font-weight-bold">Bead Detail:</h5>
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Sr.</th>
                                                                  <th>Type</th>
                                                                  <th>Beads</th>
                                                                  <th>Gram</th>
                                                                  <th>Carat</th>
                                                                  <th>Rate/Gram</th>
                                                                  <th>Rate/Carat</th>
                                                                  <th>Total Amount</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody id="bead_table_body"></tbody>
                                                </table>
                                          </div>
                                    </div>

                                    <div class="row" id="stoneSection" style="display:none;">
                                          <div class="col-md-12">
                                                <h5 class="font-weight-bold">Stone Detail:</h5>
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Sr.</th>
                                                                  <th>Type</th>
                                                                  <th>Stones</th>
                                                                  <th>Gram</th>
                                                                  <th>Carat</th>
                                                                  <th>Rate/Gram</th>
                                                                  <th>Rate/Carat</th>
                                                                  <th>Total Amount</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody id="stone_table_body"></tbody>
                                                </table>
                                          </div>
                                    </div>

                                    <div class="row" id="diamondSection" style="display:none;">
                                          <div class="col-md-12">
                                                <h5 class="font-weight-bold">Diamond Detail:</h5>
                                                <table class="table table-striped">
                                                      <thead>
                                                            <tr>
                                                                  <th>Sr.</th>
                                                                  <th>Type</th>
                                                                  <th>Diamonds</th>
                                                                  <th>Color</th>
                                                                  <th>Cut</th>
                                                                  <th>Clarity</th>
                                                                  <th>Carat</th>
                                                                  <th>Rate/Carat</th>
                                                                  <th>Total Amount</th>
                                                            </tr>
                                                      </thead>
                                                      <tbody id="diamond_table_body"></tbody>
                                                </table>
                                          </div>
                                    </div>

                              </div>
                              <div class="card-footer"></div>
                        </div>
                  </div>
            </div>
      </section>
</div>
@endsection

@section('js')
<script>
      $(document).ready(function() {
            $('#search').select2();
            $(document).on('change', '#search', function() {
                  let id = $(this).val();
                  if (!id) return;

                  $.ajax({
                        url: "/finish-product/fetch-search/" + id,
                        type: "GET",
                        success: function(response) {
                              console.log(response);
                              if (response.Success && response.Data) {
                                    let d = response.Data.finish_product || {};
                                    let beads = response.Data.finish_product_bead || [];
                                    let stones = response.Data.finish_product_stone || [];
                                    let diamonds = response.Data.finish_product_diamond || [];

                                    $('#dataContainer').removeClass('d-none');

                                    // Main product
                                    $("td[data-field='product']").text(d.product?.name ? d.product.name + ' ' + (d.product.prefix ?? '') : '');
                                    $("td[data-field='purchase']").text(d.ratti_kaat?.ratti_kaat_no ?? '');
                                    $("td[data-field='tag_no']").text(d.tag_no ?? '');
                                    $("td[data-field='warehouse']").text(d.warehouse?.name ?? '');
                                    $("td[data-field='karat']").text(d.gold_carat ?? '');
                                    $("td[data-field='scale_weight']").text(d.scale_weight ?? '');
                                    $("td[data-field='bead_weight']").text(d.bead_weight ?? '');
                                    $("td[data-field='stones_weight']").text(d.stones_weight ?? '');
                                    $("td[data-field='diamond_weight']").text(d.diamond_weight ?? '');
                                    $("td[data-field='net_weight']").text(d.net_weight ?? '');
                                    $("td[data-field='waste_per']").text(d.waste_per ?? '');
                                    $("td[data-field='waste']").text(d.waste ?? '');
                                    $("td[data-field='gross_weight']").text(d.gross_weight ?? '');
                                    $("td[data-field='laker']").text(d.laker ?? '');
                                    $("td[data-field='making_gram']").text(d.making_gram ?? '');
                                    $("td[data-field='making']").text(d.making ?? '');
                                    $("td[data-field='total_bead_price']").text(d.total_bead_price ?? '');
                                    $("td[data-field='total_stones_price']").text(d.total_stones_price ?? '');
                                    $("td[data-field='total_diamond_price']").text(d.total_diamond_price ?? '');
                                    $("td[data-field='gold_rate']").text(d.gold_rate ?? '');
                                    $("td[data-field='total_gold_price']").text(d.total_gold_price ?? '');
                                    $("td[data-field='other_amount']").text(d.other_amount ?? '');
                                    $("td[data-field='total_amount']").text(d.total_amount ?? '');
                                    $("td[data-field='is_saled']").html(d.is_saled == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>');

                                    // Images
                                    $('#barcode_img').attr('src', d.barcode ?? '');
                                    $('#main_img').attr('src', d.picture ?? '');
                                    $('input[name="id"][type="hidden"]').val(d.id ?? '');

                                    // Beads
                                    if (beads.length) {
                                          $('#beadSection').show();
                                          let html = '';
                                          beads.forEach((b, i) => {
                                                html += `<tr>
                                <td>${i+1}</td>
                                <td>${b.type ?? ''}</td>
                                <td>${b.beads ?? ''}</td>
                                <td>${b.gram ?? ''}</td>
                                <td>${b.carat ?? ''}</td>
                                <td>${b.gram_rate ?? ''}</td>
                                <td>${b.carat_rate ?? ''}</td>
                                <td>${b.total_amount ?? ''}</td>
                            </tr>`;
                                          });
                                          $('#bead_table_body').html(html);
                                    } else {
                                          $('#beadSection').hide();
                                    }

                                    // Stones
                                    if (stones.length) {
                                          $('#stoneSection').show();
                                          let html = '';
                                          stones.forEach((s, i) => {
                                                html += `<tr>
                                <td>${i+1}</td>
                                <td>${s.type ?? ''}</td>
                                <td>${s.stones ?? ''}</td>
                                <td>${s.gram ?? ''}</td>
                                <td>${s.carat ?? ''}</td>
                                <td>${s.gram_rate ?? ''}</td>
                                <td>${s.carat_rate ?? ''}</td>
                                <td>${s.total_amount ?? ''}</td>
                            </tr>`;
                                          });
                                          $('#stone_table_body').html(html);
                                    } else {
                                          $('#stoneSection').hide();
                                    }

                                    // Diamonds
                                    if (diamonds.length) {
                                          $('#diamondSection').show();
                                          let html = '';
                                          diamonds.forEach((d, i) => {
                                                html += `<tr>
                                <td>${i+1}</td>
                                <td>${d.type ?? ''}</td>
                                <td>${d.diamonds ?? ''}</td>
                                <td>${d.color ?? ''}</td>
                                <td>${d.cut ?? ''}</td>
                                <td>${d.clarity ?? ''}</td>
                                <td>${d.carat ?? ''}</td>
                                <td>${d.carat_rate ?? ''}</td>
                                <td>${d.total_amount ?? ''}</td>
                            </tr>`;
                                          });
                                          $('#diamond_table_body').html(html);
                                    } else {
                                          $('#diamondSection').hide();
                                    }

                              } else {
                                    alert(response.Message || 'No data found');
                                    $('#dataContainer').addClass('d-none');
                              }
                        },
                        error: function(xhr) {
                              console.log(xhr.responseText);
                              alert('Error fetching data.');
                        }
                  });
            });
      });
</script>
@endsection