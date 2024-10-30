<?php
/*
Plugin Name: Login Page Tailor
description: Customize the default wordpress login page, logo on top, form background color and login buttun style.
Version: 0.1.0
Author: Soroush Angabini
Author URI: #
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/* DEFINE SETTINGS GROUP FOR LOGIN PAGE TAILOR */
function register_wplt_style_settings() 
{
    $styles = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize_text_field',
            'default' => NULL,
   );
    register_setting( 'wplt_style_group', 'wplt_logo_url', $styles);
    register_setting( 'wplt_style_group', 'wplt_logo_height', $styles);
    register_setting( 'wplt_style_group', 'wplt_logo_width', $styles);
    register_setting( 'wplt_style_group', 'wplt_bg_color', $styles);
    register_setting( 'wplt_style_group', 'wplt_form_border_color', $styles);
    register_setting( 'wplt_style_group', 'wplt_form_border_size', $styles);
    register_setting( 'wplt_style_group', 'wplt_form_corner_radius', $styles);
    register_setting( 'wplt_style_group', 'wplt_btn_bg_color', $styles);
    register_setting( 'wplt_style_group', 'wplt_btn_border_color', $styles);

}
add_action( 'admin_init', 'register_wplt_style_settings' );

/* CREATE SETTINGS PAGE */
function create_login_tailor_settings_page() {
  add_options_page('Login Page Tailor', 'Login Page Tailor', 'manage_options', 'login-page-tailor', 'login_page_tailor_settings');
}
add_action('admin_menu', 'create_login_tailor_settings_page');

