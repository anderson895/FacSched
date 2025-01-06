<?php 
include "components/header.php";
?>

<h1 class="text-center mt-5">Settings</h1>
<p class="text-center">Update your personal information below.</p>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0 text-center">Update Your Information</h3>
                </div>
                <div class="card-body">
                    <form id="frmUpdateAccountSetting">
                        <div class="mb-3" hidden>
                            <label for="firstName" class="form-label">teacher_id</label>
                            <input type="text" class="form-control" name="teacher_id" value="<?=$_SESSION['teacher_id']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?=$teacher['fname']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="middleName" class="form-label">Middle Name (Optional)</label>
                            <input type="text" class="form-control" id="middleName" name="middleName" value="<?=$teacher['mname']?>" >
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?=$teacher['lname']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmNewPassword" name="password">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary">Update Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include "components/footer.php";
?>
