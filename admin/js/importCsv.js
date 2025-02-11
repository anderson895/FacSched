$(document).ready(function() {
    $('#addImportForm').on('submit', function(event) {
        event.preventDefault();

        var fileInput = $('#Datafile')[0].files[0]; // Get the file
        $('#btnImportDataFile').prop('disabled', true);

        if (fileInput) {
            // Read and parse the CSV file using PapaParse
            Papa.parse(fileInput, {
                complete: function(results) {
                    // results.data contains all rows of data
                    var jsonData = formatCSVDataToJSON(results.data);

                    // Now send the JSON data via AJAX
                    $.ajax({
                        url: 'backend/end-points/importCsv.php',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(jsonData), // Send the actual JSON data here
                        success: function(response) {
                            alertify.success('Added Successful');

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error importing data', error);
                            console.log("Response Text: ", xhr.responseText); // Log the actual response
                            alert('Error importing data');
                        }
                    });
                },
                header: true,  // Assuming the first row is the header
                skipEmptyLines: true
            });
        } else {
            $('#btnImportDataFile').prop('disabled', false);
            alertify.error("Please select a file first.");
        }
    });

    // Format the CSV data into JSON
    function formatCSVDataToJSON(data) {
        var jsonData = [];
        
        data.forEach(function(row) {
            var subject = {
                subject_code: row['subject code'], 
                subject_name: row['subject name'],
                lab: row['lab'],
                lec: row['lec'],
                hrs: row['hrs'],
                sem: row['sem'],
                year_level: row['year level'],
                school_year: row['school year']
            };
            jsonData.push(subject);
        });

        return jsonData;
    }
});
