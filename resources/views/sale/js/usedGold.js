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

$("#UsedGoldButton").click(function () {
      $("#usedGoldForm").trigger("reset");
      $("#usedGoldModel").modal("show");
});

$("#used_weight").on("keyup", function (event) {
      PureWeight();
});

$("#used_kaat").on("keyup", function (event) {
      PureWeight();
});
$("#used_rate").on("keyup", function (event) {
      Amount();
});

$("#used_karat").on("keyup", function (event) {
      var karat = $("#used_karat").val();
      var karat_rate = (gold_rate / 24) * (karat * 1);
      var gold_rate_gram = karat_rate / 11.664;
      $("#used_rate").val(gold_rate_gram.toFixed(3));
      Amount();
});
function PureWeight() {
      var weight = $("#used_weight").val();
      var kaat = $("#used_kaat").val();
      var cal = (weight / 96) * (kaat * 1);
      var pure_weight = (weight * 1) - (cal * 1);
      $("#used_pure_weight").val(pure_weight.toFixed(3));
}
function Amount() {
      var pure_weight = $("#used_pure_weight").val();
      var rate = $("#used_rate").val();
      var amount = pure_weight * rate;
      $("#used_amount").val(amount.toFixed(3));
}
var usedGoldData = [];
var used_sr = 0;

function addUsedGold() {

      var sale_id = $("#id").val();
      var used_gold_type = $("#used_gold_type").val();
      var used_weight = $("#used_weight").val();
      var used_kaat = $("#used_kaat").val();
      var used_pure_weight = $("#used_pure_weight").val();
      var used_karat = $("#used_karat").val();
      var used_rate = $("#used_rate").val();
      var used_amount = $("#used_amount").val();
      var used_description = $("#used_description").val();

      if (used_gold_type == 0 || used_gold_type == "") {
            error("Please enter gold type!");
            return false;
      }
      if (used_weight == 0 || used_weight == "") {
            error("Please enter weight");
            return false;
      }
      if (used_kaat == 0 || used_kaat == "") {
            error("Please enter kaat");
            return false;
      }
      if (used_pure_weight == 0 || used_pure_weight == "") {
            error("Please enter pure weight");
            return false;
      }
      if (used_karat == 0 || used_karat == "") {
            error("Please enter karat");
            return false;
      }
      if (used_rate == 0 || used_rate == "") {
            error("Please enter rate");
            return false;
      }
      if (used_amount == 0 || used_amount == "") {
            error("Please enter amount");
            return false;
      }
      var check = true;
      $.each(usedGoldData, function (e, val) {
            var type = val.type;
            if (type.replace(/\s+/g, '') + Math.floor(val.weight) + Math.floor(val.kaat) == used_gold_type.replace(/\s+/g, '') + Math.floor(used_weight) + Math.floor(used_kaat)) {
                  error("This Diamond is already added !");
                  check = false;
                  return false;
            }
      });
      if (check == false) {
            return;
      }
      var tbody = $("#usedGoldTable tbody");
      tbody.empty();
      var rows = "";
      var total = 0;

      usedGoldData.push({
            // sr: i,
            sale_id: sale_id,
            type: used_gold_type,
            weight: used_weight,
            kaat: used_kaat,
            pure_weight: used_pure_weight,
            karat: used_karat,
            rate: used_rate,
            amount: used_amount,
            description: used_description,
      });
      $.each(usedGoldData, function (e, val) {
            used_sr = used_sr + 1;
            usedGoldData.sr = used_sr;
            var type = val.type;

            rows += `<tr id=${type.replace(/\s+/g, '') + Math.floor(val.weight) + Math.floor(val.kaat)}><td>${used_sr}</td><td>${val.type}</td><td style="text-align: right;">${val.weight}</td>
                  <td style="text-align: right;">${val.kaat}</td><td style="text-align: right;">${val.pure_weight}</td><td style="text-align: right;" >${val.karat}</td><td style="text-align: right;" >${val.rate}</td>
            <td style="text-align: right;" >${val.amount}</td><td>${val.description}</td>
            <td><a class="text-danger text-white usedr${type.replace(/\s+/g, '') + Math.floor(val.weight) + Math.floor(val.kaat)}" onclick="UsedGoldRemove('${type.replace(/\s+/g, '') + Math.floor(val.weight) + Math.floor(val.kaat)}')"><i class="fa fa-trash"></i></a></td></tr>`;
            total += val.amount * 1;
      });

      $("#gold_impurity_amount").val(total.toFixed(3)).trigger("keyup");

      Amount();
      netWeight();
      ChangeAmount();
      success("Use Gold Added Successfully!");
      tbody.prepend(rows);
      usedGoldhort();
      $("#diamondCaratForm").trigger("reset");
}

function UsedGoldRemove(id) {

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
            $.each(usedGoldData, function (used_sr, val) {

                  var type = val.type;
                  if (type.replace(/\s+/g, '') + Math.floor(val.weight) + Math.floor(val.kaat) == id) {
                        total = $("#gold_impurity_amount").val() * 1 - val.amount * 1;
                        $("#gold_impurity_amount").val(total > 0 ? total : 0);
                        $("#" + id).hide();
                        item_index = used_sr;
                        return false;
                  }
            });

            usedGoldData.splice(item_index, 1);
            var check = ".usedr" + id;
            $(check).closest("tr").remove();
            success("Used Gold Deleted Successfully!");
            Amount();
            PureWeight();
            usedGoldhort();
      });
}
// Short
function usedGoldhort() {
      var table, j, x, y;
      table = document.getElementById("usedGoldTable");
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