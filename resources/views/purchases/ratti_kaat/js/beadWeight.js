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

$("#BeadWeightButton").click(function () {
    if ($("#product_id").find(":selected").val() == 0) {
        error("Product is not selected!");
        return false;
    }
    netWeight();
    totalAmount();
    $("#beadWeightForm").trigger("reset");
    $("#bead_weight_product_id").val($("#product_id").find(":selected").val());
    $("#beadWeightModel").modal("show");
});

$("#bead_gram").on("keyup", function (event) {
    var bead_gram = $("#bead_gram").val();
    var cal = bead_gram * 5;
    $("#bead_carat").val(cal.toFixed(3));
    bead_total();
});
$("#bead_carat").on("keyup", function (event) {
    var bead_carat = $("#bead_carat").val();
    var cal = bead_carat / 5;
    $("#bead_gram").val(cal.toFixed(3));
    bead_total();
});

$("#bead_carat_rate").on("keyup", function (event) {
    var bead_carat_rate = $("#bead_carat_rate").val();
    var cal = bead_carat_rate * 5;
    $("#bead_gram_rate").val(cal.toFixed(3));
    bead_total();
});
$("#bead_gram_rate").on("keyup", function (event) {
    var bead_gram_rate = $("#bead_gram_rate").val();
    var cal = bead_gram_rate / 5;
    $("#bead_carat_rate").val(cal.toFixed(3));
    bead_total();
});
function bead_total() {
    var bead_carat = $("#bead_carat").val();
    var bead_carat_rate = $("#bead_carat_rate").val();
    var cal = bead_carat * bead_carat_rate;
    $("#bead_total").val(cal.toFixed(3));
}
function beadWeightData(ratti_kaat_id, product_id) {
    $.ajax({
        url: url_local + "/ratti-kaats/beads" + "/" + ratti_kaat_id + "/" + product_id,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            if (data.Success) {
                var rows = "";
                var total_weight = 0;
                var total_bead_amount = 0;
                var i = 1;
                $("#beadTable").empty();
                if (data.Data.length > 0) {
                    $.each(data.Data, function (e, val) {
                        total_weight = total_weight * 1 + val.gram * 1;
                        total_bead_amount = total_bead_amount * 1 + val.total_amount * 1;
                        rows += `<tr id=${val.id} ><td>${i}</td><td>${val.beads}</td><td>${val.gram}</td><td>${val.carat}</td><td>${val.gram_rate}</td><td>${val.carat_rate}</td><td>${val.total_amount}</td><td><a class="text-danger text-white"  id="deleteBead" href="javascript:void(0)" data-toggle="tooltip"  data-id="${val.id}" data-original-title="delete"><i class="fa fa-trash" style="font-size:18px;"></i></a></td></tr>`;
                    });

                    $("#bead_weight").val(total_weight.toFixed(3)).trigger("keyup");
                    $("#total_bead_amount").val(total_bead_amount.toFixed(3)).trigger("keyup");
                    var tbody = $("#beadTable");
                    tbody.prepend(rows);
                    i = i + 1;
                } else {
                    $("#total_bead_amount").val(0);
                    $("#beadTable").html('<tr><td colspan="8" style="text-align:center;">Record Not Found!</td></tr>');
                }
            } else {
                error(data.Message);
            }
        },
    });
}
$("#beadWeightForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: url_local + "/ratti-kaats/bead-store",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: $("#beadWeightForm").serialize(),
        dataType: "json",

        success: function (data) {
            if (data.Success) {
                success(data.Message);
                $("#beadWeightForm").trigger("reset");
                beadWeightData(ratti_kaat_id, $("#product_id").find(":selected").val());
                netWeight();
                totalAmount();
            } else {
                error(data.Message);
            }
        },
    });
});
// Delete Bead Weight

$("body").on("click", "#deleteBead", function () {
    var ratti_kaat_bead_id = $(this).data("id");
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
                url: url_local + "/ratti-kaats/bead-destroy" + "/" + ratti_kaat_bead_id,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    if (data.Success) {
                        success(data.Message);
                        beadWeightData(ratti_kaat_id, $("#product_id").find(":selected").val());
                        netWeight();
                        totalAmount();
                    } else {
                        error(data.Message);
                    }
                },
            });
        }
    });
});