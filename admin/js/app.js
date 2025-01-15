$('#subject_id').on('change', function () {
  // Get the selected subject's designated year level
  const selectedYearLevel = $(this).find(':selected').data('designated_year_level');
  
  // Show all options first, then filter based on the selected year level
  $('#sectionId option').each(function () {
      const sectionYearLevel = $(this).data('year-level');
      
      // Show or hide options based on the year level match
      if (sectionYearLevel == selectedYearLevel || !selectedYearLevel) {
          $(this).show(); // Show matching options
      } else {
          $(this).hide(); // Hide non-matching options
      }
  });

  // Reset the section dropdown to its default state
  $('#sectionId').val('').trigger('change');
});

$('#subjectName').on('change', function () {
  // Get the designated year level of the selected subject
  const selectedYearLevel = $(this).find(':selected').data('designated_year_level');

  // Loop through all options in the Section dropdown
  $('#subjectCode option').each(function () {
      const sectionYearLevel = $(this).data('year-level');

      // Show or hide sections based on the match
      if (sectionYearLevel == selectedYearLevel || !selectedYearLevel) {
          $(this).show(); // Show matching sections
      } else {
          $(this).hide(); // Hide non-matching sections
      }
  });

  // Reset the Section dropdown to its default state
  $('#subjectCode').val('').trigger('change');
});

// Trigger the change event manually after the page loads to filter based on initial selections
$(document).ready(function() {


  function validateTimeInput(inputId) {
      $('.' + inputId).on('input', function() {
          var value = $(this).val();
          var parts = value.split(':');
          
          if (parts.length === 2) {
              var hours = parts[0];
              var minutes = parts[1];
              
              // If minutes are not 00 or 30, reset to nearest valid time (00)
              if (minutes !== '00' && minutes !== '30') {
                  $(this).val(hours + ':00'); // Reset to full hour
              }
          }
      });
  }

  // Apply validation to both start and end time inputs
  validateTimeInput('subtStartTimeAssign');
  validateTimeInput('subtEndTimeAssign');
 
  validateTimeInput('subtStartTimeAssign_OverLoad');
  validateTimeInput('subtEndTimeAssign_OverLoad');

  validateTimeInput('subtStartTimeAssign_OverLoad');
  validateTimeInput('subtEndTimeAssign_OverLoad');

  validateTimeInput('subtStartTimeAssign_other');
  validateTimeInput('subtEndTimeAssign_other');



  $('#subject_id').trigger('change');
  $('#subjectName').trigger('change');
});







