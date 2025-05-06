$(document).ready(function () {

  toastr.options = {
    closeButton: true,
    closeMethod: "fadeOut",
    closeDuration: 300,
    closeEasing: "swing",
    showEasing: "swing",
    hideEasing: "linear",
    preventDuplicates: true,
    timeOut: 3000, // 3 seconds
    extendedTimeOut: 1000, // 1 second
    progressBar: true,
  };

  $("#sendButton").on("click", function () {
    var $inputField = $("#userPrompt");
    var $chatBox = $("#chatBox");
    var prompt = $inputField.val().trim();

    if (prompt) {
      $("<p>")
        .text(prompt)
        .addClass("mb-2 bg-blue-300 w-fit py-1 px-2 rounded-md ml-auto")
        .appendTo($chatBox);
      $inputField.val("");
      $chatBox.scrollTop($chatBox[0].scrollHeight);

      $.ajax({
        url: "../vertexai/vertexAI.php",
        type: "POST",
        data: { prompt: prompt },
        dataType: "json",
        success: function (response) {
          if (response && response.response) {
            var $message = $("<p class=whitespace-pre-wrap>")
              .text(response.response)
              .addClass(
                "mb-2 bg-gray-300 w-fit py-1 px-2 rounded-md mr-auto hover:bg-gray-400 cursor-pointer relative"
              )
              .appendTo($chatBox);

            var $reactionContainer = $("<div>")
              .addClass("hidden mt-1 reaction-container")
              .append(
                $("<span>")
                  .html('<i class="far fa-thumbs-up"></i>')
                  .addClass(
                    "like-icon cursor-pointer mx-1 p-1 rounded hover:bg-green-300"
                  )
                  .on("click", function () {
                    var $dislikeIcon = $(this).siblings(".dislike-icon");
                    if (!$(this).find("i").hasClass("text-green-500")) {
                      // Add like
                      $(this).find("i").addClass("text-green-500");
                      toastr.success("You liked the response!");

                      // If previously disliked, remove dislike
                      if ($dislikeIcon.find("i").hasClass("text-red-500")) {
                        $dislikeIcon.find("i").removeClass("text-red-500");
                      }

                      disableIcons($message);
                      postFeedback(prompt, response.response, "Liked");
                    }
                  }),
                $("<span>")
                  .html('<i class="far fa-thumbs-down"></i>')
                  .addClass(
                    "dislike-icon cursor-pointer mx-1 p-1 rounded hover:bg-red-300"
                  )
                  .on("click", function () {
                    var $likeIcon = $(this).siblings(".like-icon");
                    if (!$(this).find("i").hasClass("text-red-500")) {
                      // Add dislike
                      $(this).find("i").addClass("text-red-500");
                      toastr.error("You disliked the response!");

                      // If previously liked, remove like
                      if ($likeIcon.find("i").hasClass("text-green-500")) {
                        $likeIcon.find("i").removeClass("text-green-500");
                      }

                      disableIcons($message);
                      postFeedback(prompt, response.response, "Disliked");
                    }
                  })
              );

            $message.append($reactionContainer);
            $message.hover(
              function () {
                $reactionContainer.removeClass("hidden");
              },
              function () {
                $reactionContainer.addClass("hidden");
              }
            );
          } else {
            toastr.error("No AI response found!");
          }
          $chatBox.scrollTop($chatBox[0].scrollHeight);
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", status, error);
          toastr.error(
            "An error occurred: " + xhr.status + " " + xhr.statusText
          );
        },
      });
    } else {
      toastr.warning("Please fill the Prompt field!");
    }
  });

  // Set default user prompt
  $("#userPrompt").val("Hello, Crystal Dash Agent!");
  // Trigger send button click to send default prompt
  $("#sendButton").click();

  $("#userPrompt").on("keydown", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      $("#sendButton").click();
    }
  });

  // destroy session
  $("#destroySessionBtn").click(function () {
    $.ajax({
      type: "POST",
      url: "../session/destroy_session.php",
      success: function (response) {
        if (response) {
          toastr.success("New Chat created!");
          $("#chatBox").empty();
          $("#userPrompt").val("Hello, Crystal Dash Agentss!"); // Reset to default prompt

          // Trigger send button click to send default prompt
          $("#sendButton").click();
        }
      },
    });
  });

  // Function to post feedback to your API
  function postFeedback(prompt, response, feedbackType) {
    $.ajax({
      url: "../operations/save_feedback.php",
      type: "POST",
      data: {
        prompt: prompt,
        response: response,
        feedbackType: feedbackType,
      },
      success: function (data) {
        console.log("Feedback successfully sent:", data);
      },
      error: function (xhr, status, error) {
        console.error("Error sending feedback:", status, error);
      },
    });
  }

  // Function to disable both like and dislike icons
  function disableIcons($message) {
    $message
      .find(".like-icon, .dislike-icon")
      .addClass("opacity-50 cursor-not-allowed pointer-events-none");
  }
});
