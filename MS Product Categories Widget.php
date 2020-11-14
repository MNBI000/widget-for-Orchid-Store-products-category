
<?php 




//==============================
//------------------------------
// ---Start copying From Here---
//------------------------------
//==============================




// Creating the widget 
class wpb_widget extends WP_Widget {
  
function __construct() {
parent::__construct(
  
// Base ID of your widget
'wpb_widget', 
  
// Widget name will appear in UI
__('MS All product categories Widget By Awesome Developer', 'wpb_widget_domain'), 
  
// Widget description
array( 'description' => __( 'Custom MS Widget From developer', 'wpb_widget_domain' ), ) 
);
}
  
// Creating widget front-end
  
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
  
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
  
// This is where you run the code and display the output
$terms = get_terms(
    array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    )
);

// Check if any term exists
if ( ! empty( $terms ) && is_array( $terms ) ) {
?>
<section class="cats-widget-styles cats-widget-style-1 section-spacing">
                    <div class="section-inner">
                        <div class="__os-container__">
                            <div class="cats-widget-entry">
                                <div class="os-row">
                                    <?php
    // add links for each category
    foreach ( $terms as $term ) { ?>
    
    
    
    <div class="os-col">
        <div class="card wow osfadeInUp" data-wow-duration="1.5s" data-wow-delay="0.2s">
            <div class="box">
                <div class="left">
                    <div class="thumb">
                        <?php  
                        $thumbnail_id   = get_term_meta( $term->term_id, 'thumbnail_id', true );
                                
                        $image_url      = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
                        
                        if( !empty( $image_url ) ){

                            $term_img_url = $image_url[0];

                        } else {

                            $term_img_url = wc_placeholder_img_src();
                            
                        } 
                        
                        ?>
                        <img src="<?php echo $term_img_url; ?>" alt="<?php echo $term->name; ?>">
                        <!--thumb-->
                    </div>
                </div>
                <div class="right">
                    <div class="title">
                        <h3><a class="btn  btn-default" href="<?php echo esc_url( get_term_link( $term ) ) ?>">
                            <?php echo $term->name; ?>
                        </a></h3>
                    </div><!-- .title -->
                    <div class="product-numbers">
                        <p>
                            <?php  echo $term->count; 
                            if ($term->count > 1 ) {
                            echo esc_html( ' products '  );
                            } else {
                            echo esc_html( ' product '  );
                            }
                            ?>
                        </p>
                    </div><!-- // product-numbers -->
                </div><!-- .right -->
            </div><!-- box -->
        </div><!-- // card -->
    </div><!-- .col -->
    

        <?php
    }
    ?>
</div></div></div></div>
</section>
<?php
}


echo $args['after_widget'];
}
          
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
      
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
 
// Class wpb_widget ends here
} 
 
 
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );