<?php

// the ajax function
add_action('wp_ajax_data_fetchwpwp' , 'data_fetchwpwp');
add_action('wp_ajax_nopriv_data_fetchwpwp','data_fetchwpwp');
function data_fetchwpwp(){

    $the_query = new WP_Query( array( 'posts_per_page' => -1, 's' => esc_attr( $_POST['keyword'] ), 'post_type' => 'booking_agency',
	'tax_query'     => array(
		array(
			'taxonomy'  => 'talentcategory',
			'field'     => 'slug',
			'terms'     => 'speaker',
		),
	), 
	'orderby'=>'post_title',
	'order'=>'ASC',
	
	
	) );
    if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post(); ?>
            <div class="s_box_area">
					<div class="s_box_1">
						<?php the_post_thumbnail('thumbnail' ,array('class' => 's_box_img'));?>
					</div>
					<div class="s_box_2">
						<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title();?></a></h2>
					</div>
				
				<?php?>
			</div>

        <?php endwhile;
        wp_reset_postdata();  
    endif;

    die();
}


function live_search_function_s(){

?>
<style>
	/ width /
	div#datafetchwp::-webkit-scrollbar {
  width: 5px;
  border-radius: 0px;
  
}


/ Track /
div#datafetchwp::-webkit-scrollbar-track {
  background: #0066cc14; 
  border-radius: 0px;
}
 
/ Handle /
div#datafetchwp::-webkit-scrollbar-thumb {
  background: #2e67b2; 
  border-radius: 3px;
  height: 50px;
}
.s_box_area {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    margin: 0px 0px 0px 2px;
}
div#datafetchwp {
    height: 61px;
    scroll-behavior: smooth;
    overflow: auto;
    margin-right: 16px;
    z-index: -9;
    margin-top: -1px;
}
.s_form-live_area {
    display: flex;
}
.s_box_1 img {
    border-radius: 5px;
}
.s_box_1 {
    height: 50px;
    max-width: 66px;
    margin: 5px 0px 5px 0px;
}
.s_box_2 h2 a {
    color: #333;
    margin-left: 10px;
}
.s_box_2 h2 {
    font-size: 20px;
}
.s_form-live_area input {
    border: 1px solid black;
    font-size: 16px;
    padding: 0px 12px;
    background-color: #fff;
}
.s_from_live {
    width: 100%;
    height: 54px;
}
svg.svg-inline--fa.fa-magnifying-glass {
    color: #2e67b2;
}

svg.svg-inline--fa.fa-magnifying-glass {
    color: #2e67b2;
    position: relative;
    overflow: hidden;
    right: 3%;
    top: 20px;
}
</style>
<div class="s_form-live_area">
	<input type="text" name="keyword" class="s_from_live" id="keyword" placeholder="Search..." onkeyup="fetchwp()"></input>
	<i class="fa-solid fa-magnifying-glass"></i>
</div>

<div id="datafetchwp"></div>
<?php

}
add_shortcode( 'live_search_s', 'live_search_function_s');


// add the ajax fetchwp js
add_action( 'wp_footer', 'ajax_fetchwp' );
function ajax_fetchwp() {
?>
<script type="text/javascript">
function fetchwp(){

    jQuery.ajax({
        url: '<?php echo admin_url('admin-ajax.php'); ?>',
        type: 'post',
        data: { action: 'data_fetchwpwp', keyword: jQuery('#keyword').val() },
        success: function(data) {
            jQuery('#datafetchwp').html( data );
        }
    });

}
</script>
<?php
}