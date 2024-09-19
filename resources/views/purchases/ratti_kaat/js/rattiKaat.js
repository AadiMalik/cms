

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

var productData = [];
var poId = "";
var ID = "";
var purchase_total = 0;
var tax_total = 0;
$("#show_hide").on("click", function (e) {
    $("#purchase_form_input").toggle();
});
$(document).ready(function () {
    $('#total_bead_amount').trigger('keyup');
    $('#total_stones_amount').trigger('keyup');
    $('#total_diamond_amount').trigger('keyup');
    $('#scale_weight').trigger('keyup');
    $('#beads_weight').trigger('keyup');
    $('#other_charge').trigger('keyup');
    
});


$("#StonesWeightButton").click(function () {
    $("#stonesWeightForm").trigger("reset");
    $("#stonesWeightModel").modal("show");
});

$("#diamondCartButton").click(function () {
    $("#diamondCartForm").trigger("reset");
    $("#diamondCartModel").modal("show");
});

$("#ChangeKaatButton").click(function () {
    $("#chnageKaatForm").trigger("reset");
    $("#changeKaatModel").modal("show");
});

$("body").on("keyup", "#scale_weight,#beads_weight, #stones_weight,#diamond_carat",
    function (event) {
        var scale_weight = $("#scale_weight").val();
        var beads_weight = $("#beads_weight").val();
        var stones_weight = $("#stones_weight").val();
        var diamond_carat = $("#diamond_carat").val();
        var net_weight = 0;
        net_weight = scale_weight - (beads_weight + stones_weight + diamond_carat);
        $("#net_weight").val(net_weight.toFixed(3));
    }
);

function totalAmount(){
   var total_bead_amount = $("#total_bead_amount").val();
   var total_stones_amount = $("#total_stones_amount").val();
   var total_diamond_amount = $("#total_diamond_amount").val();
   var other_charge = $("#other_charge").val();
   var total_amount = (total_bead_amount * 1) + (total_stones_amount * 1) + (total_diamond_amount * 1) + (other_charge * 1);
   $("#total_amount").val(total_amount.toFixed(3));
}
$("#total_bead_amount").on("change", function (event) {
    totalAmount();
});
$("#total_stones_amount").on("change", function (event) {
    totalAmount();
});
$("#total_diamond_amount").on("change", function (event) {
    totalAmount();
});
$("#other_charge").on("change", function (event) {
    totalAmount();
});

