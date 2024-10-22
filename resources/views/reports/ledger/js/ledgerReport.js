var nb_cols = "";
var total_dr = "";
var total_page_dr = "";
var total_cr = "";
var table = "";

const startDate = document.getElementById("start_date");
const endDate = document.getElementById("end_date");

// ✅ Using the visitor's timezone
startDate.value = formatDate();
endDate.value = formatDate();

console.log(formatDate());

function padTo2Digits(num) {
    return num.toString().padStart(2, "0");
}

function formatDate(date = new Date()) {
    return [
        padTo2Digits(date.getMonth() + 1),
        padTo2Digits(date.getDate()),
        date.getFullYear(),
    ].join("/");
}
startDate.value = new Date().toISOString().split("T")[0];
endDate.value = new Date().toISOString().split("T")[0];

//   $("#vpdf").click(function() {
//       //alert('view pdf');
//       let account_id = $('#account_id option:selected').val();
//       let start_date = $('#startdate').val();
//       let end_date = $('#enddate').val();
//       let date = new Date().getDate();
//       let month = new Date().getMonth();
//       let year = new Date().getFullYear();
//       if (!end_date) {
//           end_date = date + '/' + month + '/' + year;
//       } else {
//           end_date = $('#enddate').val();
//       }
//       console.log(end_date);
//       window.open("{{ url('http://122.129.76.85:8888/rptcon/lepdf') }}?account_id=" + account_id +
//           "& start_date=" + start_date + "& end_date=" + end_date);

//   });

//   $("#vxls").click(function() {
//       //alert('view pdf');
//       let account_id = $('#account_id option:selected').val();
//       let start_date = $('#startdate').val();
//       let end_date = $('#enddate').val();
//       let date = new Date().getDate();
//       let month = new Date().getMonth();
//       let year = new Date().getFullYear();
//       if (!end_date) {
//           end_date = date + '/' + month + '/' + year;
//       } else {
//           end_date = $('#enddate').val();
//       }
//       console.log(end_date);
//       window.open("{{ url('http://122.129.76.85:8888/rptcon/lexls') }}?account_id=" + account_id +
//           "& start_date=" + start_date + "& end_date=" + end_date);

//   });

$(document).on("dblclick", "#example2", function () {
    var entryNum = $(this).find("input").val();
    console.log(entryNum);
    $.ajax({
        url: "get-journal-by-entryNum",
        data: {
            entryNum: entryNum,
        },
        dataType: "json",
        type: "get",
        success: function (res) {
            var id = res;
            window.location.href = "edit-journal-entry/" + id;
        },
    });
});

$(document).ready(function () {
    $("#account_id").select2();
    $("#project_id").select2();
});

function reloadDtTable() {
    $("#example thead th").each(function () {
        var title = $("#example thead th").eq($(this).index()).text();
        $(this).html(
            '<input class="searching" type="text" placeholder="' +
                title +
                '" />'
        );
        $("#action").html("Balance");
        $("#action1").html("Opening Balance");
    });

    var buttonCommon = {
        exportOptions: {
            format: {
                body: function (data, row, column, node) {
                    // Strip , from Total Balance column to make it numeric
                    return;
                    column === 6 ? data.replace(/[,]/g, "") : data;
                },
            },
        },
    };
    table = $("#example").DataTable({
        order: [[0, "asc"]],
        pageLength: 100,
        dom: "Bfrtip",
        ordering: false,
        searching: false,
        buttons: [],
        sPaginationType: "full_numbers",

        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            nb_cols = api.columns().nodes().length;
            var j = 4;
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };

            while (j < nb_cols) {
                var total_page_dr = api
                    .column(j, {
                        page: "current",
                    })
                    .data()
                    .reduce(function (a, b) {
                        return Number(a) + Number(b);
                    }, 0);
                var total_page_cr = api
                    .column(j, {
                        page: "current",
                    })
                    .data()
                    .reduce(function (a, b) {
                        return Number(a) + Number(b);
                    }, 0);

                total_page_dr = total_page_dr.toFixed(2);
                total_page_cr = total_page_cr.toFixed(2);

                total_dr = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                total_cr = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                total_cr = total_cr
                    .toFixed(2)
                    .replace(/\d(?=(\d{3})+\.)/g, "$&,");

                // Update footer
                $(api.column(4).footer()).html(total_cr);

                j++;
            }
        },
    });
    table.button().remove();
    table
        .columns()
        .eq(0)
        .each(function (colIdx) {
            $("input", table.column(colIdx).header()).on("keyup", function () {
                table.column(colIdx).search(this.value).draw();
            });
        });
}

$("#search").on("click", function (e) {
    e.preventDefault();
    // alert('ok')
    var url = $("#form_filter").attr("action");
    var data = $("#form_filter").serializeArray();

    var get = $("#form_filter").attr("method");
    if ($("#start_date").val() == null || $("#start_date").val() == "") {
        toastr.error("Start Date is required!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });
        return false;
    }
    if ($("#end_date").val() == null || $("#end_date").val() == "") {
        toastr.error("End Date is required!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });
        return false;
    }
    if ($("#start_date").val() > $("#end_date").val()) {
        toastr.error("Start Date should be previous than End Date!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });
        return false;
    }
    $.ajax({
        type: get,
        url: url,
        data: data,
        beforeSend: function () {
            $("#preloader").show();
        },

        complete: function () {
            $("#preloader").hide();
        },
    }).done(function (data) {
        $("#excel_button").show();
        console.log(data);
        if (data.length > 0) {
            toastr.success("Ledger Report Generated!", {
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 2e3,
            });
            $(".result").html(data);
            // reloadDtTable();
        }else{
            toastr.success("No Data/Record found!", {
                showMethod: "slideDown",
                hideMethod: "slideUp",
                timeOut: 2e3,
            });
        }
    });
});

$("#excel_button").on("click", function (e) {
    e.preventDefault();
    // alert('ok')
    var data = $("#form_filter").serializeArray();

    var get = $("#form_filter").attr("method");

    $.ajax({
        type: get,
        url: url_local + "/accounting/excel-ledger-report",
        data: data,
        beforeSend: function () {
            $("#preloader").show();
        },

        complete: function () {
            $("#preloader").hide();
        },
    }).done(function (data) {
        $("#preloader").hide();
        toastr.success("Ledger Report Export!", {
            showMethod: "slideDown",
            hideMethod: "slideUp",
            timeOut: 2e3,
        });
        $(".result").html(data);
        reloadDtTable();
    });
});
