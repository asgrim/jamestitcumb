<?php require_once('header.php'); ?>

<h2>Something went wrong...</h2>
<p>Sorry, but something appears to have gone wrong.</p>

<?php if (isset($exception)): ?>
<p><strong><?php echo get_class($exception); ?>:</strong> <?php echo $exception->getMessage(); ?></p>
<?php endif; ?>

<?php require_once('footer.php'); ?>
