import {
  ajaxPostRequest,
  ajaxGetRequest,
} from "../../../../../js/common-methods/http-requests.js";
import {
  errorMessage,
  successMessage,
} from "../../../../../js/common-methods/toasters.js";

$(function () {
  //Click to Button

  $("#createNewFinishProductLocation").click(function () {
    $("#id").val("");
    $("#finishProductLocationForm").trigger("reset");
    $("#modelHeading").html("Create New Tagging Location");
    $("#ajaxModel").modal("show");
  });

  // Click to Edit Button

  $("body").on("click", "#editFinishProductLocation", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var finish_product_location_id = $(this).data("id");
    ajaxGetRequest(url_local + "/finish-product-location/edit" + "/" + finish_product_location_id)
        .then(function (data) {
            $("#modelHeading").html("Edit Tagging Location");
            const form = document.getElementById("finishProductLocationForm");
            for (let index = 0; index < form.length; index++) {
                const element = form[index];
                if (element && element.value != "Save" && element.name != "id")
                    element.value = data[element.name];
                if (element.name == "id") element.value = data.id;
            }
            $("#ajaxModel").modal("show");
        })
        .catch(function (err) {
            // Run this when promise was rejected via reject()
            errorMessage(err.message);
        });
  });

  // Save/Update Code

  $("#finishProductLocationForm").submit(function (e) {
    e.preventDefault();
    ajaxPostRequest(
        url_local + "/finish-product-location/store",
        $("#finishProductLocationForm").serialize()
    )
        .then(function (data) {
            $("#finishProductLocationForm").trigger("reset");
            $("#ajaxModel").modal("hide");
            initDataTablefinish_product_location_table();
        })
        .catch(function (err) {
            errorMessage(err.message);
        });
  });

  //Status

  $("body").on("click", "#status", function () {
    var finish_product_location_id = $(this).data("id");
    ajaxGetRequest(
      url_local + "/finish-product-location/status" + "/" + finish_product_location_id
    )
      .then(function (data) {
        successMessage(data.Message);
        initDataTablefinish_product_location_table();
      })
      .catch(function (err) {
        errorMessage(err.message);
      });
  });
  // Delete Code

  $("body").on("click", "#deleteFinishProductLocation", function () {
    var finish_product_location_id = $(this).data("id");
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
        ajaxGetRequest(
          url_local + "/finish-product-location/destroy" + "/" + finish_product_location_id
        )
          .then(function (data) {
            successMessage(data.Message);
            initDataTablefinish_product_location_table();
          })
          .catch(function (err) {
            errorMessage(err.message);
          });
      }
    });
  });
});
