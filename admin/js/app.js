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
      },
      error: function () {
        $('.spinner').hide();
        $('#btnLogin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
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

