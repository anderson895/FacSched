$("#frmLoginTeacher").submit(function (e) {
    e.preventDefault();
    

    $('.spinner').show();
    $('#btnLoginTeacher').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'LoginTeacher' });
    var serializedData = $.param(formData);

    // Perform the AJAX request
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      dataType: 'json',
      success: function (response) {

        console.log(response.status)

        if (response.status === "success") {
          alertify.success('Login Successful');

          setTimeout(function () {
            window.location.href = "teacher/index.php"; 
          }, 1000);

        } else {
          $('#spinner').hide();
          $('#btnLoginTeacher').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('#spinner').hide();
        $('#btnLoginTeacher').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });

















  $("#frmLoginAdmin").submit(function (e) {
    e.preventDefault();
    

    $('#spinner').show();
    $('#btnLoginAdmin').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'LoginAdmin' });
    var serializedData = $.param(formData);

    // Perform the AJAX request
    $.ajax({
      type: "POST",
      url: "backend/end-points/controller.php",
      data: serializedData,
      dataType: 'json',
      success: function (response) {

        console.log(response.status)

        if (response.status === "success") {
          alertify.success('Login Successful');

          setTimeout(function () {
            window.location.href = "admin/index.php"; 
          }, 1000);

        } else {
          $('#spinner').hide();
          $('#btnLoginAdmin').prop('disabled', false);
          console.log(response); 
          alertify.error(response.message);
        }
      },
      error: function () {
        $('#spinner').hide();
        $('#btnLoginAdmin').prop('disabled', false);
        alertify.error('An error occurred. Please try again.');
      }
    });
  });
