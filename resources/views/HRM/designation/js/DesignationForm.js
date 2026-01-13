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

  $("#createNewDesignation").click(function () {
    $("#id").val("");
    $("#designationForm").trigger("reset");
    $("#modelHeading").html("Create New Designation");
    $("#ajaxModel").modal("show");
  });

  // Click to Edit Button

  $("body").on("click", "#editDesignation", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var designation_id = $(this).data("id");
    ajaxGetRequest(url_local + "/designation/edit" + "/" + designation_id)
        .then(function (data) {
            $("#modelHeading").html("Edit Designation");
            const form = document.getElementById("designationForm");
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

  $("#designationForm").submit(function (e) {
    e.preventDefault();
    ajaxPostRequest(
        url_local + "/designation/store",
        $("#designationForm").serialize()
    )
        .then(function (data) {
            $("#designationForm").trigger("reset");
            $("#ajaxModel").modal("hide");
            initDataTabledesignation_table();
        })
        .catch(function (err) {
            errorMessage(err.message);
        });
  });

  //Status

  $("body").on("click", "#status", function () {
    var designation_id = $(this).data("id");
    ajaxGetRequest(
      url_local + "/designation/status" + "/" + designation_id
    )
      .then(function (data) {
        successMessage(data.Message);
        initDataTabledesignation_table();
      })
      .catch(function (err) {
        errorMessage(err.message);
      });
  });
  // Delete Code

  $("body").on("click", "#deleteDesignation", function () {
    var designation_id = $(this).data("id");
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
          url_local + "/designation/destroy" + "/" + designation_id
        )
          .then(function (data) {
            successMessage(data.Message);
            initDataTabledesignation_table();
          })
          .catch(function (err) {
            errorMessage(err.message);
          });
      }
    });
  });
});
