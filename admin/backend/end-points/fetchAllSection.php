<div class="container my-4">
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="filterCourse" class="form-select">
                <option value="">Select Course</option>
                <!-- Populate dynamically with courses -->
            </select>
        </div>

        <div class="col-md-4">
            <select id="filterSection" class="form-select">
                <option value="">Select Section</option>
                <!-- Populate dynamically with sections -->
            </select>
        </div>

        <div class="col-md-4">
            <select id="filterYearLevel" class="form-select">
                <option value="">Select Year Level</option>
                <!-- Populate dynamically with year levels -->
            </select>
        </div>
    </div>
</div>


<?php 
    $fetch_all_Section = $db->fetch_all_Section();
    if (!empty($fetch_all_Section)) {  
        foreach ($fetch_all_Section as $section):
?>
<tr class="sectionRow" 
    data-course="<?= $section['course']; ?>" 
    data-section="<?= $section['section']; ?>" 
    data-year_level="<?= $section['year_level']; ?>">
    <td class="p-2"><?= $section['sectionId']; ?></td>
    <td class="p-2"><?= $section['course']; ?></td>
    <td class="p-2"><?= $section['section']; ?></td>
    <td class="p-2"><?= $section['year_level']; ?></td>
    <td class="p-2">
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm updateProductToggler" data-bs-toggle="modal" data-bs-target="#updateSectionModal"
                data-course="<?=$section['course']?>"
                data-year_level="<?=$section['year_level']?>"
                data-section="<?=$section['section']?>"
                data-sectionid="<?=$section['sectionId']?>"
                >Update</button>
            <button class="btn btn-danger btn-sm removeSection" data-sectionid="<?=$section['sectionId']?>">Remove</button>
            <a href="view_Section_schedule.php?sectionId=<?=$section['sectionId']?>"><button class="btn btn-success btn-sm">Schedule</button></a>
        </div>
    </td>
</tr>
<?php 
    endforeach; 
    } else { ?>
    <tr>
        <td colspan="8" class="p-2 text-center">No Record found.</td>
    </tr>
<?php } ?>









                