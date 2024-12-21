$(document).ready(function() {
    var itemsPerPage = 3; // Number of items per page
    var currentPage = 1;  // Track the current page
    var totalItems = $('#scheduleList .card-item').length; // Total number of items
    var totalPages = Math.ceil(totalItems / itemsPerPage); // Total number of pages

    // Function to generate page numbers in the pagination
    function generatePagination() {
        $('#pagination').empty(); // Clear existing page numbers

        // Previous button
        $('#pagination').append('<li class="page-item" id="prevPage"><a class="page-link" href="#">Previous</a></li>');

        // Generate page numbers dynamically
        for (var i = 1; i <= totalPages; i++) {
            $('#pagination').append('<li class="page-item" id="page' + i + '"><a class="page-link" href="#">' + i + '</a></li>');
        }

        // Next button
        $('#pagination').append('<li class="page-item" id="nextPage"><a class="page-link" href="#">Next</a></li>');
        
        // Set the active class for the current page
        $('#page' + currentPage).addClass('active');
        
        // Hide/show Previous and Next buttons based on the current page
        if (currentPage === 1) {
            $('#prevPage').hide(); // Hide previous button on the first page
        } else {
            $('#prevPage').show();
        }

        if (currentPage === totalPages) {
            $('#nextPage').hide(); // Hide next button on the last page
        } else {
            $('#nextPage').show();
        }
    }

    // Function to display the current page of items
    function paginate() {
        $('#scheduleList .card-item').hide(); // Hide all items
        var start = (currentPage - 1) * itemsPerPage;
        var end = start + itemsPerPage;
        $('#scheduleList .card-item').slice(start, end).show(); // Show items for the current page
        generatePagination(); // Regenerate the pagination links after each page change
    }

    // Initialize pagination
    paginate();

    // Click event for page numbers
    $('#pagination').on('click', 'a', function(e) {
        e.preventDefault(); // Prevent the default action

        var clickedPage = $(this).text(); // Get the page number clicked

        if (clickedPage === 'Previous') {
            if (currentPage > 1) {
                currentPage--;
            }
        } else if (clickedPage === 'Next') {
            if (currentPage < totalPages) {
                currentPage++;
            }
        } else {
            currentPage = parseInt(clickedPage);
        }

        paginate(); // Update the displayed items and pagination
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        var searchValue = $(this).val().toLowerCase();
        var visibleItems = 0;

        $('#scheduleList .card-item').each(function() {
            var teacherName = $(this).find('.card-title').text().toLowerCase();
            if (teacherName.indexOf(searchValue) !== -1) {
                $(this).show();
                visibleItems++;
            } else {
                $(this).hide();
            }
        });

        // Show or hide "No Results" message
        if (visibleItems === 0) {
            $('#noResultsMessage').show();
        } else {
            $('#noResultsMessage').hide();
        }

        // Reset pagination after search
        currentPage = 1;
        totalItems = visibleItems;
        totalPages = Math.ceil(totalItems / itemsPerPage);
        paginate();
    });
});
