$(document).ready(function () {
  let hashtag = window.location.search.split("=")[1];

  function fetchTweets(hashtag) {
    $.ajax({
      url: "../controllers/hashtag/hashtag.php",
      type: "POST",
      data: {
        hashtag: hashtag,
      },
      success: function (response) {
        console.log(response);
        $.each(response, function (value) {
          const tweet = $("<div>");

          tweet.html(`
                      <p>
                          <span class=text-xl>${response[value]["username"]}</span>
                          <span>${response[value]["at_user_name"]}</span> 
                          <span>${response[value]["time"]}</span>
                      </p>
                      <p>${response[value]["content"]}</p>
                      <div class="flex gap-6">
                          <button>
                              <img src="../imgs/comment_icon.png" alt="Comment" class="w-10">
                          </button>
                          <button>
                              <img src="../imgs/retweet_icon.png" alt="Retweet" class="w-10">
                          </button>
                          <button onclick=(like(${this.id}))>
                              <img src="../imgs/heart_icon_empty.png" alt="Like" class="w-10 invert">
                          </button>
                      </div>
                  `);
          $("#tweets").append(tweet);
        });
      },
    });
  }

  $.ajax({
    url: "../controllers/hashtag/hashtag.php",
    type: "POST",
    data: {
      hashtag: hashtag,
    },
    success: function (response) {
      if (response.length === 0) {
        $.ajax({
          url: "../controllers/hashtag/add_hashtag.php",
          type: "POST",
          data: {
            hashtag: hashtag,
          },
          success: function () {
            fetchTweets(hashtag);
          },
        });
      } else {
        fetchTweets(hashtag);
      }
    },
  });
});
