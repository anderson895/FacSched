<?php 
include "components/header.php";

?>



<div class="container mt-5">
    <h1>List of sections</h1>

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
                    <th>Section ID</th>
                    <th style="min-width: 150px;">Course</th>
                    <th>Year Level</th>
                    <th>Section</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
           <?php include "backend/end-points/fetchAllSection.php";?>
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

      <div id="spinner" style="display:none;">
                <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

        <h5 class="modal-title" id="addSectionModalLabel">Add New Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addSectionForm">
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="course" placeholder="" required>
            <label for="course" class="form-label">Course</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="year_level" placeholder="" required>
            <label for="year_level" class="form-label">Year Level</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="section" placeholder="" required>
            <label for="section" class="form-label">Section</label>
          </div>
          <button type="submit" id="btnAddSection" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Add Section
          </button>
        </form>
      </div>
    </div>
  </div>
</div>











<!-- update Section Modal -->
<div class="modal fade" id="updateSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

      <div id="spinner" style="display:none;">
                <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

        <h5 class="modal-title" id="addSectionModalLabel">Update Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateSectionForm">

        <input hidden type="text" id="sectionId" name="sectionId">
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="course" name="course" placeholder="" required>
            <label for="course" class="form-label">Course</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="year_level" name="year_level" placeholder="" required>
            <label for="year_level" class="form-label">Year Level</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="section" name="section" placeholder="" required>
            <label for="section" class="form-label">Section</label>
          </div>
          <button type="submit" id="btnUpdateSection" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Update Section
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