$(".togglerDeleteWorkSchedule").click(function (e) { 
  e.preventDefault();
  let ws_id= $(this).data('ws_id');
  console.log(ws_id);
   // SweetAlert2 confirmation
   Swal.fire({
    title: 'Are you sure?',
    text: 'Do you want to delete this?',
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
            data: {ws_id: ws_id,requestType:'DeleteWorkSchedule'}, // Send the sectionId to the server
            success: function(response) {
                // Handle the response from the server (e.g., refresh the page or show a success message)
                if (response == '200') {
                    Swal.fire(
                        'Deleted!',
                        'Remove Successful.',
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {

                  console.log(response);

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











$(".togglerDeleteWorkScheduleOther").click(function (e) { 
  e.preventDefault();
  let ows_id= $(this).data('ows_id');
  console.log(ows_id);
   // SweetAlert2 confirmation
   Swal.fire({
    title: 'Are you sure?',
    text: 'Do you want to delete this?',
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
            data: {ows_id: ows_id,requestType:'DeleteWorkScheduleOther'}, // Send the sectionId to the server
            success: function(response) {
                // Handle the response from the server (e.g., refresh the page or show a success message)

               

                if (response == '200') {
                    Swal.fire(
                        'Deleted!',
                        'Remove Successful.',
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page to reflect changes
                    });
                } else {

                  console.log(response);

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


















// teacher_id
$(".TogglerAssignSubject").click(function (e) { 
  e.preventDefault();
  let sched_id = $(this).data('sched_id')
  let remaining_hours = $(this).attr('data-remaining_hours')
  $('#sched_id').val(sched_id);
  $('.remaining_hours').text(remaining_hours);
  console.log(sched_id)  
});


$(".TogglerAssignOtherWork").click(function (e) { 
  e.preventDefault();
  let sched_id = $(this).data('sched_id')
  let remaining_hours = $(this).attr('data-remaining_hours')
  $('#sched_id_other').val(sched_id);
  $('.remaining_hours').text(remaining_hours);
  console.log(sched_id)  
});



$(".TogglerAssignOverLoadWork").click(function (e) { 
  e.preventDefault();
  let sched_id = $(this).data('sched_id')
  let remaining_hours = $(this).attr('data-remaining_hours')
  $('#sched_id_OverLoad').val(sched_id);
  $('.remaining_hours').text(remaining_hours);
  console.log(sched_id)  
});



$("#frmAssign").submit(function (e) {
  e.preventDefault();

  $('.spinner').show();
  $('#btnAssignSched').prop('disabled', true);

  var formData = $(this).serializeArray(); 
  formData.push({ name: 'requestType', value: 'AssignSched' });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      console.log(response);
      if (response === "200") {
        alertify.success('Sched Added Successfully');
        setTimeout(function () {
          location.reload();
        }, 1000);
      } else {
        $('.spinner').hide();
        $('#btnAssignSched').prop('disabled', false);
        alertify.error(response);
      }
    },
    error: function (xhr, status, error) {
      $('.spinner').hide();
      $('#btnAssignSched').prop('disabled', false);
      alertify.error('Request failed: ' + error);
    }
  });
});




$("#frmAssign_OverLoad").submit(function (e) {
  e.preventDefault();

  $('.spinner').show();
  $('#btnAssignSched_OverLoad').prop('disabled', true);

  var formData = $(this).serializeArray(); 
  formData.push({ name: 'requestType', value: 'AssignSched_OverLoad' });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      console.log(response);
      if (response === "200") {
        alertify.success('Sched Added Successfully');
        setTimeout(function () {
          location.reload();
        }, 1000);
      } else {
        $('.spinner').hide();
        $('#btnAssignSched_OverLoad').prop('disabled', false);
        alertify.error(response);
      }
    },
    error: function (xhr, status, error) {
      $('.spinner').hide();
      $('#btnAssignSched_OverLoad').prop('disabled', false);
      alertify.error('Request failed: ' + error);
    }
  });
});







$("#frmAssignOther").submit(function (e) { 
  e.preventDefault();

  $('.spinner').show();
  $('#btnAssignOtherSched').prop('disabled', true);

  var formData = $(this).serializeArray(); 
  formData.push({ name: 'requestType', value: 'AssignSchedOthers' });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      console.log(response);
      if (response === "200") {
        alertify.success('Sched Added Successfully');
        setTimeout(function () {
          location.reload();
        }, 1000);
      } else {
        $('.spinner').hide();
        $('#btnAssignOtherSched').prop('disabled', false);
        alertify.error(response);
      }
    },
    error: function (xhr, status, error) {
      $('.spinner').hide();
      $('#btnAssignOtherSched').prop('disabled', false);
      alertify.error('Request failed: ' + error);
    }
  });
});





// // teacher_id
// $(document).on('click', '.TogglerAssignSubject', function (e) {
//   e.preventDefault();
//   // Your code here
// });


$("#addSubjectForm").submit(function (e) {
    e.preventDefault();
    

    $('.spinner').show();
    $('#btnAddSubject').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'addSubject' });
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
          $('.spinner').hide();
          $('#btnAddSubject').prop('disabled', false);
          alertify.error(response.message);
        }
      }
    });
  });







