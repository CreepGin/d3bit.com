<?php
$sources = array(
	"blizz" => "http://diablo3.com/",
	"reddit" => "http://www.reddit.com/r/Diablo",
	"news" => "http://d3bit.com/"
);
$recentNews = R::find("thread", "forum='news' ORDER BY created_at DESC LIMIT 0, 6");

?>

<?php foreach ($recentNews as $thread): ?>
<?php
$v = R::getCell("SELECT vote FROM thread_vote WHERE user_id=? AND thread_id=?", array(Auth::$user->id, $thread->id));
?>
<div class="thread">
	<div class="news-img <?php echo $thread->type ?>"></div>
	<div class="threadContent">
		<?php if ($thread->type == "news"): ?>
			<a href="/discuss/<?php echo $thread->id ?>/<?php echo Util::SanitizeForUrl($thread->title) ?>/" class="title"><?php echo Util::HtmlEntities($thread->title) ?></a>
		<?php else: ?>
			<a href="<?php echo $thread->body ?>"><?php echo Util::HtmlEntities($thread->title) ?></a>
		<?php endif ?>
		<div class="meta">
			Source:
			<a href="<?php echo $sources[$thread->type] ?>"><?php echo ucfirst($thread->type) ?></a> -
			<span class="timeago" title="<?php echo date("c", strtotime($thread->created_at)) ?>"><?php echo $thread->created_at ?></span>
			<?php if ($thread->type == "news"): ?> -
			<a data-disqus-identifier="t-<?php echo $thread->id ?>" href="/discuss/<?php echo $thread->id ?>/<?php echo Util::SanitizeForUrl($thread->title) ?>/#disqus_thread"><?php echo Util::HtmlEntities($thread->title) ?></a>
			<?php endif ?>
		</div>
	</div>
</div>
<?php endforeach ?>