$("body").on("keyup", "#modal_total_qty", function (event) {
    var quantity = $("#modal_total_qty").val();
    var price = $("#modal_product_price").val();
    var taxPrecent = $("#modal_product_tax").val();
    var sub = 0;
    var total = 0;
    taxRate = 0;
    tax = taxPrecent / 100;
    if (tax > 0) {
        taxRate = tax;
        netPrice = quantity * price;
        sub = netPrice * taxRate;
        total = sub + netPrice;
    } else {
        netPrice = quantity * price;
        total = netPrice;
    }

    $("#modal_product_tax_amount").val(sub.toFixed(2));
    $("#modal_total_price").val(total.toFixed(2));

    var i = $("#example tbody tr").length;
});
$("body").on(
    "keyup",
    "#modal_product_quantity,#modal_product_price, #modal_product_tax",
    function (event) {
        getTotalByPackage();
        var rdata = $(this).attr("data-id");
        var quantity = $("#modal_product_quantity").val();
        var price = $("#modal_product_price").val();
        var taxPrecent = $("#modal_product_tax").val();
        var sub = 0;
        var total = 0;
        taxRate = 0;
        tax = taxPrecent / 100;
        if (tax > 0) {
            taxRate = tax;
            netPrice = quantity * price;
            sub = netPrice * taxRate;
            total = sub + netPrice;
        } else {
            netPrice = quantity * price;
            total = netPrice;
        }

        $("#modal_product_tax_amount").val(sub.toFixed(2));
        $("#modal_total_price").val(total.toFixed(2));

        var i = $("#example tbody tr").length;
    }
);
$("body").on("keyup", "#modal_product_tax_amount", function (event) {
    var quantity = $("#modal_product_quantity").val();
    var price = $("#modal_product_price").val();
    var tax_amount = $("#modal_product_tax_amount").val();
    var total = 0;
    netPrice = quantity * price;
    total = (tax_amount * 1) + netPrice;
    $("#modal_total_price").val(total);
});
$("body").on("click", "#submit", function (e) {
    e.preventDefault();
    if ($("#bill_no").val() == "") {
        error("Please Fill Bill No!");
        $("#bill_no").focus();
        return false;
    }

    if ($("#order_date").val() == "") {
        error("Please Enter the Order Date!");
        $("#order_date").focus();
        return false;
    }
    if ($("#required_date").val() == "") {
        error("Please Enter Delivery Date !");
        $("#required_date").focus();
        return false;
    }
    if ($("#vendor").find(":selected").val() == 0) {
        error("Please select Vendor!");
        $("#vendor").focus();
        return false;
    }
    if ($("#warehouse_id").find(":selected").val() == 0) {
        error("Please select Warehouse!");
        $("#warehouse_id").focus();
        return false;
    }
    if ($("#purchase_account").find(":selected").val() == 0) {
        error("Please select Purchase Account!");
        $("#purchase_account").focus();
        return false;
    }
    if ($("#paid").val() > 0 && $("#paid_account").find(":selected").val() == '') {
        error("Please select Paid Account!");
        $("#paid_account").focus();
        return false;
    }
    if ($("#tax_total").val() > 0 && $("#tax_account").find(":selected").val() == '') {
        error("Please select Tax Account!");
        $("#tax_account").focus();
        return false;
    }
    var rowCount = $("table tbody tr").length;
    if (rowCount < 1) {
        error("No item is added!");

        return false;
    }
    var submitEntry = {};
    submitEntry.id = $("#id").val();
    submitEntry.poId = $("#poId").val();
    submitEntry.bill_no = $("#bill_no").val();
    submitEntry.vendor = $("#vendor").find(":selected").val();
    submitEntry.warehouse_id = $("#warehouse_id").find(":selected").val();
    submitEntry.datePost = $("#order_date").val();
    submitEntry.required_date = $("#required_date").val();
    submitEntry.vendor = $("#vendor").find(":selected").val();
    submitEntry.reference = $("#reference").val();
    submitEntry.purchase_account = $("#purchase_account").find(":selected").val();
    submitEntry.fare = $("#fare").val();
    submitEntry.fare_account = $("#fare_account").find(":selected").val();
    submitEntry.paid = $("#paid").val();
    submitEntry.paid_account = $("#paid_account").find(":selected").val();
    submitEntry.tax_account = $("#tax_account").find(":selected").val();
    submitEntry.purchaseDetail = productData;

    $.ajax({
        url: url_local + "/accounting/store-purchase",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: submitEntry,
        dataType: "json",

        success: function (data) {
            if (data.Success) {
                success(data.Message);
                $("#submit").prop("disabled", true);

                setTimeout(function () {
                    $("#submit").prop("disabled", false);

                    window.location = url_local + "/accounting/list-purchase";
                }, 1000); // Disable button for 1 seconds
            } else {
                error(data.Message);
            }
        },
    });
});

$("#supplier_id").on("change", function () {
    var supplier_id = $("#supplier_id").find(":selected").val();

    $.ajax({
        type: "get",
        url: url_local + "/suppliers/get-by-id/" + supplier_id,
    }).done(function (data) {
        var data = data.Data;
        $("#ratti_kaat").val(data.kaat);
    });
});

