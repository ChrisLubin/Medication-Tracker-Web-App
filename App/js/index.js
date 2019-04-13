$(document).ready(() => {
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
});
