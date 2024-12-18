<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Select Days of the Week</h5>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="dow" class="font-weight-bold">Days of Week</label>
                <select name="dow[]" id="dow" class="custom-select select2 mb-4">
                    <option value="" disabled selected>Select a day</option>
                    <?php 
                    $dow = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
                    for($i = 0; $i < 7; $i++):
                    ?>
                    <option value="<?php echo $dow[$i] ?>"><?php echo $dow[$i] ?></option>
                    <?php endfor; ?>
                </select>
                <div id="selected-days-container" class="mt-3">
                    <!-- Dynamic tags will be added here -->
                </div>
                <input type="hidden" id="selected-days" name="selected-days">
            </div>
        </div>
    </div>
</div>

<style>
    .selected-day-tag {
        display: inline-flex;
        align-items: center;
        padding: 0.5em 0.75em;
        background-color: #007bff;
        color: white;
        border-radius: 50px;
        margin: 0.25em;
        position: relative;
    }

    .selected-day-tag .close {
        color: white;
        font-size: 1rem;
        font-weight: bold;
        margin-left: 0.5em;
        cursor: pointer;
        background: transparent;
        border: none;
    }

    .selected-day-tag .close:hover {
        color: #ff4d4d;
    }
</style>

<script>
    $(document).ready(function() {
        let selectedDays = []; // Array to store selected days

        // Handle adding days
        $('#dow').on('change', function() {
            const selectedDay = $(this).val();
            if (selectedDay && !selectedDays.includes(selectedDay)) {
                selectedDays.push(selectedDay);
                updateSelectedDays();
                addDayTag(selectedDay);
                highlightAddedDays();
            }
            // Reset select to default
            $(this).val('');
        });

        // Update the hidden input field
        function updateSelectedDays() {
            $('#selected-days').val(selectedDays.join(','));
        }

        // Add a tag for the selected day
        function addDayTag(day) {
            $('#selected-days-container').append(`
                <span class="badge badge-pill badge-primary selected-day-tag" data-day="${day}">
                    ${day} <button type="button" class="close" data-day="${day}">&times;</button>
                </span>
            `);
        }

        // Highlight already added options in the dropdown
        function highlightAddedDays() {
            $('#dow option').each(function() {
                const day = $(this).val();
                if (selectedDays.includes(day)) {
                    $(this).css('color', 'gray').attr('disabled', true);
                } else {
                    $(this).css('color', 'black').attr('disabled', false);
                }
            });
        }

        // Handle removing days
        $('#selected-days-container').on('click', '.close', function() {
            const dayToRemove = $(this).data('day');
            selectedDays = selectedDays.filter(day => day !== dayToRemove);
            updateSelectedDays();
            $(`.selected-day-tag[data-day="${dayToRemove}"]`).remove();
            highlightAddedDays();
        });
    });
</script>
