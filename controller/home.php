<?php
require_once("inc/iteminfo.php");
$forums = array();
$forumsInfo = json_decode(file_get_contents("data/json/forums.json"));
foreach ($forumsInfo as $f) {
	$forums[$f->name] = $f->title;
}
$items = R::find("item", " 1=1 ORDER BY created_at DESC, id DESC LIMIT 0, 19");
$albums = R::find("album", " id>0 ORDER BY created_at DESC LIMIT 0, 19");
?>
<div id="homePage">
	<div class="topContent">
		<div class="clientDownload">
			<center>
				<a href="http://e5fd3441c586cd7a06b5-bd47888b5e21605c12195dcf5648cc7c.r24.cf2.rackcdn.com/D3Bit_Client_1.1.7f.zip">
				<img src="/img/dlclient_icon.png" alt="">
				<h4>Download Client</h4>
			</center>
			</a>
			<p>
				D3Bit is a tooltip scanner for Diablo 3. You can use it to parse item stats, upload cropped tooltips, batch process screenshots, etc...
			</p>
			<p>
				Current version: 1.1.7f (2013-01-27)<br>
				<a href="https://github.com/CreepGin/D3Bit">GitHub Page</a> - 
				<a href="http://www.youtube.com/watch?v=cXiQmj3-txM">Demo Video</a>
			</p>
			<p>
				Added in this version:
				<ul>
					<li>Localization Support for quality and type strings</li>
					<li>Minor Tweaks</li>
				</ul>
			</p>
		</div>
		<div class="popularThreads">
			<h4>Recent News</h4>
			<?php echo G::RenderView("recent_news") ?>
		</div>
	</div>
	<div id="info">
		<div class="inner">
			<table class="cols">
				<tr>
					<td>
						<h4>Recently Uploaded Items</h4>
						<table class="items">
							<?php foreach ($items as $item): ?>
							<?php
							$itemInfo = new ItemInfo($item->stats, $item->type, $item->dps);
							$encodedId = Util::EncodeId($item->id);
							?>
							<tr data-item-id="<?php echo $encodedId ?>" class="tooltip <?php echo strtolower($item->quality) ?>" onclick="window.location='/i/<?php echo $encodedId ?>'">
								<td><a class="<?php echo strtolower($item->quality) ?>" href="/i/<?php echo $encodedId ?>"><?php echo $item->quality ?> <?php echo $item->type ?></a></td>
								<td><div class="starRating small"><div></div><div style="width: <?php echo round($itemInfo->starsRating*10) ?>%"></div></div></td>
							</tr>
							<?php endforeach ?>
						</table>
					</td>
					<td>
						<h4>New Albums</h4>
						<table class="items albums">
							<?php foreach ($albums as $album): ?>
							<?php
							$encodedId = Util::EncodeId($album->id);
							$itemArray = json_decode($album->items_code);
							?>
							<tr onclick="window.location='/a/<?php echo $encodedId ?>'">
								<td><a href="/a/<?php echo $encodedId ?>"><?php echo $album->name ?></a> (<?php echo count($itemArray) ?> Items)</td>
							</tr>
							<?php endforeach ?>
						</table>
					</td>
					<td>
						<h4><a href="/discuss/support/">Support</a></h4>
						<?php echo G::RenderView("threads", array("forumName"=>"support", "order"=>"normal", "limit"=>10)) ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>