<?php
function playcanvas_shortcode( $atts ) {
  $atts = shortcode_atts(
    array(
      'title' => '',
      'url' => '',
      'width' => '100%',
      'height' => '500px',
    ),
    $atts,
    'playcanvas'
  );

  $title = $atts['title'];
  $url = $atts['url'];
  $width = $atts['width'];
  $height = $atts['height'];

  $output = '<div class="playcanvas-container" style="width: ' . $width . '; height: ' . $height . ';">';
  $output .= '<canvas id="application-canvas" width="' . $width . '" height="' . $height . '"></canvas>';
  $output .= '</div>';
  $output .= '<script>';
  $output .= 'var canvas = document.getElementById("application-canvas");';
  $output .= 'var app = new pc.Application(canvas, {});';
  $output .= 'app.start();';
  $output .= 'app.setCanvasFillMode(pc.FILLMODE_FILL_WINDOW);';
  $output .= 'app.setCanvasResolution(pc.RESOLUTION_AUTO);';
  $output .= 'app.loadFromUrl("' . $url . '");';
  $output .= '</script>';

  if ( ! empty( $title ) ) {
    $output = '<h2>' . $title . '</h2>' . $output;
  }

  return $output;
}
add_shortcode( 'playcanvas', 'playcanvas_shortcode' );