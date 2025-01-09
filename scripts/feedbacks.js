$(document).ready(function () {
  toastr.options = {
    closeButton: true,
    closeMethod: "fadeOut",
    closeDuration: 300,
    closeEasing: "swing",
    showEasing: "swing",
    hideEasing: "linear",
    preventDuplicates: true,
    timeOut: 5000, // 5 seconds
    extendedTimeOut: 1000, // 1 second
    progressBar: true,
  };

  let initialPrompt, initialResponse;

  $(document).on("click", "#editButton", function () {
    // Get the current row
    var $row = $(this).closest("tr");

    // Get values from the row
    var id = $row.find("td:nth-child(1)").text().trim();
    var prompt = $row.find("td:nth-child(2)").text().trim();
    var response = $row.find("td:nth-child(3)").text().trim();

    // Set values to modal inputs
    $("#prompt").val(prompt);
    $("#response").val(response);

    // Store initial values
    initialPrompt = prompt;
    initialResponse = response;

    // Show the modal
    $("#editModal").removeClass("hidden").addClass("flex");

    // Disable the save button initially
    $("#saveButton")
      .prop("disabled", true)
      .addClass("bg-gray-400 text-gray-600 cursor-not-allowed");

    // Display toastr info message
    toastr.info(
      "Save button disabled unless you make changes to the response!"
    );

    // Track changes in input fields
    $("#prompt, #response").on("input change", function () {
      const currentPrompt = $("#prompt").val();
      const currentResponse = $("#response").val();

      // Enable or disable the save button based on changes
      if (
        currentPrompt !== initialPrompt ||
        currentResponse !== initialResponse
      ) {
        $("#saveButton")
          .prop("disabled", false)
          .removeClass("bg-gray-400 text-gray-600 cursor-not-allowed");
      } else {
        $("#saveButton")
          .prop("disabled", true)
          .addClass("bg-gray-400 text-gray-600 cursor-not-allowed");
      }
    });

    // Handle save button click
    $("#saveButton")
      .off("click")
      .on("click", function () {
        var new_response = $("#response").val();

        if (new_response == "") {
          toastr.warning("Response must be provided!");
        } else {
          $.ajax({
            type: "POST",
            url: "../operations/save_edited_feedback.php",
            data: {
              id: id,
              new_response: new_response,
            },
            success: function (response) {
              if (response) {
                Swal.fire({
                  title: "Success",
                  text: "Feedback edited successfully!",
                  icon: "success",
                  confirmButtonText: "Okay",
                  confirmButtonColor: "green",
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              }
            },
            error: function (xhr, status, error) {
              console.error("AJAX Error:", status, error);
              toastr.error(
                "An error occurred: " + xhr.status + " " + xhr.statusText
              );
            },
          });
        }
      });
  });

  // Disable delete button based on feedback type
  $(document).on("click", "#deleteButton", function () {
    var feedbackType = $(this)
      .closest("tr")
      .find("td:nth-child(4)") // feedback column order is 4th
      .text()
      .trim();

    // Proceed with delete operation here
    Swal.fire({
      title: "Are you sure?",
      text: "This action cannot be undone.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "red",
      cancelButtonColor: "gray",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        var id = $(this).closest("tr").find("td:nth-child(1)").text().trim(); // id column order is 1st

        $.ajax({
          type: "POST",
          url: "../operations/delete_feedback.php",
          data: { id: id },
          success: function (response) {
            if (response) {
              Swal.fire({
                title: "Deleted!",
                text: "Feedback has been deleted.",
                icon: "success",
                confirmButtonColor: "green",
              }).then(() => {
                location.reload();
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            toastr.error(
              "An error occurred while deleting: " +
                xhr.status +
                " " +
                xhr.statusText
            );
          },
        });
      }
    });
  });

  $("#exitButton").click(function () {
    $("#editModal").addClass("hidden");
  });
});
