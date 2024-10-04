@extends('layouts.master')
@section('content')
    <div class="main-content pt-4">
        <div class="breadcrumb">
            <h1>View Finish Product</h1>
            <ul>
                <li>View</li>
                <li>Show</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <!-- end of row -->
        <section class="contact-list">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent text-right">

                        </div>
                        <div class="card-body" style="font-size: 14px;">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Product:</td>
                                                <td>{{$finish_product->product->name??''}} {{$finish_product->product->prefix??''}}</td>
                                                <td class="font-weight-bold">Purchase:</td>
                                                <td>{{$finish_product->ratti_kaat->ratti_kaat_no??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Tag No:</td>
                                                <td>{{$finish_product->tag_no??''}}</td>
                                                <td class="font-weight-bold">Warehouse:</td>
                                                <td>{{$finish_product->warehouse->name??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Karat:</td>
                                                <td>{{$finish_product->gold_carat??''}}</td>
                                                <td class="font-weight-bold">Scale Weight:</td>
                                                <td>{{$finish_product->scale_weight??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Bead Weight:</td>
                                                <td>{{$finish_product->bead_weight??''}}</td>
                                                <td class="font-weight-bold">Stones Weight:</td>
                                                <td>{{$finish_product->stones_weight??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Diamond Weight:</td>
                                                <td>{{$finish_product->diamond_weight??''}}</td>
                                                <td class="font-weight-bold">Net Weight:</td>
                                                <td>{{$finish_product->net_weight??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Waste (%):</td>
                                                <td>{{$finish_product->waste_per??''}}</td>
                                                <td class="font-weight-bold">Waste:</td>
                                                <td>{{$finish_product->waste??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Gross Weight:</td>
                                                <td>{{$finish_product->gross_weight??''}}</td>
                                                <td class="font-weight-bold">Laker:</td>
                                                <td>{{$finish_product->laker??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Making/gram:</td>
                                                <td>{{$finish_product->making_gram??''}}</td>
                                                <td class="font-weight-bold">Making:</td>
                                                <td>{{$finish_product->making??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Bead Price:</td>
                                                <td>{{$finish_product->bead_price??''}}</td>
                                                <td class="font-weight-bold">Stone Price:</td>
                                                <td>{{$finish_product->stones_price??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Diamond Price:</td>
                                                <td>{{$finish_product->diamond_price??''}}</td>
                                                <td class="font-weight-bold">Total Bead Price:</td>
                                                <td>{{$finish_product->total_bead_price??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Total Stones Price:</td>
                                                <td>{{$finish_product->total_stones_price??''}}</td>
                                                <td class="font-weight-bold">Total Diamond Price:</td>
                                                <td>{{$finish_product->total_diamond_price??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Gold Rate/gram:</td>
                                                <td>{{$finish_product->gold_rate??''}}</td>
                                                <td class="font-weight-bold">Total Gold Price:</td>
                                                <td>{{$finish_product->total_gold_price??''}}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Other Amount:</td>
                                                <td>{{$finish_product->other_amount??''}}</td>
                                                <td class="font-weight-bold">Total Amount:</td>
                                                <td>{{$finish_product->total_amount??''}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-3">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><img src="{{ asset($finish_product->barcode) }}"
                                                        alt=""><br><span
                                                        style="font-family: fantasy;">{{ $finish_product->tag_no ?? '' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="{{ asset($finish_product->picture) }}" alt="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                    <!-- end of col -->
                </div>
                <!-- end of row -->
            </div>
        </section>
    </div>
@endsection
@section('js')
@endsection
