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
                if (data.ratti_kaat.length > 0) {
                    $.each(data.ratti_kaat, function (k, value) {
                        row += '<tr>';
                        row +=
                            '<td><a id="purchase_id" href="javascript:void(0)" data-toggle="tooltip"  data-id="' +
                            value.ratti_kaat_detail_id +
                            '" data-original-title="Purchase"><b>' +
                            value.ratti_kaat_no + '</b></a></td>';
                        row += '</tr>';
                    });

                } else {
                    row += '<tr>';
                    row +=
                        '<td>No Purchase found</td>';
                    row += '</tr>';
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
    $("td a.purchase_active").removeClass("purchase_active");
    $(this).addClass("purchase_active");
    $.ajax({
        url: url_local + "/ratti-kaats/get-detail-by-id/" + purchase_id,
        type: "GET",
    }).done(function (data) {
        console.log(data);
        if (data.Success) {
            var data = data.Data;
            $("#ratti_kaat_id").val((data.ratti_kaat_id>0)?data.ratti_kaat_id:0);
            $("#ratti_kaat_detail_id").val((data.id>0)?data.id:0);
            $("#scale_weight").val((data.scale_weight>0)?data.scale_weight:0);
            $("#net_weight").val((data.net_weight>0)?data.net_weight:0);
            $("#bead_weight").val((data.bead_weight>0)?data.bead_weight:0);
            $("#stones_weight").val((data.stones_weight>0)?data.stones_weight:0);
            $("#diamond_weight").val((data.diamond_carat>0)?data.diamond_carat:0);
        } else {
            error(data.Message);
        }
    });
});

$("#gold_carat").on("keyup", function (event) {
    var gold_carat = $("#gold_carat").val();
    var gold_carat_rate = gold_rate/24*(gold_carat*1);
    var gold_rate_gram = gold_carat_rate/11.664;
    $("#gold_rate").val(gold_rate_gram.toFixed(3));
    TotalGoldAmount();
    TotalAmount();
});

$("#bead_price").on("keyup", function (event) {
    var bead_price = $("#bead_price").val();
    var bead_weight = $("#bead_weight").val();
    var cal = bead_price*bead_weight;
    $("#total_bead_price").val(cal.toFixed(3));
    TotalAmount();
});

$("#stones_price").on("keyup", function (event) {
    var stones_price = $("#stones_price").val();
    var stones_weight = $("#stones_weight").val();
    var cal = stones_price*stones_weight;
    $("#total_stones_price").val(cal.toFixed(3));
    TotalAmount();
});

$("#diamond_price").on("keyup", function (event) {
    var diamond_price = $("#diamond_price").val();
    var diamond_weight = $("#diamond_weight").val();
    var cal = diamond_price*diamond_weight;
    $("#total_diamond_price").val(cal.toFixed(3));
    TotalAmount();
});

$("#waste_per").on("keyup", function (event) {
    var waste_per = $("#waste_per").val();
    var net_weight = $("#net_weight").val();
    var cal = net_weight*waste_per/100;
    var gross_wt = (net_weight*1) + (cal*1);
    $("#waste").val(cal.toFixed(3));
    $("#gross_weight").val(gross_wt.toFixed(3));
    TotalGoldAmount();
});

$("#waste").on("keyup", function (event) {
    var waste = $("#waste").val();
    var net_weight = $("#net_weight").val();
    var cal = waste/net_weight*100;
    var gross_wt = (net_weight*1) + (waste*1);
    $("#waste_per").val(cal.toFixed(3));
    $("#gross_weight").val(gross_wt.toFixed(3));
    TotalGoldAmount();
});

$("#making_gram").on("keyup", function (event) {
    var making_gram = $("#making_gram").val();
    var gross_weight = $("#gross_weight").val();
    var making = (making_gram*1) * (gross_weight*1);
    $("#making").val(making.toFixed(3));
    TotalAmount();
});

$("#making").on("keyup", function (event) {
    var making = $("#making").val();
    var gross_weight = $("#gross_weight").val();
    var making_gram = (making*1) / (gross_weight*1);
    $("#making_gram").val(making_gram.toFixed(3));
    TotalAmount();
});

$("#laker").on("keyup", function (event) {
    TotalAmount();
});
$("#other_amount").on("keyup", function (event) {
    TotalAmount();
});
$("#gold_rate").on("keyup", function (event) {
    TotalGoldAmount();
});
function TotalGoldAmount(){
    var gross_wt = $("#gross_weight").val();
    var gold_rate = $("#gold_rate").val();
    var total_gold_price = (gold_rate*1) + (gross_wt*1);
    $("#total_gold_price").val(total_gold_price.toFixed(3));
}
function TotalAmount(){
    var total_bead_price = $("#total_bead_price").val();
    var total_stones_price = $("#total_stones_price").val();
    var total_diamond_price = $("#total_diamond_price").val();
    var other_amount = $("#other_amount").val();
    var making = $("#making").val();
    var laker = $("#laker").val();
    var total_gold_price = $("#total_gold_price").val();
    var cal = (total_bead_price *1) + (total_stones_price*1) + (total_diamond_price*1) + (other_amount*1) + (making*1) + (laker*1) + (total_gold_price*1);

    $("#total_amount").val(cal.toFixed(3));
}
