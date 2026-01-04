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
    if ($("#metal_purchase_detail_id").val() == '') {
        error("Purchase is not selected!");
        return false;
    }
    $("#diamondCaratForm").trigger("reset");
    $("#diamondCaratModel").modal("show");
});

$("#carat").on("keyup", function (event) {
    var carat = $("#carat").val();
    var carat_rate = $("#carat_rate").val();
    var cal = carat * carat_rate;
    var dollars = cal / dollar_rate;
    $("#diamond_total").val(cal.toFixed(3));
    $("#diamond_total_dollar").val(dollars.toFixed(3));
});

$("#carat_rate").on("keyup", function (event) {
    var carat = $("#carat").val();
    var carat_rate = $("#carat_rate").val();
    var cal = carat * carat_rate;
    var dollars = cal / dollar_rate;
    $("#diamond_total").val(cal.toFixed(3));
    $("#diamond_total_dollar").val(dollars.toFixed(3));
});
var diamondsData = [];

function addDiamond() {
    var type = $("#diamond_type option:selected").val();
    var diamonds = $("#diamonds").val();
    var cut = $("#cut").val();
    var color = $("#color").val();
    var clarity = $("#clarity").val();
    var carat = $("#carat").val();
    var carat_rate = $("#carat_rate").val();
    var diamond_total = $("#diamond_total").val();
    if (type == 0 || type == '') {
        error("type is not selected!");
        return false;
    }
    if (diamonds == 0 || diamonds == "") {
        error("Please enter diamonds!");
        return false;
    }
    if (cut == 0 || cut == "") {
        error("Please enter diamonds cut");
        return false;
    }
    if (color == 0 || color == "") {
        error("Please enter diamonds color");
        return false;
    }
    if (clarity == 0 || clarity == "") {
        error("Please enter diamond clarity");
        return false;
    }
    if (carat == 0 || carat == "") {
        error("Please enter diamond carat");
        return false;
    }
    if (carat_rate == 0 || carat_rate == "") {
        error("Please enter diamond carat rate");
        return false;
    }
    if (diamond_total == 0 || diamond_total == "") {
        error("Please enter total diamond amount");
        return false;
    }
    var check = true;
    $.each(diamondsData, function (e, val) {
        var valuetype = val.type;
        if (valuetype.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat) == type.replace(/\s+/g, '') + Math.floor(diamonds) + Math.floor(carat)) {
            error("This Diamond is already added !");
            check = false;
            return false;
        }
    });
    if (check == false) {
        return;
    }
    var tbody = $("#diamondsTable tbody");
    tbody.empty();
    var rows = "";
    var total = 0;
    var total_weight = 0;

    diamondsData.push({
        // sr: i,
        type: type,
        diamonds: diamonds,
        cut: cut,
        color: color,
        carat: carat,
        clarity: clarity,
        carat_rate: carat_rate,
        total_amount: diamond_total,
    });
    $.each(diamondsData, function (e, val) {
        var type = val.type;

        rows += `<tr id=${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}><td>${val.diamonds}</td><td>${val.type}</td>
                <td >${val.cut}</td><td >${val.color}</td><td >${val.clarity}</td><td style="text-align: right;" >${val.carat}</td>
          <td style="text-align: right;" ><input type="number" class="form-control form-control-sm carat-rate" 
         value="${val.carat_rate}" 
         data-diamonds="${val.diamonds}" 
         data-carat="${val.carat}" 
         data-rowid="${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}" 
         style="width: 100px; text-align: right;" /></td><td style="text-align: right;" class="total-amount" id="total-${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}">
  ${val.total_amount}
</td>
          <td><a class="text-danger text-white stoner${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}" onclick="DiamondRemove('${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}')"><i class="fa fa-trash"></i></a></td></tr>`;
        total += val.total_amount * 1;
        total_weight += val.carat * 0.2;
    });

    $("#total_diamond_amount").val(total.toFixed(3));
    $("#diamond_weight").val(total_weight.toFixed(3));

    TotalAmount();
    netWeight();
    success("diamonds Added Successfully!");
    tbody.prepend(rows);
    diamondshort();
    $("#stoneWeightForm").trigger("reset");
}
function DiamondsByPurchaseDetail(metal_purchase_detail_id) {
    $.ajax({
        type: "GET",
        url: url_local + "/metal-purchase/diamonds" + "/" + metal_purchase_detail_id,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (data) {
            console.log(data);
            diamondsData = data.Data;
            var tbody = $("#diamondsTable tbody");
            tbody.empty();
            var rows = "";
            var total = 0;
            var total_weight = 0;
            $.each(diamondsData, function (e, val) {

                var type = val.type;
                rows += `<tr id=${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}><td>${val.diamonds}</td><td>${val.type}</td>
                <td >${val.cut}</td><td >${val.color}</td><td >${val.clarity}</td><td style="text-align: right;" >${val.carat}</td>
          <td style="text-align: right;" ><input type="number" class="form-control form-control-sm carat-rate" 
         value="${val.carat_rate}" 
         data-diamonds="${val.diamonds}" 
         data-carat="${val.carat}" 
         data-rowid="${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}" 
         style="width: 100px; text-align: right;" /></td><td style="text-align: right;" class="total-amount" id="total-${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}">
  ${val.total_amount}
</td>
          <td><a class="text-danger text-white stoner${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}" onclick="DiamondRemove('${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}')"><i class="fa fa-trash"></i></a></td></tr>`;
                total += val.total_amount * 1;
                // total_weight += val.carat * 0.2;
                total_weight += val.carat * 1;
            });

            $("#total_diamond_amount").val(total.toFixed(3));
            $("#diamond_weight").val(total_weight.toFixed(3));
            TotalAmount();
            netWeight();
            tbody.prepend(rows);
        },
    });
}
$(document).off('input', '.carat-rate').on('input', '.carat-rate', function () {

    let rate = parseFloat($(this).val()) || 0;
    let carat = parseFloat($(this).data('carat')) || 0;
    let rowId = $(this).data('rowid');

    let totalAmount = rate * carat;

    /* =========================
       1️⃣ UPDATE TABLE UI
    ==========================*/
    let $row = $(this).closest('tr');
    $row.find('.total-amount').text(totalAmount.toFixed(3));

    /* =========================
       2️⃣ UPDATE diamondsData ARRAY ✅
    ==========================*/
    $.each(diamondsData, function (index, val) {

        let currentId =
            val.type.replace(/\s+/g, '') +
            Math.floor(val.diamonds) +
            Math.floor(val.carat);

        if (currentId == rowId) {
            diamondsData[index].carat_rate = rate;
            diamondsData[index].total_amount = totalAmount.toFixed(3);
            return false; // break loop
        }
    });

    /* =========================
       3️⃣ RECALCULATE GRAND TOTAL
    ==========================*/
    let grandTotal = 0;
    $.each(diamondsData, function (i, val) {
        grandTotal += parseFloat(val.total_amount) || 0;
    });

    $("#total_diamond_amount").val(grandTotal.toFixed(3));

    TotalAmount();
});




