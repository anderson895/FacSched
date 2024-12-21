$(document).ready(function() {
    var rowsPerPage = 5;
    var currentPage = 1;
    var rows = $('#dataTable tbody tr');
    var noResultsMessage = $('#noResultsMessage');

    function displayTable() {
        var searchTerm = $('#searchInput').val().toLowerCase();
        var filteredRows = rows.filter(function() {
            return $(this).text().toLowerCase().indexOf(searchTerm) !== -1;
        });

        var totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        rows.hide();

        if (filteredRows.length > 0) {
            filteredRows.each(function(index) {
                if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                    $(this).show();
                }
            });

            var pagination = $('#pagination');
            pagination.empty();

            var prevPage = $('<li class="page-item"><a class="page-link" href="#">Previous</a></li>');
            if (currentPage === 1) prevPage.addClass('disabled');
            prevPage.click(function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    displayTable();
                }
            });
            pagination.append(prevPage);

            for (var i = 1; i <= totalPages; i++) {
                (function(page) {
                    var pageItem = $('<li class="page-item"><a class="page-link" href="#">' + page + '</a></li>');
                    if (page === currentPage) pageItem.addClass('active');
                    pageItem.click(function(e) {
                        e.preventDefault();
                        currentPage = page;
                        displayTable();
                    });
                    pagination.append(pageItem);
                })(i);
            }

            var nextPage = $('<li class="page-item"><a class="page-link" href="#">Next</a></li>');
            if (currentPage === totalPages) nextPage.addClass('disabled');
            nextPage.click(function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    displayTable();
                }
            });
            pagination.append(nextPage);

            noResultsMessage.hide();
        } else {
            $('#pagination').empty();
            noResultsMessage.show();
        }
    }

    displayTable();

    $('#searchInput').on('input', function() {
        currentPage = 1;
        displayTable();
    });
});
