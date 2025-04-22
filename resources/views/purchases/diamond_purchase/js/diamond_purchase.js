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
var diamondProductData = [];
var diamond_product_sr = 0;
Clear();
function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
$("#CustomerButton").click(function () {
    $("#customerForm").trigger("reset");
    $("#customerModel").modal("show");
});
function getCustomer() {
    $("#preloader").show();
    $.ajax({
        url: url_local + "/customers/json",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            var data = data.Data;
            $("#customer_id").empty();
            $("#customer").empty();
            var customer =
                '<option value="0" selected disabled>--Select Customer--</option>';
            $.each(data, function (key, value) {
                customer +=
                    '<option value="' +
                    value.id +
                    '">' +
                    value.name +
                    " </option>";
            });
            $("#customer_id").append(customer);
            $("#preloader").hide();
        },
    });
}

$("#carat_price").on("keyup", function (event) {
    var carat = $("#carat").val();
    var carat_price = $("#carat_price").val();
    var total = carat * 1 * (carat_price * 1);
    var dollars = total / dollar_rate;
    $("#total_amount").val(total.toFixed(3));
    $("#total_dollar").val(dollars.toFixed(3));
});
$("#carat").on("keyup", function (event) {
    var carat = $("#carat").val();
    var carat_price = $("#carat_price").val();
    var total = carat * 1 * (carat_price * 1);
    var dollars = total / dollar_rate;
    $("#total_amount").val(total.toFixed(3));
    $("#total_dollar").val(dollars.toFixed(3));
});

function addProduct() {
    $("#preloader").show();
    var diamond_type_id = $("#diamond_type_id").find(":selected").val();
    var diamond_type = $("#diamond_type_id").find(":selected").text();
    var diamond_cut_id = $("#diamond_cut_id").find(":selected").val();
    var diamond_cut = $("#diamond_cut_id").find(":selected").text();
    var diamond_color_id = $("#diamond_color_id").find(":selected").val();
    var diamond_color = $("#diamond_color_id").find(":selected").text();
    var diamond_clarity_id = $("#diamond_clarity_id").find(":selected").val();
    var diamond_clarity = $("#diamond_clarity_id").find(":selected").text();
    var qty = $("#qty").val();
    var carat = $("#carat").val();
    var carat_price = $("#carat_price").val();
    var total_amount = $("#total_amount").val();
    var total_dollar = $("#total_dollar").val();

    if (diamond_type_id == 0 || diamond_type_id == "") {
        error("Please Enter Type!");
        $("#preloader").hide();
        return false;
    }
    if (diamond_cut_id == 0 || diamond_cut_id == "") {
        error("Please Enter Cut!");
        $("#preloader").hide();
        return false;
    }
    if (diamond_color_id == 0 || diamond_color_id == "") {
        error("Please Enter Color!");
        $("#preloader").hide();
        return false;
    }
    if (diamond_clarity_id == 0 || diamond_clarity_id == "") {
        error("Please Enter Clarity!");
        $("#preloader").hide();
        return false;
    }
    if (carat == 0 || carat == "") {
        error("Please Enter Carat!");
        $("#preloader").hide();
        return false;
    }
    if (carat_price == 0 || carat_price == "") {
        error("Please Enter Carat Price!");
        $("#preloader").hide();
        return false;
    }
    if (qty == 0 || qty == "") {
        error("Please Enter Quantity!");
        $("#preloader").hide();
        return false;
    }
    var check = true;
    $.each(diamondProductData, function (e, val) {
        if (val.diamond_type_id + val.diamond_cut_id + val.diamond_color_id + val.diamond_clarity_id == diamond_type_id + diamond_cut_id + diamond_color_id + diamond_clarity_id) {
            error("Diamond is already added !");
            $("#preloader").hide();
            check = false;
            return false;
        }
    });
    if (check == false) {
        return;
    }

    var rows = "";
    var total = 0;
    var total_dollar_amount = 0;

    diamondProductData.push({
        // sr: i,
        diamond_type_id: diamond_type_id,
        diamond_type: diamond_type,
        diamond_cut_id: diamond_cut_id,
        diamond_cut: diamond_cut,
        diamond_color_id: diamond_color_id,
        diamond_color: diamond_color,
        diamond_clarity_id: diamond_clarity_id,
        diamond_clarity: diamond_clarity,
        carat: carat,
        qty: qty,
        carat_price: carat_price,
        total_amount: total_amount,
        total_dollar: total_dollar,
    });
    $("#total").val(total);
    $("#total_dollar").val(total_dollar_amount);

    $.each(diamondProductData, function (e, val) {
        diamond_product_sr = diamond_product_sr + 1;
        diamondProductData.sr = diamond_product_sr;

        rows += `<tr id="${val.diamond_type_id+val.diamond_cut_id+val.diamond_color_id+val.diamond_clarity_id}">
        <td>${diamond_product_sr}</td>
        <td>${val.diamond_type}</td>
        <td>${val.diamond_cut}</td>
        <td>${val.diamond_color}</td>
        <td>${val.diamond_clarity}</td>
                <td style="text-align: right;">${val.carat}</td>
                <td style="text-align: right;">${val.carat_price}</td>
                <td style="text-align: right;">${val.qty}</td>
                <td style="text-align: right;">${val.total_amount}</td>
                <td style="text-align: right;">${val.total_dollar}</td>
                <td><a class="text-danger text-white diamondproductr${val.diamond_type_id+val.diamond_cut_id+val.diamond_color_id+val.diamond_clarity_id}" onclick="DiamondProductRemove(${val.diamond_type_id+val.diamond_cut_id+val.diamond_color_id+val.diamond_clarity_id})"><i class="fa fa-trash"></i></a></td></tr>`;

        total += val.total_amount * 1;
        total_dollar_amount += val.total_dollar * 1;
    });
    $("#grand_total").val(total.toFixed(3));
    $("#grand_total_dollar").val(total_dollar_amount.toFixed(3));
    success("Diamond Added Successfully!");
    $("#diamond_products").empty();
    console.log(rows);
    $("#diamond_products").html(rows);
    Clear();
    DiamondProductShort();
    $("#preloader").hide();
}

