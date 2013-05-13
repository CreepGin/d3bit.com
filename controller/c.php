<?php
//require_once("inc/iteminfo.php");
$g = (object)$_GET;
//$itemInfo = new ItemInfo($g->stats, $g->type, $g->dps);
$itemTypes = get_object_vars(json_decode(file_get_contents("data/json/itemtypes.json")));
$qualities = array("Magic", "Rare", "Legendary", "Set");
$secrets = explode("-", $g->secret);
$albums = array();
if (count($secrets) == 2 && Util::IsPInt($secrets[0]) && Util::IsPInt($secrets[0])){
	$user = R::findOne("user", " id=? AND secret=?", $secrets);
	$albums = R::find("album", " user_id=? ORDER BY created_at DESC, id DESC LIMIT 0, 32", array($user->id));
}
?>
<!DOCTYPE html>
<html data-nav-highlight-class-name="highlight-global-nav-home">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="stylesheet" href="/css/c.<?php echo G::$version ?>.css">
</head>
<body>
	<div id="outer-wrapper">
		<div id="wrapper">
			<div id="inner">
				<div id="container" class="cf">
					<fieldset>
						<div class="top-note">No OCR algorithm is 100% accurate, please double check the values before uploading.</div>
						<input type="hidden" id="battletag" value="<?php echo $g->battletag ?>" />
						<input type="hidden" id="build" value="<?php echo $g->build ?>" />
					  <label for="name">Name</label><input type="text" id="name" name="name" value="<?php echo $g->name ?>" /><br />
					  <label for="quality">Quality</label>
					  <select name="quality" id="quality">
					  	<option value="Unknown">Unknown</option>
					  	<?php foreach ($qualities as $quality): ?>
					  	<option value="<?php echo $quality ?>" <?php if (ucwords(strtolower($g->quality)) == $quality) echo 'selected="selected"'; ?>><?php echo $quality ?></option>
					  	<?php endforeach ?>
					  </select><br />
					  <label for="type">Type</label>
					  <select name="type" id="type">
					  	<option value="Unknown">Unknown</option>
					  	<?php foreach ($itemTypes as $generalType => $types): ?>
				  		<optgroup label="<?php echo $generalType ?>">
				  			<?php foreach ($types as $type): ?>
				  			<option value="<?php echo $type ?>" <?php if (strtolower($g->type) == strtolower($type)) echo 'selected="selected"'; ?>><?php echo $type ?></option>
				  			<?php endforeach ?>
				  		</optgroup> 
					  	<?php endforeach ?>
					  </select><br />
					  <label for="dps">DPS/Armor</label><input type="text" id="dps" name="dps" value="<?php echo $g->dps ?>" /><br />
					  <?php if ($g->test == 1): ?>
						<label for="meta" title="damage range, attacks per second, chance to block, block amount... (separated by commas)">Meta</label><input type="text" id="meta" name="meta" value="<?php echo $g->meta ?>" /><br />
					  <?php endif ?>
					  <label for="stats">Stats</label><textarea class="expand" type="text" id="stats" name="stats"><?php echo htmlentities($g->stats) ?></textarea><br />
					</fieldset>
				</div>
				<div id="rating" class="cf"></div>
				<div id="stats-progress" class="cf"></div>
				<?php if (isset($g->image)): ?>
				<div id="image-holder" class="cf">
					<img src="file:///<?php echo str_replace("", "", $g->image) ?>" />
				</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<div class="buttons">
		<div class="divider"></div>
		<button title="Upload Item to D3Bit.com or other services." rel="upload"><img src="/img/button_up.png" /> Upload</button>
		<?php if ($g->test == 1): ?>
		<button title="Analyze item &amp; compare against builds on D3Up.com" rel="analyze" data-status="hidden"><img src="/img/button_chart.png" /> Analyze</button>
		<?php endif ?>
		<button title="Reset all fields" rel="reset"><img src="/img/button_reset.png" /> Reset</button>
		<button title="Close this card" rel="close"><img src="/img/button_close.png" /> Close</button>
	</div>
	<div id="upload-overlay" class="overlay">
		<div class="form">
			<p><input type="radio" name="destin" id="d3bit-destin" value="d3bit" checked="checked" /> <label for="d3bit-destin">D3Bit</label></p>
			<p <?php if (!$user): ?>class="disabled" title="To upload to an album, you need to input your account secret in the d3bit client first."<?php endif ?>>
				<input type="radio" name="destin" id="album-destin" value="album" <?php if (!$user): ?>disabled="disabled"<?php endif ?> />
				<label for="album-destin">D3Bit Album</label>
				<select name="album" id="album" <?php if (!$user): ?>disabled="disabled"<?php endif ?>>
					<option value="new">New Album</option>
					<?php foreach ($albums as $album): ?>
					<option value="<?php echo $album->id ?>"><?php echo Util::HtmlEntities($album->name) ?></option>
					<?php endforeach ?>
				</select>
			</p>
			<p><input type="radio" name="destin" id="imgur-destin" value="imgur" /> <label for="imgur-destin">Imgur</label></p>
			<input type="hidden" name="secret" id="secret" value="<?php echo $g->secret ?>" />
			<center><button class="upload">Upload</button><button class="cancel">Cancel</button></center>
		</div>
	</div>
	<div id="d3up-frame"><iframe src=""></iframe></div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	<script src="/watchr/js/iteminfo.<?php echo G::$version ?>.js"></script>
	<script src="/js/c.<?php echo G::$version ?>.js"></script>
</body>
</html>

<?php
die();
?>