<?php 

                $fetch_all_Subject = $db->fetch_all_Subject();

                if (!empty($fetch_all_Subject)) {  // Check if the array is not empty
                    foreach ($fetch_all_Subject as $subject):
                       
                ?>
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

                <?php 
                    endforeach; 
                } else { ?>
                    <tr>
                        <td colspan="8" class="p-2 text-center">No Record found.</td>
                    </tr>
                <?php } ?>
              