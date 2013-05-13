<?php
set_include_path(get_include_path() . PATH_SEPARATOR . './inc/cloudfiles/');
require_once("cloudfiles.php");
require_once("inc/iteminfo.php");

$status = "failure";
$msg = "There's something wrong with your data.";
if (Util::HasValues($_POST, array("n", "d", "q", "t", "a"), $p) && is_numeric($p->d) && isset($_FILES['uploadedfile'])){

	$qualities = array("Unknown", "Magic", "Rare", "Legendary", "Set");
	$types = array_merge(ItemInfo::$itemTypes["Weapon"], ItemInfo::$itemTypes["Two-handed"], ItemInfo::$itemTypes["Off-Hand"], ItemInfo::$itemTypes["Follower"], ItemInfo::$itemTypes["Other"]);
	$secrets = explode("-", $_POST["s"]);
	if (count($secrets) == 2 && Util::IsPInt($secrets[0]) && Util::IsPInt($secrets[1]))
		$user = R::findOne("user", " id=? AND secret=?", $secrets);
	else
		$user = R::findOne("user", " id=1");
	if (!in_array($p->t, $types)){
		$msg = "Unknown Weapon Type.";
	}else if (!in_array($p->q, $qualities)){
		$msg = "Unknown Quality.";
	}elseif ($user){
		$item = R::dispense("item");
		$item->name = $p->n;
		$item->quality = $p->q;
		$item->type = $p->t;
		$item->dps = $p->d;
		$item->stats = $p->a;
		$item->created_at = date("Y-m-d H:i:s", time());
		$item->user = $user;
		$id = R::store($item);
		$msg = "Item ".$item->name." uploaded successfully.";
		$status = "success";
		
		//CloudFiles
		$auth = new CF_Authentication('creepgin','9dbea4b038c48b080d3f88b353ac877d');
		$auth->authenticate();
		$conn = new CF_Connection($auth);
		$cont = $conn->get_container('D3BitTooltips');
		$obj  = $cont->create_object(Util::EncodeId($id) . ".png");
		$obj->content_type = "image/png";
		$result = $obj->load_from_filename($_FILES['uploadedfile']['tmp_name']);

		if (isset($_POST["aid"]) && Util::IsPInt($_POST["aid"]) && $album = R::load("album", $_POST["aid"])) {
			$itemIds = json_decode($album->items_code);
			$itemIds[] = $id;
			$album->items_code = json_encode($itemIds);
			$aid = R::store($album);
		}
	}
}
$res = (object)array("status" => "$status", "msg" => "$msg");
if ($id) 
	$res->link = "http://d3bit.com/i/" . Util::EncodeId($id);
if ($aid)
	$res->link = "http://d3bit.com/a/" . Util::EncodeId($aid);
echo json_encode($res);
?>