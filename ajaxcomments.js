jQuery(document).ready(function(){

  // Loading Comments
  var commentHolder = $("#list_all_comments"); // Where we will append comments.
  var id = $("#list_all_comments").data("id"); // id is added to comment form as data-id in html part, but you can retrieve it any way you want.
  $("#more-comments").on("click", function(event){ // click button to load more comments
    var offset = $(".comment").length; //how many comments we already have on the screen is offset for get_comment function.
    $.ajax({
      url: admin_urls.admin_ajax,
      type: 'post',
      data: {
        'postCommentNonce' : admin_urls.postCommentNonce, // security thingy
        'action' : 'load_comments',
        'post_id' : id,
        'start_from' : offset
      },
      success: function(data) {
        //console.log(data);
        $(commentHolder).append(data);
      },
      error: function(error) {
        console.log(error);
      }
    });
    return false;
  });
});
