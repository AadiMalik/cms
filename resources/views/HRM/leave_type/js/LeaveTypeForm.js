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

  $("#createNewLeaveType").click(function () {
    $("#id").val("");
    $("#leaveTypeForm").trigger("reset");
    $("#modelHeading").html("Create New Leave Type");
    $("#ajaxModel").modal("show");
  });

  // Click to Edit Button

  $("body").on("click", "#editLeaveType", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var leave_type_id = $(this).data("id");
    ajaxGetRequest(url_local + "/leave-type/edit" + "/" + leave_type_id)
        .then(function (data) {
            $("#modelHeading").html("Edit Leave Type");
            const form = document.getElementById("leaveTypeForm");
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

  $("#leaveTypeForm").submit(function (e) {
    e.preventDefault();
    ajaxPostRequest(
        url_local + "/leave-type/store",
        $("#leaveTypeForm").serialize()
    )
        .then(function (data) {
            $("#leaveTypeForm").trigger("reset");
            $("#ajaxModel").modal("hide");
            initDataTableleave_type_table();
        })
        .catch(function (err) {
            errorMessage(err.message);
        });
  });

  //Status

  $("body").on("click", "#status", function () {
    var leave_type_id = $(this).data("id");
    ajaxGetRequest(
      url_local + "/leave-type/status" + "/" + leave_type_id
    )
      .then(function (data) {
        successMessage(data.Message);
        initDataTableleave_type_table();
      })
      .catch(function (err) {
        errorMessage(err.message);
      });
  });
  // Delete Code

  $("body").on("click", "#deleteLeaveType", function () {
    var leave_type_id = $(this).data("id");
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
          url_local + "/leave-type/destroy" + "/" + leave_type_id
        )
          .then(function (data) {
            successMessage(data.Message);
            initDataTableleave_type_table();
          })
          .catch(function (err) {
            errorMessage(err.message);
          });
      }
    });
  });
});
