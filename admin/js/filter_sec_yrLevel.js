$(document).ready(function() {




    // Show/Hide school year tables
    $('.show-hide-btn').click(function() {
        var schoolYear = $(this).data('school-year');
        var container = $('#school-year-' + schoolYear);
        
        // Toggle visibility
        container.toggle();
        
        // Change button text
        if (container.is(':visible')) {
            $(this).text('Hide ' + schoolYear);
        } else {
            $(this).text('Show ' + schoolYear);
        }
    });




    // Filter on Semester or Year Level change
    $('#semesterFilter, #yearLevelFilter').on('change', function() {
        filterTable();
    });

    // Filter function
    function filterTable() {
        var selectedSemester = $('#semesterFilter').val();
        var selectedYearLevel = $('#yearLevelFilter').val();

        $('#tableEachSchoolYear tbody tr').each(function() {
            var semester = $(this).find('td').eq(5).text().trim();  // Get semester column (6th column)
            var yearLevel = $(this).find('td').eq(6).text().trim();  // Get year level column (7th column)

            var semesterMatch = selectedSemester === "" || semester.includes(selectedSemester + 'st') || semester.includes(selectedSemester + 'nd') || semester.includes(selectedSemester + 'rd') || semester.includes(selectedSemester + 'th');
            var yearLevelMatch = selectedYearLevel === "" || yearLevel.includes(selectedYearLevel + 'st') || yearLevel.includes(selectedYearLevel + 'nd') || yearLevel.includes(selectedYearLevel + 'rd') || yearLevel.includes(selectedYearLevel + 'th');

            if (semesterMatch && yearLevelMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});