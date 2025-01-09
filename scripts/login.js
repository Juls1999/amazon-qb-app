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

  $("#registerBtn").click(function () {
    // console.log("clicked!");
    window.location.href = "pages/register.php";
  });

  // Prevent spaces from being entered in the username and password fields
  $("#username, #password").on("keypress", function (e) {
    if (e.which === 32) {
      // 32 is the keycode for space
      e.preventDefault(); // Prevent the space from being entered
    }
  });

  $("#loginBtn").click(function () {
    var username = $("#username").val().trim();
    var password = $("#password").val().trim();
    if (username == "" || password == "") {
      toastr.warning("Fill all fields!");
    } else {
      $.ajax({
        type: "post",
        url: "operations/login_user.php",
        data: { username: username, password: password },
        dataType: "json",
        success: function (response) {
          if (response.status == "success") {
            window.location.href = "pages/home.php";
          } else {
            toastr.error(response.message);
          }
        },
      });
    }
  });
});
