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

class index extends MY_Controller {
	
	
	function __construct() {
		parent::__construct();
		
		// load model
		$this->load->model( array( 'posts_model' ) );
		
		// set post_type
		$this->posts_model->post_type = 'article';
		
		// load helper
		$this->load->helper( array( 'date', 'language' ) );
		
		// load language
		$this->lang->load( 'post' );
	}// __construct
	
	
	function _remap( $att1 = '' ) {
		if ( is_numeric( $att1 ) || $att1 == null || $att1 == 'index' ) {
			$this->index();
		}
	}// _remap
	
	
	function index() {
		
		// get frontpage category from config
		$fp_category = $this->config_model->load_single( 'content_frontpage_category', $this->lang->get_current_lang() );
		
		if ( $fp_category != null ) {
			// load category for title, metas
			$this->db->where( 'tid', $fp_category );
			$query = $this->db->get( 'taxonomy_term_data' );
			if ( $query->num_rows() <= 0 ) {
				// not found category
				unset( $_GET['tid'] );
			} else {
				$row = $query->row();
				if ( $row->theme_system_name != null ) {
					// set theme
					$this->theme_path = base_url().config_item( 'agni_theme_path' ).$row->theme_system_name.'/';// for use in css
					$this->theme_system_name = $row->theme_system_name;// for template file.
				}
			}
			$query->free_result();
			unset( $query );			
		}
		
		// list posts---------------------------------------------------------------
		if ( $fp_category != null && is_numeric( $fp_category ) ) {
			$_GET['tid'] = $fp_category;
		}
		$output['list_item'] = $this->posts_model->list_item( 'front' );
		if ( is_array( $output['list_item'] ) ) {
			$output['pagination'] = $this->pagination->create_links();
		}
		// end list posts---------------------------------------------------------------
		
		// head tags output ##############################
		if ( isset( $row ) && $row->meta_title != null ) {
			$output['page_title'] = $row->meta_title;
		} else {
			$output['page_title'] = $this->html_model->gen_title();
		}
		// meta tags
		$meta = '';
		if ( isset( $row ) && $row->meta_description != null ) {
			$meta[] = '<meta name="description" content="'.$row->meta_description.'" />';
		}
		if ( isset( $row ) && $row->meta_keywords != null ) {
			$meta[] = '<meta name="keywords" content="'.$row->meta_keywords.'" />';
		}
		$output['page_meta'] = $this->html_model->gen_tags( $meta );
		unset( $meta );
		// link tags
		// script tags
		// end head tags output ##############################
		
		// output
		$this->generate_page( 'front/templates/index/index_view', $output );
	}// index
	
	
}