/* SETTINGS PAGE FUNCTION */
function login_page_tailor_settings()
{
	wp_enqueue_script('jquery');
	wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
	?>
	
<style>
    th {text-align:left;}
    
    .wplt_wrap {width: 100%;display: inline-block;vertical-align: top;}
    
    .wplt_section {border: 2px solid grey; border-radius: 10px; margin:20px 3%;padding:20px; box-shadow: 20px -20px 200px 0px grey}
    
    tr {valign=middle}
    th {width:50%}

@media only screen and (min-width: 900px) {
      /* For desktop: */
      .wplt_wrap {width: 48.8%;}
      .wplt_section {margin:30px 20px}
      
}

</style>
<div class="wplt_wrap">
	<form method="post" action="options.php">
	<?php settings_fields( 'wplt_style_group' ); ?>
	<?php do_settings_sections( 'wplt_style_group' ); ?>
	<div class="wplt_section">
		<h1>Login Page Logo</h1>
		<table class="wplt_form-table">
			<tr>
			<th scope="row">Custom Logo</th>
			<td>
				<input type="text" id="wplt_logo_url" name="wplt_logo_url" value="<?php echo esc_attr( get_option('wplt_logo_url') ); ?>" />
				<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload">
			</td>
			</tr>
			<tr>
			<th scope="row">Height</th>
			<td>
				<input type="number" name="wplt_logo_height" value="<?php echo esc_attr( get_option('wplt_logo_height') ); ?>" />					
			</td>
			</tr>
			<tr>
			<th scope="row">Width</th>
			<td>
				<input type="number" name="wplt_logo_width" value="<?php echo esc_attr( get_option('wplt_logo_width') ); ?>" />
			</td>
			</tr>
		</table>
    </div>
			
    <div class="wplt_section">
		<h1>Login Page Form Style</h1>
		<table class="wplt_form-table">
	    	<tr>
			<th scope="row">Form Background Color</th>
			<td>
				<input type="text" id="wplt_bg_color" name="wplt_bg_color" value="<?php echo esc_attr( get_option('wplt_bg_color') ); ?>" />
			</td>
			</tr>
			<tr>
			<th scope="row">Form Border Color</th>
			<td>
				<input type="text" id="wplt_form_border_color" name="wplt_form_border_color" value="<?php echo esc_attr( get_option('wplt_form_border_color') ); ?>" />
			</td>
			</tr>
			<tr>
			<th scope="row">Form Border Size</th>
			<td>
				<input type="number" id="wplt_form_border_size" name="wplt_form_border_size" value="<?php echo esc_attr( get_option('wplt_form_border_size') ); ?>" />
			</td>
			</tr>
			<tr>
			<th scope="row">Round Corner Radius</th>
			<td>
				<input type="number" id="wplt_form_corner_radius" name="wplt_form_corner_radius" value="<?php echo esc_attr( get_option('wplt_form_corner_radius') ); ?>" />
			</td>
			</tr>
		
			
		</table>
    </div>
	
    <div class="wplt_section">
		<h1>Login Buttun Style</h1>
		<table class="wplt_form-table">
			<tr>
			<th scope="row">Buttun Color</th>
			<td>
				<input type="text" id="wplt_btn_bg_color" name="wplt_btn_bg_color" value="<?php echo esc_attr( get_option('wplt_btn_bg_color') ); ?>" />
			</td>
			</tr>
			<tr>
			<th scope="row">Buttun Border Color</th>
			<td>
				<input type="text" id="wplt_btn_border_color" name="wplt_btn_border_color" value="<?php echo esc_attr( get_option('wplt_btn_border_color') ); ?>" />
			</td>
			</tr>
		</table>
    </div>
	<?php submit_button(); ?>
	</form>
	<script type="text/javascript">
        jQuery(document).ready(function($){
	    $('#upload-btn').click(function(e) {
		e.preventDefault();
		var image = wp.media({ 
			title: 'Select File',
			multiple: false
		}).open()
		.on('select', function(e){
			var uploaded_image = image.state().get('selection').first();
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			$('#wplt_logo_url').val(image_url);
   			});
   		});
   	});
    </script>
     <script type="text/javascript">
        jQuery(document).ready(function($) {   
        $('#wplt_bg_color').wpColorPicker();
        $('#wplt_form_border_color').wpColorPicker();
        $('#wplt_btn_bg_color').wpColorPicker();
        $('#wplt_btn_border_color').wpColorPicker();
    });             
    </script>
</div>

<div class="wplt_wrap">
    <div class="wplt_section" style="background: #f0f0f1;">
	    <h1 style="text-align: center">Preview</h1>
	    <div class="wplt-preview" style="width:320px;margin: 25% auto;">
			<p style="background-image: url(<?php echo esc_attr( get_option('wplt_logo_url')); ?>) !important;
    			    height:<?php echo esc_attr( get_option('wplt_logo_height') ); ?>px !important;
    			    min-height: 100px;
    				width:<?php echo esc_attr( get_option('wplt_logo_width') ); ?>px !important;
    				background-size:100% !important;
    				line-height:inherit !important;
                    display: block;
                    background-repeat: no-repeat;">
			</p>
    		<div class="wplt-preview" style="
    			        padding: 26px 24px 34px !important;
    				    background: <?php echo esc_attr( get_option('wplt_bg_color') ); ?> !important;
    				    box-shadow: 20px -20px 200px 0px grey !important;
                        overflow: hidden;
                        margin-bottom: 0;
    				    border-radius: <?php echo esc_attr( get_option('wplt_form_corner_radius') ); ?>px !important;
    				    border: <?php echo esc_attr( get_option('wplt_form_border_size') ); ?>px solid <?php echo esc_attr( get_option('wplt_form_border_color') ); ?> !important;
    				    ">
    		    <p>
    				<label>Username or Email Address</label>
    				<input type="text" size="20" style="width: 100%;font-size: 18px;"/>
    			</p>
                <p>
    			    <label>Password</label>
    			    <input type="text" size="20" style="width: 100%;font-size: 18px;"/>
    		    </p>
    	        <p style="float: left;display: inline-block;"><input type="checkbox"/>
    	            <label for="rememberme">Remember Me</label>
    	        </p>
    		    <p class="submit">
    				<buttun class="button button-primary button-large" style="
    				    vertical-align: top;
                        min-height: 32px;
                        line-height: 2.30769231;
                        padding: 0 12px;
                        vertical-align: baseline;
                        border-color: #ffffff00 !important;
                        background: <?php echo esc_attr( get_option('wplt_btn_bg_color')); ?> !important;
                        float: right;
                        text-decoration: none;
                        text-shadow: none;
                        font-size: 13px;
                        cursor: pointer;
                        border-width: 1px;
                        border-style: solid;
                        border-radius: 3px;
                        white-space: nowrap;
                        box-sizing: border-box;
                        margin: 0;
                        display: inline-block;"/>Log In
                    </buttun>
                </p>
    	    </div>
        </div>
    </div>
</div>

	<?php
}

