
$.ajax({
    url:"../controllers/follow/follow.php",
    type:"POST",
    data:{
      tweet_id: tweet_id,
    },
    success:function(response){
      
      console.log(response[0]);
      $.ajax({
        url: "../controllers/follow/follow.php",
        type: "POST",
        data: {
          id: id,
        },
        success: function (response) {
          console.log(response);
        },
    
    });
    
  }
  });