$("body").on("click", "#submit", function (e) {
    e.preventDefault();

    $("#preloader").show();
    // Validation logic
    if ($("#diamond_purchase_date").val() == "") {
        error("Please select purchase date!");
        $("#purchase_date").focus();
        $("#preloader").hide();
        return false;
    }
    if ($("#bill_no").val() == "") {
        error("Please add bill no!");
        $("#bill_no").focus();
        $("#preloader").hide();
        return false;
    }
    if (
        $("#supplier_id").find(":selected").val() == "" ||
        $("#supplier_id").find(":selected").val() == 0
    ) {
        error("Please Select supplier!");
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
    if (
        $("#purchase_account_id").find(":selected").val() == "" ||
        $("#purchase_account_id").find(":selected").val() == 0
    ) {
        error("Please Select Purchase Account!");
        $("#purchase_account_id").focus();
        $("#preloader").hide();
        return false;
    }

    if ($("#grand_total").val() == "" || $("#grand_total").val() == 0) {
        error("Grand total is zero!");
        $("#grand_total").focus();
        $("#preloader").hide();
        return false;
    }
    if ($("#grand_total_dollar").val() == "" || $("#grand_total_dollar").val() == 0) {
        error("Grand total dollar is zero!");
        $("#grand_total_dollar").focus();
        $("#preloader").hide();
        return false;
    }

    // Create FormData object for Ajax
    var formData = new FormData();
    formData.append("id", $("#id").val());
    formData.append("diamond_purchase_date", $("#diamond_purchase_date").val());
    formData.append("supplier_id", $("#supplier_id").find(":selected").val());
    formData.append("warehouse_id", $("#warehouse_id").find(":selected").val());
    formData.append("purchase_account_id", $("#purchase_account_id").find(":selected").val());
    formData.append("is_pkr", $("#is_pkr").find(":selected").val());
    formData.append("total", $("#grand_total").val());
    formData.append("total_dollar", $("#grand_total_dollar").val());
    formData.append("paid", $("#paid").val());
    formData.append("paid_account_id", $("#paid_account_id").find(":selected").val());
    formData.append("reference", $("#reference").val());

    formData.append("diamondProductDetail", JSON.stringify(diamondProductData));

    $.ajax({
        url: url_local + "/diamond-purchase/store", // Laravel route
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
                    window.location = url_local + "/diamond-purchase";
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

function DiamondProductRemove(id) {
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
        var total_dollar = 0;
        $("#preloader").show();
        $.each(diamondProductData, function (i, val) {
            if (val.diamond_type_id+val.diamond_cut_id+val.diamond_color_id+val.diamond_clarity_id == id) {
                total = $("#grand_total").val() * 1 - val.total_amount * 1;
                total_dollar = $("#grand_total_dollar").val() * 1 - val.total_dollar * 1;
                $("#grand_total").val(total > 0 ? total : 0);
                $("#grand_total_dollar").val(total_dollar > 0 ? total_dollar : 0);
                $("#" + id).hide();
                item_index = i;
                return false;
            }
        });

        diamondProductData.splice(item_index, 1);
        var check = ".diamondproductr" + id;
        $(check).closest("tr").remove();
        success("Diamond Deleted Successfully!");
        DiamondProductShort();
        $("#preloader").hide();
    });
}

function Clear() {
    $("#diamond_type_id option[value='0']").remove();
    $("#diamond_type_id").append(
        '<option disabled selected value="0">--Select Type--</option>'
    );
    $("#diamond_cut_id option[value='0']").remove();
    $("#diamond_cut_id").append(
        '<option disabled selected value="0">--Select Cut--</option>'
    );
    $("#diamond_color_id option[value='0']").remove();
    $("#diamond_color_id").append(
        '<option disabled selected value="0">--Select Color--</option>'
    );
    $("#diamond_clarity_id option[value='0']").remove();
    $("#diamond_clarity_id").append(
        '<option disabled selected value="0">--Select Clarity--</option>'
    );
    $("#carat").val("");
    $("#qty").val("");
    $("#carat_price").val("");
    $("#total_amount").val(0);
    $("#total_dollar").val(0);

}
// Short
function DiamondProductShort() {
    var tbody, j, x, y;
    tbody = document.getElementById("diamond_products");
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
