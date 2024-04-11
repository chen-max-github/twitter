$(document).ready(function () {
    let username = window.location.search.split("=")[1];

    function fetchUserTweets(username) {
        $.ajax({
            url: '../controllers/users/users_tweets.php', 
            type: "POST",
            data: {
                username: username,
            },
            success: function (response) {
                console.log(response[0]);
                $.each(response, function (value) {
                    const tweet = $("<div>");
            
                    tweet.html(`
                    <p>
                        <span class=text-xl>${response[value]['username']}</span>
                        <span>${response[value]['at_user_name']}</span> 
                        <span>${response[value]['time']}</span>
                    </p>
                    <p>${response[value]['content']}</p>
                    <div class="flex gap-6">
                        <button>
                            <img src="../imgs/comment_icon.png" alt="Comment" class="w-6">
                        </button>
                        <button>
                            <img src="../imgs/retweet_icon.png" alt="Retweet" class="w-6">
                        </button>
                        <button onclick=(like(${this.id}))>
                            <img src="../imgs/heart_icon_empty.png" alt="Like" class="w-6 invert">
                        </button>
                    </div>
                `); 
                $("#tweets").append(tweet);
                });
            },
        });
    }

    $.ajax({
        url: '../controllers/users/users.php', 
        type: "POST",
        data: {
            username: username, 
        },
        success: function (response) {
            if (response.exists) {
                fetchUserTweets(username);
                console.log(username + ' successfully retrieved');
            } else {
                alert("L'utilisateur n'existe pas.");
                location.replace("home.html");
            }
        },
    });
}); 
