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

$("#DiamondCaratButton").click(function () {
    if ($("#product_id").find(":selected").val() == 0) {
        error("Product is not selected!");
        return false;
    }
    $("#diamondCaratForm").trigger("reset");
    $("#diamond_carat_product_id").val($("#product_id").find(":selected").val());
    $("#diamondCaratModel").modal("show");
});

$("#carat").on("keyup", function (event) {
    var carat = $("#carat").val();
    var carat_rate = $("#carat_rate").val();
    var cal = carat * carat_rate;
    $("#diamond_total").val(cal.toFixed(3));
});

$("#carat_rate").on("keyup", function (event) {
    var carat = $("#carat").val();
    var carat_rate = $("#carat_rate").val();
    var cal = carat * carat_rate;
    $("#diamond_total").val(cal.toFixed(3));
});
function diamondCaratData(ratti_kaat_id, product_id) {
    $.ajax({
        url: url_local + "/ratti-kaats/diamonds" + "/" + ratti_kaat_id + "/" + product_id,
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log(data);
            if (data.Success) {
                var rows = "";
                var total_carat = 0;
                var total_diamond_amount = 0;
                var total_diamond_dollar = 0;
                var i = 1;
                $("#diamondTable").empty();
                if (data.Data.length > 0) {
                    $.each(data.Data, function (e, val) {
                        total_carat = total_carat * 1 + val.carat * 1;
                        total_diamond_amount = total_diamond_amount*1 + val.total_amount * 1;
                        total_diamond_dollar = total_diamond_dollar*1 + val.total_dollar * 1;
                        rows += `<tr id=${val.id} ><td>${i}</td><td>${val.diamonds}</td><td>${val.type}</td><td>${val.cut}</td><td>${val.color}</td><td>${val.clarity}</td><td>${val.carat}</td><td>${val.carat_rate}</td><td>${val.total_amount}</td><td>${val.total_dollar}</td><td><a class="text-danger text-white"  id="deleteDiamond" href="javascript:void(0)" data-toggle="tooltip"  data-id="${val.id}" data-original-title="delete"><i class="fa fa-trash" style="font-size:18px;"></i></a></td></tr>`;
                    });

                    $("#diamond_carat").val(total_carat.toFixed(3)).trigger("keyup");
                    $("#total_diamond_amount").val(total_diamond_amount.toFixed(3)).trigger("keyup");
                    $("#total_dollar").val(total_diamond_dollar.toFixed(3));
                    var tbody = $("#diamondTable");
                    tbody.prepend(rows);
                    i = i + 1;
                } else {
                    $("#total_diamond_amount").val(0);
                    $("#total_dollar").val(0);
                    $("#diamondTable").html('<tr><td colspan="11" style="text-align:center;">Record Not Found!</td></tr>');
                }
            } else {
                error(data.Message);
            }
        },
    });
}
$("#diamondCaratForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: url_local + "/ratti-kaats/diamond-store",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: $("#diamondCaratForm").serialize(),
        dataType: "json",

        success: function (data) {
            if (data.Success) {
                success(data.Message);
                $("#diamondCaratForm").trigger("reset");
                diamondCaratData(ratti_kaat_id, $("#product_id").find(":selected").val());
            } else {
                error(data.Message);
            }
        },
    });
});
// Delete Diamond Carat

$("body").on("click", "#deleteDiamond", function () {
    var ratti_kaat_diamond_id = $(this).data("id");
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
                url: url_local + "/ratti-kaats/diamond-destroy" + "/" + ratti_kaat_diamond_id,
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (data) {
                    if (data.Success) {
                        success(data.Message);
                        diamondCaratData(ratti_kaat_id, $("#product_id").find(":selected").val());
                    } else {
                        error(data.Message);
                    }
                },
            });
        }
    });
});