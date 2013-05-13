<?php
$msg = "There's something wrong with your data.";
if (Util::HasValues($_GET, array("n", "d", "q", "t", "i", "a", "s"), $p) && is_numeric($p->d) && ctype_digit($p->i) && $p->i >= 0 && $p->i <= 100){
	$qualities = array("Unknown", "Common", "Magic", "Rare", "Legendary", "Set");
	$itemtypes = get_object_vars(json_decode(file_get_contents("data/json/itemtypes.json")));
	//$types = array_merge($itemtypes["Weapon"], $itemtypes["Off-Hand"], $itemtypes["Follower"], $itemtypes["Common"]);
	$types = array_merge($itemtypes["Weapon"], $itemtypes["Off-Hand"], $itemtypes["Follower"], $itemtypes["Common"]);
	$secrets = explode("-", $p->s);
	if (count($secrets) == 2 && Util::IsPInt($secrets[0]) && Util::IsPInt($secrets[0]))
		$user = R::findOne("user", " id=? AND secret=?", $secrets);
	$msg = "Your secret is wrong.";
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
		$item->ilvl = $p->i;
		$item->user = $user;
		$id = R::store($item);
		$msg = "Item ".$item->name." uploaded successfully.";
	}
}
$res = (object)array("msg" => "$msg");
if ($id)
	$res->link = "http://d3bit.com/i/" . Util::EncodeId($id);
echo json_encode($res);
?>