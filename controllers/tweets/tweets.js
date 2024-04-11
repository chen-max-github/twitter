const id = localStorage.getItem("id");

if (!id) {
  window.location.replace("signin.html");
}

displayTweets();
setInterval(displayTweets, 6000);

function displayTweets() {
  $.ajax({
    url: "../controllers/tweets/tweets.php",
    type: "GET",
    data: {
      user_id: id,
      functionality: "getTweets",
    },

    success: function (response) {
      if (response.tweets) {
        $("#tweets").html("");

        $.each(response.tweets, function () {
          const tweet = $(`<div id=${this.tweet_id}>`);

          tweet.html(`
          <p>
            <span class=text-xl>${this.username}</span>
            <span>@${this.at_user_name}</span>
            <span>${this.time}</span>
          </p>
  
          <p>
            ${this.content}
          </p>
  
          <div class="flex gap-6">
            <button onclick=(comment(${this.tweet_id}))>
              <img src="../imgs/comment_icon.png" alt="Comment" class="comment w-10">
            </button>
  
            <button onclick=(retweet(${this.tweet_id}))>
              <img src="../imgs/retweet_icon.png" alt="Retweet" class="retweet w-10">
            </button>
  
            <button onclick=(like(${this.tweet_id}))>
              <img src="../imgs/heart_icon_empty.png" alt="Like" class="like w-10 invert">
            </button>
          </div>
          `);

          $("#tweets").append(tweet);
        });
      }
    },
  });
}

$(".create_tweet_form").submit(function (e) {
  e.preventDefault();

  const content = $("#create_tweet_input").val();

  $.ajax({
    url: "../controllers/tweets/tweets.php",
    type: "POST",
    data: {
      user_id: id,
      response_id: null,
      content: content,
      id_quoted_tweet: null,
      functionality: "comment",
    },

    success: function (response) {
      if (response.success) {
        window.location.reload();
      }
    },
  });
});

$("#create_tweet_input").on("input", () => {
  const text = $("#create_tweet_input").val();

  const array = text.split("");

  let hashtag = [];
  let at = [];

  let is_hashtag = false;
  let is_at = false;

  let current_hashtag = "";
  let current_at = "";

  $.each(array, function (index, character) {
    if (character == "#") {
      return (is_hashtag = true);
    }

    if (character == "@") {
      return (is_at = true);
    }

    if (is_hashtag == true) {
      if (character == " " || character == ".") {
        hashtag.push(current_hashtag);
        current_hashtag = "";
        is_hashtag = false;
      }

      current_hashtag += character;
    }

    if (is_at == true) {
      if (character == " " || character == ".") {
        at.push(current_at);
        current_at = "";
        is_at = false;
      }

      current_at += character;
    }

    if (current_at.length > 0) {
      $.ajax({
        url: "../controllers/tweets/tweets.php",
        type: "GET",
        data: {
          username: current_at,
          functionality: "autocomplete",
        },

        success: function (response) {
          if (response.usernames) {
            const usernames = response.usernames;
            const suggestions = usernames.filter((username) =>
              username.startsWith(current_at)
            );

            let result = $("<div>");

            $.each(suggestions, function (index, username) {
              let p = $("<p>");
              p.html(username);

              result.append(p);
            });

            $("#autocomplete").html(result);
          }
        },
      });
    }

    if (current_at.length == 0) {
      $("#autocomplete").html("");
    }
  });
});

function like(tweet_id) {
  $.ajax({
    url: "../controllers/tweets/tweets.php",
    type: "POST",
    data: {
      user_id: id,
      tweet_id: tweet_id,
      functionality: "like",
    },

    success: function (response) {
      if (response.success) {
        const like = $(`#${tweet_id} .like`);

        like.attr("src") == "../imgs/heart_icon_filled.png"
          ? (like.attr("src", "../imgs/heart_icon_empty.png"),
            like.addClass("invert"))
          : (like.attr("src", "../imgs/heart_icon_filled.png"),
            like.removeClass("invert"));
      }
    },
  });
}

function retweet(tweet_id) {
  $.ajax({
    url: "../controllers/tweets/tweets.php",
    type: "POST",
    data: {
      user_id: id,
      tweet_id: tweet_id,
      functionality: "retweet",
    },

    success: function (response) {
      if (response.success) {
        const retweet = $(`#${tweet_id} .retweet`);

        retweet[0].classList.contains("invert")
          ? retweet.removeClass("invert")
          : retweet.addClass("invert");

        retweet[0].animate({ transform: "rotate(180deg)" }, 600);
      }
    },
  });
}

function comment(tweet_id) {
  const comment = prompt("Comment");

  $.ajax({
    url: "../controllers/tweets/tweets.php",
    type: "POST",
    data: {
      user_id: id,
      tweet_id: tweet_id,
      content: comment,
      functionality: "comment",
    },

    success: function (response) {
      if (response.success) {
        window.location.reload();
      }
    },
  });
}