// function DiamondsByJobPurchaseDetail(job_purchase_detail_id, product_id) {
//     $.ajax({
//         type: "GET",
//         url: url_local + "/job-purchase/diamonds" + "/" + job_purchase_detail_id + "/" + product_id,
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },

//         success: function (data) {
//             console.log(data);
//             diamondsData = data.Data;
//             var tbody = $("#diamondsTable tbody");
//             tbody.empty();
//             var rows = "";
//             var total = 0;
//             var total_weight = 0;
//             $.each(diamondsData, function (e, val) {

//                 var type = val.type;
//                 rows += `<tr id=${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}><td>${val.diamonds}</td><td>${val.type}</td>
//                 <td >${val.cut}</td><td >${val.color}</td><td >${val.clarity}</td><td style="text-align: right;" >${val.carat}</td>
//           <td style="text-align: right;" ><input type="number" class="form-control form-control-sm carat-rate" 
//          value="${val.carat_rate}" 
//          data-diamonds="${val.diamonds}" 
//          data-carat="${val.carat}" 
//          data-rowid="${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}" 
//          style="width: 100px; text-align: right;" /></td><td style="text-align: right;" class="total-amount" id="total-${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}">
//   ${val.total_amount}
// </td>
//           <td><a class="text-danger text-white stoner${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}" onclick="DiamondRemove('${type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat)}')"><i class="fa fa-trash"></i></a></td></tr>`;
//                 total += val.total_amount * 1;
//                 total_weight += val.carat * 0.2;
//             });

//             $("#total_diamond_price").val(total.toFixed(3));
//             $("#diamond_weight").val(total_weight.toFixed(3));
//             TotalAmount();
//             netWeight();
//             tbody.prepend(rows);
//         },
//     });
// }
function DiamondRemove(id) {

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
        var total_weight = 0;
        $.each(diamondsData, function (diamond_sr, val) {

            var type = val.type;
            if (type.replace(/\s+/g, '') + Math.floor(val.diamonds) + Math.floor(val.carat) == id) {
                total = $("#total_diamond_amount").val() * 1 - val.total_amount * 1;
                total_weight = $("#diamond_weight").val() - val.carat * 0.2;
                $("#total_diamond_amount").val(total > 0 ? total : 0);
                $("#diamond_weight").val(total_weight > 0 ? total_weight : 0);
                $("#" + id).hide();
                item_index = diamond_sr;
                return false;
            }
        });

        diamondsData.splice(item_index, 1);
        var check = ".stoner" + id;
        $(check).closest("tr").remove();
        success("diamonds Deleted Successfully!");
        TotalAmount();
        netWeight();
        diamondshort();
    });
}
// Short
function diamondshort() {
    var table, j, x, y;
    table = document.getElementById("diamondsTable");
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