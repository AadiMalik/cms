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
var product_sr = 0;
Clear();
function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
$("body").on("click", "#JobTaskDetail", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    $("td a.job_task_detail_active").removeClass("job_task_detail_active");
    $(this).addClass("job_task_detail_active");
    $("#purchase_order_detail_id").val($(this).data("id"));
    $("#product_id").val($(this).data("product_id"));
    $("#product").val($(this).data("product"));
    $("#product_category").val($(this).data("category"));
    $("#design_no").val($(this).data("design_no"));
    $("#recieved_weight").val($(this).data("net_weight"));
});
$("#CustomerButton").click(function () {
    $("#customerForm").trigger("reset");
    $("#customerModel").modal("show");
});



$("#bead_price").on("keyup", function (event) {
    var bead_price = $("#bead_price").val();
    var bead_weight = $("#bead_weight").val();
    var cal = bead_price * bead_weight;
    $("#total_bead_price").val(cal.toFixed(3));
    TotalAmount();
});

$("#stones_price").on("keyup", function (event) {
    var stones_price = $("#stones_price").val();
    var stones_weight = $("#stones_weight").val();
    var stone_waste = $("#stone_waste").val();
    var cal = stones_price * stones_weight;
    $("#total_stones_price").val(cal.toFixed(3));
    TotalAmount();
});

$("#diamond_price").on("keyup", function (event) {
    var diamond_price = $("#diamond_price").val();
    var diamond_weight = $("#diamond_weight").val();
    var cal = diamond_price * diamond_weight;
    $("#total_diamond_price").val(cal.toFixed(3));
    TotalAmount();
});
//Function
function totalRecievedWeight() {
    var recieved_weight = $("#recieved_weight").val();
    var stone_waste_weight = $("#stone_waste_weight").val();
    var with_stone_weight = $("#with_stone_weight").val();
    var total_recieved_weight = 0;
    var payable_weight = 0;
    total_recieved_weight =recieved_weight * 1 + stone_waste_weight * 1;
    payable_weight =with_stone_weight * 1 - total_recieved_weight * 1;
    $("#total_recieved_weight").val(total_recieved_weight.toFixed(3));
    $("#payable_weight").val(payable_weight.toFixed(3));
}
function finalPureWeight() {
    var payable_weight = $("#payable_weight").val();
    var mail_weight = $("#mail_weight").val();
    var stone_adjustement = 0; 
    if($("#mail").find(":selected").val()=='Upper'){
        stone_adjustement = (payable_weight/(96+ (1*mail_weight)))*96;
    }else{
        stone_adjustement = (payable_weight/96)*(96 - (1*mail_weight));
    }
    $("#stone_adjustement").val(stone_adjustement.toFixed(3));
    var pure_weight = $("#pure_weight").val();
    var final_pure_weight = (pure_weight * 1)+(stone_adjustement*1);
    $("#final_pure_weight").val(final_pure_weight.toFixed(3));
}
$("#polish_weight").on("keyup", function (event) {
    var waste_ratti = $("#waste_ratti").val();
    var polish_weight = $("#polish_weight").val();
    var waste = (polish_weight / 96) * waste_ratti;
    var total_weight = polish_weight * 1 + waste * 1;
    $("#waste").val(waste.toFixed(3));
    $("#total_weight").val(total_weight.toFixed(3));
});
$("#mail").on("change", function (event) {
    $("#mail_weight").val(0);
    $("#pure_weight").val(0);
    $("#stone_adjustement").val(0);
    $("#final_pure_weight").val(0);
});
$("#mail_weight").on("keyup", function (event) {
    var total_weight=$("#total_weight").val();
    var mail_weight=$("#mail_weight").val();
    var pure_weight=0;
    $("#pure_weight").val(0);
    if($("#mail").find(":selected").val()=='Upper'){
        pure_weight = (total_weight/(96+ (1*mail_weight)))*96;
    }else{
        pure_weight = (total_weight/96)*(96 - (1*mail_weight));
    }
    $("#pure_weight").val(pure_weight.toFixed(3));
    totalRecievedWeight();
    finalPureWeight();
});