$("#package").on("change", function () {
    getTotalByPackage();
});
function getTotalByPackage() {
    var package_id = $("#package").find(":selected").val();
    var bundle_qty = $("#modal_product_quantity").val();
    $.ajax({
        type: "get",
        url: url_local + "/edit-package/" + package_id,
    }).done(function (data) {
        var data = data.Data;
        $("#modal_total_qty").val(data.qty * bundle_qty);
        // var quantity = data.qty * bundle_qty;
        // var price = $("#modal_product_price").val();
        // var taxPrecent = $("#modal_product_tax").val();
        // var sub = 0;
        // var total = 0;
        // taxRate = 0;
        // tax = taxPrecent / 100;
        // if (tax > 0) {
        //   taxRate = tax;
        //   netPrice = quantity * price;
        //   sub = netPrice * taxRate;
        //   total = sub + netPrice;
        // } else {
        //   netPrice = quantity * price;
        //   total = netPrice;
        // }
        // $("#modal_product_tax_amount").val(sub.toFixed(2));
        // $("#modal_total_price").val(total.toFixed(2));
    });
}
function Short() {
    var table, j, x, y;
    table = document.getElementById("example");
    var switching = true;

    // Run loop until no switching is needed
    while (switching) {
        switching = false;
        var rows = table.rows;

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
var i = 0;
function addProductRequest(id = null) {
    var productName = $("#product_id option:selected").text();
    var productId = $("#product_id option:selected").val();
    var scale_weight = $("#scale_weight").val();
    var description = $("#description").val();
    var beads_weight = $("#beads_weight").val();
    var stones_weight = $("#stones_weight").val();
    var diamond_carat = $("#diamond_carat").val();
    var net_weight = $("#net_weight").val();
    var ratti_kaat = $("#ratti_kaat").val();
    var kaat = $("#kaat").val();
    var pure_payable = $("#pure_payable").val();
    var other_charge = $("#other_charge").val();
    var total_amount = $("#total_amount").val();
    if ($("#product_id").find(":selected").val() == 0) {
        error("Product is not selected!");
        return false;
    }
    if (scale_weight == 0 || scale_weight == "") {
        error("Please Enter Scale Weight!");
        return false;
    }
    if (description == "") {
        error("Please Enter Description!");
        return false;
    }
    if (ratti_kaat == 0 || ratti_kaat == "") {
        error("Select Supplier/Karigar or Enter Ratti Kaat!");
        return false;
    }
    var check = true;
    $.each(productData, function (e, val) {
        if (val.product_id == $("#product_id option:selected").val()) {
            error("Product is already added !");
            check = false;
            return false;
        }
    });
    if (check == false) {
        return;
    }
    i = i + 1;
    var rows = "";

    rows += `<tr id=${productId}><td>${i}</td><td>${productName}</td><td>${description}</td><td style="text-align: right;">${scale_weight}</td><td style="text-align: right;" >${beads_weight}</td>
          <td style="text-align: right;" >${stones_weight}</td><td style="text-align: right;" >${diamond_carat}</td><td style="text-align: right;" >${net_weight}</td><td style="text-align: right;" >${ratti_kaat}</td>
          <td style="text-align: right;" >${kaat}</td><td style="text-align: right;" >${pure_payable}</td><td style="text-align: right;" >${other_charge}</td><td style="text-align: right;" >${total_amount}</td><td>
          <a class="text-danger text-white r${productId}" onclick="Remove(${productId})"><i class="fa fa-trash"></i></a></td></tr>`;
    total = $("#total").val() * 1 + total_amount * 1;
    $("#total").val(total.toFixed(3));
    var tbody = $("#example tbody");
    success("Product Added Successfully!");
    tbody.prepend(rows);

    productData.push({
        // sr: i,
        product_id: productId,
        product_name: productName,
        description: description,
        scale_weight: scale_weight,
        beads_weight: beads_weight,
        stones_weight: stones_weight,
        diamond_carat: diamond_carat,
        net_weight: net_weight,
        ratti_kaat: ratti_kaat,
        kaat: kaat,
        pure_payable: pure_payable,
        other_charge: other_charge,
        total_amount: total_amount,
    });
    Short();
    Clear();
}

function updateProductRequest(id) {
    // var sr = $("#sr").val();
    var productName = $("#product_id option:selected").text();
    var productId = $("#product_id option:selected").val();
    var productPackage = $("#package option:selected").text();
    var productPackage_id = $("#package option:selected").val();
    var productUnit = $("#modal_product_unit").val();
    var modalProductQuantity = $("#modal_product_quantity").val();
    if (modalProductQuantity < 1) {
        error("Product can't be less than 1 !");

        return false;
    }
    var modalProductPrice = $("#modal_product_price").val();
    if (modalProductPrice < 1) {
        error("Product Price can't be less than 1 !");

        return false;
    }
    var modalProductTax = $("#modal_product_tax").val();
    var modalProductTaxAmount = $("#modal_product_tax_amount").val();
    var modalTotalQty = $("#modal_total_qty").val();
    var modalTotalPrice = $("#modal_total_price").val();

    if ($("#product_id").find(":selected").val() == 0) {
        error("Product is not selected!");
        return false;
    }
    if ($("#package").find(":selected").val() == 0) {
        error("Package is not selected!");
        return false;
    }
    if ($("#modal_product_quantity").val() == "") {
        error("Product Quantity Field is Required!");
        return false;
    }
    if ($("#modal_product_tax").val() == "") {
        error("Purchase Tax Field is Required!");
        return false;
    }
    if ($("#modal_product_tax_amount").val() == "") {
        error("Purchase Tax Amount Field is Required!");
        return false;
    }
    if (id != null) {
        purchaseRequestDelete(productId);
    }
    $.each(productData, function (e, val) {
        if (val.productId == $("#product_id option:selected").val()) {
            error("Product is already added !");
            return false;
        }
    });
    productData.push({
        //   sr: $("#sr").val(),
        productId: $("#product_id option:selected").val(),
        pName: $("#product_id option:selected").text(),
        productPackage_id: $("#package option:selected").val(),
        productPackage: $("#package option:selected").text(),
        productQuantity: modalProductQuantity,
        productUnit: productUnit,
        productPrice: modalProductPrice,
        productTax: modalProductTax,
        productTaxAmount: modalProductTaxAmount,
        TotalQTY: modalTotalQty,
        totalPrice: modalTotalPrice,
    });
    var rows = "";

    // rows += `<tr id=${productId}><td>${productName}</td><td>${productPackage}</td><td style="text-align: center;" >${modalProductQuantity}</td><td>${productUnit}</td></tr>`;
    rows += `<tr id=${productId}><td>${productName}</td><td>${productPackage}</td><td>${productUnit}</td><td style="text-align: center;" >${modalProductQuantity}</td>
          <td style="text-align: center;" >${modalProductPrice}</td><td style="text-align: center;" >${modalProductTax}</td><td style="text-align: center;" >${modalTotalQty}</td><td style="text-align: center;" >${modalTotalPrice}</td><td>
          <a class="btn btn-warning" onclick="editProduct(${productId})" id="EditProduct">Edit</a><a class="btn btn-danger text-white r${productId}" onclick="Remove(${productId})">Delete</a></td></tr>`;
    var tbody = $("#example tbody");
    var old_total = $("#purchase_total").val() * 1 - $("#old_price").val() * 1;
    purchase_total = old_total + modalTotalPrice * 1;
    $("#purchase_total").val(purchase_total);
    $("#paid").val(purchase_total);
    tbody.prepend(rows);

    $("#New-Entry-Modal").modal("hide");
    $("#modal_product_quantity").val(0);
    $("#modal_product_unit").val("");

    // Short();
}

function purchaseRequestDelete(row_id) {
    var item_index = "";

    $.each(productData, function (i, val) {
        if (val.productId == row_id) {
            $("#" + row_id).hide();
            item_index = i;
            return false;
        }
    });
    var check = ".r" + row_id;
    $(check).closest("tr").remove();
    productData.splice(item_index, 1);
}
poId = $("#poId").val() != null ? $("#poId").val() : null;
$.ajax({
    type: "GET",
    url: url_local + "/accounting/get-purchase-detail/" + poId,
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },

    success: function (data) {
        //   console.log(data);
        i = 0;
        productData = data.Data;

        var rows = "";
        $.each(productData, function (e, val) {
            i = i + 1;
            productData.sr = i;
            purchase_total = purchase_total * 1 + val.totalPrice * 1;
            rows += `<tr id=${val.productId} ><td><input type="text" disabled style="border:none; background:none; width:100%;" value="${val.pName}"> <input type="hidden" value="${val.productId}"></td><td><input type="text" disabled style="border:none; background:none; width:100%;" value="${val.productPackage}"> <input type="hidden" value="${val.productPackage_id}"></td><td><input type="text" disabled style="border:none; background:none; width:100%;" value="${val.productUnit}"></td><td ><input type="text" disabled style="border:none; background:none; width:100%; text-align:center;" value="${val.productQuantity}"></td>
                  <td><input type="text" disabled style="border:none; background:none; width:100%; text-align:center;" value="${val.productPrice}"></td><td><input type="text" disabled style="border:none; background:none; width:100%; text-align:center;" value="${val.productTax}"></td><td ><input type="text" disabled style="border:none; background:none; width:100%; text-align:center;" value="${val.TotalQTY}"></td><td ><input type="text" disabled style="border:none; background:none; width:100%; text-align:center;" value="${val.totalPrice}"></td><td>  
                  <a class="btn btn-warning" onclick="editProduct(${val.productId})" id="EditProduct">Edit</a>
                                      <a class="btn btn-danger text-white  r${val.productId}" onclick="Remove(${val.productId})">Delete</a></td></tr>`;
        });

        $("#purchase_total").val(purchase_total.toFixed(2));
        // $("#paid").val(purchase_total);
        var tbody = $("#example tbody");
        tbody.prepend(rows);
    },
});
function Remove(id) {
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
        $.each(productData, function (i, val) {
            if (val.product_id == id) {
                total = $("#total").val() * 1 - val.totalPrice * 1;
                $("#total").val(total > 0 ? total : 0);
                $("#" + id).hide();
                item_index = i;
                return false;
            }
        });

        productData.splice(item_index, 1);
        var check = ".r" + id;
        $(check).closest("tr").remove();
        success("Product Deleted Successfully!");
        Short();
    });
}
function editProduct(id) {
    Clear();
    $("#save").hide();
    $("#update").show();
    $("#New-Entry-Modal").modal("show");
    var item_sr = "";
    var item_id = "";
    var item_name = "";
    var item_unit = "";
    var item_quantity = "";
    $.each(productData, function (i, val) {
        if (val.productId == id) {
            item_sr = val.sr;
            item_id = val.productId;
            item_name = val.pName;
            item_package_id = val.productPackage_id;
            item_package = val.productPackage;
            item_unit = val.productUnit;
            item_price = val.productPrice;
            item_tax = val.productTax;
            item_tax_amount = val.productTaxAmount;
            item_quantity = val.productQuantity;
            item_total_quantity = val.TotalQTY;
            item_total_price = val.totalPrice;
            item_price = val.productPrice;
            $("#package").empty();
            $.ajax({
                type: "get",
                url: url_local + "/accounting/find-product-unit/" + id,
            }).done(function (data) {
                var data = data.Data;
                $.each(data.package, function (key, value) {
                    $("#package").append(
                        '<option value="' + value.id + '">' + value.name + "</option>"
                    );
                });
            });
            return false;
        }
    });
    $("#sr").val(item_sr);
    $("#product_id").val(item_id);
    $("#product_id").append(
        '<option selected value="' + item_id + '">' + item_name + "</option>"
    );
    $("#package").val(item_package_id);
    $("#modal_product_unit").val(item_unit);
    $("#modal_product_price").val(item_price);
    $("#modal_product_tax").val(item_tax);
    $("#modal_product_tax_amount").val(item_tax_amount);
    $("#modal_total_price").val(parseFloat(item_total_price));
    $("#old_price").val(parseFloat(item_total_price));
    $("#modal_product_quantity").val(parseFloat(item_quantity));
    $("#modal_total_qty").val(parseFloat(item_total_quantity));
    $("#modal_total_price").val(parseFloat(item_total_price));

    $("#product_id").prop("disabled", true);
    $("#modelHeading").html("Edit Product");
}
function Clear() {
    $("#product_id option[value='0']").remove();
    $("#product_id").append(
        '<option disabled selected value="0">--Select Product--</option>'
    );
    $("#scale_weight").val(0);
    $("#description").val('');
    $("#beads_weight").val(0);
    $("#stones_weight").val(0);
    $("#diamond_carat").val(0);
    $("#net_weight").val(0);
    $("#kaat").val(0);
    $("#pure_payable").val(0);
    $("#other_charge").val(0);
    $("#total_amount").val(0);
}