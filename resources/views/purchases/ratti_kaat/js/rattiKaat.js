

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
    $('#bead_weight').trigger('keyup');
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
    if ($("#supplier_id").find(":selected").val() == 0) {
        error("Supplier is not selected!");
        return false;
    }
    $("#chnageKaatForm").trigger("reset");
    $("#changeKaatModel").modal("show");
});

//Function
function netWeight() {
    var scale_weight = $("#scale_weight").val();
    var bead_weight = $("#bead_weight").val();
    var stones_weight = $("#stones_weight").val();
    var diamond_carat = $("#diamond_carat").val();
    var net_weight = 0;
    net_weight = scale_weight * 1 - (bead_weight * 1 + stones_weight * 1 + diamond_carat * 1);
    $("#net_weight").val(net_weight.toFixed(3)).trigger("keyup");
}

function totalAmount() {
    var total_bead_amount = $("#total_bead_amount").val();
    var total_stones_amount = $("#total_stones_amount").val();
    var total_diamond_amount = $("#total_diamond_amount").val();
    var other_charge = $("#other_charge").val();
    var total_amount = (total_bead_amount * 1) + (total_stones_amount * 1) + (total_diamond_amount * 1) + (other_charge * 1);
    $("#total_amount").val(total_amount.toFixed(3));
}

//Total weight

$("body").on("keyup", "#scale_weight",
    function (event) {
        netWeight()
    }
);
$("#bead_weight").on("keyup", function (event) {
    netWeight();
});
$("#stones_weight").on("keyup", function (event) {
    netWeight();
});
$("#diamond_carat").on("keyup", function (event) {
    netWeight();
});

//Kaat Calulation
$("#net_weight").on("keyup", function (event) {
    var net_weight = $("#net_weight").val();
    var supplier_kaat = $("#supplier_kaat").val();
    var kaat = (net_weight / 96) * supplier_kaat;
    $("#kaat").val(kaat.toFixed(3)).trigger("keyup");
});

// pure payable cal
$("#kaat").on("keyup", function (event) {
    var kaat = $("#kaat").val();
    var net_weight = $("#net_weight").val();
    var pure_payable = (net_weight * 1) - (kaat * 1);
    $("#pure_payable").val(pure_payable.toFixed(3));
});
//Total Amount

$("#total_bead_amount").on("keyup", function (event) {
    totalAmount();
});
$("#total_stones_amount").on("keyup", function (event) {
    totalAmount();
});
$("#total_diamond_amount").on("keyup", function (event) {
    totalAmount();
});
$("#other_charge").on("keyup", function (event) {
    totalAmount();
});



$("#supplier_id").on("change", function () {
    var supplier_id = $("#supplier_id").find(":selected").val();

    $.ajax({
        type: "get",
        url: url_local + "/suppliers/get-by-id/" + supplier_id,
    }).done(function (data) {
        var data = data.Data;
        $("#supplier_kaat").val(data.kaat);
    });
});
// Change Kaat
$("#changeKaatForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: url_local + "/ratti-kaats/change-kaat",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: $("#changeKaatForm").serialize(),
        dataType: "json",

        success: function (data) {
            console.log(data);
            if (data.Success==true) {
                $("#supplier_kaat").val(data.Data.kaat);
                $("#kaat").trigger("keyup");
                $("#approved_by").val(data.Data.approved_by);
                $("#changeKaatForm").trigger("reset");
                $("#changeKaatModel").modal("show");
            } else {
                error(data.Message);
            }
        },
    });
});
// Submit Purchase
$("body").on("click", "#submit", function (e) {
    e.preventDefault();

    // Validation logic
    if ($("#purchase_date").val() == "") {
        error("Please Enter the Purchase Date!");
        $("#purchase_date").focus();
        return false;
    }
    if ($("#supplier_id").find(":selected").val() == "" || $("#supplier_id").find(":selected").val() == 0) {
        error("Please Select Supplier/Karigar!");
        $("#supplier_id").focus();
        return false;
    }
    if ($("#purchase_account").find(":selected").val() == 0 || $("#purchase_account").find(":selected").val() == '') {
        error("Please Select Purchase Account!");
        $("#purchase_account").focus();
        return false;
    }
    if ($("#reference").val() == '') {
        error("Please Enter Reference!");
        $("#reference").focus();
        return false;
    }
    if ($("#pictures")[0].files.length === 0) {  // Check for file selection
        error("Please add pictures!");
        $("#pictures").focus();
        return false;
    }
    if ($("#paid_account").val() === '' && $("#paid").val() > 0) {
        error("Please select paid account!");
        $("#paid_account").focus();
        return false;
    }

    var rowCount = $("table tbody tr").length;
    if (rowCount < 1) {
        error("No item is added!");
        return false;
    }

    // Create FormData object for Ajax
    var formData = new FormData();
    formData.append("id", $("#id").val());
    formData.append("purchase_date", $("#purchase_date").val());
    formData.append("supplier_id", $("#supplier_id").find(":selected").val());
    formData.append("purchase_account", $("#purchase_account").find(":selected").val());
    formData.append("paid", $("#paid").val());
    formData.append("paid_account", $("#paid_account").find(":selected").val());
    formData.append("reference", $("#reference").val());
    formData.append("total", $("#total").val());

    // Append files (multiple images)
    var pictures = $("#pictures")[0].files;
    for (var i = 0; i < pictures.length; i++) {
        formData.append('pictures[]', pictures[i]); // Add files to the form data
    }

    // Append product data (assuming productData is already a JSON string)
    formData.append("purchaseDetail", JSON.stringify(productData));

    $.ajax({
        url: url_local + "/ratti-kaats/store",  // Laravel route
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        processData: false,  // Important for file uploads
        contentType: false,  // Important for file uploads
        dataType: "json",
        success: function (data) {
            if (data.Success) {
                success(data.Message);
                $("#submit").prop("disabled", true);

                setTimeout(function () {
                    $("#submit").prop("disabled", false);
                    window.location = url_local + "/ratti-kaats";
                }, 1000); // Disable button for 1 second
            } else {
                error(data.Message);
            }
        },
        error: function(xhr, status, error) {
            error("An error occurred: " + error);
        }
    });
});

