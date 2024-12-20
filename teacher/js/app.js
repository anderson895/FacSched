$("#frmSetSchedule").submit(function (e) { 
    e.preventDefault();

    $('.spinner').show();
    $('#btnSaveSchedule').prop('disabled', true);
    
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'SetSchedule' });
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
          $('#btnSaveSchedule').prop('disabled', false);
          alertify.error(response);
        }
      },
    });
    
});