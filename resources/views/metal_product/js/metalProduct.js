function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
$("#product_id").on("change", function () {
    var product_id = $("#product_id").val();
    $.ajax({
        url: url_local + "/metal-purchase/metal-purchase-by-product-id/" + product_id,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            if (data.Success) {
                var data = data.Data;
                var row = "";
                $("#purchases").empty();
                if (data.metal_purchase.length > 0) {
                    $.each(data.metal_purchase, function (k, value) {
                        row += "<tr>";
                        row +=
                            '<td><a id="purchase_id" href="javascript:void(0)" data-toggle="tooltip"  data-id="' +
                            value.metal_purchase_detail_id +
                            '" data-original-title="Purchase"><b>' +
                            value.metal_purchase_no +
                            "</b></a></td>";
                        row += "</tr>";
                    });
                }

                // if (data.job_purchase.length > 0) {
                //     $.each(data.job_purchase, function (k, value) {
                //         row += `<tr>
                //                     <td>
                //                         <a id="job_purchase_id" href="javascript:void(0)" data-toggle="tooltip"
                //                          data-id="${value.job_purchase_detail_id}" data-original-title="Purchase">
                //                             <b>${value.job_purchase_no}</b>
                //                         </a>
                //                     </td>
                //                 </tr>`;
                //     });
                // }

                if (
                    data.metal_purchase.length === 0
                ) {
                    row += "<tr><td>No Purchase found</td></tr>";
                }
                $("#purchases").append(row);
                $("#tag_no_text").val(data.tag_no);
                $("#tag_no").val(data.tag_no);
            } else {
                error(data.Message);
            }
        },
    });
});

$("body").on("click", "#purchase_id", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var purchase_id = $(this).data("id");
    var product_id = $("#product_id").val();
    $("td a.purchase_active").removeClass("purchase_active");
    $(this).addClass("purchase_active");
    $.ajax({
        url: url_local + "/metal-purchase/get-detail-by-id/" + purchase_id,
        type: "GET",
    }).done(function (data) {
        console.log(data);
        if (data.Success) {
            var data = data.Data;
            $("#metal_purchase_id").val(
                data.metal_purchase_id > 0 ? data.metal_purchase_id : 0
            );
            $("#metal_purchase_detail_id").val(data.id > 0 ? data.id : 0);
            $("#scale_weight").val(
                data.scale_weight > 0 ? data.scale_weight : 0
            );
            $("#gross_weight").val(
                data.scale_weight > 0 ? data.scale_weight : 0
            );
            $("#net_weight").val(data.net_weight > 0 ? data.net_weight : 0);
            $("#bead_weight").val(data.bead_weight > 0 ? data.bead_weight : 0);
            $("#stones_weight").val(
                data.stone_weight > 0 ? data.stone_weight : 0
            );
            $("#diamond_weight").val(
                data.diamond_weight > 0 ? data.diamond_weight : 0
            );
            $("#metal").val(data.metal > '' ? data.metal : '');
            $("#purity").val(data.purity > 0 ? data.purity : 0);
            $("#metal_rate").val(data.metal_rate > 0 ? data.metal_rate : 0);
            $("#metal_rate").val(data.metal_rate > 0 ? data.metal_rate : 0);
            netWeight();
            TotalMetalAmount();
            TotalAmount();
            BeadByPurchaseDetail(data.id);
            StonesByPurchaseDetail(data.id);
            DiamondsByPurchaseDetail(data.id);
        } else {
            error(data.Message);
        }
    });
});

$("#bead_price").on("keyup", function (event) {
    var bead_price = $("#bead_price").val();
    var bead_weight = $("#bead_weight").val();
    var cal = bead_price * bead_weight;
    $("#total_bead_amount").val(cal.toFixed(3));
    TotalAmount();
});

$("#stones_price").on("keyup", function (event) {
    var stones_price = $("#stones_price").val();
    var stones_weight = $("#stones_weight").val();
    var cal = stones_price * stones_weight;
    $("#total_stones_amount").val(cal.toFixed(3));
    TotalAmount();
});

$("#diamond_price").on("keyup", function (event) {
    var diamond_price = $("#diamond_price").val();
    var diamond_weight = $("#diamond_weight").val();
    var cal = diamond_price * diamond_weight;
    $("#total_diamond_amount").val(cal.toFixed(3));
    TotalAmount();
});
//Function
function netWeight() {
    var scale_weight = $("#scale_weight").val();
    var bead_weight = $("#bead_weight").val();
    var stones_weight = $("#stones_weight").val();
    var net_weight = 0;
    net_weight =
        scale_weight * 1 -
        (bead_weight * 1 + stones_weight * 1);
    $("#net_weight").val(net_weight.toFixed(3));
}



$("#other_charges").on("keyup", function (event) {
    TotalAmount();
});
$("#metal_rate").on("keyup", function (event) {
    TotalMetalAmount();
    TotalAmount();
});
function TotalMetalAmount() {
    var gross_wt = $("#gross_weight").val();
    var metal_rate = $("#metal_rate").val();
    var total_metal_amount = metal_rate * 1 * (gross_wt * 1);
    $("#total_metal_amount").val(total_metal_amount.toFixed(3));
}
function TotalAmount() {
    var total_metal_amount = $("#total_metal_amount").val();
    var total_bead_amount = $("#total_bead_amount").val();
    var total_stones_amount = $("#total_stones_amount").val();
    var total_diamond_amount = $("#total_diamond_amount").val();
    var other_charges = $("#other_charges").val();
    var cal =
    total_metal_amount * 1 +
        total_bead_amount * 1 +
        total_stones_amount * 1 +
        total_diamond_amount * 1 +
        other_charges * 1 ;

    $("#total_amount").val(cal.toFixed(3));
}

