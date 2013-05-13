<?php
set_include_path(get_include_path() . PATH_SEPARATOR . './inc/');
require_once("inc/PHPLinq/LinqToObjects.php");
$forums = json_decode(file_get_contents("data/json/forums.json"));
$forumNames = from('$f')->in($forums)->select('$f->name');

$order = Util::FromSet($_GET["o"], array("new", "popular"), "popular");
$arg = G::$args[1];

//Edit
if (Util::IsPInt($arg) && G::$args[2] == "edit" || G::$args[1] == "new") {
	if (Util::IsPInt($arg) && R::getCell("SELECT COUNT(*) FROM thread WHERE id=$arg AND root_id=0 AND parent_id=0") == 1){	
		$thread = R::load("thread", $arg);
	}else{	
		$thread = R::dispense("thread");
	}
	if (!$_SESSION["loggedin"] || $thread->id && $thread->user_id != Auth::$user->id){
		header("Location: /");
		exit;
	}
	$p = (object)$_POST;
	if (Auth::$user->type != "admin")
		$p->category = "support";
	if ($p->submit == "Submit" && (in_array($p->category, $forumNames) || $thread->id)){
		$thread->title = $p->title;
		$thread->body = $p->body;
		if (!$thread->id)
			$thread->forum = $p->category;
		if (strlen($p->title) < 5){
			$msg = "Your title is too short";
		}else if (strlen($p->body) < 20){
			$msg = "Your body text is too short";
		}else{
			require_once("inc/markdown.php");
			$thread->html = Markdown($thread->body);
			$thread->user = Auth::$user;
			if (!$thread->id)
				$thread->created_at = date( 'Y-m-d H:i:s', time() );
			$id = R::store($thread);
			header("Location: /discuss/$id/");
			exit;
		}
	}
	echo G::RenderView("threadedit", array("forums"=>$forums, "forumNames"=>$forumNames, "thread"=>$thread, "msg"=>$msg));

//Display Thread Page
}else if (Util::IsPInt($arg) && $thread = R::load("thread", $arg)){
	echo G::RenderView("thread", array("forums"=>$forums, "thread"=>$thread));

//Individual Forums
}else if (in_array($arg, $forumNames)){
	$forum = reset(from('$f')->in($forums)->where('$f => $f->name == "'.$arg.'"')->select('$f'));
	echo G::RenderView("forum", array("forum"=>$forum, "showNewPostButton" => true));

//All Forums
}else{
	echo G::RenderView("discuss", array("forums"=>$forums, "order"=>$order));
}
?>
