<?php
if (isset(G::$args[1]) && $itemId = Util::DecodeId(G::$args[1])){
	$item = R::load("item", $itemId);
	if ($item->id){
		require_once("inc/iteminfo.php");
		G::$pageTitle = $item->name . " - " . G::$pageTitle;
		$color = "white";
		if ($item->quality == "Magic")
			$color = "#2854D9";
		elseif ($item->quality == "Rare")
			$color = "#FCB910";
		elseif ($item->quality == "Legendary")
			$color = "#CF9030";
		elseif ($item->quality == "Set")
			$color = "#33C526";
		$itemInfo = new ItemInfo($item->stats, $item->type, $item->dps);
	}else{
		header( "Location: /"  );
	}
}

?>
<div id="itemPage">
	<div class="itemHolder">
		<div class="item">
			<h4>Stat Strengths</h4>

			<?php if ($item->dps > 0): ?>
			<div class="dps">
				<div class="name">
					<?php echo in_array($item->type, array_merge(ItemInfo::$itemTypes["Weapon"], ItemInfo::$itemTypes["Two-handed"])) ? "DPS:" : "Armor:" ?>
				</div>
				<div class="value"><?php echo $item->dps ?></div>
			</div>
			<div class="clear"></div>
			<?php endif ?>

			<?php foreach ($itemInfo->stats as $stat): ?>
				<div class="stat">
					<div class="name"><?php echo $stat->name ?></div>
					<div class="progress"><div style="width: <?php echo $stat->progress ?>%"></div></div>
					<div class="value"><?php echo $stat->value ?>/<?php echo $stat->max == 0 ? "--" : $stat->max ?></div>
				</div>
			<?php endforeach ?>
			<div class="clear"></div>
			<div class="divider"></div>
			<div class="starRating big"><div></div><div style="width: <?php echo round($itemInfo->starsRating*10) ?>%"></div></div>
			<div class="clear"></div>
		</div>
		<div class="info">Uploaded at <span class="timeago" title="<?php echo date("c", strtotime($item->updated_at)) ?>"><?php echo $item->updated_at ?></span></div>
	</div>
	<div id="tooltipImage">
		<div class="sharing">
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_floating_style addthis_32x32_style">
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
			<a class="addthis_button_compact"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=st0724"></script>
			<!-- AddThis Button END -->
		</div>
		<img src="//c15208371.r71.cf2.rackcdn.com/<?php echo G::$args[1] ?>.png" alt="">
	</div>
	<div class="clear"></div>
	<div id="comments">
		<div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'd3bit'; // required: replace example with your forum shortname
        var disqus_identifier = 'i-<?php echo G::$args[1] ?>';

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
</div>