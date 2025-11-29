

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
var ID = "";
$("#show_hide").on("click", function (e) {
    $("#purchase_form_input").toggle();
});
$(document).ready(function () {
    $('#total_bead_amount').trigger('keyup');
    $('#total_stones_amount').trigger('keyup');
    $('#total_diamond_amount').trigger('keyup');
    $('#scale_weight').trigger('keyup');
    $('#bead_weight').trigger('keyup');
    $('#other_charges').trigger('keyup');

});

//Function
function netWeight() {
    var scale_weight = $("#scale_weight").val();
    var bead_weight = $("#bead_weight").val();
    var stone_weight = $("#stone_weight").val();
    var diamond_carat = $("#diamond_carat").val();
    var net_weight = 0;
    net_weight = scale_weight * 1 - (bead_weight * 1 + stone_weight * 1);
    $("#net_weight").val(net_weight.toFixed(3)).trigger("keyup");
}

//Total Amount
function totalAmount() {
    var total_metal_amount = $("#total_metal_amount").val();
    var total_bead_amount = $("#total_bead_amount").val();
    var total_stones_amount = $("#total_stones_amount").val();
    var total_diamond_amount = $("#total_diamond_amount").val();
    var other_charges = $("#other_charges").val();
    var total_amount = (total_metal_amount * 1) + (total_bead_amount * 1) + (total_stones_amount * 1) + (total_diamond_amount * 1) + (other_charges * 1);
    $("#total_amount").val(total_amount.toFixed(3));
}

function totalMetalAmount() {
    var metal_rate = $("#metal_rate").val();
    var scale_weight = $("#scale_weight").val();
    var total_metal_amount = (metal_rate * 1) * (scale_weight * 1);
    $("#total_metal_amount").val(total_metal_amount.toFixed(3));
}

