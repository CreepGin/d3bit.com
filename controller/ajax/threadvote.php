<?php
$res = new stdClass();
$res->msg = "Unknown Error.";
if ($_SESSION["loggedin"] && Util::HasValues($_GET, array("tid", "v"), $p) && Util::IsPInt($p->tid) && ($p->v == -1 || $p->v == 1) && R::getCell("SELECT COUNT(*) FROM thread WHERE id=$p->tid") == 1){
	$vote = R::findOne("thread_vote", "user_id=? AND thread_id=?", array(Auth::$user->id, $p->tid));
	$threadUserId = R::getCell("SELECT user_id FROM thread WHERE id=$p->tid");
	if ($threadUserId == Auth::$user->id)
		$threadUserId = 0;
	if (!$vote)
		$vote = R::dispense("thread_vote");
	if ($vote->vote == 1 & $p->v == 1) {
		$vote->vote = 0;
		R::exec( 'update thread set up_vote=up_vote-1 where id='.$p->tid );
		R::exec( 'update user set rep=rep-1 where id='.$threadUserId );
	}else if ($vote->vote == -1 & $p->v == -1) {
		$vote->vote = 0;
		R::exec( 'update thread set down_vote=down_vote-1 where id='.$p->tid );
		R::exec( 'update user set rep=rep+1 where id='.$threadUserId );
	}else{
		if ($p->v == 1){
			R::exec( 'update thread set up_vote=up_vote+1 where id='.$p->tid );
			R::exec( 'update user set rep=rep+1 where id='.$threadUserId );
		}else{
			R::exec( 'update thread set down_vote=down_vote+1 where id='.$p->tid );
			R::exec( 'update user set rep=rep-1 where id='.$threadUserId );
		}
		if ($vote->vote == -1 & $p->v == 1){
			R::exec( 'update thread set down_vote=down_vote-1 where id='.$p->tid );
			R::exec( 'update user set rep=rep+1 where id='.$threadUserId );
		}else if ($vote->vote == 1 & $p->v == -1){
			R::exec( 'update thread set up_vote=up_vote-1 where id='.$p->tid );
			R::exec( 'update user set rep=rep-1 where id='.$threadUserId );
		}
		$vote->vote = $p->v;
	}
	$vote->user = Auth::$user;
	$vote->thread_id = $p->tid;
	$res->id = R::store($vote);
	$res->msg = "Saved.";
}
echo json_encode($res);
?>