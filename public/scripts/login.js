$('#apiLoginForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: '/oauth/token',
      method: 'POST',
      data: {
        grant_type: 'password',
        client_id: client_id,
        client_secret: client_secret,
        username: $('#email').val(),
        password: $('#password').val(),
        scope: ''
      },
      success: function(response) {
        localStorage.setItem('access_token', response.access_token);
        localStorage.setItem('refresh_token', response.refresh_token);
        window.location.href = '/dashboard';
      },
      error: function(xhr) {
        console.log(xhr.responseJSON);
      }
    });
  });

  function logout() {
    localStorage.removeItem('access_token');
    localStorage.removeItem('refresh_token');
    alert('Logged out!');
  }