$("#addSectionForm").submit(function (e) {
    e.preventDefault();
    

    $('.spinner').show();
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
          $('.spinner').hide();
          $('#btnAddSection').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('.spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });






  $('.removeTeacher').on('click', function () {
    // Get the sectionId from the data attribute
    var teacher_id = $(this).data('teacher_id');
    // SweetAlert2 confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to Archive this Teacher?',
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
                data: {teacher_id: teacher_id,requestType:'deleteTeacher'}, 
                success: function(response) {

                    console.log(response);
                    if (response == '200') {
                        Swal.fire(
                            'Deleted!',
                            'The Teacher has been move to archived.',
                            'success'
                        ).then(() => {
                            location.reload(); 
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



  
  $('.removeSubject').on('click', function () {
    // Get the sectionId from the data attribute
    var subject_id = $(this).data('subject_id');

    // SweetAlert2 confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this Subject?',
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
                data: {subject_id: subject_id,requestType:'deleteSubject'}, // Send the sectionId to the server
                success: function(response) {

                    console.log(response);
                    // Handle the response from the server (e.g., refresh the page or show a success message)
                    if (response == '200') {
                        Swal.fire(
                            'Deleted!',
                            'The Subject has been deleted.',
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


  // When the "Remove" button is clicked
  $('.removeSection').on('click', function () {
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
    

    $('.spinner').show();
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
          $('.spinner').hide();
          $('#btnUpdateSection').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('.spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });
  











  
  $("#updateSubjectForm").submit(function (e) {
    e.preventDefault();
    

    $('.spinner').show();
    $('#btnUpdateSection').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'updateSubject' });
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
          $('.spinner').hide();
          $('#btnUpdateSection').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('.spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });
  























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




$('.updateSubjectToggler').click(function (e) { 
    e.preventDefault();

    var subject_id = $(this).data('subject_id'); 
    var subject_code = $(this).data('subject_code');
    var subject_name = $(this).data('subject_name');
    var lab_num = $(this).data('lab_num');
    var lec_num = $(this).data('lec_num');
    var hours = $(this).data('hours');
    var semester = $(this).data('semester');
    var designated_year_level = $(this).data('designated_year_level');

    // Log the sectionId to ensure it's correct
    console.log(designated_year_level);

    // Set the values of the modal form fields
    $('#subjectId').val(subject_id);
    $('#subjectCode').val(subject_code);
    $('#subjectName').val(subject_name);
    $('#lab_num').val(lab_num);
    $('#lec_num').val(lec_num);
    $('#hours').val(hours);
    $('#semester').val(semester);
    $('#designated_year_level').val(designated_year_level);

});








  // addTeacherForm

  $("#addTeacherForm").submit(function (e) {
    e.preventDefault();
    

    $('.spinner').show();
    $('#btnAddTeacher').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'addTeacher' });
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
          $('.spinner').hide();
          $('#btnAddTeacher').prop('disabled', false);
          alertify.error(response);
        }
      },
      error: function () {
        $('.spinner').hide();
        $('#btnAddTeacher').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });






  


  $('.updateTeacherToggler').click(function (e) { 
    e.preventDefault();

    var teacher_id = $(this).data('teacher_id'); 
    var ID_code = $(this).data('id_code');
    var fname = $(this).data('fname');
    var mname = $(this).data('mname');
    var lname = $(this).data('lname');
    var designation = $(this).data('designation');


    $('#teacher_id').val(teacher_id);
    $('#teacherCode').val(ID_code);
    $('#Teacher_Fname').val(fname);
    $('#Teacher_Mname').val(mname);
    $('#Teacher_Lname').val(lname);
    $('#Teacher_designation').val(designation);

});



// updateTeacherForm
$("#updateTeacherForm").submit(function (e) {
  e.preventDefault();
  
  $('.spinner').show();
  $('#btnUpdateTeacher').prop('disabled', true);
  
  var formData = $(this).serializeArray(); 
  formData.push({ name: 'requestType', value: 'updateTeacher' });
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
        $('.spinner').hide();
        $('#btnUpdateTeacher').prop('disabled', false);
        console.log(response); 
        alertify.error(response.message);
      }
    },
    error: function () {
      $('.spinner').hide();
      $('#btnUpdateTeacher').prop('disabled', false);
      alertify.error('An error occurred. Please try again.');
    }
  });
});

