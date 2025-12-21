function error(message) {
    toastr.error(message, "Error!", {
        showMethod: "slideDown",
        hideMethod: "slideUp",
        timeOut: 2e3,
    });
}
function success(message) {
    toastr.success(message, "Success!", {
        showMethod: "slideDown",
        hideMethod: "slideUp",
        timeOut: 2e3,
    });
}
var metalPurchaseOrderData = [];
var metal_purchase_order_sr = 0;
Clear();
function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
$("#warehouse_id").on("change", function () {
    var warehouse_id = $("#warehouse_id").val();
    $("#preloader").show();
    $.ajax({
        url: url_local + "/metal-sale-order/by-warehouse/" + warehouse_id,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            if (data.Success) {
                var data = data.Data;
                $("#metal_sale_order").empty();
                var row =
                    '<table class="table table-bordered" style="margin-bottom: 0px;">';
                row += "<tbody>";
                $.each(data, function (k, value) {
                    row += "<tr>";
                    row +=
                        '<td style="padding: 3px;"><a  id="MetalSaleOrder" href="javascript:void(0)" data-toggle="tooltip" data-id="' +
                        value.id +
                        '" data-original-title="Metal Sale order"><b>' +
                        value.metal_sale_order_no +
                        "</b></a></td>";
                    row += "</tr>";
                });
                row += "</tbody>";
                row += "</table>";
                $("#metal_sale_order").html(row);
                $("#preloader").hide();
            } else {
                error(data.Message);
                $("#preloader").hide();
            }
        },
    });
});

$("body").on("click", "#MetalSaleOrder", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var metal_metal_sale_order_id = $(this).data("id");
    $("td a.metal_sale_order_active").removeClass("metal_sale_order_active");
    $(this).addClass("metal_sale_order_active");
    $.ajax({
        url: url_local + "/metal-sale-order/get-detail/" + metal_metal_sale_order_id,
        type: "GET",
    }).done(function (data) {
        console.log(data);
        var data = data.Data;
        metalPurchaseOrderData = [];
        $("#metal_metal_purchase_order_products").empty();
        var metal_purchase_order_sr = 0;
        var rows = "";
        $.each(data, function (k, value) {
            metalPurchaseOrderData.push({
                // sr: i,
                product_id: value.product_id,
                product: value.product_name,
                category: value.category,
                metal: value.metal,
                purity: value.purity,
                design_no: value.design_no,
                net_weight: value.net_weight,
                description: value.description,
            });
        });
        $.each(metalPurchaseOrderData, function (e, val) {
            metal_purchase_order_sr = metal_purchase_order_sr + 1;
            metalPurchaseOrderData.sr = metal_purchase_order_sr;

            rows += `<tr id="${val.product_id
                }"><td>${metal_purchase_order_sr}</td><td>${val.product}</td><td>${val.category}</td>
                <td>${val.design_no}</td>
                <td>${val.metal}</td>
                <td>${val.purity}</td>
                <td style="text-align: right;">${val.net_weight
                }</td>
                <td>${val.description}</td>
                <td><a class="text-danger text-white metalpurchaseorderr${val.product_id
                }" onclick="MetalPurchaseOrderRemove(${val.product_id
                })"><i class="fa fa-trash"></i></a></td></tr>`;
        });
        console.log(rows);
        $("#metal_purchase_order_products").html(rows);
        Clear();
        MetalPurchaseOrderShort();
        $("#metal_sale_order_id").val(metal_sale_order_id);
    });
});

function addProduct() {
    $("#preloader").show();
    $("#metal_sale_order_id").val('');
    var product_id = $("#product_id").find(":selected").val();
    var product = $("#product_id").find(":selected").text();
    var category = $("#category").val();
    var design_no = $("#design_no").val();
    var metal = $("#metal").val();
    var purity = $("#purity").val();
    var net_weight = $("#net_weight").val();
    var description = $("#description").val();
    if (product_id == 0 || product_id == "") {
        error("Please Select Product!");
        $("#preloader").hide();
        return false;
    }
    if (category == 0 || category == "") {
        error("Please Enter Category!");
        $("#preloader").hide();
        return false;
    }
    if (design_no == 0 || design_no == "") {
        error("Please Enter Design No!");
        $("#preloader").hide();
        return false;
    }
    if (metal == 0 || metal == "") {
        error("Please Enter Metal!");
        $("#preloader").hide();
        return false;
    }
    if (purity == 0 || purity == "") {
        error("Please Enter Purity!");
        $("#preloader").hide();
        return false;
    }
    if (net_weight == 0 || net_weight == "") {
        error("Please Enter Net Weight!");
        $("#preloader").hide();
        return false;
    }
    if (description == 0 || description == "") {
        error("Please Enter Description!");
        $("#preloader").hide();
        return false;
    }
    var check = true;
    $.each(metalPurchaseOrderData, function (e, val) {
        if (
            val.product_id == product_id &&
            val.category == category &&
            val.design_no == design_no &&
            val.metal == metal
        ) {
            error("This product with same category, metal and design no is already added!");
            $("#preloader").hide();
            check = false;
            return false;
        }
    });
    if (check == false) {
        return;
    }

    var rows = "";

    metalPurchaseOrderData.push({
        // sr: i,
        product_id: product_id,
        product: product,
        category: category,
        design_no: design_no,
        metal: metal,
        purity: purity,
        net_weight: net_weight,
        description: description,
    });

    $.each(metalPurchaseOrderData, function (e, val) {
        metal_purchase_order_sr = metal_purchase_order_sr + 1;
        metalPurchaseOrderData.sr = metal_purchase_order_sr;

        rows += `<tr id="prow_${val.product_id}_${val.category}_${val.metal}_${val.design_no}"><td>${metal_purchase_order_sr}</td><td>${val.product}</td><td>${val.category}</td>
                <td>${val.design_no}</td>
                <td>${val.metal}</td>
                <td>${val.purity}</td>
                <td style="text-align: right;">${val.net_weight
            }</td>
                <td>${val.description}</td>
                <td><a class="text-danger text-white metalpurchaseorderr${val.product_id
            }" onclick="MetalPurchaseOrderRemove('${val.product_id}','${val.category}','${val.metal}','${val.design_no}')"><i class="fa fa-trash"></i></a></td></tr>`;
    });
    success("Product Added Successfully!");
    $("#metal_purchase_order_products").empty();
    console.log(rows);
    $("#metal_purchase_order_products").html(rows);
    Clear();
    MetalPurchaseOrderShort();
    $("#preloader").hide();
}

