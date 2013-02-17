<?php $this->load->view( 'site-admin/inc_html_head' ); ?> 
		
		<div class="page-container">
			<div class="header">
				<div class="site-name"><?php echo $this->config_model->load_single( 'site_name' ); ?></div>
				<div class="user">
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="navigations">
					<?php // load helper
					$this->load->helper( 'account' ); 
					?> 
					
					<div class="clear"></div>
				</div>
			</div>
			<div class="body-wrap">
				
				<?php if ( isset( $page_content ) ) {echo $page_content;} ?> 
				
			</div>
		</div>
		<div class="footer">
			<?php //echo lang( 'admin_credit' ); ?> 
		</div>
		
<?php $this->load->view( 'site-admin/inc_html_foot' ); ?>