//Total weight
$("#scale_weight").on("keyup", function (event) {
    totalMetalAmount();
    totalAmount();
});
$("#metal_rate").on("keyup", function (event) {
    totalMetalAmount();
    totalAmount();
});
$("body").on("keyup", "#scale_weight",
    function (event) {
        netWeight()
    }
);
$("#bead_weight").on("keyup", function (event) {
    netWeight();
});
$("#stone_weight").on("keyup", function (event) {
    netWeight();
});
$("#diamond_carat").on("keyup", function (event) {
    netWeight();
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
$("#other_charges").on("keyup", function (event) {
    totalAmount();
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
    if ($("#reference").val() == '') {
        error("Please Enter Reference!");
        $("#reference").focus();
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
    // formData.append("purchase_order_id", $("#purchase_order_id").find(":selected").val());
    formData.append("supplier_id", $("#supplier_id").find(":selected").val());
    formData.append("paid", $("#paid").val());
    formData.append("paid_dollar", $("#paid_dollar").val());
    formData.append("reference", $("#reference").val());
    formData.append("total", $("#total").val());
    formData.append("total_dollar", $("#grand_total_dollar").val());

    // Append files (multiple images)
    var pictures = $("#pictures")[0].files;
    for (var i = 0; i < pictures.length; i++) {
        formData.append('pictures[]', pictures[i]); // Add files to the form data
    }

    // Append product data (assuming productData is already a JSON string)
    formData.append("purchaseDetail", JSON.stringify(productData));

    $.ajax({
        url: url_local + "/metal-purchase/store",  // Laravel route
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
                    window.location = url_local + "/metal-purchase";
                }, 1000); // Disable button for 1 second
            } else {
                error(data.Message);
            }
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
    var metal = $("#metal option:selected").val();
    var purity = $("#purity").val();
    var metal_rate = $("#metal_rate").val();
    var scale_weight = $("#scale_weight").val();
    var description = $("#description").val();
    var bead_weight = $("#bead_weight").val();
    var stone_weight = $("#stone_weight").val();
    var diamond_carat = $("#diamond_carat").val();
    var net_weight = $("#net_weight").val();
    var other_charges = $("#other_charges").val();
    var total_metal_amount = $("#total_metal_amount").val();
    var total_bead_amount = $("#total_bead_amount").val();
    var total_stones_amount = $("#total_stones_amount").val();
    var total_diamond_amount = $("#total_diamond_amount").val();
    var total_dollar = $("#total_dollar").val();
    var total_amount = $("#total_amount").val();
    if ($("#product_id").find(":selected").val() == 0) {
        error("Product is not selected!");
        return false;
    }
    if ($("#metal").find(":selected").val() == 0) {
        error("Metal is not selected!");
        return false;
    }
    if (purity == 0 || purity == "") {
        error("Please Enter Purity!");
        return false;
    }
    if (metal_rate == 0 || metal_rate == "") {
        error("Please Enter Metal Rate!");
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
    var check = true;
    $.each(productData, function (e, val) {
        if (val.metal.replace(/\s+/g, '') + val.product_id.toString() == metal.replace(/\s+/g, '') + productId.toString()) {
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

    rows += `<tr id=${productId}><td>${i}</td><td>${productName}</td><td>${metal}</td><td>${purity}</td><td>${description}</td><td style="text-align: right;">${scale_weight}</td><td style="text-align: right;" >${bead_weight}</td>
          <td style="text-align: right;" >${stone_weight}</td><td style="text-align: right;" >${diamond_carat}</td><td style="text-align: right;" >${net_weight}</td><td style="text-align: right;" >${metal_rate}</td>
          <td style="text-align: right;" >${other_charges}</td><td style="text-align: right;" >${total_dollar}</td><td style="text-align: right;" >${total_amount}</td><td>
          <a class="text-danger text-white r${metal.replace(/\s+/g, '') + productId.toString()}" onclick="Remove('${metal.replace(/\s+/g, '') + productId.toString()}')"><i class="fa fa-trash"></i></a></td></tr>`;
    total = $("#total").val() * 1 + total_amount * 1;
    $("#total").val(total.toFixed(3));
    total_dollar = $("#grand_total_dollar").val() * 1 + total_dollar * 1;
    $("#grand_total_dollar").val(total_dollar.toFixed(3));
    var tbody = $("#example tbody");
    success("Product Added Successfully!");
    $("#supplier_id").trigger("change");
    tbody.prepend(rows);

    productData.push({
        // sr: i,
        product_id: productId,
        product_name: productName,
        metal: metal,
        purity: purity,
        metal_rate: metal_rate,
        description: description,
        scale_weight: scale_weight,
        bead_weight: bead_weight,
        stone_weight: stone_weight,
        diamond_carat: diamond_carat,
        net_weight: net_weight,
        other_charges: other_charges,
        total_bead_amount: total_bead_amount,
        total_stones_amount: total_stones_amount,
        total_diamond_amount: total_diamond_amount,
        total_metal_amount: total_metal_amount,
        total_dollar: total_dollar,
        total_amount: total_amount,
        beadData: beadData,
        stoneData: stoneData,
        diamondData: diamondData,
    });
    Short();
    Clear();
}


id = $("#id").val() != null ? $("#id").val() : null;
$.ajax({
    type: "GET",
    url: url_local + "/metal-purchase/get-metal-purchase-detail/" + id,
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },

    success: function (data) {
        console.log(data);
        i = 0;
        productData = data.Data;

        var rows = "";
        var total = 0;
        $.each(productData, function (e, val) {
            i = i + 1;
            productData.sr = i;
            rows += `<tr id=${val.product_id}><td>${i}</td><td>${val.product_name.name}</td><td>${val.metal}</td><td>${val.purity}</td><td>${val.description}</td><td style="text-align: right;">${val.scale_weight}</td><td style="text-align: right;" >${val.bead_weight}</td>
          <td style="text-align: right;" >${val.stone_weight}</td><td style="text-align: right;" >${val.diamond_weight}</td><td style="text-align: right;" >${val.net_weight}</td><td style="text-align: right;" >${val.metal_rate}</td>
          <td style="text-align: right;" >${val.other_charges}</td><td style="text-align: right;" >${val.total_dollar_amount}</td><td style="text-align: right;" >${val.total_amount}</td><td>
          <a class="text-danger text-white r${val.metal.replace(/\s+/g, '') + val.product_id}" onclick="Remove(${val.metal.replace(/\s+/g, '') + val.product_id})"><i class="fa fa-trash"></i></a></td></tr>`;
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
        var grand_total_dollar = 0;
        $.each(productData, function (i, val) {
            if (val.description.replace(/\s+/g, '') + val.product_id.toString() == id) {
                total = $("#total").val() * 1 - val.total_amount * 1;
                grand_total_dollar = $("#grand_total_dollar").val() * 1 - val.total_dollar * 1;
                $("#total").val(total > 0 ? total : 0);
                $("#grand_total_dollar").val(grand_total_dollar > 0 ? grand_total_dollar : 0);
                $("#" + id).hide();
                item_index = i;
                return false;
            }
        });

        productData.splice(item_index, 1);
        var check = ".r" + id;
        $(check).closest("tr").remove();
        success("Item Deleted Successfully!");
        Short();
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
    $("#purity").val(0);
    $("#scale_weight").val('');
    $("#description").val('');
    $("#bead_weight").val(0);
    $("#stone_weight").val(0);
    $("#diamond_carat").val(0);
    $("#net_weight").val(0);
    $("#metal_rate").val(0);
    $("#total_bead_amount").val(0);
    $("#total_stones_amount").val(0);
    $("#total_diamond_amount").val(0);
    $("#total_metal_amount").val(0);
    $("#other_charges").val(0);
    $("#total_dollar").val(0);
    $("#total_amount").val(0);
    beadData = [];
    stoneData = [];
    diamondData = [];
    $("#beads_products").empty();
    $("#stones_products").empty();
    $("#diamonds_products").empty();
}