$("body").on("click", "#submit", function (e) {
    e.preventDefault();

    $("#preloader").show();
    // Validation logic
    if ($("#metal_purchase_order_date").val() == "") {
        error("Please select purchase date!");
        $("#metal_purchase_order_date").focus();
        $("#preloader").hide();
        return false;
    }

    if (
        $("#supplier_id").find(":selected").val() == "" ||
        $("#supplier_id").find(":selected").val() == 0
    ) {
        error("Please Select Supplier!");
        $("#supplier_id").focus();
        $("#preloader").hide();
        return false;
    }

    if (
        $("#warehouse_id").find(":selected").val() == "" ||
        $("#warehouse_id").find(":selected").val() == 0
    ) {
        error("Please Select warehouse!");
        $("#warehouse_id").focus();
        $("#preloader").hide();
        return false;
    }

    // Create FormData object for Ajax
    var formData = new FormData();
    formData.append("id", $("#id").val());
    formData.append("metal_purchase_order_date", $("#metal_purchase_order_date").val());
    formData.append("metal_delivery_date", $("#metal_delivery_date").val());
    formData.append("reference_no", $("#reference_no").val());
    formData.append("metal_sale_order_id", $("#metal_sale_order_id").val());
    formData.append("supplier_id", $("#supplier_id").find(":selected").val());
    formData.append("warehouse_id", $("#warehouse_id").find(":selected").val());

    formData.append("metalPurchaseOrderDetail", JSON.stringify(metalPurchaseOrderData));

    $.ajax({
        url: url_local + "/metal-purchase-order/store", // Laravel route
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false, // Important for file uploads
        contentType: false, // Important for file uploads
        dataType: "json",
        success: function (data) {
            if (data.Success) {
                success(data.Message);
                $("#preloader").hide();
                $("#submit").prop("disabled", true);

                setTimeout(function () {
                    $("#submit").prop("disabled", false);
                    window.location = url_local + "/metal-purchase-order";
                }, 1000); // Disable button for 1 second
            } else {
                error(data.Message);
                $("#preloader").hide();
            }
        },
        error: function (xhr, status, e) {
            error("An error occurred:");
            $("#preloader").hide();
        },
    });
});

function MetalPurchaseOrderRemove(product_id, category,metal, design_no) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        var item_index = "";
        var total = 0;
        $("#preloader").show();
        $.each(metalPurchaseOrderData, function (i, val) {
            if (
                val.product_id == product_id &&
                val.category == category &&
                val.design_no == design_no &&
                val.metal == metal
            ) {
                $("#prow_" + val.product_id + "_" + val.category + "_" + val.metal + "_" + val.design_no).remove();
                item_index = i;
                return false;
            }
        });

        // metalPurchaseOrderData.splice(item_index, 1);
        // var check = ".metalpurchaseorderr" + id;
        // $(check).closest("tr").remove();
        if (item_index !== "") {
            metalPurchaseOrderData.splice(item_index, 1);
        }
        success("Product Deleted Successfully!");
        MetalPurchaseOrderShort();
        $("#preloader").hide();
    });
}

function Clear() {
    $("#product_id option[value='0']").remove();
    $("#product_id").append(
        '<option disabled selected value="0">--Select Product--</option>'
    );
    $("#metal").append(
        '<option disabled selected value="0">--Select Metal--</option>'
    );
    $("#category").val("");
    $("#design_no").val("");
    $("#purity").val(0);
    $("#net_weight").val(0);
    $("#description").val("");
}
// Short
function MetalPurchaseOrderShort() {
    var tbody, j, x, y;
    tbody = document.getElementById("metal_purchase_order_products");
    var switching = true;

    // Run loop until no switching is needed
    while (switching) {
        switching = false;
        var rows = tbody.rows;

        // Loop to go through all rows
        for (j = 1; j < rows.length - 1; j++) {
            var Switch = false;

            // Fetch 2 elements that need to be compared
            x = rows[j].getElementsByTagName("TD")[0];
            y = rows[j + 1].getElementsByTagName("TD")[0];

            // Check if 2 rows need to be switched
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                // If yes, mark Switch as needed and break loop
                Switch = true;
                break;
            }
        }
        if (Switch) {
            // Function to switch rows and mark switch as completed
            rows[j].parentNode.insertBefore(rows[j + 1], rows[j]);
            switching = true;
        }
    }
}
