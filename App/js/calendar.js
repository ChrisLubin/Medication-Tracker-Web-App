$(document).ready(function() {
    $('.dtp').datetimepicker();

    var Calendar = $('#calendar').Calendar();
    Calendar.init();
    console.log(Calendar);

    function UUID4() {
      function S4() {
        return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
      }
      return (S4() + S4() + '-' + S4() + '-4' + S4().substr(0, 3) + '-' + S4() + '-' + S4() + S4() + S4()).toLowerCase();
    }

    /**
     * GET
     */
    $.ajax({
      type: 'post',
      url: 'php/getEvents.php',
      statusCode: {
        // OK
        200: results => {
          var results = JSON.parse(results);
          var events = [];
          $.each(results, (i, data) => {
            events.push({
              _id: data.id,
              start: data.start,
              end: parseInt(data.start) + (3600 * data.duration),
              title: data.title,
              content: data.content,
              category: data.category
            });
          });

          Calendar.addEvents(events);
          Calendar.init();
        },
        // No content
        204: () => {
          console.log('No events in database to retrieve.');
        }
      }
    });

    /**
     * CREATE
     */
    $('#form-create').on('submit', function(event) {
      event.preventDefault();
      var form = $(event.target);
      var id = UUID4();
      var duration = form.find('.duration').val();
      var start = form.find('.start').data('DateTimePicker').date().unix();
      var end = form.find('.start').data('DateTimePicker').date().unix() + (3600 * duration);
      var title = form.find('.title').val();
      var content = form.find('.content').val().replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
      var category = form.find('.category').val();
      var e = {
        _id: id,
        start: start,
        end: end,
        title: title,
        content: content,
        category: category
      };

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
          Calendar.addEvents(e);
          Calendar.init();
          $('#modal-create').modal('hide');
        },
        statusCode: {
          // Internal server error
          500: () => {
            alert("Server error!");
          }
        }
      });
    });

    /**
     * UPDATE and DELETE event : replace the default modal by our modal (#modal-update)
     */
    $('#calendar')
      .unbind('Calendar.event-click')
      .on('Calendar.event-click', function(event, instance, elem, evt) {
        $('#form-update')
          .find('._id')
          .val(evt._id);
        $('#form-update')
          .find('._rev')
          .val(evt._rev);
        $('#form-update')
          .find('.start')
          .data('DateTimePicker')
          .date(moment.unix(evt.start));
        $('#form-update')
          .find('.duration')
          .val((evt.end - evt.start) / 3600);
        $('#form-update')
          .find('.title')
          .val(evt.title);
        $('#form-update')
          .find('.content')
          .val(evt.content.replace(/<br>/g, '\n'));
        $('#form-update')
          .find('.category')
          .val(evt.category);
        $('#modal-update').modal('show');
      });

    /**
     * UPDATE
     */
    $('#form-update').on('submit', function(event) {
      event.preventDefault();
      var form = $(event.target);
      var id = form.find('._id').val();
      var duration = form.find('.duration').val();
      var start = form.find('.start').data('DateTimePicker').date().unix();
      var end = form.find('.start').data('DateTimePicker').date().unix() + (3600 * duration);
      var title = form.find('.title').val();
      var content = form.find('.content').val().replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br>$2');
      var category = form.find('.category').val();
      var e = {
        _id: id,
        start: start,
        end: end,
        title: title,
        content: content,
        category: category
      };

      var events = Calendar.getEvents();
          for (var i = 0; i < events.length; i++) {
            if (events[i]._id == e._id) {
              events[i].start = e.start;
              events[i].end = e.end;
              events[i].title = e.title;
              events[i].content = e.content;
              events[i].category = e.category;

              $.ajax({
                type: 'post',
                url: 'php/updateEvent.php',
                data: {
                  id: id,
                  start: start,
                  duration: duration,
                  title: title,
                  content: content,
                  category: category
                },
                success: () => {
                  console.log('Edit successful');
                },
                statusCode: {
                  // Internal server error
                  500: () => {
                    alert("Server error!");
                  }
                }
              });
            }
          }
          Calendar.init();
          $('#modal-update').modal('hide');
    });

    /**
     * DELETE
     */
    $('#form-update')
      .find('.delete')
      .click(function() {
        var form = $('#form-update');
        var id = form.find('._id').val();

        $.ajax({
          type: 'post',
          url: 'php/deleteEvent.php',
          data: {
            id: id
          },
          success: () => {
            var events = Calendar.getEvents();
            for (var i = 0; i < events.length; i++) {
              if (events[i]._id == id) {
                events.splice(i, 1);
              }
            }
            Calendar.init();
            $('#modal-update').modal('hide');
            console.log('Delete successful');
          },
          statusCode: {
            // Internal server error
            500: () => {
              alert("Server error!");
            }
          }
        });
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
