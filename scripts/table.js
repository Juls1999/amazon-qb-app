$(document).ready(function () {
  new DataTable("#feedbackTable", {
      order: [[0, "desc"]] // This will order by the first column (ID) in descending order
  });
});
