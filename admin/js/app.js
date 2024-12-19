$('.updateProductToggler').click(function (e) { 
    e.preventDefault();

    // Retrieve the data attributes from the button
    var sectionId = $(this).data('sectionid'); // data-sectionId -> 'sectionid' in camelCase
    var course = $(this).data('course');
    var year_level = $(this).data('year_level');
    var section = $(this).data('section');

    // Log the sectionId to ensure it's correct
    console.log(sectionId);

    // Set the values of the modal form fields
    $('#sectionId').val(sectionId);
    $('#course').val(course);
    $('#year_level').val(year_level);
    $('#section').val(section);
});



$("#addSectionForm").submit(function (e) {
    e.preventDefault();
    

    $('#spinner').show();
    $('#btnAddSection').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'addSection' });
    var serializedData = $.param(formData);

    // Perform the AJAX request
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      success: function (response) {

        console.log(response)

        if (response === "200") {
          alertify.success('Added Successful');

          setTimeout(function () {
            location.reload();
          }, 1000);

        } else {
          $('#spinner').hide();
          $('#btnAddSection').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('#spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });












  // When the "Remove" button is clicked
  $('.removeProduct').on('click', function () {
    // Get the sectionId from the data attribute
    var sectionId = $(this).data('sectionid');

    // SweetAlert2 confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this section?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete the section
            $.ajax({
                url: "backend/end-points/controller.php",
                type: 'POST',
                data: {sectionId: sectionId,requestType:'deleteSection'}, // Send the sectionId to the server
                success: function(response) {
                    // Handle the response from the server (e.g., refresh the page or show a success message)
                    if (response == '200') {
                        Swal.fire(
                            'Deleted!',
                            'The section has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page to reflect changes
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'There was an issue deleting the section.',
                            'error'
                        );
                    }
                }
            });
        }
    });
});







  
$("#updateSectionForm").submit(function (e) {
    e.preventDefault();
    

    $('#spinner').show();
    $('#btnUpdateSection').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'UpdateSection' });
    var serializedData = $.param(formData);

    // Perform the AJAX request
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      success: function (response) {

        console.log(response)

        if (response === "200") {
          alertify.success('Update Successful');

          setTimeout(function () {
            location.reload();
          }, 1000);

        } else {
          $('#spinner').hide();
          $('#btnUpdateSection').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('#spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });
  