<?php
get_header();

if (get_field("blog_type") === "1") {?>
<div class="container">
	<?php get_template_part('parts/blogs/pagetitle-text-blog');
		  get_template_part('parts/blogs/text-blog-content');
	?>
</div>
	<div class="previous-blogs-wrap">
        <?php get_template_part('parts/blogs/previous-blogs')?>
	</div>
<?php
} else if (get_field("blog_type") === "2") { ?>
<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<?php get_template_part('parts/blogs/pagetitle-video-blog');
			      get_template_part('parts/blogs/video-blog-content'); ?>

		</div>
		<div class="col-lg-4 pl-lg-5">
			<div class="single-post-sidebar">
                <?php get_sidebar('single-video-blogs')?>
			</div>
		</div>
	</div>
</div>
<?php }	?>

<?php get_template_part('parts/forms-bottom');?>

</div>




<?php get_footer(); ?>
