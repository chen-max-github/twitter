const id = localStorage.getItem("id");

if (!id) {
  window.location.replace("signin.html");
}

const openpop = $("#popup");
const modal = $("#modal");
const update = $("#update_account");
const listfollow = $("#list_following");
const message = $("#update_message");

openpop.click(() => {
  modal.toggle();
});

update.submit((e) => {
  e.preventDefault();

  const username = $("#new_username").val();
  const at = $("#new_at_user_name").val();

  if (username.length < 3 && at.length < 3) {
    return message.html("You cannot choose a username or @ under 3 characters");
  }

  $.ajax({
    url: "../controllers/account/popup.php",
    type: "POST",
    data: {
      id: id,
      username: username,
      at: at,
    },

    success: function (response) {
      if (response.message) {
        return message.html(response.message);
      }
    },
  });
});

$.ajax({
  url: "../controllers/account/account.php",
  type: "GET",
  data: {
    id: id,
  },

  success: function (response) {
    if (response.followers) {
      $.each(response.followers, function (index, user) {
        const followers_profil_picture = $(
          `<img src='${user.profile_picture}' alt='Profil picture' class='w-10 rounded-full' />`
        );

        const followers_at = $(
          `<a href='user.html?user=@${user.at_user_name}'>@${user.at_user_name}</a>`
        );

        $("#followers_modal").append(followers_profil_picture, followers_at);
      });
    }

    if (response.following) {
      $.each(response.following, function (index, user) {
        const following_profil_picture = $(
          `<img src='${user.profile_picture}' alt='Profil picture' class='w-10 rounded-full' />`
        );

        const following_at = $(
          `<a href='user.html?user=@${user.at_user_name}'>@${user.at_user_name}</a>`
        );

        $("#following_modal").append(following_profil_picture, following_at);
      });
    }

    if (response.tweets) {
      $.each(response.tweets, function (index, tweet) {
        const div = $("<div>");

        const name = $(
          `<p><span class='text-xl'>${tweet.username}</span> @${tweet.at_user_name} ${tweet.time}</p>`
        );

        const content = $(`<p>${tweet.content}</p>`);

        const buttons = $(`<div class="flex gap-6">
        <button onclick=(comment(${tweet.tweet_id}))>
          <img src="../imgs/comment_icon.png" alt="Comment" class="comment w-10">
        </button>

        <button onclick=(retweet(${tweet.tweet_id}))>
          <img src="../imgs/retweet_icon.png" alt="Retweet" class="retweet w-10">
        </button>

        <button onclick=(like(${tweet.tweet_id}))>
          <img src="../imgs/heart_icon_empty.png" alt="Like" class="like w-10 invert">
        </button>
      </div>`);

        div.append(name, content, buttons);

        $("#tweets").append(div);
      });
    }

    const user = response.user_info[0];

    $("#username").html(user.username);
    $("#created_at").append(user.creation_time);
    $("#banner").html($(`<img src='${user.banner}' />`));
    $("#profil_picture").html(
      $(`<img src='${user.profile_picture}' class='w-20 rounded-full' />'`)
    );
  },
});

$("#followers").click(() => {
  $("#followers_modal").toggle();
});

$("#following").click(() => {
  $("#following_modal").toggle();
});
