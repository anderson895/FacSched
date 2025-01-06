function printAcademicSchedule() {
    var printContents = "<h2>Academic Schedule</h2>" + document.getElementById("academicScheduleTable").outerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function printOtherSchedule() {
    var printContents = "<h2>Other Work Schedule</h2>" + document.getElementById("otherWorkScheduleTable").outerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}



function filterBySection() {
    var selectedSection = document.getElementById('sectionFilter').value;
    var scheduleEntries = document.querySelectorAll('.schedule-entry');

    scheduleEntries.forEach(function(entry) {
        var entrySection = entry.getAttribute('data-section');
        if (selectedSection === "" || entrySection === selectedSection || (selectedSection === "No Section" && entrySection === "No Section")) {
            entry.parentElement.style.display = '';
        } else {
            entry.parentElement.style.display = 'none';
        }
    });
}