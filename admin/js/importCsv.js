$(document).ready(function() {
    $('#addImportForm').on('submit', function(event) {
        event.preventDefault();

        var fileInput = $('#Datafile')[0].files[0]; // Get the file
        $('#btnImportDataFile').prop('disabled', true);

        if (fileInput) {
            // Read and parse the CSV file using PapaParse
            Papa.parse(fileInput, {
                complete: function(results) {
                    if (results.errors.length > 0) {
                        alertify.error("CSV file has errors: " + results.errors[0].message);
                        $('#btnImportDataFile').prop('disabled', false);
                        return;
                    }

                    // Check if headers match expected format
                    var requiredHeaders = ["Subject code", "Subject name", "Lab", "Lec", "Hrs", "Sem", "Year level", "School year"];
                    var fileHeaders = results.meta.fields || Object.keys(results.data[0] || {});

                    var missingHeaders = requiredHeaders.filter(header => !fileHeaders.includes(header));

                    if (missingHeaders.length > 0) {
                        alertify.error("Invalid CSV format. Missing headers: " + missingHeaders.join(", "));
                        $('#btnImportDataFile').prop('disabled', false);
                        return;
                    }

                    var jsonData = formatCSVDataToJSON(results.data);

                    if (jsonData.length === 0) {
                        alertify.error("No valid subject rows found.");
                        $('#btnImportDataFile').prop('disabled', false);
                        return;
                    }

                    // Now send the JSON data via AJAX
                    $.ajax({
                        url: 'backend/end-points/importCsv.php',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(jsonData),
                        success: function(response) {
                            alertify.success('Added Successfully');

                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error importing data', error);
                            console.log("Response Text: ", xhr.responseText);
                            alertify.error('Error importing data');
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
            if (row['Subject code'] && row['Subject name']) { // Ensure required fields exist
                var subject = {
                    subject_code: row['Subject code'], 
                    subject_name: row['Subject name'],
                    lab: row['Lab'],
                    lec: row['Lec'],
                    hrs: row['Hrs'],
                    sem: row['Sem'],
                    year_level: row['Year level'],
                    school_year: row['School year']
                };
                jsonData.push(subject);
            }
        });

        return jsonData;
    }
});
