$(document).ready(function () {
  const form = $("#PS");
  const userId = localStorage.getItem("id");

  form.submit((e) => {
    e.preventDefault();

    $.ajax({
      url: "../controllers/message/message.php",
      type: "POST",
      data: form.serialize(),
      success: function (response) {
        console.log(response);
        if (response && response.length > 0) {
          // Si la réponse contient des messages, les afficher
          response.forEach((message) => {
            const Pseudonyme = $("<div>");
            console.log(message.userId);
            if (message.userId == userId) {
              Pseudonyme.css("background-color", "blue");
            } else {
              Pseudonyme.css("background-color", "grey");
            }
            Pseudonyme.html(
              `<span>${message.username}:</span><br><span>${message.content}</span>`
            );
            $("#Pseudonyme").prepend(Pseudonyme); // Utilisation de prepend() au lieu de append()
          });
        } else {
          console.log("Aucun message trouvé.");
        }
      },
      error: function () {
        console.log("Erreur lors de la requête AJAX");
      },
    });
  });

  const formulaire = $("#MS");
  formulaire.submit((e) => {
    e.preventDefault();

    const send = $("#send").val();
    const userId = localStorage.getItem("id");
    const conversation_id = $("#conversation_id").val();

    $.ajax({
      url: "../controllers/message/message.php",
      type: "POST",
      data: {
        send: send,
        userId: userId,
        conversation_id: conversation_id,
      },
      success: function (response) {
        console.log(response.message);
        const Message = $("<div class=bg-blue-500>");
        Message.html(`<span>${response.message}</span>`);
        $("#Message").append(Message);
        $("#Message").on("click", function () {
          console.log("test");
        });
      },
      error: function () {
        console.log("error");
      },
    });
  });

  $("#creer").submit(function (e) {
    e.preventDefault();

    const conversation_id = $("#conversation_id").val();
    const userId = $("#userId").val();

    console.log("conv id = ", conversation_id);
    console.log("id = ", userId);
    $.ajax({
      url: "../controllers/message/message.php",
      type: "POST",
      data: {
        conversation_id: conversation_id,
        userId: userId,
      },
      success: function (response) {
        if (response.success) {
          alert("Conversation créée / rejointe avec succès !");
        } else {
          alert("Échec de la création / rejoindre la conversation !");
          console.log(conversation_id);
          console.log(userId);
        }
      },
      error: function () {
        alert("Une erreur s'est produite lors de la création !");
      },
    });
  });
});
