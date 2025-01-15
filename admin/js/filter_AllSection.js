$(document).ready(function() {
    // Populate filter options dynamically (optional)
    var courses = [], sections = [], yearLevels = [];
    
    // Loop through all rows to gather unique courses, sections, and year levels
    $('.sectionRow').each(function() {
        var course = $(this).data('course');
        var section = $(this).data('section');
        var yearLevel = $(this).data('year_level');
        
        if (!courses.includes(course)) courses.push(course);
        if (!sections.includes(section)) sections.push(section);
        if (!yearLevels.includes(yearLevel)) yearLevels.push(yearLevel);
    });

    // Populate filter dropdowns
    $.each(courses, function(i, item) {
        $('#filterCourse').append('<option value="'+item+'">'+item+'</option>');
    });

    $.each(sections, function(i, item) {
        $('#filterSection').append('<option value="'+item+'">'+item+'</option>');
    });

    $.each(yearLevels, function(i, item) {
        $('#filterYearLevel').append('<option value="'+item+'">'+item+'</option>');
    });

    // Handle filter change
    $('#filterCourse, #filterSection, #filterYearLevel').on('change', function() {
        var courseFilter = $('#filterCourse').val().toLowerCase();
        var sectionFilter = $('#filterSection').val().toLowerCase();
        var yearLevelFilter = $('#filterYearLevel').val().toLowerCase();

        $('.sectionRow').each(function() {
            var course = $(this).data('course').toLowerCase();
            var section = $(this).data('section').toLowerCase();
            var yearLevel = $(this).data('year_level').toLowerCase();

            // Show or hide rows based on filter match
            if ((courseFilter === "" || course.includes(courseFilter)) &&
                (sectionFilter === "" || section.includes(sectionFilter)) &&
                (yearLevelFilter === "" || yearLevel.includes(yearLevelFilter))) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
