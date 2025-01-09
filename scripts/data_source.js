$(document).ready(function () {
  // Initialize DataTable
  $('#dataTable').DataTable();

  let selectedRow = null;

  // Row click handler using event delegation
  $("#dataTable tbody").on("click", "tr", function () {
    // Highlight the selected row
    $("#dataTable tbody tr").removeClass("bg-selected"); // Remove class from all rows
    $(this).addClass("bg-selected"); // Add focus styling as well
    selectedRow = $(this);

    // Enable the Edit button
    $("#editBtn").prop("disabled", false);
    $("#editBtn").removeClass("cursor-not-allowed");
  });

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
      // Show the modal with fade-in animation
      $("#editModal").hide().fadeIn(300);
    }
  });

  // Close modal handler
  $("#closeModal").on("click", function (e) {
    e.preventDefault();
    // Deselect the row and disable the Edit button
    $("#dataTable tbody tr").removeClass("bg-selected");
    selectedRow = null;
    $("#editBtn").prop("disabled", true);
    $("#editBtn").addClass("cursor-not-allowed");
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
    $("#editModal").addClass("hidden");
  });
});
