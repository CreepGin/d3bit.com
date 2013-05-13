<?php
$c = $_GET["c"];
if (in_array($thread->forum, $forumNames))
	$c = $thread->forum;
elseif (in_array(G::$args[2], $forumNames))
	$c = G::$args[2];
?>
<div id="editPage">
	<div id="tipsHolder">
		<h4>Formatting tips</h4>
		<table>
			<tr>
				<th>Markup</th>
				<th>Output</th>
			</tr>
			<tr>
				<td>### header</td>
				<td><h3>header</h3></td>
			</tr>
			<tr>
				<td>**bold**</td>
				<td><strong>bold</strong></td>
			</tr>
			<tr>
				<td>*italic*</td>
				<td><em>italic</em></td>
			</tr>
			<tr>
				<td>* item 1<br>* item 2<br>* item 3</td>
				<td><ul><li>item 1</li><li>item 2</li><li>item 3</li></ul></td>
			</tr>
			<tr>
				<td>1. item 1<br>2. item 2<br>3. item 3</td>
				<td><ol><li>item 1</li><li>item 2</li><li>item 3</li></ol></td>
			</tr>
			<tr>
				<td>[Link](http://google.com/)</td>
				<td><a href="http://google.com/">Link</a></td>
			</tr>
			<tr>
				<td>![alt text](http://d3bit.com/ img/question_mark.png "Title")</td>
				<td><img src="http://d3bit.com/img/question_mark.png" title="Title" alt="alt text"></td>
			</tr>
			<tr>
				<td>&gt; Quote<br>&gt;<br>&gt; Line 2</td>
				<td><blockquote><p>Quote</p><p>Line 2</p></blockquote></td>
			</tr>
		</table>
		<p>Full Markdown syntaxes are supported. For more references, <a target="_blank" href="http://daringfireball.net/projects/markdown/basics">visit here</a>.</p>
	</div>

	<?php if (strlen($msg) > 0): ?>
	<div class="msg"><?php echo $msg ?></div>
	<?php endif ?>

	<form action="" method="post">
		<div class="titleHolder">
			<h4>Title</h4>
			<input name="title" value="<?php echo Util::HtmlEntities($thread->title) ?>" />
		</div>
		<?php if (G::$args[1] == "new" && Auth::$user->type == "admin"): ?>
		<div class="categoryHolder">
			<h4>Category</h4>
			<select name="category">
				<?php foreach ($forums as $forum): ?>
				<option value="<?php echo $forum->name ?>" <?php if ($c==$forum->name) echo 'selected="selected"'; ?>><?php echo $forum->title ?></option>
				<?php endforeach ?>
			</select>
		</div>
		<?php endif ?>
		<div class="bodyHolder">
			<h4>Body</h4>
			<textarea name="body"><?php echo Util::HtmlEntities($thread->body) ?></textarea>
		</div>
		<div class="buttons">
			<input type="submit" name="submit" value="Submit" />
		</div>
	</form>
</div>