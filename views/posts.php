<?php require_once('header.php'); ?>

<?php foreach ($posts as $slug => $post): ?>
<article>
	<div class="article-header">
		<h1><a href="/posts/<?php echo $slug; ?>"><?php echo $post['title']; ?></a></h1>
		<p>Posted on <?php echo date('jS F Y', strtotime($post['date'])); ?></p>
	</div>
	<div class="article-body">
		<?php echo $post['content']; ?>
	</div>
</article>
<?php endforeach; ?>

<?php require_once('footer.php'); ?>
