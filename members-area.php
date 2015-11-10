<?php
/**
* A Simple Category Template
*/

get_header(); ?> 

<section id="primary" class="site-content">
<div id="content" role="main">

<?php 
// Check if there are any posts to display
if ( have_posts() ) :

//Get our title, since this is a custom taxonomy
global $wp_query;
$term = $wp_query->get_queried_object();
$title = $term->name;

?>

<header class="archive-header">
<h1 class="archive-title">Our Members in <strong><?php echo $title ?></strong></h1>


<?php
// Display optional category description
 if ( category_description() ) : ?>
<div class="archive-meta"><?php echo category_description(); ?></div>
<?php endif; ?>
</header>

<?php

// The Loop
while ( have_posts() ) : the_post();
	
		$filtering_links = array(
	    	'member-card',
			'one-half'
		);
		//and some variables
		$terms = get_the_terms( $post->ID, 'member' );
	 
	    foreach ( $terms as $term ) {
	        $filtering_links[] = $term->slug;
	    }
	    
		if ($i % 2 == 0) :
			$filtering_links[] = "first";
		endif;
	                        
	    $filtering = join( " ", $filtering_links );
	    ?>
	    
    <div id="post-<?php the_ID(); ?>"<?php post_class( $filtering ); ?>>
		
		<div class="one-third member-image first">
			<a href="<?php get_the_permalink() ?>'">
		    	<?php the_post_thumbnail(); ?>
			</a>
		</div>
		
		<div class="two-thirds member-text">
			<h4><a href="<?php get_the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php the_excerpt(); ?>
		</div>

	</div>
	
</div>

	<?php
	//Let's add to our counter
	$i++;
	unset($filtering_links);
	$filtering_links = [];
	//Close it out!
	endwhile;

else: ?>
<p>Sorry, no posts matched your criteria.</p>


<?php endif; ?>
</div>
</section>

<?php get_footer(); ?>