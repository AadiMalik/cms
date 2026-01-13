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

  $("#createNewDepartment").click(function () {
    $("#id").val("");
    $("#departmentForm").trigger("reset");
    $("#modelHeading").html("Create New Department");
    $("#ajaxModel").modal("show");
  });

  // Click to Edit Button

  $("body").on("click", "#editDepartment", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var department_id = $(this).data("id");
    ajaxGetRequest(url_local + "/department/edit" + "/" + department_id)
        .then(function (data) {
            $("#modelHeading").html("Edit Department");
            const form = document.getElementById("departmentForm");
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

  $("#departmentForm").submit(function (e) {
    e.preventDefault();
    ajaxPostRequest(
        url_local + "/department/store",
        $("#departmentForm").serialize()
    )
        .then(function (data) {
            $("#departmentForm").trigger("reset");
            $("#ajaxModel").modal("hide");
            initDataTabledepartment_table();
        })
        .catch(function (err) {
            errorMessage(err.message);
        });
  });

  //Status

  $("body").on("click", "#status", function () {
    var department_id = $(this).data("id");
    ajaxGetRequest(
      url_local + "/department/status" + "/" + department_id
    )
      .then(function (data) {
        successMessage(data.Message);
        initDataTabledepartment_table();
      })
      .catch(function (err) {
        errorMessage(err.message);
      });
  });
  // Delete Code

  $("body").on("click", "#deleteDepartment", function () {
    var department_id = $(this).data("id");
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
          url_local + "/department/destroy" + "/" + department_id
        )
          .then(function (data) {
            successMessage(data.Message);
            initDataTabledepartment_table();
          })
          .catch(function (err) {
            errorMessage(err.message);
          });
      }
    });
  });
});
