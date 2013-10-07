<?php require_once('header.php'); ?>

<?php foreach ($posts as $slug => $post): ?>
<article style="margin-bottom: 60px;">
	<div class="article-header">
		<h1><a href="/posts/<?php echo $slug; ?>"><?php echo $post['title']; ?></a></h1>
		<p style="font-weight: bold; font-style: italic;">Posted on <?php echo date('jS F Y', strtotime($post['date'])); ?></p>
	</div>
	<hr />
	<div class="article-body">
		<?php echo $post['content']; ?>
	</div>
</article>
<?php endforeach; ?>

<?php require_once('footer.php'); ?>
