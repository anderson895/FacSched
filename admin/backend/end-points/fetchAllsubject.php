<!-- Card Container for Data -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">

            <!-- Filter Dropdowns -->
            <div class="d-flex gap-4 mb-3">
                <select id="semesterFilter" class="form-select">
                    <option value="">Select Semester</option>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                </select>

                <select id="yearLevelFilter" class="form-select">
                    <option value="">Select Year Level</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>

            <?php
            // Fetch all subjects
            $fetch_all_Subject = $db->fetch_all_Subject();

            if (!empty($fetch_all_Subject)) {
                // Group subjects by school year
                $subjects_by_school_year = [];

                foreach ($fetch_all_Subject as $subject) {
                    // Extract the year and month from subject_date_added
                    $date_added = strtotime($subject['subject_date_added']);
                    $month = date('m', $date_added);
                    $year = date('Y', $date_added);

                    // Determine school year
                    if ($month >= 8) {  // August or later
                        $school_year = $year . '-' . ($year + 1);
                    } else {  // Before August
                        $school_year = ($year - 1) . '-' . $year;
                    }

                    // Group subjects by school year
                    $subjects_by_school_year[$school_year][] = $subject;
                }

                // Sort subjects by school year in descending order (newest first)
                krsort($subjects_by_school_year);

                // Get the latest school year for the button
                $latest_school_year = key($subjects_by_school_year);
                $first = true;

                // Loop through each school year group and display a table for each
                foreach ($subjects_by_school_year as $school_year => $subjects):
                    $is_latest = ($school_year == $latest_school_year);
                    ?>
                    <div class="school-year-container" id="school-year-<?= $school_year ?>" <?= $is_latest ? '' : 'style="display:none;"' ?>>
                        <h4 class="mt-4">School Year - <?= $school_year ?></h4>
                        <table class="table table-striped table-bordered" id="tableEachSchoolYear">
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
                                <?php foreach ($subjects as $subject): ?>
                                <tr>
                                    <td class="p-2"><?= $subject['subject_code']; ?></td>
                                    <td class="p-2"><?= $subject['subject_name']; ?></td>
                                    <td class="p-2"><?= $subject['lab_num']; ?></td>
                                    <td class="p-2"><?= $subject['lec_num']; ?></td>
                                    <td class="p-2"><?= $subject['hours']; ?></td>
                                    <td class="p-2">
                                        <?php
                                            $semester = $subject['semester'];
                                            if ($semester == 1) {
                                                echo $semester . 'st';
                                            } elseif ($semester == 2) {
                                                echo $semester . 'nd';
                                            } elseif ($semester == 3) {
                                                echo $semester . 'rd';
                                            } else {
                                                echo $semester . 'th';
                                            }
                                        ?>
                                    </td>
                                    <td class="p-2">
                                        <?php
                                            $year_level = $subject['designated_year_level'];
                                            if ($year_level == 1) {
                                                echo $year_level . 'st';
                                            } elseif ($year_level == 2) {
                                                echo $year_level . 'nd';
                                            } elseif ($year_level == 3) {
                                                echo $year_level . 'rd';
                                            } else {
                                                echo $year_level . 'th';
                                            }
                                        ?>
                                    </td>

                                    <td class="p-2">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-primary btn-sm updateSubjectToggler" data-bs-toggle="modal" data-bs-target="#updateSubjectModal"
                                                data-subject_id="<?=$subject['subject_id']?>"
                                                data-subject_code="<?=$subject['subject_code']?>"
                                                data-subject_name="<?=$subject['subject_name']?>"
                                                data-lab_num="<?=$subject['lab_num']?>"
                                                data-lec_num="<?=$subject['lec_num']?>"
                                                data-hours="<?=$subject['hours']?>"
                                                data-semester="<?=$subject['semester']?>"
                                                data-designated_year_level="<?=$subject['designated_year_level']?>"
                                                >Update</button>

                                            <button class="btn btn-danger btn-sm removeSubject" data-subject_id="<?=$subject['subject_id']?>">Remove</button>

                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endforeach; ?>
                    <div id="show-hide-buttons">
                        <?php foreach (array_keys($subjects_by_school_year) as $school_year): ?>
                            <?php if ($school_year != $latest_school_year): ?>
                                <button class="btn btn-info btn-sm show-hide-btn" data-school-year="<?= $school_year ?>">Show <?= $school_year ?></button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
            <?php 
            } else { ?>
                <tr>
                    <td colspan="8" class="p-2 text-center">No Record found.</td>
                </tr>
            <?php } ?>
        </div>
    </div>
</div>
