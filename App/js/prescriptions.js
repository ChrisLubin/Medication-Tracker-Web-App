$(document).ready(() => {
  "use strict";
  let isDoc = $('#patients').val();
  let docResults;
  let oldPrescription;
  let docEmail;
  let prescription;
  let email;

  getPrescriptions();

  $('#addPrescription').click(() => {
    const prescription = $('#prescription').val();
    const instructions = $('#instructions').val();
    const dosage = $('#dosage').val();
    const email = $('#email option:selected').attr('id');

    if (isDoc) {
      const both = $('#email option:selected').val();
      const firstName = both.substr(0, both.indexOf(' '));
      const lastName = both.substr(both.indexOf(' ') + 1);
      //const doctorLastName = $('#email option:selected').val().substr(4);

      $.ajax({
        type: 'post',
        url: 'php/addPrescription.php',
        data: {
          prescription: prescription,
          instructions: instructions,
          dosage: dosage,
          email: email,
          firstName : firstName,
          lastName: lastName
        },
        success: () => {
          // Will automatically redirect to logged in page once it is created (Not yet implemeneted)
          console.log('Prescription added to database.');
  
          // Clear all fields
          $('#prescription').val("");
          $('#instructions').val("");
          $('#dosage').val("");
          $('#email option:eq(0)').prop('selected', true);

          getPrescriptions();
          updateDocPrescriptions();
        },
        statusCode: {
          // Internal server error
          500: () => {
            alert("Server error!");
          }
        }
      });
    } else {
      const lastName = $('#email option:selected').val().substr(4);

      $.ajax({
        type: 'post',
        url: 'php/addPrescription.php',
        data: {
          prescription: prescription,
          instructions: instructions,
          dosage: dosage,
          email: email,
          lastName: lastName
        },
        success: () => {
          // Will automatically redirect to logged in page once it is created (Not yet implemeneted)
          console.log('Prescription added to database.');
  
          // Clear all fields
          $('#prescription').val("");
          $('#instructions').val("");
          $('#dosage').val("");
          $('#email option:eq(0)').prop('selected', true);

          getPrescriptions();
        },
        statusCode: {
          // Internal server error
          500: () => {
            alert("Server error!");
          }
        }
      });
    }

  });

  $('#patients').change(() => {
    updateDocPrescriptions();
  });

  $('#rows').on('click', '.fa-wrench', function (e) {
    const prescription = $(this).parent().parent().parent().children(':nth-child(1)').html().trim();
    const instructions = $(this).parent().parent().parent().children(':nth-child(2)').html().trim();
    const dosage = $(this).parent().parent().parent().children(':nth-child(3)').html().trim();
    oldPrescription = prescription;

    $('#editPrescription').val(prescription);
    $('#editInstructions').val(instructions);
    $('#editDosage').val(dosage);

    if (!isDoc) {
      docEmail = $(this).parent().parent().parent().children(':nth-child(4)').attr('id');
    }
  });

  $('#edit').click(() => {
    const prescription = $('#editPrescription').val().trim();
    const instructions = $('#editInstructions').val().trim();
    const dosage = $('#editDosage').val().trim();
    let email;

    if (isDoc) {
      email = $('#patients option:selected').attr('id');
    } else {
      email = docEmail;
    }

    $.ajax({
      type: 'post',
      url: 'php/editPrescription.php',
      async: false,
      data: {
        prescription: prescription,
        instructions: instructions,
        dosage: dosage,
        oldPrescription: oldPrescription,
        email: email
      },
      success: () => {
        console.log('Edit successful');
        getPrescriptions();
      }
    });
  });

  $('#rows').on('click', '.fa-times', function (e) {
    prescription = $(this).parent().parent().parent().children(':nth-child(1)').html().trim();

    if (isDoc) {
      email = $('#patients option:selected').attr('id');
    } else {
      email = $(this).parent().parent().parent().children(':nth-child(4)').attr('id');
    }
  });

  $('#delete').click(() => {
    
    $.ajax({
      type: 'post',
      url: 'php/deletePrescription.php',
      data: {
        prescription: prescription,
        email: email
      },
      success: () => {
        console.log('Delete successful');
        getPrescriptions();
        if (isDoc) {
          updateDocPrescriptions();
        }
      },
      statusCode: {
        // Internal server error
        500: () => {
          alert("Server error!");
        }
      }
    });
  });

  $(".js-pscroll").each(function() {
    var ps = new PerfectScrollbar(this);

    $(window).on("resize", function() {
      ps.update();
    });
  });

  $(".column100").on("mouseover", function() {
    var table1 = $(this)
      .parent()
      .parent()
      .parent();
    var table2 = $(this)
      .parent()
      .parent();
    var verTable = $(table1).data("vertable") + "";
    var column = $(this).data("column") + "";

    $(table2)
      .find("." + column)
      .addClass("hov-column-" + verTable);
    $(table1)
      .find(".row100.head ." + column)
      .addClass("hov-column-head-" + verTable);
  });

  $(".column100").on("mouseout", function() {
    var table1 = $(this)
      .parent()
      .parent()
      .parent();
    var table2 = $(this)
      .parent()
      .parent();
    var verTable = $(table1).data("vertable") + "";
    var column = $(this).data("column") + "";

    $(table2)
      .find("." + column)
      .removeClass("hov-column-" + verTable);
    $(table1)
      .find(".row100.head ." + column)
      .removeClass("hov-column-head-" + verTable);
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

  function getPrescriptions() {
    $('#rows').html("");

    $.ajax({
      type: 'post',
      url: 'php/getPrescriptions.php',
      async: false,
      statusCode: {
        // OK
        200: results => {
          var results = JSON.parse(results);
          $.each(results, (i, data) => {
            if (isDoc) {
              docResults = results;
            } else {
              $('#rows').append(`<tr class="row100 body">
                <td class="cell100 column1">${data.prescription}</td>
                <td class="cell100 column2">
                ${data.instruction}
                </td>
                <td class="cell100 column3">${data.dosage}</td>
                <td id="${data.doctor}" class="cell100 column4">Dr. ${data.doctorLname}</td>
                <td class="cell100 column5">
                <button type="button">
                  <i
                    class="fa fa-wrench"
                    style="color:black"
                    data-toggle="modal"
                    data-target=".bd-example-modal-smm"
                    id="add"
                  ></i>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <i
                    class="fa fa-times"
                    style="color: red"
                    data-toggle="modal"
                    data-target="#deleteModal"
                  ></i>
                </button>
                </td>
                </tr>`);
            }
          });

          if (isDoc) {
            updateDocPrescriptions();
          }
  
        },
        // No content
        204: () => {
          console.log('No prescriptions in database to retrieve.');
        }
      }
    });
  }

  function updateDocPrescriptions() {
    const email = $('#patients option:selected').attr('id');
    $('#rows').html("");

    $.each(docResults, (i, data) => {
      if (data.patient == email) {
        $('#rows').append(`<tr class="row100 body">
                <td class="cell100 column1">${data.prescription}</td>
                <td class="cell100 column2">
                ${data.instruction}
                </td>
                <td class="cell100 column3">${data.dosage}</td>
                <td class="cell100 column5">
                <button type="button">
                  <i
                    class="fa fa-wrench"
                    style="color:black"
                    data-toggle="modal"
                    data-target=".bd-example-modal-smm"
                    id="add"
                  ></i>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <i
                    class="fa fa-times"
                    style="color: red"
                    data-toggle="modal"
                    data-target="#deleteModal"
                  ></i>
                </button>
                </td>
                </tr>`);
      }
    });
  }
});