$("#other,#laker,#rp,#wax").on("keyup", function (event) {
    TotalAmount();
});
function TotalAmount() {
    var total_bead_price = $("#total_bead_price").val();
    var total_stones_price = $("#total_stones_price").val();
    var total_diamond_price = $("#total_diamond_price").val();
    var other_amount = $("#other").val();
    var laker = $("#laker").val();
    var rp = $("#rp").val();
    var wax = $("#wax").val();
    var cal =total_bead_price * 1 + total_stones_price * 1 + total_diamond_price * 1 + other_amount * 1 + laker * 1 + rp * 1 + wax * 1;
    $("#total_amount").val(cal.toFixed(3));
}

function addProduct() {
    $("#preloader").show();
    var product = $("#product").val();
    var product_id = $("#product_id").val();
    var finish_product_id = $("#finish_product_id").val();
    var ratti_kaat_id = $("#ratti_kaat_id").val();
    var ratti_kaat_detail_id = $("#ratti_kaat_detail_id").val();
    var product = $("#product").val();
    var product_id = $("#product_id").val();
    var gold_carat = $("#gold_carat").val();
    var scale_weight = $("#scale_weight").val();
    var bead_weight = $("#bead_weight").val();
    var stones_weight = $("#stones_weight").val();
    var diamond_weight = $("#diamond_weight").val();
    var net_weight = $("#net_weight").val();
    var gross_weight = $("#gross_weight").val();
    var waste = $("#waste").val();
    var making = $("#making").val();
    var gold_rate = $("#gold_rate").val();
    var total_gold_price = $("#total_gold_price").val();
    var total_bead_price = $("#total_bead_price").val();
    var total_stones_price = $("#total_stones_price").val();
    var total_diamond_price = $("#total_diamond_price").val();
    var other_amount = $("#other_amount").val();
    var total_amount = $("#total_amount").val();

    if (
        tag_no == "" ||
        finish_product_id == "" ||
        ratti_kaat_id == "" ||
        ratti_kaat_detail_id == ""
    ) {
        error("tag is not selected!");
        $("#preloader").hide();
        return false;
    }
    if (product == 0 || product == "") {
        error("Please Enter product!");
        $("#preloader").hide();
        return false;
    }
    if (gold_carat == 0 || gold_carat == "") {
        error("Please Enter karat!");
        $("#preloader").hide();
        return false;
    }
    if (scale_weight == 0 || scale_weight == "") {
        error("Please Enter scale weight!");
        $("#preloader").hide();
        return false;
    }
    if (net_weight == 0 || net_weight == "") {
        error("Please Enter net weight!");
        $("#preloader").hide();
        return false;
    }
    if (gross_weight == 0 || gross_weight == "") {
        error("Please Enter gross weight!");
        $("#preloader").hide();
        return false;
    }
    if (waste < 10 || waste == "") {
        error("Please Enter waste or minimum 10!");
        $("#preloader").hide();
        return false;
    }
    if (gold_rate == 0 || gold_rate == "") {
        error("Please Enter gold rate!");
        $("#preloader").hide();
        return false;
    }
    var check = true;
    $.each(productData, function (e, val) {
        if (val.finish_product_id == $("#finish_product_id").val()) {
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
    var total = 0;

    productData.push({
        // sr: i,
        tag_no: tag_no,
        finish_product_id: finish_product_id,
        ratti_kaat_id: ratti_kaat_id,
        ratti_kaat_detail_id: ratti_kaat_detail_id,
        product: product,
        product_id: product_id,
        gold_carat: gold_carat,
        scale_weight: scale_weight,
        bead_weight: bead_weight,
        stones_weight: stones_weight,
        diamond_weight: diamond_weight,
        net_weight: net_weight,
        gross_weight: gross_weight,
        waste: waste,
        making: making,
        gold_rate: gold_rate,
        total_gold_price: total_gold_price,
        other_amount: other_amount,
        total_bead_price: total_bead_price,
        total_stones_price: total_stones_price,
        total_diamond_price: total_diamond_price,
        total_amount: total_amount,
        beadDetail: beadData,
        stonesDetail: stonesData,
        diamondDetail: diamondsData,
    });

    $("#total").val(total);

    $.each(productData, function (e, val) {
        product_sr = product_sr + 1;
        productData.sr = product_sr;

        rows += `<tr id="${val.finish_product_id}"><td>${product_sr}</td><td>${val.tag_no}</td><td>${val.product}</td>
                <td>${val.gold_carat}</td><td style="text-align: right;">${val.scale_weight}</td><td style="text-align: right;">${val.bead_weight}</td>
                <td style="text-align: right;">${val.stones_weight}</td><td style="text-align: right;">${val.diamond_weight}
                <td style="text-align: right;">${val.net_weight}</td><td style="text-align: right;">${val.waste}</td>
                </td><td style="text-align: right;">${val.gross_weight}</td><td style="text-align: right;" >${val.gold_rate}</td>
          <td style="text-align: right;" >${val.total_gold_price}</td><td style="text-align: right;" >${val.making}</td>
          <td style="text-align: right;" >${val.other_amount}</td><td style="text-align: right;" >${val.total_amount}</td>
          <td><a class="text-warning text-white" id="Detail" href="javascript:void(0)" data-toggle="tooltip"  data-id="${val.finish_product_id}" data-original-title="Detail"><i title="Detail" class="mr-2 fa fa-eye"></i></a>
          <a class="text-danger text-white productr${val.finish_product_id}" onclick="ProductRemove(${val.finish_product_id})"><i class="fa fa-trash"></i></a></td></tr>`;

        total += val.total_amount * 1;
    });
    $("#total").val(total);
    $("#grand_total").val(total.toFixed(3));
    success("Product Added Successfully!");
    $("#products").empty();
    console.log(rows);
    $("#products").html(rows);
    Clear();
    ProductShort();
    $("#preloader").hide();
}


$("body").on("click", "#submit", function (e) {
    e.preventDefault();

    $("#preloader").show();
    // Validation logic
    if ($("#sale_date").val() == "") {
        error("Please select sale date!");
        $("#sale_date").focus();
        $("#preloader").hide();
        return false;
    }

    if (
        $("#customer_id").find(":selected").val() == "" ||
        $("#customer_id").find(":selected").val() == 0
    ) {
        error("Please Select customer!");
        $("#customer_id").focus();
        $("#preloader").hide();
        return false;
    }

    if ($("#grand_total").val() == "" || $("#grand_total").val() == 0) {
        error("Grand total is zero!");
        $("#grand_total").focus();
        $("#preloader").hide();
        return false;
    }

    // Create FormData object for Ajax
    var formData = new FormData();
    formData.append("id", $("#id").val());
    formData.append("sale_date", $("#sale_date").val());
    formData.append("customer_id", $("#customer_id").find(":selected").val());
    formData.append("total", $("#grand_total").val());
    formData.append("cash_amount", $("#cash_amount").val());
    formData.append("bank_transfer_amount", $("#bank_transfer_amount").val());
    formData.append("card_amount", $("#card_amount").val());
    formData.append("advance_amount", $("#advance_amount").val());
    formData.append("gold_impure_amount", $("#gold_impure_amount").val());

    formData.append("productDetail", JSON.stringify(productData));

    $.ajax({
        url: url_local + "/sale/store", // Laravel route
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
                    window.location = url_local + "/sale";
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

function ProductRemove(id) {
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
        $.each(productData, function (i, val) {
            if (val.finish_product_id == id) {
                total = $("#grand_total").val() * 1 - val.total_amount * 1;
                $("#grand_total").val(total > 0 ? total : 0);
                $("#" + id).hide();
                item_index = i;
                return false;
            }
        });

        productData.splice(item_index, 1);
        var check = ".productr" + id;
        $(check).closest("tr").remove();
        success("Product Deleted Successfully!");
        // GrandTotalAmount();
        ProductShort();
        $("#preloader").hide();
    });
}

function Clear() {
    $("#select_tag_no option[value='0']").remove();
    $("#select_tag_no").append(
        '<option disabled selected value="0">--Select Tag No--</option>'
    );
    $("#search_tag_no").val("");
    $("#finish_product_id").val("");
    $("#ratti_kaat_id").val("");
    $("#ratti_kaat_detail_id").val("");
    $("#tag_no").val("");
    $("#product").val("");
    $("#product_id").val("");
    $("#gold_carat").val("");
    $("#scale_weight").val("");
    $("#bead_weight").val(0);
    $("#stones_weight").val(0);
    $("#diamond_weight").val(0);
    $("#net_weight").val(0);
    $("#gross_weight").val(0);
    $("#waste").val(0);
    $("#making").val(0);
    $("#total_bead_price").val(0);
    $("#total_stones_price").val(0);
    $("#total_diamond_price").val(0);
    $("#other_amount").val(0);
    $("#total_gold_price").val(0);
    $("#total_amount").val(0);
}
// Short
function ProductShort() {
    var tbody, j, x, y;
    tbody = document.getElementById("products");
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
