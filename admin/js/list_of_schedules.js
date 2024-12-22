$(document).ready(function() {
    const itemsPerPage = 3;
    let currentPage = 1;
    let scheduleItems = $('.card-item');  // All schedule items
    let filteredItems = scheduleItems;   // Initially all items are considered as filtered

    // Function to handle pagination
    function paginate() {
        const totalItems = filteredItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const startItem = (currentPage - 1) * itemsPerPage;
        const endItem = startItem + itemsPerPage;

        // Show or hide pagination buttons based on the current page
        $('#prevPage').toggle(currentPage > 1);
        $('#nextPage').toggle(currentPage < totalPages);

        // Hide all items, then show the items for the current page
        scheduleItems.hide();  // Hide all initially
        $(filteredItems.slice(startItem, endItem)).show();  // Show the filtered items for the current page

        // Update pagination buttons
        $('#prevPage').off('click').on('click', function() {
            if (currentPage > 1) {
                currentPage--;
                paginate();
            }
        });

        $('#nextPage').off('click').on('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                paginate();
            }
        });

        // Generate page numbers
        $('#pageNumbers').empty();
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = $('<li>')  // Create page number button
                .addClass('page-item')
                .html(`<a class="page-link" href="#">${i}</a>`)
                .on('click', function() {
                    currentPage = i;
                    paginate();
                });
            if (i === currentPage) {
                pageItem.addClass('active');
            }
            $('#pageNumbers').append(pageItem);
        }
    }

    // Filter the schedules based on the search input
    $('#searchInput').on('input', function() {
    const searchValue = $(this).val().toLowerCase();
    filteredItems = [];  // Reset filteredItems array

    // Loop through all items and check if they match the search term
    scheduleItems.each(function() {
        const teacherName = $(this).data('teacher-name').toLowerCase();
        if (teacherName.includes(searchValue)) {
            $(this).show(); // Show matching item
            filteredItems.push(this);  // Add matching item to filteredItems array (raw DOM element)
        } else {
            $(this).hide(); // Hide non-matching item
        }
    });

    // Show no results message if there are no matching items
    if (filteredItems.length === 0) {
        $('#noResultsMessage').show();
    } else {
        $('#noResultsMessage').hide();
    }

    // Reset to the first page and apply pagination on the filtered items
    currentPage = 1;
    paginate();  // Reapply pagination after filtering
});



    // Initial pagination setup
    paginate();  // Apply pagination on all items initially
});