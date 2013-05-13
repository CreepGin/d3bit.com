<?php
set_include_path(get_include_path() . PATH_SEPARATOR . './inc/cloudfiles/');
require_once("cloudfiles.php");
if ($_SESSION["loggedin"] != true){
	header( "Location: /"  );
	exit;
}
//User Info Save
if (isset($_GET["s"])){
	if (!Util::HasValues($_GET, array("tag_name", "tag_number"), $p))
		$msg = "Please fill out both Tag name and number";
	else if (!Util::IsValidBattleTag($p->tag_name))
		$msg = "Invalid Battle Tag";
	else if (!Util::IsPInt($p->tag_number))
		$msg = "Invalid Tag Number";
	else {
		Auth::$user->tag_name = $p->tag_name;
		Auth::$user->tag_number = $p->tag_number;
		R::store(Auth::$user);
		$msg = "Saved.";
	}
//Delete Item
}elseif (isset($_GET["d"]) && Util::IsPInt($_GET["d"])){
	$item = R::findOne("item", " id=? AND user_id=?", array($_GET["d"], Auth::$user->id));
	if ($item) {
		try {
		$auth = new CF_Authentication('creepgin','9dbea4b038c48b080d3f88b353ac877d');
		$auth->authenticate();
		$conn = new CF_Connection($auth);
		$cont = $conn->get_container('D3BitTooltips');
		$obj  = $cont->delete_object(Util::EncodeId($item->id) . ".png");
		}catch(Exception $e){}
		R::trash( $item );
		//header( "Location: /user/"  );
	}
//Delete Album
}elseif (isset($_GET["da"]) && Util::IsPInt($_GET["da"])){
	$album = R::findOne("album", " id=? AND user_id=?", array($_GET["da"], Auth::$user->id));
	if ($album) {
		R::trash( $album );
	}
}
$albums = R::find("album", " user_id=? ORDER BY created_at DESC, id DESC LIMIT 0, 32", array(Auth::$user->id));
$items = R::find("item", " user_id=? ORDER BY created_at DESC, id DESC LIMIT 0, 64", array(Auth::$user->id));
?>
<div id="userPage">
	<div class="secret">
		<strong>Account Secret:</strong>
		<input id="secret" value="<?php echo Auth::$user->id . "-" . Auth::$user->secret ?>" />
	</div>
	<div class="userInfo">
		<h3>User Info</h3>
		<?php if (strlen($msg) > 0): ?>
		<div class="msg"><?php echo $msg ?></div>
		<?php endif ?>
		<form action="" method="get">
		<table>
			<tr><td><strong>Battle Tag:</strong></td><td><input name="tag_name" value="<?php echo Auth::$user->tag_name ?>" /></td></tr>
			<tr><td><strong>Tag Number:</strong></td><td><input name="tag_number" value="<?php echo Auth::$user->tag_number ?>" /></td></tr>
		</table>
		<input type="submit" name="s" value="save" />
		</form>
	</div>

	<?php if (count($albums) == 0): ?>
	<div class="note">You have not created any album yet.</div>
	<?php else: ?>
	<table class="items albums" cellspacing="4">
		<tr><th colspan="2">My Albums</th></tr>
		<?php foreach ($albums as $album): ?>
		<?php
		$encodedId = Util::EncodeId($album->id);
		$itemArray = json_decode($album->items_code);
		?>
		<tr onclick="window.location='/a/<?php echo $encodedId ?>'">
			<td><a href="/a/<?php echo $encodedId ?>"><?php echo Util::HtmlEntities($album->name) ?></a> (<?php echo count($itemArray) ?> Items)</td>
			<td><a href="?da=<?php echo $album->id ?>" class="delete">Delete</a></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php endif ?>

	<div class="divider"></div>

	<?php if (count($items) == 0): ?>
	<div class="note">You have not uploaded any item yet.</div>
	<?php else: ?>
	<table class="items" cellspacing="4">
		<tr><th colspan="4">Uploaded Item History</th></tr>
		<?php foreach ($items as $item): ?>
		<?php
		$encodedId = Util::EncodeId($item->id);
		?>
		<tr class="tooltip <?php echo strtolower($item->quality) ?>" data-item-id="<?php echo $encodedId ?>" onclick="window.location='/i/<?php echo $encodedId ?>'">
			<td><a class="<?php echo strtolower($item->quality) ?>" href="/i/<?php echo $encodedId ?>"><?php echo Util::HtmlEntities($item->name) ?></a></td>
			<td><?php echo $item->quality ?> <?php echo $item->type ?></td>
			<td><?php echo $item->stats ?></td>
			<td><a href="?d=<?php echo $item->id ?>" class="delete">Delete</a></td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php endif ?>
</div>