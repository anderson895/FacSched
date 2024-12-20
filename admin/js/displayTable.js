$(document).ready(function() {
    var rowsPerPage = 5;  // Number of rows per page
    var currentPage = 1;
    var rows = $('#dataTable tbody tr');  // Get all table rows
    var noResultsMessage = $('#noResultsMessage'); // Placeholder for no results message

    // Function to display rows based on current page and filter
    function displayTable() {
        var searchTerm = $('#searchInput').val().toLowerCase();
        var filteredRows = rows.filter(function() {
            var rowText = $(this).text().toLowerCase();
            return rowText.indexOf(searchTerm) !== -1;
        });

        var totalPages = Math.ceil(filteredRows.length / rowsPerPage);

        // Hide all rows first
        rows.hide();

        // Show the correct rows based on the current page
        if (filteredRows.length > 0) {
            filteredRows.each(function(index) {
                if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                    $(this).show();
                }
            });

            // Show pagination controls only if there are results
            var pagination = $('#pagination');
            pagination.empty();

            for (var i = 1; i <= totalPages; i++) {
                var pageItem = $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
                if (i === currentPage) {
                    pageItem.addClass('active');
                }
                pageItem.click(function(e) {
                    e.preventDefault();
                    currentPage = $(this).text();
                    displayTable();
                });
                pagination.append(pageItem);
            }

            // Hide "No search results" message
            noResultsMessage.hide();
        } else {
            // Hide pagination controls and show "No search results" message
            $('#pagination').empty();
            noResultsMessage.show();
        }
    }

    // Initial display of the table
    displayTable();

    // Search functionality
    $('#searchInput').on('input', function() {
        currentPage = 1;  // Reset to first page on search
        displayTable();
    });

});