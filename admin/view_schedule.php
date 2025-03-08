<?php include "components/header.php"; ?>

<?php
$teacher_id = $_GET['teacher_id'];
$teacher = $db->getTeacherInfo($teacher_id);
$teacherName = ucfirst($teacher[0]['fname']) . ' ' . $teacher[0]['mname'] . ' ' . $teacher[0]['lname'];

// Collect sections for filter dropdown
$sections = [];

// Get data from PHP backend
$view_AcademicSchedule = $db->view_AcademicSchedule($teacher_id);
$view_OtherSchedule = $db->view_OtherSchedule($teacher_id);

// Extract sections
foreach ([$view_AcademicSchedule, $view_OtherSchedule] as $schedule) {
    foreach ($schedule['schedule'] as $day => $entries) {
        foreach ($entries as $entry) {
            if (isset($entry['section'])) {
                $sections[] = $entry['section'];
            }
        }
    }
}

// Remove duplicate sections
$sections = array_unique($sections);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Faculty Schedule for Teacher: <span id="teacherName"><?= $teacherName; ?></span></h2>

    <div class="text-center mb-4">
        <button onclick="printAcademicSchedule()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Print Schedule
        </button>
    </div>

    <div class="mb-4">
        <label for="sectionFilter" class="form-label">Filter by Section:</label>
        <select id="sectionFilter" class="form-select" onchange="filterBySection()">
            <option value="">All Sections</option>
            <?php foreach ($sections as $section): ?>
                <option value="<?= htmlspecialchars($section); ?>"><?= htmlspecialchars($section); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="scheduleTable">
            <thead class="table-dark">
                <tr>
                    <th>Time</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                    <th>Sunday</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be inserted here -->
            </tbody>
        </table>
    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/function.js"></script>


<script>
$(document).ready(function () {
    function applyCellStyles() {
        $('#scheduleTable tbody td.time-cell').css({
            "background-color": "#e0f7fa",
            "font-weight": "bold",
            "text-align": "center"
        });

        $('.breaktime-row td').css({
            "background-color": "#ffccbc",
            "font-weight": "bold",
            "text-align": "center"
        });
    }

    fetchSchedules();

    function fetchSchedules() {
        $.ajax({
            url: 'backend/end-points/fetchSchedules.php',
            method: 'GET',
            data: { teacher_id: '<?= $teacher_id; ?>' },
            success: function(response) {
                console.log(response);
                
                let schedules = response;
                let html = '';

                let breaktimeStart = null;
                let breaktimeEnd = null;

                schedules.forEach((schedule, index) => {
                    let isBreaktime = (schedule.time === "12:00 PM - 12:30 PM" || schedule.time === "12:30 PM - 1:00 PM");

                    if (isBreaktime) {
                        if (!breaktimeStart) {
                            breaktimeStart = schedule.time.split(" - ")[0]; // Start of break
                        }
                        breaktimeEnd = schedule.time.split(" - ")[1]; // Keep updating until end of break
                    } else {
                        if (breaktimeStart) {
                            html += `<tr class="breaktime-row">
                                <td class="time-cell">${breaktimeStart} - ${breaktimeEnd}</td>
                                <td colspan="7" class="breaktime-label">BREAKTIME</td>
                            </tr>`;
                            breaktimeStart = null;
                        }

                        html += `<tr>
                            <td class="time-cell">${schedule.time}</td>
                            <td class="monday">${schedule.monday}</td>
                            <td class="tuesday">${schedule.tuesday}</td>
                            <td class="wednesday">${schedule.wednesday}</td>
                            <td class="thursday">${schedule.thursday}</td>
                            <td class="friday">${schedule.friday}</td>
                            <td class="saturday">${schedule.saturday}</td>
                            <td class="sunday">${schedule.sunday}</td>
                        </tr>`;
                    }
                });

                if (breaktimeStart) {
                    html += `<tr class="breaktime-row">
                        <td class="time-cell">${breaktimeStart} - ${breaktimeEnd}</td>
                        <td colspan="7" class="breaktime-label">BREAKTIME</td>
                    </tr>`;
                }

                $('#scheduleTable tbody').html(html);
                mergeTableCells();
                applyCellStyles();
            }
        });
    }

    function mergeTableCells() {
        let days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        days.forEach(day => {
            let prevCell = null;
            let rowspan = 1;

            $(`#scheduleTable tbody tr`).each(function () {
                let currentRow = $(this);
                
                if (currentRow.hasClass('breaktime-row')) {
                    prevCell = null; // Reset merging when a breaktime row is encountered
                    rowspan = 1;
                    return;
                }

                let currentCell = currentRow.find(`td.${day}`);

                if (prevCell && prevCell.text() === currentCell.text() && prevCell.text().trim() !== "") {
                    rowspan++;
                    prevCell.attr("rowspan", rowspan);
                    currentCell.hide();
                } else {
                    prevCell = currentCell;
                    rowspan = 1;
                }
            });
        });
    }

    function convertTo24Hour(timeStr) {
        let match = timeStr.match(/(\d+):(\d+)\s(AM|PM)/);
        if (!match) return 0;

        let hours = parseInt(match[1]);
        let minutes = parseInt(match[2]);
        let period = match[3];

        if (period === "PM" && hours !== 12) {
            hours += 12;
        } else if (period === "AM" && hours === 12) {
            hours = 0;
        }

        return hours * 60 + minutes;
    }
});



</script>
