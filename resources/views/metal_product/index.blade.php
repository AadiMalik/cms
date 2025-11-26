@extends('layouts.master')
@section('content')
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1>Metal Tagging</h1>
        <ul>
            <li>List</li>
            <li>All</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
    @endif
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-header text-right bg-transparent">
                    @can('tagging_metal_product_create')
                    <a class="btn btn-primary btn-md m-1" href="{{ url('metal-product/create') }}"><i
                            class="fa fa-plus text-white mr-2"></i> Add Tagging</a>
                    @endcan
                    @can('tagging_metal_product_view')
                    <a class="btn btn-info btn-md m-1" href="javascript:void(0)" id="tagPrintBtn"><i
                            class="fa fa-print text-white mr-2"></i> Tag Print</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="metal_product_table" class="table table-striped display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Parent</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Warehouse</th>
                                    <th scope="col">Tag No</th>
                                    <th scope="col">Bead Wt</th>
                                    <th scope="col">Stone Wt</th>
                                    <th scope="col">Scale Wt</th>
                                    <th scope="col">Net Wt</th>
                                    <th scope="col">Gross Wt</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Is Parent</th>
                                    <th scope="col">Saled</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of col-->
    </div>
    <!-- end of row-->
</div>
@include('metal_product/Modal/TagPrint')
@endsection
@section('js')
@include('includes.datatable', [
'columns' => "
{data: 'parent' , name: 'parent' , 'sortable': false , searchable: false},
{data: 'product' , name: 'product' , 'sortable': false , searchable: false},
{data: 'warehouse' , name: 'warehouse' , 'sortable': false , searchable: false},
{data: 'tag_no' , name: 'tag_no'},
{data: 'bead_weight' , name: 'bead_weight'},
{data: 'stones_weight' , name: 'stones_weight'},
{data: 'scale_weight' , name: 'scale_weight'},
{data: 'net_weight' , name: 'net_weight'},
{data: 'gross_weight' , name: 'gross_weight'},
{data: 'total_amount' , name: 'total_amount'},
{data: 'is_parent' , name: 'is_parent' , 'sortable': false , searchable: false},
{data: 'saled' , name: 'saled' , 'sortable': false , searchable: false},
{data: 'status' , name: 'status' , 'sortable': false , searchable: false},
{data: 'location' , name: 'location' , 'sortable': false , searchable: false},
{data: 'action' , name: 'action' , 'sortable': false , searchable: false},",
'route' => 'metal-product/data',
'buttons' => false,
'pageLength' => 10,
'class' => 'metal_product_table',
'variable' => 'metal_product_table',
])

<script>
    $(document).ready(function() {
        $('#tag_products').select2();
    });
    var url_local = "{{ url('/') }}";

    function errorMessage(message) {

        toastr.error(message, "Error", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });

    }

    function successMessage(message) {

        toastr.success(message, "Success", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });

    }
    $("#tagPrintBtn").click(function() {
        $("#id").val("");
        $("#tagPrintForm").trigger("reset");
        $("#tagPrintModel").modal("show");
    });
    $("body").on("click", "#search_tag", function() {
        $("#preloader").show();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        $.ajax({
            url: url_local + "/metal-product/get-by-date?start_date=" + start_date + "&end_date=" + end_date,
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(data) {
                console.log(data);
                var data = data.Data;
                $("#tag_products").empty();
                var tags = '';
                $.each(data, function(key, value) {
                    tags +=
                        '<option value="' +
                        value.id +
                        '">' +
                        value.tag_no + " </option>";
                });
                $("#tag_products").append(tags);
                $("#preloader").hide();
            },
        });
    });
    $("body").on("click", "#printBtn", function() {
        var tag_products = $("#tag_products").val();
        if (tag_products && tag_products.length % 2 === 0) {
            var finalUrl = `${url_local}/metal-product/print?tag_products=${encodeURIComponent(tag_products)}`;
            window.location.href = finalUrl;
        } else {
            errorMessage("The number of selected items is odd.");
        }

    });
    $("body").on("click", "#status", function() {
        var metal_product_id = $(this).data("id");
        $.ajax({
                type: "get",
                url: "{{ url('metal-product/status') }}/" + metal_product_id,
            })
            .done(function(data) {
                if (data.Success) {
                    successMessage(data.Message);
                    initDataTablemetal_product_table();
                } else {
                    errorMessage(data.Message);
                }
            })
            .catch(function(err) {
                errorMessage(err.Message);
            });
    });
    $("body").on("click", "#deleteMetalProduct", function() {
        var metal_product_id = $(this).data("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                        type: "get",
                        url: "{{ url('metal-product/destroy') }}/" + metal_product_id,
                    })
                    .done(function(data) {
                        if (data.Success) {
                            successMessage(data.Message);
                            initDataTablemetal_product_table();
                        } else {
                            errorMessage(data.Message);
                        }
                    })
                    .catch(function(err) {
                        errorMessage(err.Message);
                    });
            }
        });
    });
    $("body").on('change', '#location-dropdown', function() {
        let itemId = $(this).data('id');
        let locationId = $(this).val();

        // Send AJAX request to update the location
        $.ajax({
            url: "{{ url('metal-product/location-update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: itemId,
                metal_product_location_id: locationId
            },
            success: function(data) {
                if (data.Success) {
                    successMessage(data.Message);
                    initDataTablemetal_product_table();
                } else {
                    errorMessage(data.Message);
                }
            }
        });
    });
</script>
@endsection