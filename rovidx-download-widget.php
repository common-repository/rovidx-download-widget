<?php
/**
 * Plugin Name: RoVidX Download Widget
 * Plugin URI: http://rovidx.com
 * Description: RoVidX Add-On: Adds links to SD & HD file downloads from the RoVidX system.
 * Version: 1.0.1
 * Author: Rob Davenport
 * Author URI: http://smokingmanstudios.com/
 * License: GPL2
 */

// Creating the widget 
class rovidx_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'rovidx_sub', 

// Widget name will appear in UI
__('RoVidX Download Widget', 'rovidx_widget_domain'), 

// Widget description
array( 'description' => __( 'Displays links to Downloads for Files in RoVidX' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
// if ( ! empty( $title ) )
// echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output

$postid = get_the_ID();
$roMetaTitle = get_post_meta($postid, 'rovidx_vtitle', true);
$roSDdownload = get_post_meta($postid, 'rovidx_vurl', true);
$roHDdownload = get_post_meta($postid, 'rovidx_vurlhd', true);


ob_start();
?>
<h4>Download this program:</h4>
<ul>
  <li><a href="<?php echo $roSDdownload; ?>" download>SD Edition (480p)</a></li>
 <?php if ($roHDdownload) { ?> <li><a href="<?php echo $roHDdownload; ?>" download>HD Edition (720p)</a></li> <?php } ?>
</ul><br />

<?php
echo ob_get_clean();
}
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Subscribe/Download', 'rovidx_widget_domain' );
}

if ( isset( $instance[ 'itunes' ] ) ) {
$itunes = $instance[ 'itunes' ];
}

$plugin = ( ABSPATH . 'wp-content/plugins/rovidx/rovidx.php' ); 
if ( is_plugin_active( 'rovidx/rovidx.php' ) ) {
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
} else {
	echo "<p>Please install or activate <a href=\"http://wordpress.org/plugins/rovidx/\" target=\"_blank\">RoVidX</a></p><br />";
}
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['itunes'] = ( ! empty( $new_instance['itunes'] ) ) ? strip_tags( $new_instance['itunes'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function roSub_load_widget() {
	register_widget( 'rovidx_widget' );
}
add_action( 'widgets_init', 'roSub_load_widget' );