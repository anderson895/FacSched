<?php 

                $fetchAllteachers = $db->fetchAllteachers();

                if (!empty($fetchAllteachers)) {  // Check if the array is not empty
                    foreach ($fetchAllteachers as $teacher):
                       
                ?>
                <tr>
                    <td class="p-2"><?= $teacher['ID_code']; ?></td>
                    <td class="p-2"><?= $teacher['fname']; ?></td>
                    <td class="p-2"><?= $teacher['mname']; ?></td>
                    <td class="p-2"><?= $teacher['lname']; ?></td>
                    <td class="p-2"><?= $teacher['designation']; ?></td>
                  
                

                    <td class="p-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm updateTeacherToggler" data-bs-toggle="modal" data-bs-target="#updateTeacherModal"
                                data-teacher_id="<?=$teacher['teacher_id']?>"
                                data-ID_code="<?=$teacher['ID_code']?>"
                                data-fname="<?=$teacher['fname']?>"
                                data-mname="<?=$teacher['mname']?>"
                                data-lname="<?=$teacher['lname']?>"
                                data-designation="<?=$teacher['designation']?>"
                                >Update</button>

                                <button class="btn btn-danger btn-sm removeTeacher" data-teacher_id="<?=$teacher['teacher_id']?>">Remove</button>
                                <a href="view_schedule.php?teacher_id=<?=$teacher['teacher_id']?>"><button class="btn btn-success btn-sm">Schedule</button></a>

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
              