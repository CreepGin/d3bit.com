<?php
$orderClause = "created_at";
if ($order == "popular")
	$orderClause = "(score + views / 100) / (1 + (NOW() - created_at) / 40000)";
if ($forceStickyTop)
	$orderClause = "type, " . $orderClause;
$limitClause = "0, 36";
if (isset($limit) && Util::IsPInt($limit))
	$limitClause = "0, $limit";
$all = 0;
if (isset($forumName))
	$all = 99999999;
$threads = G::GetRows("SELECT title, forum, type, user_id, up_vote-down_vote as score, views, created_at, id FROM thread WHERE (type='normal' OR type='sticky' )AND (forum=? OR id>?) ORDER BY $orderClause DESC LIMIT $limitClause", array($forumName, $all));

?>
<?php if (count($threads) == 0): ?>
<div class="notice">No threads yet.</div>
<?php endif ?>
<?php foreach ($threads as $thread): $user = R::load("user", $thread->user_id); ?>
<?php
$v = R::getCell("SELECT vote FROM thread_vote WHERE user_id=? AND thread_id=?", array(Auth::$user->id, $thread->id));
?>
<div class="thread">
	<div class="voteHolder" data-id="<?php echo $thread->id ?>">
		<div class="voteArrow up <?php if ($v==1) echo "active" ?>"></div>
		<div class="voteValue"><?php echo $thread->score ?></div>
		<div class="voteArrow down <?php if ($v==-1) echo "active" ?>"></div>
	</div>
	<div class="threadContent">
		<?php if ($showForumTag): ?>
		<a class="tag" href="/discuss/<?php echo $thread->forum ?>/"><?php echo $forums[$thread->forum] ?></a>
		<?php endif ?>
		<?php if ($thread->type == "sticky"): ?>
		<span class="tag">Sticky</span>
		<?php endif ?>
		<a href="/discuss/<?php echo $thread->id ?>/<?php echo Util::SanitizeForUrl($thread->title) ?>/" class="title"><?php echo Util::HtmlEntities($thread->title) ?></a>
		<div class="meta">
			Posted by
			<a href="/u/<?php echo $user->id ?>/"><?php echo $user->tag_name ?></a>
			<span class="timeago" title="<?php echo date("c", strtotime($thread->created_at)) ?>"><?php echo $thread->created_at ?></span>
			<a data-disqus-identifier="t-<?php echo $thread->id ?>" href="/discuss/<?php echo $thread->id ?>/<?php echo Util::SanitizeForUrl($thread->title) ?>/#disqus_thread"><?php echo Util::HtmlEntities($thread->title) ?></a>
		</div>
	</div>
</div>
<?php endforeach ?>