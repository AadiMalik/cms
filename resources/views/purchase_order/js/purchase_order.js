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
var purchaseOrderData = [];
var purchase_order_sr = 0;
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
        url: url_local + "/sale-order/by-warehouse/" + warehouse_id,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            if (data.Success) {
                var data = data.Data;
                $("#sale_order").empty();
                var row =
                    '<table class="table table-bordered" style="margin-bottom: 0px;">';
                row += "<tbody>";
                $.each(data, function (k, value) {
                    row += "<tr>";
                    row +=
                        '<td style="padding: 3px;"><a  id="SaleOrder" href="javascript:void(0)" data-toggle="tooltip" data-id="' +
                        value.id +
                        '" data-original-title="Sale order"><b>' +
                        value.sale_order_no +
                        "</b></a></td>";
                    row += "</tr>";
                });
                row += "</tbody>";
                row += "</table>";
                $("#sale_order").html(row);
                $("#preloader").hide();
            } else {
                error(data.Message);
                $("#preloader").hide();
            }
        },
    });
});

$("body").on("click", "#SaleOrder", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var sale_order_id = $(this).data("id");
    $("td a.sale_order_active").removeClass("sale_order_active");
    $(this).addClass("sale_order_active");
    $.ajax({
        url: url_local + "/sale-order/get-detail/" + sale_order_id,
        type: "GET",
    }).done(function (data) {
        console.log(data);
        var data = data.Data;
        $("#purchase_order_products").empty();
        var purchase_order_sr =0;
        var rows = "";
        $.each(data, function (k, value) {
            purchaseOrderData.push({
                // sr: i,
                category: value.category,
                design_no: value.design_no,
                net_weight: value.net_weight,
                description: value.description,
            });
        });
        $.each(purchaseOrderData, function (e, val) {
            purchase_order_sr = purchase_order_sr + 1;
            purchaseOrderData.sr = purchase_order_sr;

            rows += `<tr id="${
                val.category + "_" + val.design_no
            }"><td>${purchase_order_sr}</td><td>${val.category}</td>
                <td>${val.design_no}</td><td style="text-align: right;">${
                val.net_weight
            }</td>
                <td>${val.description}</td>
                <td><a class="text-danger text-white purchaseorderr${
                    val.category + "_" + val.design_no
                }" onclick="PurchaseOrderRemove(${
                val.category + "_" + val.design_no
            })"><i class="fa fa-trash"></i></a></td></tr>`;
        });
        console.log(rows);
        $("#purchase_order_products").html(rows);
        Clear();
        PurchaseOrderShort();
        $("#sale_order_id").val(sale_order_id);
    });
});

function addProduct() {
    $("#preloader").show();
    var category = $("#category").val();
    var design_no = $("#design_no").val();
    var net_weight = $("#net_weight").val();
    var description = $("#description").val();

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
    $.each(purchaseOrderData, function (e, val) {
        if (
            val.category + "_" + val.design_no ==
            $("#category").val() + "_" + $("#design_no").val()
        ) {
            error("Product is already added !");
            $("#preloader").hide();
            check = false;
            return false;
        }
    });
    if (check == false) {
        return;
    }

    var rows = "";

    purchaseOrderData.push({
        // sr: i,
        category: category,
        design_no: design_no,
        net_weight: net_weight,
        description: description,
    });

    $.each(purchaseOrderData, function (e, val) {
        purchase_order_sr = purchase_order_sr + 1;
        purchaseOrderData.sr = purchase_order_sr;

        rows += `<tr id="${
            val.category + "_" + val.design_no
        }"><td>${purchase_order_sr}</td><td>${val.category}</td>
                <td>${val.design_no}</td><td style="text-align: right;">${
            val.net_weight
        }</td>
                <td>${val.description}</td>
                <td><a class="text-danger text-white purchaseorderr${
                    val.category + "_" + val.design_no
                }" onclick="PurchaseOrderRemove(${
            val.category + "_" + val.design_no
        })"><i class="fa fa-trash"></i></a></td></tr>`;
    });
    success("Product Added Successfully!");
    $("#purchase_order_products").empty();
    console.log(rows);
    $("#purchase_order_products").html(rows);
    Clear();
    PurchaseOrderShort();
    $("#preloader").hide();
}

$("body").on("click", "#submit", function (e) {
    e.preventDefault();

    $("#preloader").show();
    // Validation logic
    if ($("#purchase_order_date").val() == "") {
        error("Please select sale date!");
        $("#purchase_order_date").focus();
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
    formData.append("purchase_order_date", $("#purchase_order_date").val());
    formData.append("supplier_id", $("#supplier_id").find(":selected").val());
    formData.append("warehouse_id", $("#warehouse_id").find(":selected").val());

    formData.append("purchaseOrderDetail", JSON.stringify(purchaseOrderData));

    $.ajax({
        url: url_local + "/purchase-order/store", // Laravel route
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
                    window.location = url_local + "/purchase-order";
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

function PurchaseOrderRemove(id) {
    console.log(id);
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
        $.each(purchaseOrderData, function (i, val) {
            if (val.category + "_" + val.design_no == id) {
                $("#" + id).hide();
                item_index = i;
                return false;
            }
        });

        purchaseOrderData.splice(item_index, 1);
        var check = ".purchaseorderr" + id;
        $(check).closest("tr").remove();
        success("Product Deleted Successfully!");
        PurchaseOrderShort();
        $("#preloader").hide();
    });
}

function Clear() {
    $("#category").val("");
    $("#design_no").val("");
    $("#net_weight").val(0);
    $("#description").val("");
}
// Short
function PurchaseOrderShort() {
    var tbody, j, x, y;
    tbody = document.getElementById("purchase_order_products");
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
