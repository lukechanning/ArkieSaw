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
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        $count = count( $terms );
        $i = 0;
        $term_list = '<ul class="sort-links">';
        foreach ( $terms as $term ) {
            $i++;
        	$term_list .= '<li class="sort-link"><a href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all post filed under %s', 'magazine-pro' ), $term->name ) . '">' . $term->name . '</a></li>';
        	if ( $count != $i ) {
                //$term_list .= ' &middot; ';
            }
            else {
                $term_list .= '</ul>';
            }
        }
        echo $term_list;
    }
}

// Add our custom loop
add_action( 'genesis_loop', 'cd_goh_loop' );
function cd_goh_loop() {
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
		$i = 0;
		if($i % 2 == 0) :
		    //If it's even, make it a first
            echo '<div class="one-half member-card first">';
        else :
            //Else, don't do that!
            echo '<div class="one-half member-card">';
        endif;
        
        //Now run the actual content
		echo '<div class="one-third member-image first"><a href="'. get_the_permalink() .'">';
		    the_post_thumbnail();
		echo '</a></div>';
		echo '<div class="two-thirds member-text">';
			echo '<h4><a href="'. get_the_permalink() .'">' . get_the_title() . '</a></h4>';
			the_excerpt();
		echo '</div>';
    	
    	//Close columns
    	echo "</div>";
    	
    	//Let's add to our counter
    	$i++;
    	//Close it out!
	    endwhile;
	}
	wp_reset_postdata();
}
genesis();
?>