$(document).ready(function() {
    // Pagination setup
    const itemsPerPage = 3;
    let currentPage = 1;
    
    // Hide all cards initially
    function showPage(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        $(".card-item").hide().slice(startIndex, endIndex).show();
    }

    // Function to display "No schedules found" message
    function checkEmptySearch() {
        if ($(".card-item:visible").length === 0) {
            $("#noResultsMessage").show();
        } else {
            $("#noResultsMessage").hide();
        }
    }

    showPage(currentPage);

    // Search functionality
    $("#searchInput").on("keyup", function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $(".card-item").each(function() {
            const employeeName = $(this).find(".card-title").text().toLowerCase();
            if (employeeName.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        checkEmptySearch();  // Check if there are any visible cards after search
    });

    // Pagination buttons
    $("#prevPage").click(function() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    $("#nextPage").click(function() {
        const totalItems = $(".card-item:visible").length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });
});