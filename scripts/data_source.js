$(document).ready(function () {
  // Initialize DataTable
  $("#dataTable").DataTable();

  let selectedRow = null;

  // Row click handler using event delegation
  $("#dataTable tbody").on("click", "tr", function () {
    // Highlight the selected row
    $("#dataTable tbody tr").removeClass("selected"); // Remove class from all rows
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
    } else {
      alert("Please select a row to delete.");
    }
  });

  // Close the delete modal
  $("#closeDeleteModal").on("click", function (e) {
    e.preventDefault();
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
  $("#confirmDelete").on("click", function (e) {
    e.preventDefault();

    if (selectedRow) {
      // Remove the selected row from the table
      selectedRow.remove();

      // Close the modal after deletion
      $("#deleteModal").removeClass("flex");
      $("#deleteModal").addClass("hidden");

      // Deselect the row and disable the buttons
      selectedRow = null;
      $("#editBtn").prop("disabled", true);
      $("#editBtn").addClass("cursor-not-allowed");
      $("#deleteBtn").prop("disabled", true);
      $("#deleteBtn").addClass("cursor-not-allowed");
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
  $("#closeAddModal").on("click", function (e) {
    e.preventDefault();
    $("#addModal").removeClass("flex");
    $("#addModal").addClass("hidden");
  });

  // Save add changes handler
  $("#saveAddChanges").on("click", function (e) {
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

      // Append the new row to the table body
      $("#dataTable tbody").append(newRow);

      // Close the modal
      $("#addModal").removeClass("flex");
      $("#addModal").addClass("hidden");

      // Clear the input fields in the modal
      $("#addName").val("");
      $("#addStatus").val("");
    } else {
      alert("Please fill out all fields!");
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
  $("#saveChanges").on("click", function (e) {
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
  });

  // Deselect row if clicking outside the table
  $(document).on("click", function (e) {
    if (!$(e.target).closest("#dataTable, #dataTable tbody").length) {
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
