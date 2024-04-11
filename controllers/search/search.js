$(document).ready(function () {
  const form = $("#searchUser");

  form.submit((e) => {
      e.preventDefault();

      let Value = $("#searchHashtag").val();
      if (Value.startsWith("#")) {
          Value = Value.substring(1);
      }
      if (Value.startsWith("@")) {
        $.ajax({
          url: "user.html?user=" + Value,
          type: "POST",
          data: form.serialize(),
          success: function (response) {
              console.log(response);
              window.location.replace("user.html?user=" + Value);
              return;
          },
        })
      }
      $.ajax({
          url: "hashtag.html?hashtag=" + Value,
          type: "POST",
          data: form.serialize(),
          success: function (response) {
              console.log(response);
              window.location.replace("hashtag.html?hashtag=" + Value);
          },
      });
  });
});
