<?php 
                                $fetch_workschedule = $db->fetch_workschedule($sched_id);

                                if (!empty($fetch_workschedule)) {
                                    $has_assigned_work = false;
                                    foreach ($fetch_workschedule as $workschedule):

                                        $card_color="";

                                        if ($workschedule['ws_id']) { 
                                            $has_assigned_work = true; 
                                            $start_time = date('h:i A', strtotime($workschedule['ws_subtStartTimeAssign']));
                                            $end_time = date('h:i A', strtotime($workschedule['ws_subtEndTimeAssign']));

                                            if($workschedule['ws_ol_request_status'] =="pending"){
                                                $card_color="bg-warning";
                                            }else if($workschedule['ws_ol_request_status'] =="accept"){
                                                $card_color="bg-success text-white";
                                            }else if($workschedule['ws_ol_request_status'] =="decline"){
                                                $card_color="bg-danger text-white ";
                                            }
                                ?>
                                           <div class="card shadow-sm mb-3 ">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="card-title mb-2">
                                                            <strong><?= $workschedule['course'] ?>, <?= $workschedule['section'] ?>, <?= $workschedule['year_level'] ?></strong>
                                                        </h5>
                                                        <?php if ($has_assigned_work): ?>
                                                            <button class="btn btn-sm btn-outline-danger togglerDeleteWorkSchedule bg-danger text-white" type="button"
                                                            data-ws_id='<?= $workschedule['ws_id']?>'>×</button>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="card-text mb-1"><?= ucfirst($workschedule['subject_name']) ?> - <?= $start_time ?> - <?= $end_time ?></p>
                                                    <small class="text-muted d-block mb-2"><?= $workschedule['ws_roomCode'] ?></small>
                                                    <span class="badge <?=$card_color?> text-dark"><?=$workschedule['ws_ol_request_status']?></span> <!-- Pending status badge -->
                                                </div>
                                            </div>

                                <?php }
                                    endforeach;
                                    
                                    if (!$has_assigned_work) {
                                        echo '<p>No assigned work schedule.</p>';
                                    }
                                } else {
                                    echo '<p>No work schedule assigned.</p>';
                                }
                                
                                $fetch_workschedule = $db->fetch_workscheduleOther($sched_id);

                                if (!empty($fetch_workschedule)) {
                                    $has_assigned_work = false;
                                    foreach ($fetch_workschedule as $workschedule):
                                        if ($workschedule['ows_id']) { 
                                            $has_assigned_work = true; 
                                            $start_time = date('h:i A', strtotime($workschedule['ows_subtStartTimeAssign']));
                                            $end_time = date('h:i A', strtotime($workschedule['ows_subtEndTimeAssign']));
                                ?>
                                           <div class="card shadow-sm mb-3 bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="card-title mb-2">
                                                            <strong><?= ucfirst($workschedule['ows_typeOfWork'])?></strong>
                                                        </h5>
                                                        <?php if ($has_assigned_work): ?>
                                                        <button class="btn btn-sm btn-outline-danger togglerDeleteWorkScheduleOther bg-danger text-white" type="button"
                                                        data-ows_id='<?= $workschedule['ows_id']?>'>×</button>
                                                        <?php endif; ?>
                                                    </div>
                                                    <p class="card-text mb-1"><?= ucfirst($workschedule['ows_work_description']) ?> - <?= $start_time ?> - <?= $end_time ?></p>
                                                    <small class="text-muted d-block mb-2"><?= $workschedule['ows_location'] ?></small>
                                                </div>
                                            </div>
                                <?php }
                                    endforeach;
                                    
                                } else {
                                    echo '<p>No work schedule assigned.</p>';
                                }
                                ?>