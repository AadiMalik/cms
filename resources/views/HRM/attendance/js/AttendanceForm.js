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

  $("#createNewAttendance").click(function () {
    $("#id").val("");
    $("#attendanceForm").trigger("reset");
    $("#modelHeading").html("Create New Attendance");
    $("#ajaxModel").modal("show");
  });

  // Click to Edit Button

  $("body").on("click", "#editAttendance", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var attendance_id = $(this).data("id");
    ajaxGetRequest(url_local + "/attendance/edit" + "/" + attendance_id)
        .then(function (data) {
            $("#modelHeading").html("Edit Attendance");
            const form = document.getElementById("attendanceForm");
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

  $("#attendanceForm").submit(function (e) {
    e.preventDefault();
    ajaxPostRequest(
        url_local + "/attendance/store",
        $("#attendanceForm").serialize()
    )
        .then(function (data) {
            $("#attendanceForm").trigger("reset");
            $("#ajaxModel").modal("hide");
            initDataTableattendance_table();
        })
        .catch(function (err) {
            errorMessage(err.message);
        });
  });

  // Delete Code

  $("body").on("click", "#deleteAttendance", function () {
    var attendance_id = $(this).data("id");
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
          url_local + "/attendance/destroy" + "/" + attendance_id
        )
          .then(function (data) {
            successMessage(data.Message);
            initDataTableattendance_table();
          })
          .catch(function (err) {
            errorMessage(err.message);
          });
      }
    });
  });
});
