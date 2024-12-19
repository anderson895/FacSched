<?php 
include "components/header.php";
?>

<div class="container mt-5">
    <h1>List of Sections</h1>

    <!-- Add Section Button with Icon -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSectionModal">
        <i class="bi bi-plus-circle me-2"></i>Add Section
    </button>

    <!-- Search Input with Icon -->
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="searchInput" class="form-control" placeholder="Search for names, emails, or phones">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th style="width: 20px;">#</th>
                    <th>Name</th>
                    <th style="min-width: 150px;">Email</th>
                    <th>Phone</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john.doe@example.com</td>
                    <td>123-456-7890</td>
                    <td><button class="btn btn-primary btn-sm w-100"><i class="bi bi-pencil-square"></i> Edit</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane.smith@example.com</td>
                    <td>987-654-3210</td>
                    <td><button class="btn btn-primary btn-sm w-100"><i class="bi bi-pencil-square"></i> Edit</button></td>
                </tr>
              
            </tbody>
              <!-- Add more rows as needed -->
          
        </table>
        <div id="noResultsMessage" class="alert alert-warning" style="display: none;">
                    No search results found.
            </div>
    </div>

    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </nav>
</div>

<!-- Add Section Modal -->
<div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSectionModalLabel">Add New Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addSectionForm">
          <div class="mb-3">
            <label for="sectionName" class="form-label">Name</label>
            <input type="text" class="form-control" id="sectionName" required>
          </div>
          <div class="mb-3">
            <label for="sectionEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="sectionEmail" required>
          </div>
          <div class="mb-3">
            <label for="sectionPhone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="sectionPhone" required>
          </div>
          <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Add Section
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- jQuery Script for Search, Pagination, and Add Section -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
</script>


<?php 
include "components/footer.php";
?>
