<?php

?>
<div id="discussPage">
	<div id="newThreadButton"><a href="/discuss/new/">Post New Thread</a></div>
	<?php foreach ($forums as $forum): ?>
	<?php echo G::RenderView("forum", array("forum"=>$forum, "limit"=>20)) ?>
	<?php endforeach ?>
</div>