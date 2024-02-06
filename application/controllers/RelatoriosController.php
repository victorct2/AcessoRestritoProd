<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatoriosController extends CI_Controller {

    public $analyticsClass = null;

    function __construct() {
		parent:: __construct();

		$this->load->model('relatoriosDao_model');
        include APPPATH . 'third_party/google-api-php-client/vendor/autoload.php';   
        $this->load->library('analyticsapi');
        
        $this->analyticsClass = $this->analyticsapi->carregarAnalytics();  
        if($this->analyticsClass == false){            
            $redirect_uri = base_url() . 'RelatoriosController/oauth2callback/';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
        
	}


	function oauth2callback(){
              
        $client =  $this->analyticsapi->oauth2callback();
            if (! isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = base_url() . 'RelatoriosControllerAnalytics/visaoGeral';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }        
        
    }
	
}