$("body").on("click", "#submit", function (e) {
    e.preventDefault();
    var is_parent = 1;
    if (!$("#is_parent").is(":checked")) {
        is_parent = 0;
        // Validation logic
        if ($("#tag_no").val() == "") {
            error("Please generat tag no!");
            $("#tag_no").focus();
            return false;
        }
        if (
            $("#metal_purchase_id").val() == "" &&
            $("#metal_purchase_detail_id").val() == ""
        ) {
            error("Please select purchase!");
            return false;
        }
        if (
            $("#product_id").find(":selected").val() == "" ||
            $("#product_id").find(":selected").val() == 0
        ) {
            error("Please Select product!");
            $("#product_id").focus();
            return false;
        }
    }
    if (
        $("#warehouse_id").find(":selected").val() == 0 ||
        $("#warehouse_id").find(":selected").val() == ""
    ) {
        error("Please Select warehouse!");
        $("#warehouse_id").focus();
        return false;
    }
    if ($("#picture").val() == "") {
        error("Please add picture!");
        $("#picture").focus();
        return false;
    }
    if (!$("#is_parent").is(":checked")) {
        if ($("#gold_carat").val() == "" || $("#gold_carat").val() == 0) {
            error("Please enter gold carat!");
            $("#gold_carat").focus();
            return false;
        }
        if ($("#scale_weight").val() == "" || $("#scale_weight").val() == 0) {
            error("Please enter scale weight!");
            $("#scale_weight").focus();
            return false;
        }
        if ($("#net_weight").val() == "" || $("#net_weight").val() == 0) {
            error("Please enter net weight!");
            $("#net_weight").focus();
            return false;
        }
        if ($("#bead_weight").val() == "") {
            error("Please enter bead weight minimum 0!");
            $("#bead_weight").focus();
            return false;
        }
        if ($("#stones_weight").val() == "") {
            error("Please enter stone weight minimum 0!");
            $("#stones_weight").focus();
            return false;
        }
        if ($("#diamond_weight").val() == "") {
            error("Please enter diamond weight minimum 0!");
            $("#diamond_weight").focus();
            return false;
        }
        if ($("#gross_weight").val() == "" || $("#gross_weight").val() == 0) {
            error("Please enter gross weight!");
            $("#gross_weight").focus();
            return false;
        }
        if ($("#total_bead_amount").val() == "") {
            error("Please enter total bead amount, minimum 0!");
            $("#total_bead_amount").focus();
            return false;
        }
        if ($("#total_stones_amount").val() == "") {
            error("Please enter total stones amount, minimum 0!");
            $("#total_stones_amount").focus();
            return false;
        }
        if ($("#total_diamond_amount").val() == "") {
            error("Please enter total diamond amount, minimum 0!");
            $("#total_diamond_amount").focus();
            return false;
        }
        if ($("#other_charges").val() == "") {
            error("Please enter other amount, minimum 0!");
            $("#other_charges").focus();
            return false;
        }
        if ($("#total_amount").val() == "" || $("#total_amount").val() == 0) {
            error("Please enter total amount!");
            $("#total_amount").focus();
            return false;
        }
    }

    // Create FormData object for Ajax
    var formData = new FormData();
    formData.append("is_parent", is_parent);
    formData.append("parent_id", $("#parent_id").find(":selected").val());
    formData.append("tag_no", $("#tag_no").val());
    // formData.append("job_purchase_id", $("#job_purchase_id").val());
    // formData.append(
    //     "job_purchase_detail_id",
    //     $("#job_purchase_detail_id").val()
    // );
    formData.append("metal_purchase_id", $("#metal_purchase_id").val());
    formData.append("metal_purchase_detail_id", $("#metal_purchase_detail_id").val());
    formData.append("product_id", $("#product_id").find(":selected").val());
    formData.append("warehouse_id", $("#warehouse_id").find(":selected").val());
    formData.append("purity", $("#purity").val());
    formData.append("metal", $("#metal").val());
    formData.append("metal_rate", $("#metal_rate").val());
    formData.append("scale_weight", $("#scale_weight").val());
    formData.append("net_weight", $("#net_weight").val());
    formData.append("bead_weight", $("#bead_weight").val());
    formData.append("stones_weight", $("#stones_weight").val());
    formData.append("diamond_weight", $("#diamond_weight").val());
    formData.append("gross_weight", $("#gross_weight").val());
    formData.append("total_metal_amount", $("#total_metal_amount").val());
    formData.append("total_bead_amount", $("#total_bead_amount").val());
    formData.append("total_stones_amount", $("#total_stones_amount").val());
    formData.append("total_diamond_amount", $("#total_diamond_amount").val());
    formData.append("other_charges", $("#other_charges").val());
    formData.append("total_amount", $("#total_amount").val());
    // Append files (multiple images)
    var picture = $("#picture")[0].files;
    for (var i = 0; i < picture.length; i++) {
        formData.append("picture", picture[i]); // Add files to the form data
    }

    // Append product data (assuming productData is already a JSON string)
    formData.append("beadDetail", JSON.stringify(beadData));
    formData.append("stonesDetail", JSON.stringify(stonesData));
    formData.append("diamondDetail", JSON.stringify(diamondsData));

    $.ajax({
        url: url_local + "/metal-product/store", // Laravel route
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
                $("#submit").prop("disabled", true);

                setTimeout(function () {
                    $("#submit").prop("disabled", false);
                    window.location = url_local + "/metal-product";
                }, 1000); // Disable button for 1 second
            } else {
                error(data.Message);
            }
        },
        error: function (xhr, status, e) {
            error("An error occurred:");
        },
    });
});
