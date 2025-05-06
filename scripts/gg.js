$(document).ready(function () {
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: true,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
  };

  let selectedRow = null;

  // Fetch data from PHP script
  function fetchData() {
    $.ajax({
      url: "../api/fetch_applications.php", // Update with your PHP file path
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          populateTable(response.data);
        } else {
          toastr.error("Failed to fetch data.", "Error");
        }
      },
      error: function () {
        toastr.error("Error connecting to the server.", "Error");
      },
    });
  }

  // Populate table with fetched data
  function populateTable(data) {
    let tableBody = $("#tableBody");
    tableBody.empty();

    data.forEach((item) => {
      let row = `
          <tr class="hover:bg-gray-300">
            <td class="border border-gray-300 px-4 py-2">${item.id}</td>
            <td class="border border-gray-300 px-4 py-2">${item.name}</td>
            <td class="border border-gray-300 px-4 py-2"><span class="${
              item.status === "ACTIVE" ? "bg-green-400" : "bg-blue-400"
            } px-4 py-1 rounded-full bg-opacity-60 text-white">${
        item.status
      }</span></td>
            <td class="border border-gray-300 px-4 py-2">${item.created_at}</td>
          </tr>
        `;
      tableBody.append(row);
    });

    $("#addBtn").prop("disabled", false);
    $("#addBtn").removeClass("cursor-not-allowed");
    $("#dataTable").removeClass("hover:cursor-not-allowed");
    $("#dataTable").addClass("hover:cursor-pointer");
    // Remove the skeleton loader and the width after data is loaded
    $("#dataTable").removeClass("w-full");
    // Remove the skeleton loader and the margin after data is loaded
    $("#dataTable").removeClass("mt-2");
    // Remove the skeleton loader div after data is loaded
    $(".flex.animate-pulse").remove(); // Removes the skeleton loader

    // Initialize DataTable
    $("#dataTable").DataTable();
  }

  // Fetch data on page load
  fetchData();

  // Row selection functionality
  $("#dataTable tbody").on("click", "tr", function () {
    $("#dataTable tbody tr").removeClass("selected");
    $(this).addClass("selected");
    selectedRow = $(this);
    $("#editBtn, #deleteBtn")
      .prop("disabled", false)
      .removeClass("cursor-not-allowed");
  });

  // Deselect row on double-click
  $("#dataTable tbody").on("dblclick", "tr", function () {
    $(this).removeClass("selected");
    selectedRow = null;
    $("#editBtn, #deleteBtn")
      .prop("disabled", true)
      .addClass("cursor-not-allowed");
  });

  // Deselect row if clicking outside the table
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#dataTable, #editBtn, #deleteBtn").length) {
      $("#dataTable tbody tr").removeClass("selected");
      selectedRow = null;
      $("#editBtn, #deleteBtn")
        .prop("disabled", true)
        .addClass("cursor-not-allowed");
    }
  });
});
