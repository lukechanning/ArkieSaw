<?php

//Display our map for clickable sections

add_action('genesis_loop','map_display');
function map_display() {
	echo '<div id="arkie"></div>';
}

//Display Our Regions
add_action( 'genesis_loop','area_links' );
function area_links() {
    $args = array( 'hide_empty' => 0 );
    $terms = get_terms( 'area', $args );
    ?>
	<div class="member-filter">
		<ul class="sort-links">
	    	<li id="filter--all" class="filter sort-link active" data-filter="*">
	    		<?php _e( 'All', 'arkiesaw' ) ?>
	    	</li>
	    <?php
	    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
	        foreach ( $terms as $term ) {
	        	echo '<li data-filter=".'. $term->slug.'" class=" filter sort-link"><a href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all post filed under %s', 'arkiesaw' ), $term->name ) . '">' . $term->name . '</a></li>';
	        }
	    endif;
	    ?>
    	</ul>
    </div>
    <?php
}

// Add our custom loop
add_action( 'genesis_loop', 'cd_goh_loop' );
function cd_goh_loop() {
?>
<div class="members">
<?php
	$i = 0;
	
	$args = array(
		'post_type' => 'member', // replace with your category slug
		'orderby'       => 'post_date',
		'order'         => 'DESC',
		'posts_per_page'=> '12', // overrides posts per page in theme settings
	);
	$loop = new WP_Query( $args );
	
	if( $loop->have_posts() ) {
		// loop through posts
		while( $loop->have_posts() ): $loop->the_post();
		//Set our counter
		
		
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
	    	echo '<h3>Test text</h3>';
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
	}
	?>
<?php
wp_reset_postdata();
}
genesis();
?>