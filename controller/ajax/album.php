<?php
$res = (object)array("status"=>"failure"); 
$g = (object)$_GET;
if ($g->a == "add") {
	$name = $g->name;
	$secrets = explode("-", $g->secret);
	if (count($secrets) == 2 && Util::IsPInt($secrets[0]) && Util::IsPInt($secrets[1]))
		$user = R::findOne("user", " id=? AND secret=?", $secrets);
	if ($user && strlen($name) > 2) {
		$album = R::dispense("album");
		$album->name = $name;
		$album->user = $user;
		$album->items_code = json_encode(array());
		$album->items_msg = json_encode(new stdClass());
		$album->created_at = date("Y-m-d H:i:s", time());
		$id = R::store($album);
		$res = (object)array("status"=>"success", "id"=>$id); 
	}
}else if ($g->a == "delete") {

}else if ($g->a == "deleteitem" && Util::IsPInt($g->albumId) && Util::IsPInt($g->itemId)) {
	$album = R::load("album", $g->albumId);
	if ($album && $album->user_id == Auth::$user->id) {
		$itemIds = json_decode($album->items_code);
		$itemIds = array_merge(array_diff($itemIds, array($g->itemId)));
		$album->items_code = json_encode($itemIds);
		R::store($album);
		$res = (object)array("status"=>"success"); 
	}
}else if ($g->a == "markitem" && Util::IsPInt($g->albumId) && Util::IsPInt($g->itemId)) {
	$album = R::load("album", $g->albumId);
	if ($album && $album->user_id == Auth::$user->id) {
		$msgs = json_decode($album->items_msg);
		$msgs->{$g->itemId} = $g->msg ? $g->msg : "";
		$album->items_msg = json_encode($msgs);
		R::store($album);
		$res = (object)array("status"=>"success"); 
	}
}
echo json_encode($res);
?>