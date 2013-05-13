<?php
$v = R::getCell("SELECT vote FROM thread_vote WHERE user_id=? AND thread_id=?", array(Auth::$user->id, $thread->id));
$forumTitle = reset(from('$f')->in($forums)->where('$f => $f->name == "'.$thread->forum.'"')->select('$f->title'));
R::exec( 'update thread set views=views+1 where id=?', array($thread->id) );
G::$pageTitle = $thread->title . " - " . G::$pageTitle;
?>
<div id="threadPage">
	<div id="newThreadButton"><a href="/discuss/new/support/">Post New Thread</a></div>
	<div class="bread">
		<a href="/discuss/">Discussions</a> - 
		<a href="/discuss/<?php echo $thread->forum ?>/"><?php echo $forumTitle ?></a>
	</div>
	<div id="thread">
		<div class="leftControls">
			<div class="voteHolder" data-id="<?php echo $thread->id ?>">
				<div class="voteArrow up <?php if ($v==1) echo "active" ?>"></div>
				<div class="voteValue"><?php echo $thread->up_vote - $thread->down_vote ?></div>
				<div class="voteArrow down <?php if ($v==-1) echo "active" ?>"></div>
			</div>
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
		</div>
		<div class="content">
			<h1><?php echo $thread->title ?></h1>
			<div class="meta">
				Posted by
				<a href="/u/<?php echo $thread->user->id ?>/"><?php echo $thread->user->tag_name ?></a>
				<span class="timeago" title="<?php echo date("c", strtotime($thread->created_at)) ?>"><?php echo $thread->created_at ?></span>
				<?php if (Auth::$user->id == $thread->user->id): ?>
				 - <a href="/discuss/<?php echo $thread->id ?>/edit/">Edit</a>
				<?php endif ?>
			</div>
			<div class="divider"></div>
			<div class="body">
				<?php echo $thread->html ?>
			</div>
		</div>
	</div>
	<!--
	<div id="leaveComment">
		<h3>Comments</h3>
		<div class="comment">
			<textarea id="comment"></textarea>
			<div><input id="submitComment" type="submit" value="leave comment" /></div>
		</div>
	</div>
	-->
	<div id="comments">
		<div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'd3bit'; // required: replace example with your forum shortname
        var disqus_identifier = 't-<?php echo $thread->id ?>';

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