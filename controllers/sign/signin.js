$("form").submit((e) => {
  e.preventDefault();

  const email = $("#email").val();
  const password = $("#password").val();

  if (email == "" || password == "") {
    return $(".message").html("Fill in all the fields.");
  }

  $.ajax({
    url: "../controllers/sign/signin.php",
    type: "POST",
    data: {
      email: email,
      password: password,
    },

    success: function (response) {
      if (response.message) {
        return $(".message").html(response.message);
      }

      if (response.id) {
        localStorage.setItem("id", response.id);
        window.location.replace("home.html");
      }
    },
  });
});
