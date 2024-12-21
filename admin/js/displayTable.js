$(document).ready(function() {
    var rowsPerPage = 3;  // Number of cards per page
    var currentPage = 1;
    var rows = $('#scheduleList .card-item');  // Get all schedule items
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

            // Previous Button
            var prevPage = $('<li class="page-item"><a class="page-link" href="#">Previous</a></li>');
            prevPage.click(function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    displayTable();
                }
            });
            pagination.append(prevPage);

            // Page Number Links
            for (var i = 1; i <= totalPages; i++) {
                var pageItem = $('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
                if (i === currentPage) {
                    pageItem.addClass('active');
                }
                pageItem.click(function(e) {
                    e.preventDefault();
                    currentPage = parseInt($(this).text());
                    displayTable();
                });
                pagination.append(pageItem);
            }

            // Next Button
            var nextPage = $('<li class="page-item"><a class="page-link" href="#">Next</a></li>');
            nextPage.click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    displayTable();
                }
            });
            pagination.append(nextPage);

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