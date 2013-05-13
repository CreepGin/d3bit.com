<?php

?>
<?php if ($showNewPostButton): ?>
<div id="newThreadButton"><a href="/discuss/new/<?php echo $forum->name ?>/">Post New Thread</a></div>
<?php endif ?>
<div id="forumPage">
	<div class="forum">
		<h3><a href="/discuss/<?php echo $forum->name ?>/"><?php echo $forum->title ?></a></h3>
		<div class="description"><?php echo $forum->description ?></div>
		<div class="divider"></div>
		<?php echo G::RenderView("threads", array("forumName"=>$forum->name, "order"=>$order, "forceStickyTop"=>true, "limit"=>$limit)) ?>
	</div>
</div>