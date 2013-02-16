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

class siteman extends admin_controller {


	function __construct() {
		parent::__construct();
		
		// load model
		$this->load->model( array( 'siteman_model' ) );
		
		// load helper
		$this->load->helper( array( 'date', 'form' ) );
		
		// load language
		$this->lang->load( 'siteman' );
	}// __construct
	
	
	function _define_permission() {
		return array( 'siteman_perm' => array( 'siteman_manage_perm', 'siteman_add_perm', 'siteman_edit_perm', 'siteman_delete_perm' ) );
	}// _define_permission
	
	
	function add() {
		// check permission
		if ( $this->account_model->check_admin_permission( 'siteman_perm', 'siteman_add_perm' ) != true ) {redirect( 'site-admin' );}
		
		// preset form value
		$output['site_status'] = '1';
		
		// save action
		if ( $this->input->post() ) {
			
			// data for sites table
			$data['site_name'] = strip_tags( trim( $this->input->post( 'site_name' ) ) );
			$data['site_domain'] = strip_tags( trim( $this->input->post( 'site_domain' ) ) );
			$data['site_status'] = (int) $this->input->post( 'site_status' );
			
			// load form_validation class
			$this->load->library( 'form_validation' );
			
			// validate form
			$this->form_validation->set_rules("site_name", "lang:siteman_site_name", "trim|required");
			$this->form_validation->set_rules("site_domain", "lang:siteman_site_domain", "trim|required");
			if ( $this->form_validation->run() == false ) {
				$output['form_status'] = '<div class="txt_error alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><ul>'.validation_errors( '<li>', '</li>' ).'</ul></div>';
			} else {
				$result = $this->siteman_model->add_site( $data );
				
				if ( $result === true ) {
					// load session library
					$this->load->library( 'session' );
					$this->session->set_flashdata( 'form_status', '<div class="txt_success alert alert-success">'.$this->lang->line( 'admin_saved' ).'</div>' );
					
					redirect( 'site-admin/siteman' );
				} else {
					$output['form_status'] = '<div class="txt_error alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$result.'</div>';
				}
			}
			
			// re-populate form
			$output = array_merge( $output, $data );
		}
		
		// head tags output ##############################
		$output['page_title'] = $this->html_model->gen_title( $this->lang->line( 'siteman_siteman' ) );
		// meta tags
		// link tags
		// script tags
		// end head tags output ##############################
		
		// output
		$this->generate_page( 'site-admin/templates/siteman/siteman_ae_view', $output );
	}// add
	
	
	function edit( $site_id = '' ) {
		// check permission
		if ( $this->account_model->check_admin_permission( 'siteman_perm', 'siteman_edit_perm' ) != true ) {redirect( 'site-admin' );}
		
		// get site data from db.
		$data['site_id'] = $site_id;
		$row = $this->siteman_model->get_site_data_db( $data );
		unset( $data );
		
		if ( $row == null ) {
			unset( $row );
			redirect( 'site-admin' );
		}
		
		// store data for form
		$output['row'] = $row;
		$output['site_name'] = $row->site_name;
		$output['site_domain'] = $row->site_domain;
		$output['site_status'] = $row->site_status;
		
		// save action
		if ( $this->input->post() ) {
			
			// data for sites table
			$data['site_id'] = $site_id;
			$data['site_name'] = strip_tags( trim( $this->input->post( 'site_name' ) ) );
			$data['site_domain'] = strip_tags( trim( $this->input->post( 'site_domain' ) ) );
			$data['site_status'] = (int) $this->input->post( 'site_status' );
			
			// load form_validation class
			$this->load->library( 'form_validation' );
			
			// validate form
			$this->form_validation->set_rules("site_name", "lang:siteman_site_name", "trim|required");
			$this->form_validation->set_rules("site_domain", "lang:siteman_site_domain", "trim|required");
			if ( $this->form_validation->run() == false ) {
				$output['form_status'] = '<div class="txt_error alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><ul>'.validation_errors( '<li>', '</li>' ).'</ul></div>';
			} else {
				$result = $this->siteman_model->edit_site( $data );
				
				if ( $result === true ) {
					// load session library
					$this->load->library( 'session' );
					$this->session->set_flashdata( 'form_status', '<div class="txt_success alert alert-success">'.$this->lang->line( 'admin_saved' ).'</div>' );
					
					redirect( 'site-admin/siteman' );
				} else {
					$output['form_status'] = '<div class="txt_error alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$result.'</div>';
				}
			}
			
			// re-populate form
			$output = array_merge( $output, $data );
		}
		
		// head tags output ##############################
		$output['page_title'] = $this->html_model->gen_title( $this->lang->line( 'siteman_siteman' ) );
		// meta tags
		// link tags
		// script tags
		// end head tags output ##############################
		
		// output
		$this->generate_page( 'site-admin/templates/siteman/siteman_ae_view', $output );
	}// edit


	function index() {
		// check permission
		if ( $this->account_model->check_admin_permission( 'siteman_perm', 'siteman_manage_perm' ) != true ) {redirect( 'site-admin' );}
		
		// sort, orders, search for links and form
		$output['orders'] = strip_tags( trim( $this->input->get( 'orders' ) ) );
		$output['sort'] = ($this->input->get( 'sort' ) == null || $this->input->get( 'sort' ) == 'asc' ? 'desc' : 'asc' );
		$output['q'] = htmlspecialchars( trim( $this->input->get( 'q' ) ) );
		
		// load session for flashdata
		$this->load->library( 'session' );
		$form_status = $this->session->flashdata( 'form_status' );
		if ( $form_status != null ) {
			$output['form_status'] = $form_status;
		}
		unset( $form_status );
		
		// list websites
		$output['list_websites'] = $this->siteman_model->list_websites();
		if ( is_array( $output['list_websites'] ) ) {
			$output['pagination'] = $this->pagination->create_links();
		}
		
		// head tags output ##############################
		$output['page_title'] = $this->html_model->gen_title( $this->lang->line( 'siteman_siteman' ) );
		// meta tags
		// link tags
		// script tags
		// end head tags output ##############################
		
		// output
		$this->generate_page( 'site-admin/templates/siteman/siteman_view', $output );
	}// index
	
	
	function multiple() {
		$id = $this->input->post( 'id' );
		if ( !is_array( $id ) ) {redirect( 'site-admin/siteman' );}
		$act = trim( $this->input->post( 'act' ) );
		
		if ( $act == 'del' ) {
			if ( $this->account_model->check_admin_permission( 'siteman_perm', 'siteman_delete_perm' ) != true ) {redirect( 'site-admin' );}
			foreach ( $id as $an_id ) {
				$this->siteman_model->delete_site( $an_id );
			}
		}
		
		// go back
		$this->load->library( 'user_agent' );
		if ( $this->agent->is_referral() ) {
			redirect( $this->agent->referrer() );
		} else {
			redirect( 'site-admin/siteman' );
		}
	}// multiple


}