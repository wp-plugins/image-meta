<div class="wrap"> 
<h2>
<?php
	_e('Image Meta Options', 'image-meta');
		?>
</h2>
<form name="image-meta-options" method="post" action='options.php'>
	<?php settings_fields( 'image-meta-options' ); ?>
  <?php $options = get_option('image-meta');
        extract($options);
  ?>
<table>
  <th>
  <label for='title'><?php _e('Set title to:', 'image-meta') ?></label>
  </th>
  <td>
    <select name='image-meta[title]'>
    <option value='filename' <?php if ($title=='filename') echo
    "selected='selected'" ?>><?php _e('File name', 'image-meta') ?></option>
    <option value='caption' <?php if ($title=='caption') echo
    "selected='selected'" ?>><?php _e('IPTC caption', 'image-meta') ?></option>
    <option value='blank' <?php if ($title=='blank') echo
    "selected='selected'" ?>><?php _e('blank', 'image-meta') ?></option>
    </select>
  </td>
  </tr>
  <tr>
  <th>
  <label for='caption'><?php _e('Set caption to:', 'image-meta') ?></label>
  </th>
  <td>
    <select name='image-meta[caption]'>
    <option value='filename' <?php if ($caption=='filename') echo
    "selected='selected'" ?>><?php _e('File name', 'image-meta') ?></option>
    <option value='caption' <?php if ($caption=='caption') echo
    "selected='selected'" ?>><?php _e('IPTC caption', 'image-meta') ?></option>
    <option value='blank' <?php if ($caption=='blank') echo
    "selected='selected'" ?>><?php _e('blank', 'image-meta') ?></option>
    </select>
  </td>
  </tr>
  <tr>
  <th>
  <label for='description'><?php _e('Set description to:', 'image-meta') ?></label>
  </th>
  <td>
    <select name='image-meta[description]'>
    <option value='filename' <?php if ($description=='filename') echo
    "selected='selected'" ?>><?php _e('File name', 'image-meta') ?></option>
    <option value='caption' <?php if ($description=='caption') echo
    "selected='selected'" ?>><?php _e('IPTC caption', 'image-meta') ?></option>
    <option value='blank' <?php if ($description=='blank') echo
    "selected='selected'" ?>><?php _e('blank', 'image-meta') ?></option>
    </select>
  </td>
  </tr>
  <tr>
  <th>
  <label for='alttext'><?php _e('Set alt text to:', 'image-meta') ?></label>
  </th>
  <td>
    <select name='image-meta[alttext]'>
    <option value='title' <?php if ($alttext=='title') echo
    "selected='selected'" ?>><?php _e('Post title', 'image-meta') ?></option>
    <option value='caption' <?php if ($alttext=='caption') echo
    "selected='selected'" ?>><?php _e('Image caption', 'image-meta') ?></option>
    <option value='description' <?php if ($alttext=='description') echo
    "selected='selected'" ?>><?php _e('Image description', 'image-meta') ?></option>
    <option value='blank' <?php if ($alttext=='blank') echo
    "selected='selected'" ?>><?php _e('blank', 'image-meta') ?></option>
    </select>
  </td>
  </tr>
</table>
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
  </form>
</div>
