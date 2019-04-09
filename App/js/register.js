$(document).ready(() => {
  $('#submit').click(() => {
    // Validation checks should go here

    const fname = $('#fname').val();
    const lname = $('#lname').val();
    const email = $('#email').val();
    const phone = $('#phone').val();
    const password = $('#password').val();
    const isDoc = Boolean($('#doc').is(':checked'));

    $.ajax({
      type: 'post',
      url: 'php/register.php',
      data: {
        fname: fname,
        lname: lname,
        email: email,
        phone: phone,
        password: password,
        isDoc: isDoc
      },
      success: () => {
        window.location = 'login.html';
      },
      statusCode: {
        // Email already exists
        409: () => {
          // Feedback should be given here to let user know that the email already exists
          // Please avoid just using alert, but if you must then so be it
          // Take this log out when done
          console.log('email exists');
        }
      }
    });
  });
});