// Short
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
    var bead_weight = $("#bead_weight").val();
    var stones_weight = $("#stones_weight").val();
    var diamond_carat = $("#diamond_carat").val();
    var net_weight = $("#net_weight").val();
    var supplier_kaat = $("#supplier_kaat").val();
    var kaat = $("#kaat").val();
    var pure_payable = $("#pure_payable").val();
    var other_charge = $("#other_charge").val();
    var total_bead_amount = $("#total_bead_amount").val();
    var total_stones_amount = $("#total_stones_amount").val();
    var total_diamond_amount = $("#total_diamond_amount").val();
    var total_amount = $("#total_amount").val();
    var approved_by = $("#approved_by").val();
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
    if (supplier_kaat == 0 || supplier_kaat == "") {
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

    rows += `<tr id=${productId}><td>${i}</td><td>${productName}</td><td>${description}</td><td style="text-align: right;">${scale_weight}</td><td style="text-align: right;" >${bead_weight}</td>
          <td style="text-align: right;" >${stones_weight}</td><td style="text-align: right;" >${diamond_carat}</td><td style="text-align: right;" >${net_weight}</td><td style="text-align: right;" >${supplier_kaat}</td>
          <td style="text-align: right;" >${kaat}</td><td style="text-align: right;" >${pure_payable}</td><td style="text-align: right;" >${other_charge}</td><td style="text-align: right;" >${total_amount}</td><td>
          <a class="text-danger text-white r${productId}" onclick="Remove(${productId})"><i class="fa fa-trash"></i></a></td></tr>`;
    total = $("#total").val() * 1 + total_amount * 1;
    $("#total").val(total.toFixed(3));
    var tbody = $("#example tbody");
    success("Product Added Successfully!");
    $("#supplier_id").trigger("change");
    tbody.prepend(rows);

    productData.push({
        // sr: i,
        product_id: productId,
        product_name: productName,
        description: description,
        scale_weight: scale_weight,
        bead_weight: bead_weight,
        stones_weight: stones_weight,
        diamond_carat: diamond_carat,
        net_weight: net_weight,
        supplier_kaat: supplier_kaat,
        kaat: kaat,
        pure_payable: pure_payable,
        other_charge: other_charge,
        total_bead_amount: total_bead_amount,
        total_stones_amount: total_stones_amount,
        total_diamond_amount: total_diamond_amount,
        total_amount: total_amount,
        approved_by: approved_by,
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
id = $("#id").val() != null ? $("#id").val() : null;
$.ajax({
    type: "GET",
    url: url_local + "/ratti-kaats/get-ratti-kaats-detail/" + id,
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },

    success: function (data) {
          console.log(data);
        i = 0;
        productData = data.Data;

        var rows = "";
        var total=0;
        $.each(productData, function (e, val) {
            i = i + 1;
            productData.sr = i;
            rows += `<tr id=${val.product_id}><td>${i}</td><td>${val.product_name.name}</td><td>${val.description}</td><td style="text-align: right;">${val.scale_weight}</td><td style="text-align: right;" >${val.bead_weight}</td>
          <td style="text-align: right;" >${val.stones_weight}</td><td style="text-align: right;" >${val.diamond_carat}</td><td style="text-align: right;" >${val.net_weight}</td><td style="text-align: right;" >${val.supplier_kaat}</td>
          <td style="text-align: right;" >${val.kaat}</td><td style="text-align: right;" >${val.pure_payable}</td><td style="text-align: right;" >${val.other_charge}</td><td style="text-align: right;" >${val.total_amount}</td><td>
          <a class="text-danger text-white r${val.product_id}" onclick="Remove(${val.product_id})"><i class="fa fa-trash"></i></a></td></tr>`;
            total += val.total_amount * 1;
        });

        $("#total").val(total.toFixed(2));
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
    $("#bead_weight").val(0);
    $("#stones_weight").val(0);
    $("#diamond_carat").val(0);
    $("#net_weight").val(0);
    $("#kaat").val(0);
    $("#pure_payable").val(0);
    $("#total_bead_amount").val(0);
    $("#total_stones_amount").val(0);
    $("#total_diamond_amount").val(0);
    $("#other_charge").val(0);
    $("#total_amount").val(0);
    $("#approved_by").val('');
}