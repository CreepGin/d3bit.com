(function(){
	$('a.zoombox').zoombox({
    width       : 400,
    height      : 320
  });
  $(".timeago").timeago();

  //Vote Arrows
  $("#thread .voteArrow, .thread .voteArrow").click(function(){
    if (loggedin != true){
      alert("You need to be logged-in to vote.");
      return;
    }
  	var a = $(this);	//arrow element
  	var v = a.parent().find(".voteValue");	//value element
  	var u = a.parent().find(".up");		//down element
  	var d = a.parent().find(".down");		//down element
  	var tid = parseInt(a.parent().attr("data-id"));
  	var s = parseInt(v.text());		//score
  	var active = a.hasClass("active");
  	var up = a.hasClass("up");
  	if (up && active){
  		a.removeClass("active");
  		v.text(s - 1);
  	}else if (up){
  		a.addClass("active");
  		v.text(s + 1);
  		if (d.hasClass("active")){
  			v.text(s + 2);
  			d.removeClass("active");
  		}
  	}else if (!up && active){
  		a.removeClass("active");
  		v.text(s + 1);
  	}else if (!up){
  		a.addClass("active");
  		v.text(s - 1);
  		if (u.hasClass("active")){
  			v.text(s - 2);
  			u.removeClass("active");
  		}
  	}
  	$.get("/ajax/threadvote/", { tid:tid, v:up?1:-1 });
  });

  //Special Links
  $(".delete").click(function(){
    if (!confirm("Are you sure you want to delete this?"))
      return false;
  });
  $(".delete-album-item").click(function(){
    if (!confirm("Are you sure you want to delete this?"))
      return false;
    $.get("/ajax/album/", { a:"deleteitem", albumId:$(this).attr("data-album-id"), itemId:$(this).attr("data-item-id") });
    $(this).parents(".item").remove();
    var c = 1;
    $(".item > span > strong").each(function(){
      $(this).text(c+".");
      c++;
    });
  });
  $(".mark-album-item").click(function(){
    var msg = $(this).parents(".item").find(".msg").text();
    msg = prompt("item message:", msg);
    if (!msg && msg != "") return;
    $.get("/ajax/album/", { a:"markitem", albumId:$(this).attr("data-album-id"), itemId:$(this).attr("data-item-id"), msg:msg });
    var ele = $(this).parents(".item").find(".msg");
    ele.find("span").text(msg);
    ele.removeClass("hidden");
    if (msg == "")
      ele.addClass("hidden");
  });

  //Tooltip
  $(".tooltip").hover(function(e){
    $("body").append("<p id='preview'><img src='http://c15208371.r71.cf2.rackcdn.com/"+ $(this).attr("data-item-id") +".png' alt='' /></p>");                
    $("#preview")
      .css("top",(e.pageY) + "px")
      .css("left",(e.pageX) + "px")
      .fadeIn("fast");   
    $(".tooltip").mousemove();
  },
  function(){
    $("#preview").remove();
  }); 
  $(".tooltip").mousemove(function(e){
    var border_top = $(window).scrollTop();
    var border_right = $(window).width();
    var left_pos;
    var top_pos;
    var offset = 15;
    if(border_right - (offset *2) >= $("#preview").width() + e.pageX){
      left_pos = e.pageX+offset;
    } else{
      left_pos = border_right-$("#preview").width()-offset;
    }

    if(border_top + (offset *2)>= e.pageY - $("#preview").height()){
      top_pos = border_top +offset;
    } else{
      top_pos = e.pageY-$("#preview").height()-offset;
    }
    $("#preview")
      .css("top",top_pos + "px")
      .css("left",left_pos + "px");
  });   

  //focuses
  $(".titleHolder input").focus();
})();