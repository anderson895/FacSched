

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