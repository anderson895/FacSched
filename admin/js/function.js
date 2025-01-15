function printAcademicSchedule_Section() {
 
    
    // Ensure the teacher's name is captured correctly
    var SectionName = document.getElementById("SectionName").textContent; // Corrected property

    // Add teacher's name and section information to the printed content
    var printContents = "<h6>Schedule for Section:   " + SectionName + "</h6>" + 
                        "<hr><h3>" + SectionName + "</h3>" + 
                        document.getElementById("academicScheduleTable_Section").outerHTML;
    
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}



function printAcademicSchedule() {
    // Capture the selected section and teacher's name
    var selectedSection = document.getElementById("sectionFilter").value;
    var sectionText = selectedSection ? "Section: " + selectedSection : "All Sections";
    
    // Ensure the teacher's name is captured correctly
    var teacherName = document.getElementById("teacherName").textContent; // Corrected property

    // Add teacher's name and section information to the printed content
    var printContents = "<h6>Faculty Schedule for Teacher:   " + teacherName + "</h6>" + 
                        "<hr><h3>" + sectionText + "</h3>" + 
                        document.getElementById("academicScheduleTable").outerHTML;
    
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}



function printOtherSchedule() {
    var teacherName = document.getElementById("teacherName").textContent;
    var printContents = "<h6>Faculty Schedule for Teacher:   " + teacherName + "</h6><hr><h2>Other Work Schedule</h2>" + document.getElementById("otherWorkScheduleTable").outerHTML;
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
        if (selectedSection === "" || entrySection === selectedSection || (selectedSection === "Vacant Hours" && entrySection === "Vacant Hours")) {
            entry.parentElement.style.display = '';
        } else {
            entry.parentElement.style.display = 'none';
        }
    });
}