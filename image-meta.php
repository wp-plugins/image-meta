<?php
/*
Plugin Name: Image Meta
Plugin URI: http://blog.robfelty.com/plugins/image-meta
Description: Allows user to select filename or iptc caption for image meta info. <a href='options-general.php?page=image-meta.php'>Settings</a>
Author: Robert Felty
Version: 0.1
Author URI: http://robfelty.com
*/ 

$image_meta_options = get_option('image-meta');
function image_meta_read_filter($metadata, $file, $type) {
  //$image_meta_options = get_option('image-meta');
  global $image_meta_options;
  $base = basename($file);
  $filename = preg_replace("/\..*/", '', $base);
  $metadata['caption'] = $metadata['title'];
  if ($image_meta_options['title']=='blank') {
    $metadata['title'] = '';
  } elseif ($image_meta_options['title']=='filename') {
    $metadata['title'] = $filename;
  } elseif ($image_meta_options['title']=='caption') {
    $metadata['title'] = $metadata['title'];
  }
  return($metadata);
}

function image_meta_update_filter($metadata, $id) {
  global $image_meta_options;
  /*
  $handle = fopen('output.txt', 'w');
  $output = var_export($image_meta_options, true);
  fwrite($handle, $output);
  //$output = var_export($post, true);
  //fwrite($handle, $output);
  fclose($handle);
  //$metadata['image_meta']['caption'] = $metadata['image_meta']['title'];
  */
  //$metadata['image_meta']['title'] = $title;
  $base = basename($metadata['file']);
  $filename = preg_replace("/\..*/", '', $base);
  if ($image_meta_options['caption']=='blank') {
    $caption = '';
  } elseif ($image_meta_options['caption']=='filename') {
    $caption = $filename;
  } elseif ($image_meta_options['caption']=='caption') {
    $caption = $metadata['image_meta']['caption'];
  }
  if ($image_meta_options['description']=='blank') {
    $description = '';
  } elseif ($image_meta_options['description']=='filename') {
    $description = $filename;
  } elseif ($image_meta_options['description']=='caption') {
    $description = $metadata['image_meta']['caption'];
  }
  $post = array('ID' => $id, 
                'post_excerpt' => $caption,
                'post_content' => $description,
               );
  wp_update_post($post);
  return($metadata);
}

function image_meta_form_fields($form_fields, $post) {
  global $image_meta_options;
  $caption = $post->post_excerpt;
  $description = $post->post_content;
  if ($image_meta_options['alttext']=='blank') {
    $alttext = '';
  } elseif ($image_meta_options['alttext']=='title') {
    $alttext = $post->post_title;
  } elseif ($image_meta_options['alttext']=='caption') {
    $alttext = $post->post_excerpt;
  } elseif ($image_meta_options['alttext']=='description') {
    $alttext = $post->post_content;
  }
  update_post_meta( $post->ID, '_wp_attachment_image_alt',
      $alttext);
  if ( substr($post->post_mime_type, 0, 5) == 'image' ) {
    $alt = get_post_meta($post->ID, '_wp_attachment_image_alt', true);
    if ( empty($alt) )
      $alt = '';

    $form_fields['post_title']['required'] = true;

    $form_fields['image_alt'] = array(
      'value' => $alt,
      'label' => __('Alternate Text'),
      'helps' => __('Alt text for the image, e.g. &#8220;The Mona Lisa&#8221;')
    );

    $form_fields['align'] = array(
      'label' => __('Alignment'),
      'input' => 'html',
      'html'  => image_align_input_fields($post, get_option('image_default_align')),
    );

    $form_fields['image-size'] = image_size_input_fields( $post, get_option('image_default_size', 'medium') );

    $form_fields['post_excerpt']['value'] = $caption;
    $post->post_excerpt = $caption;
    $form_fields['post_content'] = array(
      'label'      => __('Description'),
      'value'      => $description,
      'input'      => 'textarea'
    );
  } else {
    unset( $form_fields['image_alt'] );
  }
  return($form_fields);
}

function image_meta_settings_page() {
	add_options_page('Image Meta', 'Image Meta', 8, __FILE__,
  'image_meta_settings');
}

function image_meta_settings() {
  include('settings.php');
}

function image_meta_actions() {
  add_filter('wp_update_attachment_metadata', 'image_meta_update_filter', 10, 2);
  add_filter('wp_read_image_metadata', 'image_meta_read_filter', 10, 3);
  remove_filter('attachment_fields_to_edit', 'image_attachment_fields_to_edit');
  add_filter('attachment_fields_to_edit', 'image_meta_form_fields', 1, 2);
  register_setting('image-meta-options', 'image-meta');
}
add_action('admin_init', 'image_meta_actions');
add_action('admin_menu', 'image_meta_settings_page');
?>
