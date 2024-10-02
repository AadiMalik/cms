function isNumberKey(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
$("#product_id").on("change", function () {
    var product_id = $("#product_id").val();
    $.ajax({
        url: url_local + '/ratti-kaats/ratti-kaat-by-product-id/' + product_id,
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
                if (data.length > 0) {
                    $.each(data, function (k, value) {
                        row += '<tr>';
                        row +=
                            '<td><a id="purchase_id" href="javascript:void(0)" data-toggle="tooltip"  data-id="' +
                            value.ratti_kaat_detail_id +
                            '" data-original-title="Purchase"><b>' +
                            value.ratti_kaat_no + '</b></a></td>';
                        row += '</tr>';
                    });

                    console.log(row);
                } else {
                    row += '<tr>';
                    row +=
                        '<td>No Purchase found</td>';
                    row += '</tr>';
                }
                $("#purchases").append(row);
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
    $("td a.purchase_active").removeClass("purchase_active");
    $(this).addClass("purchase_active");
    $.ajax({
        url: url_local + "/ratti-kaats/get-detail-by-id/" + purchase_id,
        type: "GET",
    }).done(function (data) {
        console.log(data);
        if (data.Success) {
            var data = data.Data;
            $("#scale_weight").val((data.scale_weight>0)?data.scale_weight:0);
            $("#net_weight").val((data.net_weight>0)?data.net_weight:0);
            $("#bead_weight").val((data.bead_weight>0)?data.bead_weight:0);
            $("#stone_weight").val((data.stone_weight>0)?data.stone_weight:0);
            $("#diamond_weight").val((data.diamond_weight>0)?data.diamond_weight:0);
        } else {
            error(data.Message);
        }
    });
});
