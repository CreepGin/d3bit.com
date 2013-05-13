<?php
if (isset(G::$args[1]) && $albumId = Util::DecodeId(G::$args[1])){
	$album = R::load("album", $albumId);
	if ($album->id){
		require_once("inc/iteminfo.php");
		G::$pageTitle = $album->name . " - " . G::$pageTitle;
		$itemIds = json_decode($album->items_code);
		$items = R::batch("item", $itemIds);
		$msgs = json_decode($album->items_msg);
	}else{
		header( "Location: /"  );
	}
}
$c = 0;
?>
<div id="album-page">
	<h1><?php echo Util::HtmlEntities($album->name) ?></h1>
	
	<?php foreach ($items as $item): $c++; $itemInfo = new ItemInfo($item->stats, $item->type, $item->dps); ?>

	<?php if ($c == 4 || count($items) < 4 && $c == 1): ?>
	<div id="comments">
		<div id="disqus_thread"></div>
	  <script type="text/javascript">
	      /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
	      var disqus_shortname = 'd3bit'; // required: replace example with your forum shortname
	      var disqus_identifier = 'a-<?php echo G::$args[1] ?>';

	      /* * * DON'T EDIT BELOW THIS LINE * * */
	      (function() {
	          var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	          dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
	          (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	      })();
	  </script>
	  <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	  <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
	</div>
	<?php endif ?>

	<div class="item">
		<span>
			<strong><?php echo $c ?>.</strong> 
			<div class="starRating small" title="<?php echo $itemInfo->starsRating/2 ?> Stars"><div></div><div style="width: <?php echo round($itemInfo->starsRating*10) ?>%"></div></div>
			<?php if (Auth::$user->id == $item->user_id): ?>
			<img class="control mark-album-item" data-album-id="<?php echo $album->id ?>" data-item-id="<?php echo $item->id ?>" src="/img/pencil.png" title="mark this item" />
			<img class="control delete-album-item" data-album-id="<?php echo $album->id ?>" data-item-id="<?php echo $item->id ?>" src="/img/bin.png" title="remove item from album" />
			<?php endif ?>
		</span>
		<div class="msg <?php if (!$msgs->{$item->id}): ?>hidden<?php endif ?>"><span><?php echo $msgs->{$item->id} ?></span></div>
		<a href="/i/<?php echo Util::EncodeId($item->id) ?>"><img src="//c15208371.r71.cf2.rackcdn.com/<?php echo Util::EncodeId($item->id) ?>.png" alt=""></a>
	</div>
	
	<?php endforeach ?>
	
</div>