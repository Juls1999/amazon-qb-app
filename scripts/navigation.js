$(document).ready(function () {
  // Check if the screen width is at least 'lg' (1024px and up)
  if ($(window).width() >= 1024) {
    var currentPage = window.location.pathname; // Get the current path
    $("nav ul li a").each(function () {
      if ($(this).attr("href") === currentPage) {
        $(this).parent().addClass("active"); 
      }
    });
  } else {
    var currentPage = window.location.pathname; // Get the current path
    $("nav ul li a").each(function () {
      if ($(this).attr("href") === currentPage) {
        $(this).parent().addClass("activeMobile"); 
      }
    });
  }
});