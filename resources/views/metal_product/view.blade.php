@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>View Metal Tagging</h1>
        <ul>
            <li>View</li>
            <li>Show</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif
    <!-- end of row -->
    <section class="contact-list">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-transparent text-right">

                    </div>
                    <div class="card-body" style="font-size: 14px;">
                        <div class="row">
                            <div class="col-md-9">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">Product:</td>
                                            <td>{{ $metal_product->product->name ?? '' }}
                                                {{ $metal_product->product->prefix ?? '' }}
                                            </td>
                                            <td class="font-weight-bold">Purchase:</td>
                                            <td>{{ $metal_product->metal_purchase->metal_purchase_no ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Tag No:</td>
                                            <td>{{ $metal_product->tag_no ?? '' }}</td>
                                            <td class="font-weight-bold">Warehouse:</td>
                                            <td>{{ $metal_product->warehouse->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Metal:</td>
                                            <td>{{ $metal_product->metal ?? '' }}</td>
                                            <td class="font-weight-bold">Scale Weight:</td>
                                            <td>{{ $metal_product->scale_weight ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Bead Weight:</td>
                                            <td>{{ $metal_product->bead_weight ?? '' }}</td>
                                            <td class="font-weight-bold">Stones Weight:</td>
                                            <td>{{ $metal_product->stones_weight ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Diamond Weight:</td>
                                            <td>{{ $metal_product->diamond_weight ?? '' }}</td>
                                            <td class="font-weight-bold">Net Weight:</td>
                                            <td>{{ $metal_product->net_weight ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Gross Weight:</td>
                                            <td>{{ $metal_product->gross_weight ?? '' }}</td>
                                            <td class="font-weight-bold">Purity(%):</td>
                                            <td>{{ $metal_product->purity ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Metal Rate:</td>
                                            <td>{{ $metal_product->metal_rate ?? '' }}</td>
                                            <td class="font-weight-bold">Total Metal Amount:</td>
                                            <td>{{ $metal_product->total_metal_amount ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Bead Price:</td>
                                            <td>{{ $metal_product->total_bead_amount ?? '' }}</td>
                                            <td class="font-weight-bold">Total Stones Price:</td>
                                            <td>{{ $metal_product->total_stones_amount ?? '' }}</td>

                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Diamond Price:</td>
                                            <td>{{ $metal_product->total_diamond_amount ?? '' }}</td>
                                            <td class="font-weight-bold">Other Charges:</td>
                                            <td>{{ $metal_product->other_charges ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Amount:</td>
                                            <td>{{ $metal_product->total_amount ?? '' }}</td>
                                            <td class="font-weight-bold">Saled:</td>
                                            <td>@if($metal_product->is_saled==1)<span class=" badge badge-success mr-3">Yes</span> @else <span class=" badge badge-danger mr-3">No</span>@endif</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><img src="{{ asset($metal_product->barcode) }}"
                                                    alt=""><br><span
                                                    style="font-family: fantasy;">{{ $metal_product->tag_no ?? '' }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="{{ asset($metal_product->picture) }}" alt="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <form action="{{url('metal-product/change-picture')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" id="id" value="{{$metal_product->id}}">
                                                    @error('id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">New Picture:<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="file" class="form-control" name="picture" id="picture"
                                                                    required>
                                                                @error('picture')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button class="btn btn-primary" id="submit" accesskey="s">Change</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($metal_product_bead->count() > 0)
                        <div class="row">
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
                                    <tbody>
                                        @foreach ($metal_product_bead as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->type ?? '' }}</td>
                                            <td>{{ $item->beads ?? 0 }}</td>
                                            <td>{{ $item->gram ?? 0 }}</td>
                                            <td>{{ $item->carat ?? 0 }}</td>
                                            <td>{{ $item->gram_rate ?? 0 }}</td>
                                            <td>{{ $item->carat_rate ?? 0 }}</td>
                                            <td>{{ $item->total_amount ?? 0 }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        @if ($metal_product_stone->count() > 0)
                        <div class="row">
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
                                    <tbody>
                                        @foreach ($metal_product_stone as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->type ?? '' }}</td>
                                            <td>{{ $item->stones ?? 0 }}</td>
                                            <td>{{ $item->gram ?? 0 }}</td>
                                            <td>{{ $item->carat ?? 0 }}</td>
                                            <td>{{ $item->gram_rate ?? 0 }}</td>
                                            <td>{{ $item->carat_rate ?? 0 }}</td>
                                            <td>{{ $item->total_amount ?? 0 }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if ($metal_product_diamond->count() > 0)
                        <div class="row">
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
                                    <tbody>
                                        @foreach ($metal_product_diamond as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->type ?? '' }}</td>
                                            <td>{{ $item->diamonds ?? 0 }}</td>
                                            <td>{{ $item->color ?? '' }}</td>
                                            <td>{{ $item->cut ?? '' }}</td>
                                            <td>{{ $item->clarity ?? '' }}</td>
                                            <td>{{ $item->carat ?? '' }}</td>
                                            <td>{{ $item->carat_rate ?? 0 }}</td>
                                            <td>{{ $item->total_amount ?? 0 }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
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