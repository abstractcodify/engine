<?php
/**
 * 
 * PHP version 5
 * 
 * @package agni cms
 * @author vee w.
 * @license http://www.opensource.org/licenses/GPL-3.0
 *
 */

class corelangswitch extends widget {
	
	
	public $title;
	public $description = 'Hello block description.';
	
	
	function __construct() {
		$this->lang->load( 'core/coremd' );
		$this->title = $this->lang->line( 'coremd_switch_title' );
		$this->description = $this->lang->line( 'coremd_switch_desc' );
	}// __construct
	
	
	function block_show_form( $row = '' ) {
		$values = unserialize( $row->block_values );
		include( dirname(__FILE__).'/views/form.php' );
	}// block_show_form
	
	
	function run() {
		// load helper
		$this->load->helper( 'url' );
		// get arguments
		$args = func_get_args();
		$values = (isset($args[1]) ? unserialize($args[1]) : '' );
		if ( isset( $values['block_title'] ) && $values['block_title'] != null ) {
			echo '<h3>'.$values['block_title'].'</h3>';
		}
		//
		echo '<ul class="language-switch-block">';
		echo '<li class="current-language">';
		echo language_switch();
		echo '</li>';
		echo '</ul>';
	}// run
	
	
}