/* Login Page Tailor Styling function */
function login_page_styler() {
    
    $wplt_logo_url=get_option('wplt_logo_url');
    $wplt_logo_height=get_option('wplt_logo_height');
    $wplt_logo_width=get_option('wplt_logo_width');
    $wplt_bg_color=get_option('wplt_bg_color');
    $wplt_form_border_color=get_option('wplt_form_border_color');
    $wplt_form_border_size=get_option('wplt_form_border_size');
    $wplt_form_corner_radius=get_option('wplt_form_corner_radius');
    $wplt_btn_bg_color=get_option('wplt_btn_bg_color');
    $wplt_btn_border_color=get_option('wplt_btn_border_color');
	
	if(empty($wplt_logo_height))
	{
		$wplt_logo_height='100px';
	}
	else
	{
		$wplt_logo_height.='px';
	}
	if(empty($wplt_logo_width))
	{
		$wplt_logo_width='100%';
	}	
	else
	{
		$wplt_logo_width.='px';
	}
	if(!empty($wplt_logo_url))
	{
		echo '<style type="text/css">'.
             'h1 a { 
				background-image:url('.$wplt_logo_url.') !important;
				height:'.$wplt_logo_height.' !important;
				width:'.$wplt_logo_width.' !important;
				background-size:100% !important;
				line-height:inherit !important;
				}'
			
				  .
         '</style>';
	    
	}
    if(!empty($wplt_bg_color))
        {
            echo '<style type="text/css">'.
        
				'form {
				    background: '.$wplt_bg_color.' !important;
				    box-shadow: 20px -20px 200px 0px grey !important;
				    }'
				  .
         '</style>';
        }
    if(!empty($wplt_form_border_color))
        {
            echo '<style type="text/css">'.
        
				'form {
				   
				    border: '.$wplt_form_border_size.'px solid '.$wplt_form_border_color.' !important;
				    }'
				  .
         '</style>';
        }
        else
	    {
            echo '<style type="text/css">'.
        
				'form {
				    border-color: '.$wplt_bg_color.' !important;
				    }'
				  .
         '</style>';
        }
    if(!empty($wplt_form_corner_radius))
        {
            echo '<style type="text/css">'.
            	'form {
				    border-radius: '.$wplt_form_corner_radius.'px !important;
				 }'
				,
				'#login{	 
				    width: 320px !important;
				 }'
		
				  .
         '</style>';
        }
    /*Buttun*/
    if(!empty($wplt_btn_bg_color))
        {
            echo '<style type="text/css">'.
        
				'.login .button-primary {
				    background: '.$wplt_btn_bg_color.' !important;
				    }'
				  .
         '</style>';
        }
    if(!empty($wplt_btn_border_color))
        {
            echo '<style type="text/css">'.
        
				'.login .button-primary {
				    border-color: '.$wplt_btn_border_color.' !important;
				    }'
				  .
         '</style>';
        }
    else
	    {
            echo '<style type="text/css">'.
        
				'.login .button-primary {
				    border-color: '.$wplt_btn_bg_color.' !important;
				    }'
				  .
         '</style>';
        }
	
}
add_action( 'login_head', 'login_page_styler' );




?>