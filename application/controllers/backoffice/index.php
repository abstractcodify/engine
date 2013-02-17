<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * PHP version 5
 * 
 * @package agni cms
 * @author vee w.
 * @license http://www.opensource.org/licenses/GPL-3.0
 *
 */

class index extends admin_controller {

	
	function __construct() {
		parent::__construct();
	}// __construct
	
	
	function index() {
		$this->load->view( 'site-admin/templates/login/login_view' );
		//$this->generate_page( 'site-admin/templates/login/login_view' );
	}// index
	

}

