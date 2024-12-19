<?php 

                $fetch_all_Section = $db->fetch_all_Section();

                if (!empty($fetch_all_Section)) {  // Check if the array is not empty
                    foreach ($fetch_all_Section as $section):
                       
                ?>
                <tr>
                    <td class="p-2"><?= $section['sectionId']; ?></td>
                    <td class="p-2"><?= $section['course']; ?></td>
                    <td class="p-2"><?= $section['year_level']; ?></td>
                    <td class="p-2"><?= $section['section']; ?></td>
                    <td class="p-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary btn-sm updateProductToggler" data-bs-toggle="modal" data-bs-target="#updateSectionModal"
                                data-course="<?=$section['course']?>"
                                data-year_level="<?=$section['year_level']?>"
                                data-section="<?=$section['section']?>"
                                data-sectionid="<?=$section['sectionId']?>"
                                >Update</button>

                                <button class="btn btn-danger btn-sm removeSection" data-sectionid="<?=$section['sectionId']?>">Remove</button>

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
              