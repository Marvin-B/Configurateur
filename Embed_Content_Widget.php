<?php

class Embed_Content_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'embed_content_widget', // Base ID
      'Embed Content Widget', // Name
      array( 'description' => ( 'A widget for embedding content in your sidebar or footer', 'text_domain' ), ) // Args
    );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    $embed_code = $instance['embed_code'];

    echo $args['before_widget'];
    if ( ! empty( $title ) ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $embed_code;
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'New title', 'text_domain' );
    }
    if ( isset( $instance[ 'embed_code' ] ) ) {
      $embed_code = $instance[ 'embed_code' ];
    }
    else {
      $embed_code = ( '', 'text_domain' );
    }
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'embed_code' ); ?>"><?php _e( 'Embed Code:' ); ?></label> 
      <textarea class="widefat" id="<?php echo $this->get_field_id( 'embed_code' ); ?>" name="<?php echo $this->get_field_name( 'embed_code' ); ?>"><?php echo esc_attr( $embed_code ); ?></textarea>
    </p>
    <?php 
  }

  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['embed_code'] = ( ! empty( $new_instance['embed_code'] ) ) ? $new_instance['embed_code'] : '';
    return $instance;
  }

}

