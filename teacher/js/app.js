




$('.togglerUpdateReq_status').click(function (e) { 
  e.preventDefault();

    
  let ws_id = $(this).data('ws_id');
  console.log(ws_id);
  
  $("#ws_id").val(ws_id);
  $('#togglerUpdateReq_status').modal('show'); // Show the modal using the Bootstrap modal method

});



  // Populate modal with schedule data on button click
  $(".update-schedule-btn").click(function () {
    const day = $(this).data("day");
    const startTime = $(this).data("start");
    const endTime = $(this).data("end");
    const sched_id = $(this).data("sched_id");

    console.log(sched_id);

    $("#scheduleDay").val(day);
    $("#scheduleStartTime").val(startTime);
    $("#scheduleEndTime").val(endTime);
    $("#sched_id").val(sched_id);
});







$("#frmUpdateSchedule").submit(function (e) {
    e.preventDefault();
    console.log('click');
    $('.spinner').show();
    $('#btnUpdateSchedule').prop('disabled', true);

    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'UpdateSchedule' });
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
          $('#btnUpdateSchedule').prop('disabled', false);
          alertify.error(response);
        }
      },
    });
});



$(".btnUpdateReq_status").click(function (e) {
    e.preventDefault();
   let ActionStatus=  $(this).attr('data-ActionStatus');
   let ws_id=  $('#ws_id').val();;
  console.log(ws_id);


    $.ajax({
      type: "POST",
        url: "backend/end-points/controller.php",
        data: { requestType: 'UpdateReq_status', ActionStatus: ActionStatus,ws_id:ws_id},  
        success: function (response) {
        console.log(response)

        if (response === "200") {
          alertify.success('Added Successful');

          setTimeout(function () {
            location.reload();
          }, 1000);

        } else {
          alertify.error(response);
        }
      },
    });
   
});




















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





$("#frmChooseWeeklyHrs").submit(function (e) {
  e.preventDefault();

  $('.spinner-border').show(); // Siguraduhing ito ay visible.
  $('#btnSaveSchedule').prop('disabled', true);

  var formData = $(this).serializeArray();
  formData.push({ name: 'requestType', value: 'ChooseWeeklyHrs' });
  var serializedData = $.param(formData);

  $.ajax({
    type: "POST",
    url: "backend/end-points/controller.php",
    data: serializedData,
    success: function (response) {
      console.log(response);

      if (response.trim() === "200") {
        alertify.success('Update Successful');
        setTimeout(function () {
          location.reload();
        }, 1000);
      } else {
        alertify.error(response);
      }
    },
    error: function () {
      alertify.error('An error occurred while processing your request.');
    },
    complete: function () {
      // Laging itago ang spinner at i-enable ang button sa `complete`
      $('.spinner-border').hide();
      $('#btnSaveSchedule').prop('disabled', false);
    }
  });
});
