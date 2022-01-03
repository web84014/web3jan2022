<?php
namespace DROIT_ELEMENTOR\Manager;
defined( 'ABSPATH' ) || exit;

class Api{

    private static $instance;

    public function init(){
        // load modules control
        $data = drdt_manager()->api->api_data();

        //enable API
        if(current_user_can('manage_options')){
            add_action( 'admin_enqueue_scripts', [ $this , 'admin_enqueue'], 9999);
            add_action( 'wp_ajax_droitaddons-ajax', [ $this, '__dismiss' ] );
            add_action( 'admin_notices', [ $this, '_generate_ads'], 110);
        }

       
    }

    public function api_data(){
        $save_options = get_option( drdt_manager()->ajax::$option_keys, true);
        return isset($save_options['api']) ? $save_options['api'] : [];
    }

    public static function api_map(){
        return apply_filters('dlAddons/api/mapping', [
            'mailchimp' => [
                'title' => __('Mailchimp', 'droit-addons'),
                'is_pro' => false,
                'field' => [
                   'key' => [
                       'title' => 'API Key',
                       'type' => 'text'
                   ]
                ]
            ],
            'google_map' => [
                'title' => __('Google Map', 'droit-addons'),
                'is_pro' => false,
                'url' => 'https://console.cloud.google.com/google/maps-apis/',
                'btn_text' => 'Get API',
                'field' => [
                    'access_token' => [
                        'title' => 'API KEY',
                        'type' => 'text'
                    ]
                ]
            ],
            'response' => [
                'title' => __('Get Response', 'droit-addons'),
                'is_pro' => true,
                'field' => [
                    'key' => [
                        'title' => 'API Key',
                        'type' => 'text'
                    ]
                ]
            ],
            'facebook' => [
                'title' => __('Facebook', 'droit-addons'),
                'is_pro' => true,
                'url' => 'https://api.droitthemes.com/token/?provider=facebook',
                'field' => [
                    'account_name' => [
                        'title' => 'FB Page Name',
                        'type' => 'text'
                    ],
                    'access_token_genarate' => [
                        'title' => 'Access Token',
                        'type' => 'text'
                    ]
                 ]
            ],
            'twitter' => [
                'title' => __('Twitter', 'droit-addons'),
                'is_pro' => true,
                'url' => 'https://api.droitthemes.com/token/?provider=twitter',
                'field' => [
                   
                    'account_name' => [
                        'title' => 'Twitter Username',
                        'type' => 'text'
                    ],
                    'access_token_genarate' => [
                        'title' => 'Access Token',
                        'type' => 'text'
                    ]
                 ]
            ],
            'dribbble' => [
                'title' => __('Dribbble', 'droit-addons'),
                'is_pro' => true,
                'url' => 'https://api.droitthemes.com/token/?provider=dribbble',
                'field' => [
                    'access_token' => [
                        'title' => 'Access Token',
                        'type' => 'text'
                    ]
                ]
            ],

            
            
        ]);
    }

    public function admin_enqueue(){
        wp_enqueue_style( 'droit-ads', self::api_url().'ads/assets/droit-ads.css', [], drdt_core()->version );
        wp_enqueue_style( 'droit-ads', self::api_url().'ads/assets/droit-ads.js', ['jquery'], drdt_core()->version );
    }
    public function __dismiss() {
		
		$id   = ( isset( $_POST['id'] ) ) ? sanitize_key($_POST['id']) : '';
		$time = ( isset( $_POST['time'] ) ) ? sanitize_text_field($_POST['time']) : '';
		$meta = ( isset( $_POST['meta'] ) ) ? sanitize_text_field($_POST['meta']) : '';
		
		$key_ = $id.'_'.get_current_user_id();

		if ( ! empty( $id ) ) {
			if ( 'user' === $meta ) {
				update_user_meta( get_current_user_id(), $id, true );
			} else {
				set_transient( $key_, true, $time );
			}
			wp_send_json_success();
		}
		wp_send_json_error();
	}
    
    public function _generate_ads( ){
		$ads = get_transient('__ads_center__dladdons', '');
        if (  false === $ads || empty( $ads ) ) {
			$ads = $this->get_notices();
			if(!empty($ads)){
				set_transient( '__ads_center__dladdons', $ads , 86400 );
			}
		}
		if(empty($ads) ){
			return;
		}
        foreach($ads as $v):
           
            $data['id'] = isset($v['id']) ? $v['id'] : 'dl_'.time();
			$data['class'] = isset($v['class']) ? $v['class'] : '';
			$data['styles'] = isset($v['styles']) ? $v['styles'] : '';
            $data['title'] = isset($v['title']) ? $v['title'] : '';
            $data['des'] = isset($v['des']) ? $v['des'] : '';
            $data['btn_url'] = isset($v['btn_url']) ? $v['btn_url'] : '';
            $data['btn_txt'] = isset($v['btn_txt']) ? $v['btn_txt'] : '';
            $data['logo'] = isset($v['logo']) ? $v['logo'] : '';
            $data['start_date'] = isset($v['start_date']) ? $v['start_date'] : '';
			$data['end_date'] = isset($v['end_date']) ? $v['end_date'] : '';
			
			if( !empty($data['start_date']) ){
				if( strtotime($data['start_date']) >= time() ){
					continue;
				}
			}

			if( !empty($data['end_date'])){
				if( strtotime($data['end_date']) <= time()){
					continue;
				}
			}
 
            if( is_readable( drdt_core()->templates_dir . 'ads.php' ) ){
                include drdt_core()->templates_dir . 'ads.php';
            }

		endforeach;
    }
    public function get_notices(){
        $parmas['action'] = 'addons';
        $url = self::api_url().'ads/?' . http_build_query($parmas,'&');
        return $this->connect($url);
    }
    public static function api_url(){
        return 'https://api.droitthemes.com/';
    }

    private function connect($url){
        $args = array('timeout'=>60, 'redirection'=>3, 'httpversion'=>'1.0', 'blocking'=>true, 'sslverify'=>true);
        $res = wp_remote_get($url, $args);
        return (array) json_decode((string) $res['body'], true);
    }

    public static function instance(){
        if ( is_null( self::$instance ) ){
            self::$instance = new self();
        }
        return self::$instance;
    }

}