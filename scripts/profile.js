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

  $("#saveBtn").click(function () {
    // console.log("clicked!");

    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();

    // console.log(`password: ${password} confirm password:${confirmPassword}`);
    if (password == "" || confirmPassword == "") {
      toastr.warning("Please fill all fields");
    } else if (password == confirmPassword) {
      $.ajax({
        url: "../operations/edit_user.php",
        type: "post",
        data: { password: password },
        dataType: "json",
        success: function (response) {
          if (response.status == "success") {
            //toastr.success("Success!");
            Swal.fire({
              title: "Success",
              text: "Password Changed Successfully!",
              icon: "success",
              confirmButtonText: "Okay",
              confirmButtonColor: "green",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "/amazon-q/pages/home.php";
              }
            });
          } else {
            toastr.error("Error");
          }
        },
      });
    } else {
      toastr.warning("Passwords do not match");
    }
  });
});
