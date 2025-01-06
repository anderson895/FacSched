<?php 
include "components/header.php";
?>

<div class="container mt-5">
   


<h1>List of Sections</h1>

    <!-- Card for adding new section and search -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- Add Subject Button with Icon -->
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                <i class="bi bi-plus-circle me-2"></i>Add Subject
            </button>

              <!-- Search Input with Icon -->
              <div class="input-group mb-3">
                  <span class="input-group-text"><i class="bi bi-search"></i></span>
                  <input type="text" id="searchInput" class="form-control" placeholder="Search...">
              </div>
        </div>
    </div>

   

  

    <!-- Card Container for Data -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Subject code</th>
                            <th style="min-width: 150px;">Subject name</th>
                            <th>Lab</th>
                            <th>Lec</th>
                            <th>Hrs</th>
                            <th>Sem</th>
                            <th>Year level</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include "backend/end-points/fetchAllsubject.php"; ?>
                    </tbody>
                </table>
                <div id="noResultsMessage" class="alert alert-warning" style="display: none;">
                    No search results found.
                </div>
            </div>
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
    <div class="modal-content shadow-sm">
      <div class="modal-header">
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
            <label for="hrs" class="form-label">Hours</label>
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

<!-- Update Subject Modal -->
<div class="modal fade" id="updateSubjectModal" tabindex="-1" aria-labelledby="updateSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow-sm">
      <div class="modal-header">
        <h5 class="modal-title" id="updateSubjectModalLabel">Update Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateSubjectForm">
          <input hidden type="text" id="subjectId" name="subjectId">
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="subjectCode" name="subjectCode" placeholder="" required>
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
            <label for="hrs" class="form-label">Hours</label>
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
<script src="js/displayTable.js"></script>
