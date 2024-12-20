<?php 
include "components/header.php";

?>



<div class="container mt-5">
    <h1>List of Subjects</h1>

    <!-- Add Section Button with Icon -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
        <i class="bi bi-plus-circle me-2"></i>Add Subject
    </button>

    <!-- Search Input with Icon -->
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>Subject code</th>
                    <th style="min-width: 150px;">Subject name</th>
                    <th>lab</th>
                    <th>lec</th>
                    <th>Hrs</th>
                    <th>Sem</th>
                    <th>Year level</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
           <?php include "backend/end-points/fetchAllsubject.php";?>
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























<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="aaddSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

      <div id="spinner" class="spinner" style="display:none;">
                <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

        <h5 class="modal-title" id="aaddSubjectModalLabel">Add New Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addSubjectForm">
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="subjectCode" placeholder="" required>
            <label for="subjectCode" class="form-label">Subject code</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="subjectName" placeholder="" required>
            <label for="subjectName" class="form-label">Subject Name</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="lab" placeholder="" required>
            <label for="lab" class="form-label">Lab</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="lec" placeholder="" required>
            <label for="lec" class="form-label">Lec</label>
          </div>

          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="hrs" placeholder="" required>
            <label for="hrs" class="form-label">hrs</label>
          </div>


          <div class="mb-3 form-floating">
            <select class="form-select" name="Sem" id="Sem" required>
              <option value="" disabled selected>Select Semester</option>
              <option value="1">1st Semester</option>
              <option value="2">2nd Semester</option>
            </select>
            <label for="Sem" class="form-label">Semester</label>
          </div>


          
          <div class="mb-3 form-floating">
            <select class="form-select" name="yrlvl" id="yrlvl" required>
              <option value="" disabled selected>Select Year Level</option>
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
            </select>
            <label for="yrlvl" class="form-label">Year Level</label>
          </div>




          <button type="submit" id="btnAddSubject" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Add Subject
          </button>
        </form>
      </div>
    </div>
  </div>
</div>











<!-- update Section Modal -->
<div class="modal fade" id="updateSubjectModal" tabindex="-1" aria-labelledby="updateSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

      <div id="spinner" class="spinner" style="display:none;">
                <div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

        <h5 class="modal-title" id="updateSubjectModalLabel">Update Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateSubjectForm">

        <input hidden type="text" id="subjectId" name="subjectId">
        <div class="mb-3 form-floating">
            <input  type="text" class="form-control" id="subjectCode" name="subjectCode" placeholder="" required>
            <label for="subjectCode" class="form-label">Subject code</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="subjectName" name="subject_name" placeholder="" required>
            <label for="subjectName" class="form-label">Subject Name</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="lab_num" name="lab_num" placeholder="" required>
            <label for="lab" class="form-label">Lab</label>
          </div>
          

          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="lec_num" name="lec_num" placeholder="" required>
            <label for="lec" class="form-label">Lec</label>
          </div>

          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="hours" name="hours" placeholder="" required>
            <label for="hrs" class="form-label">hrs</label>
          </div>


          <div class="mb-3 form-floating">
            <select class="form-select" id="semester" name="semester" required>
              <option value="" disabled selected>Select Semester</option>
              <option value="1">1st Semester</option>
              <option value="2">2nd Semester</option>
            </select>
            <label for="Sem" class="form-label">Semester</label>
          </div>


          
          <div class="mb-3 form-floating">
            <select class="form-select" id="designated_year_level" name="designated_year_level" required>
              <option value="" disabled selected>Select Year Level</option>
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
            </select>
            <label for="yrlvl" class="form-label">Year Level</label>
          </div>

          <button type="submit" id="btnUpdateSection" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Update Subject
          </button>
        </form>
      </div>
    </div>
  </div>
</div>










<?php 
include "components/footer.php";
?>


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