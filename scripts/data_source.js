$(document).ready(function () {
  toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: true,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
  };

  const $buttons = $(".tooltip-btn");
  const $tooltip = $("#tooltip");

  $buttons.each(function () {
    let enterTimeout;

    $(this).on("mouseenter", function (e) {
      // Start a timeout to enable the tooltip after 1 second
      enterTimeout = setTimeout(() => {
        $tooltip.text($(this).data("tooltip"));
        $tooltip.css({
          left: `${e.pageX - 220}px`,
          top: `${e.pageY}px`,
        });
        $tooltip.removeClass("hidden");
      }, 1000); // Delay of 1 second
    });

    $(this).on("mouseleave", function () {
      // Clear the timeout if the cursor leaves before 1 second
      clearTimeout(enterTimeout);
      $tooltip.addClass("hidden");
    });
  });

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
          <td class="border border-gray-300 px-4 py-2">${item.updated_at}</td>
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

  // Row click handler using event delegation
  $("#dataTable tbody").on("click", "tr", function () {
    // Highlight the selected row
    $("#dataTable tbody tr").removeClass("selected");
    $(this).addClass("selected");
    selectedRow = $(this);

    // Enable the Edit and Delete buttons
    $("#editBtn").prop("disabled", false);
    $("#editBtn").removeClass("cursor-not-allowed");
    $("#deleteBtn").prop("disabled", false);
    $("#deleteBtn").removeClass("cursor-not-allowed");
  });

  // Row double-click handler for deselecting
  $("#dataTable tbody").on("dblclick", "tr", function () {
    // Deselect the clicked row
    $(this).removeClass("selected");
    selectedRow = null;

    // Disable the Edit and Delete buttons
    $("#editBtn").prop("disabled", true);
    $("#editBtn").addClass("cursor-not-allowed");
    $("#deleteBtn").prop("disabled", true);
    $("#deleteBtn").addClass("cursor-not-allowed");
  });

  // *************** DELETE FUNCTIONALITY ******************
  // Open delete modal when delete button is clicked
  $("#deleteBtn").on("click", function () {
    if (selectedRow) {
      // Show the modal
      $("#deleteModal").removeClass("hidden");
      $("#deleteModal").addClass("flex");
      $("#deleteModal").hide().fadeIn(300);
    } else {
      alert("Please select a row to delete.");
    }
  });

  // Close the delete modal
  $("#closeDeleteModal").on("click", function (e) {
    e.preventDefault();
    $("#confirmDelete").val("");
    $("#deleteModal").removeClass("flex");
    $("#deleteModal").addClass("hidden");
    $("#editBtn").prop("disabled", true);
    $("#editBtn").addClass("cursor-not-allowed");
    $("#deleteBtn").prop("disabled", true);
    $("#deleteBtn").addClass("cursor-not-allowed");
    $("#dataTable tbody tr").removeClass("selected");
    selectedRow = null;
  });

  // Confirm delete action
  $("#confirmDeleteBtn").on("click", function (e) {
    let confirmDelete = $("#confirmDelete").val();

    if (confirmDelete === "DELETE") {
      Swal.fire({
        title: "Deleted!",
        text: "Your data source was deleted successfully.",
        icon: "success",
        allowOutsideClick: false,
        allowEscapeKey: false,
      });
      e.preventDefault();

      if (selectedRow) {
        // Remove the selected row from the table
        selectedRow.remove();

        // Close the modal after deletion
        $("#deleteModal").removeClass("flex");
        $("#deleteModal").addClass("hidden");
        $("#confirmDelete").val("");

        // Deselect the row and disable the buttons
        selectedRow = null;
        $("#editBtn").prop("disabled", true);
        $("#editBtn").addClass("cursor-not-allowed");
        $("#deleteBtn").prop("disabled", true);
        $("#deleteBtn").addClass("cursor-not-allowed");
      }
    } else {
      toastr.warning(
        "Please type DELETE in the text field to confirm deletion.",
        "Action warning!"
      );
    }
  });

  // *************** ADD FUNCTIONALITY ********************************
  // Add button click handler
  $("#addBtn").on("click", function () {
    // Show the modal
    $("#addModal").removeClass("hidden");
    $("#addModal").addClass("flex");
    // Show the modal with fade-in animation
    $("#addModal").hide().fadeIn(300);
  });

  // Close add modal handler
  $("#closeAddBtn").on("click", function (e) {
    e.preventDefault();
    $("#addModal").removeClass("flex");
    $("#addModal").addClass("hidden");
  });

  // Save add changes handler
  $("#saveAddBtn").on("click", function (e) {
    e.preventDefault();

    // Get data from input fields
    var name = $("#addName").val();
    var status = $("#addStatus").val();
    var createdAt = new Date().toISOString().split("T")[0]; // Get current date in YYYY-MM-DD format

    // Check if the input fields are not empty
    if (name && status) {
      // Create a new row with the entered data
      var newRow = `
      <tr class="hover:bg-gray-300">
        <td class="border border-gray-300 px-4 py-2">${
          $("#dataTable tbody tr").length + 1
        }</td>
        <td class="border border-gray-300 px-4 py-2">${name}</td>
        <td class="border border-gray-300 px-4 py-2">${status}</td>
        <td class="border border-gray-300 px-4 py-2">${createdAt}</td>
      </tr>
    `;

      Swal.fire({
        title: "Are you sure?",
        text: "You want to add this data source",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Add it!",
        allowOutsideClick: false,
        allowEscapeKey: false,
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Added!",
            text: "Your data source was added successfully.",
            icon: "success",
            allowOutsideClick: false,
            allowEscapeKey: false,
          });
          // Append the new row to the table body
          $("#dataTable tbody").append(newRow);
        } else {
          swal.fire({
            title: "Cancelled",
            text: "Your data source was not added successfully.",
            icon: "error",
            allowOutsideClick: false,
            allowEscapeKey: false,
          });
        }
      });

      // Close the modal
      $("#addModal").removeClass("flex");
      $("#addModal").addClass("hidden");

      // Clear the input fields in the modal
      $("#addName").val("");
      $("#addStatus").val("");
    } else {
      toastr.info("Please fill all the fields!", "Incomplete Form");
      // alert("Please fill out all fields!");
    }
  });

  // *************** EDIT FUNCTIONALITY ***********************************
  // Edit button click handler
  $("#editBtn").on("click", function () {
    if (selectedRow) {
      // Populate the modal with row data
      $("#editId").val(selectedRow.find("td:nth-child(1)").text());
      $("#editName").val(selectedRow.find("td:nth-child(2)").text());
      $("#editStatus").val(selectedRow.find("td:nth-child(3)").text());
      $("#editCreatedAt").val(selectedRow.find("td:nth-child(4)").text());

      // Show the modal
      $("#editModal").removeClass("hidden");
      $("#editModal").addClass("flex");
      // Show the modal with fade-in animation
      $("#editModal").hide().fadeIn(300);
    }
  });

  // Close modal handler
  $("#closeModal").on("click", function (e) {
    e.preventDefault();
    // Deselect the row and disable the Edit button
    $("#dataTable tbody tr").removeClass("selected");
    selectedRow = null;
    $("#editBtn").prop("disabled", true);
    $("#editBtn").addClass("cursor-not-allowed");
    $("#deleteBtn").prop("disabled", true);
    $("#deleteBtn").addClass("cursor-not-allowed");
    $("#editModal").removeClass("flex");
    $("#editModal").addClass("hidden");
  });

  // Save changes handler
  $("#editSaveBtn").on("click", function (e) {
    Swal.fire({
      title: "Are you sure?",
      text: "You want to edit this data source",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Edit it!",
      allowOutsideClick: false,
      allowEscapeKey: false,
    }).then((result) => {
      if (result.isConfirmed) {
        e.preventDefault();

        if (selectedRow) {
          // Update the table row with new data
          selectedRow.find("td:nth-child(2)").text($("#editName").val());
        }

        // Close the modal
        $("#editModal").removeClass("flex");
        $("#editModal").addClass("hidden");
        $("#editBtn").prop("disabled", true);
        $("#editBtn").addClass("cursor-not-allowed");
        $("#deleteBtn").prop("disabled", true);
        $("#deleteBtn").addClass("cursor-not-allowed");
        $("#dataTable tbody tr").removeClass("selected");
        selectedRow = null;
        Swal.fire({
          title: "Edited!",
          text: "Your data source was edited successfully.",
          icon: "success",
          allowOutsideClick: false,
          allowEscapeKey: false,
        });
        // Append the new row to the table body
        $("#dataTable tbody").append(newRow);
      } else {
        swal.fire({
          title: "Cancelled",
          text: "Your data source was not edited successfully.",
          icon: "error",
          allowOutsideClick: false,
          allowEscapeKey: false,
        });
        $("#editModal").addClass("hidden");
      }
    });
  });

  // Deselect row if clicking outside the table
  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(
        "#dataTable, #dataTable tbody, #editBtn, #deleteBtn, #editModal, #deleteModal"
      ).length
    ) {
      // Deselect row if clicking outside the table
      $("#dataTable tbody tr").removeClass("selected");
      selectedRow = null;

      // Disable the Edit and Delete buttons
      $("#editBtn").prop("disabled", true);
      $("#editBtn").addClass("cursor-not-allowed");
      $("#deleteBtn").prop("disabled", true);
      $("#deleteBtn").addClass("cursor-not-allowed");
    }
  });
});
