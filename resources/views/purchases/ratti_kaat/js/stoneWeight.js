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

$("#StonesWeightButton").click(function () {
    if ($("#product_id").find(":selected").val() == 0) {
        error("Product is not selected!");
        return false;
    }
    $("#stoneWeightForm").trigger("reset");
    $("#stone_weight_product_id").val($("#product_id").find(":selected").val());
    $("#stoneWeightModel").modal("show");
});

$("#stone_gram").on("keyup", function (event) {
    var stone_gram = $("#stone_gram").val();
    var cal = stone_gram * 5;
    $("#stone_carat").val(cal.toFixed(3));
    stone_total();
});
$("#stone_carat").on("keyup", function (event) {
    var stone_carat = $("#stone_carat").val();
    var cal = stone_carat / 5;
    $("#stone_gram").val(cal.toFixed(3));
    stone_total();
});

$("#stone_carat_rate").on("keyup", function (event) {
    var stone_carat_rate = $("#stone_carat_rate").val();
    var cal = stone_carat_rate * 5;
    $("#stone_gram_rate").val(cal.toFixed(3));
    stone_total();
});
$("#stone_gram_rate").on("keyup", function (event) {
    var stone_gram_rate = $("#stone_gram_rate").val();
    var cal = stone_gram_rate / 5;
    $("#stone_carat_rate").val(cal.toFixed(3));
    stone_total();
});
function stone_total() {
    var stone_carat = $("#stone_carat").val();
    var stone_carat_rate = $("#stone_carat_rate").val();
    var cal = stone_carat * stone_carat_rate;
    $("#stone_total").val(cal.toFixed(3));
}
function stoneWeightData(ratti_kaat_id, product_id) {
    $.ajax({
        url: url_local + "/ratti-kaats/stones" + "/" + ratti_kaat_id + "/" + product_id,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            if (data.Success) {
                var rows = "";
                var total_weight = 0;
                var total_stones_amount = 0;
                var i = 1;
                $("#stoneTable").empty();
                if (data.Data.length > 0) {
                    $.each(data.Data, function (e, val) {
                        total_weight = total_weight * 1 + val.gram * 1;
                        total_stones_amount = total_stones_amount*1 + val.total_amount * 1;
                        rows += `<tr id=${val.id} ><td>${i}</td><td>${val.stones}</td><td>${val.gram}</td><td>${val.carat}</td><td>${val.gram_rate}</td><td>${val.carat_rate}</td><td>${val.total_amount}</td><td><a class="text-danger text-white"  id="deleteStone" href="javascript:void(0)" data-toggle="tooltip"  data-id="${val.id}" data-original-title="delete"><i class="fa fa-trash" style="font-size:18px;"></i></a></td></tr>`;
                    });

                    $("#stones_weight").val(total_weight.toFixed(3)).trigger("keyup");
                    $("#total_stones_amount").val(total_stones_amount.toFixed(3)).trigger("keyup");
                    var tbody = $("#stoneTable");
                    tbody.prepend(rows);
                    i = i + 1;
                } else {
                    $("#total_stones_amount").val(0);
                    $("#stoneTable").html('<tr><td colspan="8" style="text-align:center;">Record Not Found!</td></tr>');
                }
            } else {
                error(data.Message);
            }
        },
    });
}
$("#stoneWeightForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: url_local + "/ratti-kaats/stone-store",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: $("#stoneWeightForm").serialize(),
        dataType: "json",

        success: function (data) {
            if (data.Success) {
                success(data.Message);
                stoneWeightData(ratti_kaat_id, $("#product_id").find(":selected").val());
                $("#stoneWeightForm").trigger("reset");
            } else {
                error(data.Message);
            }
        },
    });
});
// Delete Stone Weight

$("body").on("click", "#deleteStone", function () {
    var ratti_kaat_stone_id = $(this).data("id");
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
                url: url_local + "/ratti-kaats/stone-destroy" + "/" + ratti_kaat_stone_id,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    if (data.Success) {
                        success(data.Message);
                        stoneWeightData(ratti_kaat_id, $("#product_id").find(":selected").val());
                    } else {
                        error(data.Message);
                    }
                },
            });
        }
    });
});