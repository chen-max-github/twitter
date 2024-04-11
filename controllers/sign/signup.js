$("form").submit(function (e) {
  e.preventDefault();

  const username = $("#username").val();
  const email = $("#email").val();
  const password = $("#password").val();
  const birthdate = $("#birthdate").val();

  if (!birthdate || !email || !password) {
    return $("#message").html("Please fill all fields.");
  }

  $.ajax({
    url: "../controllers/sign/signup.php",
    type: "POST",
    data: {
      email: email,
      password: password,
      birthdate: birthdate,
      username: username,
    },

    success: function (response) {
      if (response.message) {
        return $("#message").html(response.message);
      }

      localStorage.setItem("id", response.id);
      window.location.replace("home.html");
    },
  });
});
