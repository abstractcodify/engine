<label><?php echo lang( 'block_title' ); ?>: <input type="text" name="block_title" value="<?php echo $values['block_title']; ?>" maxlength="255" /></label>
<label><?php echo lang( 'coremd_login_showadmin_link' ); ?>: <input type="checkbox" name="show_admin_link" value="1"<?php if ( isset( $values['show_admin_link'] ) && $values['show_admin_link'] == '1' ) {echo ' checked="checked"';} ?> /></label>