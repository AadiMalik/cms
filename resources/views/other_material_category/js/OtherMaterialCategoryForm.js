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

  $("#createNewOtherMaterialCategory").click(function () {
    $("#id").val("");
    $("#otherMaterialCategoryForm").trigger("reset");
    $("#modelHeading").html("Create New Material Category");
    $("#ajaxModel").modal("show");
  });

  // Click to Edit Button

  $("body").on("click", "#editOtherMaterialCategory", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var other_material_category_id = $(this).data("id");
    ajaxGetRequest(url_local + "/other-material-category/edit" + "/" + other_material_category_id)
        .then(function (data) {
            $("#modelHeading").html("Edit Material Category");
            const form = document.getElementById("otherMaterialCategoryForm");
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

  $("#otherMaterialCategoryForm").submit(function (e) {
    e.preventDefault();
    ajaxPostRequest(
        url_local + "/other-material-category/store",
        $("#otherMaterialCategoryForm").serialize()
    )
        .then(function (data) {
            $("#otherMaterialCategoryForm").trigger("reset");
            $("#ajaxModel").modal("hide");
            initDataTableother_material_category_table();
        })
        .catch(function (err) {
            errorMessage(err.message);
        });
  });

  //Status

  $("body").on("click", "#status", function () {
    var other_material_category_id = $(this).data("id");
    ajaxGetRequest(
      url_local + "/other-material-category/status" + "/" + other_material_category_id
    )
      .then(function (data) {
        successMessage(data.Message);
        initDataTableother_material_category_table();
      })
      .catch(function (err) {
        errorMessage(err.message);
      });
  });
  // Delete Code

  $("body").on("click", "#deleteOtherMaterialCategory", function () {
    var other_material_category_id = $(this).data("id");
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
          url_local + "/other-material-category/destroy" + "/" + other_material_category_id
        )
          .then(function (data) {
            successMessage(data.Message);
            initDataTableother_material_category_table();
          })
          .catch(function (err) {
            errorMessage(err.message);
          });
      }
    });
  });
});
