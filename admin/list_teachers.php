<?php 
include "components/header.php";

?>



<div class="container mt-5">
    <h1>List of Teachers</h1>

    <!-- Add Section Button with Icon -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
        <i class="bi bi-plus-circle me-2"></i>Add Teachers
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
                    <th>ID CODE</th>
                    <th style="min-width: 150px;">First name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Designation</th>
                    <th style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
           <?php include "backend/end-points/fetchAllteachers.php";?>
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



























<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
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

        <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addTeacherForm">
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="teacherCode" placeholder="" required>
            <label for="teacherCode" class="form-label">Teacher ID</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="fname" placeholder="" required>
            <label for="fname" class="form-label">First Name</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="mname" placeholder="" >
            <label for="mname" class="form-label">Middle Name (Optional)</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="text" class="form-control" name="lname" placeholder="" required>
            <label for="lname" class="form-label">Last Name</label>
          </div>


          <div class="mb-3 form-floating">
            <select class="form-select" name="designation" id="designation" required>
                <option value="" disabled selected>Select Designation</option>
                <option value="Part Time">Part Time</option>
                <option value="Instructor I">Instructor I</option>
                <option value="Instructor II">Instructor II</option>
                <option value="Instructor III">Instructor III</option>
                <option value="Program Chair">Program Chair</option>
                <option value="Asst. Prof I">Asst. Prof I</option>
                <option value="Asst. Prof II">Asst. Prof II</option>
                <option value="Asst. Prof III">Asst. Prof III</option>
                <option value="Dean">Dean</option>
            </select>
            <label for="designation" class="form-label">Designation</label>
            </div>

          <button type="submit" id="btnAddTeacher" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Save
          </button>
        </form>
      </div>
    </div>
  </div>
</div>








<!-- Update Teacher Modal -->
<div class="modal fade" id="updateTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
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

        <h5 class="modal-title" id="addTeacherModalLabel">Add Update Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateTeacherForm">
         <input hidden type="text" id="teacher_id" name="teacher_id">
          
         
         <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="teacherCode" name="teacherCode" placeholder="" required>
            <label for="teacherCode" class="form-label">Teacher Code</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="">
            <label for="newpassword" class="form-label">New Password</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="Teacher_Fname" name="fname" placeholder="" required>
            <label for="Teacher_Fname" class="form-label">First Name</label>
          </div>
          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="Teacher_Mname" name="mname" placeholder="" >
            <label for="Teacher_Mname" class="form-label">Middle Name (Optional)</label>
          </div>


          <div class="mb-3 form-floating">
            <input type="text" class="form-control" id="Teacher_Lname" name="lname" placeholder="" required>
            <label for="Teacher_Lname" class="form-label">Last Name</label>
          </div>


          


          <div class="mb-3 form-floating">
            <select class="form-select" id="Teacher_designation" name="designation" id="designation" required>
                <option value="" disabled selected>Select Designation</option>
                <option value="Part Time">Part Time</option>
                <option value="Instructor I">Instructor I</option>
                <option value="Instructor II">Instructor II</option>
                <option value="Instructor III">Instructor III</option>
                <option value="Program Chair">Program Chair</option>
                <option value="Asst. Prof I">Asst. Prof I</option>
                <option value="Asst. Prof II">Asst. Prof II</option>
                <option value="Asst. Prof III">Asst. Prof III</option>
                <option value="Dean">Dean</option>
            </select>
            <label for="designation" class="form-label">Designation</label>
            </div>

          <button type="submit" id="btnUpdateTeacher" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>Save
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
