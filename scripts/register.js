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

  // Prevent spaces from being entered in the username and password fields
  $("#username, #password").on("keypress", function (e) {
    if (e.which === 32) {
      // 32 is the keycode for space
      e.preventDefault(); // Prevent the space from being entered
    }
  });

  $("#loginHereBtn").click(function () {
    window.location.href = "/amazon-q";
  });

  // Handle form submission or button click
  $("#registerBtn").click(function () {
    // Get the values of the username and password fields and trim spaces
    var username = $("#username").val().trim();
    var password = $("#password").val().trim();

    if (username === "" || password === "") {
      toastr.warning("Fill all fields!");
    } else {
      console.log(`Hi, ${username} ${password}`);

      $.ajax({
        type: "post",
        url: "../operations/register_user.php",
        data: { username: username, password: password },
        dataType: "json",
        success: function (response) {
          console.log("Response from server:", response); // Log the response
          if (response.status === "success") {
            Swal.fire({
              title: "Success",
              text: "Registration Complete!",
              icon: "success",
              confirmButtonText: "Okay",
              confirmButtonColor: "green",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "/amazon-q";
              }
            });
          } else {
            toastr.error("Error: " + response.message);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          toastr.error("Error with the registration process!");
        },
      });
    }
  });
});
