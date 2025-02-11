$(document).ready(function () {
  let selectedRow = null;

  // Simulating an API request with a delay (e.g., 2 seconds)
  setTimeout(function () {
    // Example data fetched
    const data = [
      {
        id: 1,
        name: "Crystal Dash Support",
        description: "description 1",
        units: "2",
        indexTxtBytes: "500MB",
        indexTxtDocCount: "2500",
        status: "ACTIVE",
        createdAt: "2024-12-24",
        updatedAt: "2025-01-24",
      },
      {
        id: 2,
        name: "Fanvil Support",
        description: "description 2",
        units: "3",
        indexTxtBytes: "900MB",
        indexTxtDocCount: "7000",
        status: "CREATING",
        createdAt: "2025-01-10",
        updatedAt: "2025-01-21",
      },
    ];

    // Clear skeleton loader and populate table with data
    let tableBody = $("#tableBody");
    tableBody.empty(); // Clear skeleton rows

    // Populate table with data
    data.forEach((item) => {
      tableBody.append(`
          <tr class="hover:bg-gray-300">
              <td class="border border-gray-300 px-4 py-2">${item.id}</td>
              <td class="border border-gray-300 px-4 py-2">${item.name}</td>
              <td class="border border-gray-300 px-4 py-2">${
                item.description
              }</td>
              <td class="border border-gray-300 px-4 py-2">${item.units}</td>
              <td class="border border-gray-300 px-4 py-2">${
                item.indexTxtBytes
              }</td>
              <td class="border border-gray-300 px-4 py-2">${
                item.indexTxtDocCount
              }</td>
              <td class="border border-gray-300 px-4 py-2">
                    <span class="${
                      item.status === "ACTIVE"
                        ? "bg-green-400"
                        : item.status === "CREATING"
                        ? "bg-blue-400"
                        : item.status === "PENDING"
                        ? "bg-yellow-400"
                        : item.status === "COMPLETED"
                        ? "bg-blue-400"
                        : ""
                    } px-4 py-1 rounded-full text-white">
                        ${item.status}
                    </span>
                    </td>
              <td class="border border-gray-300 px-4 py-2">${
                item.createdAt
              }</td>
              <td class="border border-gray-300 px-4 py-2">${
                item.updatedAt
              }</td>
          </tr>
        `);
      // Remove the skeleton loader and the width after data is loaded
      $("#dataTable").removeClass("w-full");
      // Remove the skeleton loader and the margin after data is loaded
      $("#dataTable").removeClass("mt-2");
      // Remove the skeleton loader div after data is loaded
      $(".flex.animate-pulse").remove(); // Removes the skeleton loader
    });

    // Initialize DataTable after the data is loaded
    $("#dataTable").DataTable();
  }, 2000); // Simulating 2 seconds API delay

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
});
