$(document).ready(() => {
  $('.dtp').datetimepicker();

  getAppointments();

  $('#createAppointment').click(e => {
    $('#viewAppointments').removeClass('active');
    $('#createAppointment').addClass('active');
    $("#view").hide();
    $("#create").show();
  });

  $('#viewAppointments').click(e => {
    $('#createAppointment').removeClass('active');
    $('#viewAppointments').addClass('active');
    $("#create").hide();
    $("#view").show();
  });

  $('#list-tab').on('click', 'a', function (e) {
    e.preventDefault();
    $('#list-tab a').removeClass('active');
    $(this).addClass('active');
    $('#nav-tabContent div').removeClass('show');
    $(this).tab('show');
  });

  $('#createBtn').click(e => {
    const id = UUID4();
    const start = $('#from').data('DateTimePicker').date().unix();
    const duration = $('#duration').val();
    const title = $('#title').val();
    const content = $('#content').val();
    const doctor = $('#doctor option:selected').val().substr(4);
    const category = `Appointment ${doctor}`;
    
    $.ajax({
      type: 'post',
      url: 'php/addEvent.php',
      data: {
        id: id,
        start: start,
        duration: duration,
        title: title,
        content: content,
        category: category
      },
      success: () => {
        console.log('Event added succesfully');

        // Clear all fields
        $('#from').val("");
        $('#duration').val("");
        $('#title').val("");
        $('#content').val("");
        $('#doctor option:eq(0)').prop('selected', true);

        getAppointments();
        $('#viewAppointments').click();
      },
      statusCode: {
        // Internal server error
        500: () => {
          alert("Server error!");
        }
      }
    });
  });

  $('#logout').click(e => {
    e.preventDefault();
    $.ajax({
      type: 'post',
      url: 'php/logout.php',
      success: () => {
        // Goes to login screen
        console.log('Logged out');
        window.location = 'login.html';
      }
    });
  });

  function UUID4() {
    function S4() {
      return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
    }
    return (S4() + S4() + '-' + S4() + '-4' + S4().substr(0, 3) + '-' + S4() + '-' + S4() + S4() + S4()).toLowerCase();
  }

  function getAppointments() {
    $.ajax({
      type: 'post',
      url: 'php/getAppointments.php',
      statusCode: {
        // OK
        200: results => {
          const result = JSON.parse(results);
          let start;
          let duration;
          let title;
          let content;
          let doctor;
          $('#list-tab').html("");
          $('#nav-tabContent').html("");

          $.each(result, (i, data) => {
            start = moment.unix(data.start).format("MMMM Do YYYY, h:mm A");
            duration = parseInt(data.duration);
            title = data.title;
            content = data.content;
            doctor = data.category.substr(12);
  
            if(duration > 1) {
              duration = `${duration} Hours`;
            } else {
              duration = `${duration} Hour`;
            }
  
            // Show first appointment automatically
            if (i == 0) {
              $('#list-tab').append(`<a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-${i}" role="tab">Dr. ${doctor}</a>`);
              $('#nav-tabContent').append(`<div class="tab-pane fade show" id="list-${i}" role="tabpanel"><div class="list-group">
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">${start}</a>
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">${duration}</a>
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">Title : ${title}</a>
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">Content : ${content}</a>
              </div></div>`);
            } else {
              $('#list-tab').append(`<a class="list-group-item list-group-item-action" data-toggle="list" href="#list-${i}" role="tab">Dr. ${doctor}</a>`);
              $('#nav-tabContent').append(`<div class="tab-pane fade" id="list-${i}" role="tabpanel"><div class="list-group">
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">${start}</a>
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">${duration}</a>
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">Title : ${title}</a>
              <a href="#" class="list-group-item list-group-item-action list-group-item-info">Content : ${content}</a>
              </div></div>`);
            }
          });
        },
        // No content
        204: () => {
          console.log('No appointments in database to retrieve.');
        }
      }
    });
  }
});
