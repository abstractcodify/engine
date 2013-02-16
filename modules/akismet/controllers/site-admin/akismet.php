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
 
class akismet extends admin_controller {
	
	
	function __construct() {
		parent::__construct();
		// load helper
		$this->load->helper( 'form' );
	}// __construct
	
	
	function config() {
		// check permission
		if ( $this->account_model->check_admin_permission( 'akismet_perm', 'akismet_config_perm' ) != true ) {redirect( 'site-admin' );}
		// load session for flashdata
		$this->load->library( 'session' );
		$form_status = $this->session->flashdata( 'form_status' );
		if ( $form_status != null ) {
			$output['form_status'] = $form_status;
		}
		unset( $form_status );
		$output['akismet_api'] = $this->config_model->load_single( 'akismet_api' );
		// save action
		if ( $this->input->post() ) {
			$data['akismet_api'] = strip_tags( trim( $this->input->post( 'akismet_api' ) ) );
				if ( $data['akismet_api'] == null ) {$data['akismet_api'] = null;}
			$result = $this->config_model->save( $data );
			if ( $result === true ) {
				// load session library
				$this->load->library( 'session' );
				$this->session->set_flashdata( 'form_status', '<div class="txt_success alert alert-success">'.$this->lang->line( 'admin_saved' ).'</div>' );
				redirect( 'akismet/site-admin/akismet/config' );
			} else {
				$output['form_status'] = '<div class="txt_error alert alert-error">'.$result.'</div>';
			}
			// re-populate form
			$output['akismet_api'] = $data['akismet_api'];
		}
		// head tags output ##############################
		$output['page_title'] = $this->html_model->gen_title( $this->lang->line( 'akismet_akismet' ) );
		// meta tags
		// link tags
		// script tags
		// end head tags output ##############################
		// output
		$this->generate_page( 'site-admin/akismet_config_view', $output );
	}// config
	
	
	function index() {
		
	}// index
	
	
}

// EOF