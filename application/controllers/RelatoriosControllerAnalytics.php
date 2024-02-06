<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatoriosControllerAnalytics extends CI_Controller {

    public $analyticsClass = null;

    function __construct() {
		parent:: __construct();	
        include APPPATH . 'third_party/google-api-php-client/vendor/autoload.php';      
        $this->load->library('analyticsapi');
        
        $this->analyticsClass = $this->analyticsapi->carregarAnalytics();  
        if($this->analyticsClass == false){            
            $redirect_uri = base_url() . 'RelatoriosControllerAnalytics/oauth2callback/';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
	}

    public function visaoGeral(){
       

        if(count($_POST)>0){
            $periodo = explode('-', $_POST['periodo']);
            $_SESSION['startDate'] = converteDataBanco($periodo[0]);
            $_SESSION['endDate'] = converteDataBanco($periodo[1]);
            $data['periodo'] = $_POST['periodo'];
            $_SESSION['filtro'] = 'S';
        }        
        else{
            if(isset($_SESSION['filtro']) && $_SESSION['filtro']== 'S'){
                $periodo =  converteDataInterface($_SESSION['startDate']).' - '.converteDataInterface($_SESSION['endDate']);
                $data['periodo'] = $periodo;
                $_SESSION['filtro'] = 'S';
            }else{
                $startTime = mktime(0, 0, 0, date('m')-1  , 1 , date('Y')); 
                $endTime = mktime(23, 59, 59, date('m'), date('d')-date('j'), date('Y')); 
                $_SESSION['startDate'] =  date('Y-m-d', $startTime); 
                $_SESSION['endDate'] = date('Y-m-d', $endTime);
                $periodo =  date('d/m/Y', $startTime).' - '.date('d/m/Y', $endTime);
                $data['periodo'] = $periodo;
                $_SESSION['filtro'] = 'N';
            }
        }
        
        
        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);        

        $data['totalPorSessao'] = $this->analyticsapi->getTotalSessionsAnalytics($this->analyticsClass);
        $data['totalUsuarios'] = $this->analyticsapi->getTotalUsersAnalytics($this->analyticsClass);
        $data['totalVisualizacoes'] = $this->analyticsapi->getTotalViewsAnalytics($this->analyticsClass);
        $data['totalVisualizacoesUnicas'] = $this->analyticsapi->getTotalUniqueViewsAnalytics($this->analyticsClass);
        $data['listaDispositivos'] = $this->analyticsapi->getMobileAnalytics($this->analyticsClass);
        $data['listaSistemasOperacionais'] = $this->analyticsapi->getOperationsSystemAnalytics($this->analyticsClass);
        $data['listaLocais'] = $this->analyticsapi->getLocalAnalytics($this->analyticsClass);
        $data['listaIdioma'] = $this->analyticsapi->getIdiomaAnalytics($this->analyticsClass);
        $data['usuariosAtivosUmDia'] = $this->analyticsapi->getUserActiveByDay($this->analyticsClass,1);
        $data['usuariosAtivosSeteDia'] = $this->analyticsapi->getUserActiveByDay($this->analyticsClass,7);
        $data['usuariosAtivosQuatorzeDia'] = $this->analyticsapi->getUserActiveByDay($this->analyticsClass,14);
        $data['usuariosAtivosTrintaDia'] = $this->analyticsapi->getUserActiveByDay($this->analyticsClass,30);

        $open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css';
        $open['assetsCSS'] = 'analytics/publico.css';
        $this->load->view('include/openDoc',$open);
        
        $data['mainNav'] = 'relatorios';
        $data['mainNavSub'] = 'analytics';
		$data['subMainNav'] = 'publico';
		$this->load->view('paginas/analytics/publico', $data);	

        $footer['assetsJsBower'] = 'chart/Chart.js,moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js';
        $footer['assetsJs'] = 'analytics/visaoGeral.js';
        $this->load->view('include/footer',$footer);
    }

    public function aquisicao(){


        if(count($_POST)>0){
            $periodo = explode('-', $_POST['periodo']);
            $_SESSION['startDate'] = converteDataBanco($periodo[0]);
            $_SESSION['endDate'] = converteDataBanco($periodo[1]);
            $data['periodo'] = $_POST['periodo'];
            $_SESSION['filtro'] = 'S';
        }        
        else{
            if(isset($_SESSION['filtro']) && $_SESSION['filtro']== 'S'){
                $periodo =  converteDataInterface($_SESSION['startDate']).' - '.converteDataInterface($_SESSION['endDate']);
                $data['periodo'] = $periodo;
                $_SESSION['filtro'] = 'S';
            }else{
                $startTime = mktime(0, 0, 0, date('m')-1  , 1 , date('Y')); 
                $endTime = mktime(23, 59, 59, date('m'), date('d')-date('j'), date('Y')); 
                $_SESSION['startDate'] =  date('Y-m-d', $startTime); 
                $_SESSION['endDate'] = date('Y-m-d', $endTime);
                $periodo =  date('d/m/Y', $startTime).' - '.date('d/m/Y', $endTime);
                $data['periodo'] = $periodo;
                $_SESSION['filtro'] = 'N';
            }
        }

        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);        

        $data['totalPorSessao'] = $this->analyticsapi->getTotalSessionsAnalytics($this->analyticsClass);
        $data['totalUsuarios'] = $this->analyticsapi->getTotalUsersAnalytics($this->analyticsClass);
        $data['totalVisualizacoes'] = $this->analyticsapi->getTotalViewsAnalytics($this->analyticsClass);
        $data['totalVisualizacoesUnicas'] = $this->analyticsapi->getTotalUniqueViewsAnalytics($this->analyticsClass);
        $data['listaCanais'] = $this->analyticsapi->getCanaisAnalytics($this->analyticsClass);
        $data['todoTrafego'] = $this->analyticsapi->getTodoTrafegoAnalytics($this->analyticsClass);        
        $data['referenciaRedesSociais'] = $this->analyticsapi->getReferenciaRedesSociaisAnalytics($this->analyticsClass);
        $data['trafegoReferencia'] = $this->analyticsapi->getTrafegoReferenciaAnalytics($this->analyticsClass);
        $data['paginasDestino'] = $this->analyticsapi->getPaginasDestinoAnalytics($this->analyticsClass);
        $data['pesquisaOrganica'] = $this->analyticsapi->getPesquisaOrganicaAnalytics($this->analyticsClass);
        
       

        $open['assetsBower'] = 'bootstrap-daterangepicker/daterangepicker.css';
        $open['assetsCSS'] = 'analytics/aquisicao.css';
        $this->load->view('include/openDoc',$open);
        
        $data['mainNav'] = 'relatorios';
        $data['mainNavSub'] = 'analytics';
		$data['subMainNav'] = 'aquisicao';
		$this->load->view('paginas/analytics/aquisicao', $data);	

        $footer['assetsJsBower'] = 'chart/Chart.js,moment/min/moment.min.js,bootstrap-daterangepicker/daterangepicker.js';
        $footer['assetsJs'] = 'analytics/aquisicao.js';
        $this->load->view('include/footer',$footer);
    }

    public function comportamento(){


        if(count($_POST)>0){
            $periodo = explode('-', $_POST['periodo']);
            $_SESSION['startDate'] = converteDataBanco($periodo[0]);
            $_SESSION['endDate'] = converteDataBanco($periodo[1]);
            $data['periodo'] = $_POST['periodo'];
            $_SESSION['filtro'] = 'S';
        }        
        else{
            if(isset($_SESSION['filtro']) && $_SESSION['filtro']== 'S'){
                $periodo =  converteDataInterface($_SESSION['startDate']).' - '.converteDataInterface($_SESSION['endDate']);
                $data['periodo'] = $periodo;
                $_SESSION['filtro'] = 'S';
            }else{
                $startTime = mktime(0, 0, 0, date('m')-1  , 1 , date('Y')); 
                $endTime = mktime(23, 59, 59, date('m'), date('d')-date('j'), date('Y')); 
                $_SESSION['startDate'] =  date('Y-m-d', $startTime); 
                $_SESSION['endDate'] = date('Y-m-d', $endTime);
                $periodo =  date('d/m/Y', $startTime).' - '.date('d/m/Y', $endTime);
                $data['periodo'] = $periodo;
                $_SESSION['filtro'] = 'N';
            }
        }

        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);        

        $data['totalPorSessao'] = $this->analyticsapi->getTotalSessionsAnalytics($this->analyticsClass);
        $data['totalUsuarios'] = $this->analyticsapi->getTotalUsersAnalytics($this->analyticsClass);
        $data['totalVisualizacoes'] = $this->analyticsapi->getTotalViewsAnalytics($this->analyticsClass);
        $data['totalVisualizacoesUnicas'] = $this->analyticsapi->getTotalUniqueViewsAnalytics($this->analyticsClass);
        $data['paginasDestino'] = $this->analyticsapi->getPaginasDestinoCOAnalytics($this->analyticsClass);
        $data['paginasSaida'] = $this->analyticsapi->getPaginasSaidaAnalytics($this->analyticsClass);
        $data['detalhamentoConteudo'] = $this->analyticsapi->getDetalhamentoConteudoAnalytics($this->analyticsClass);
        $data['todasAsPaginas'] = $this->analyticsapi->getPaginasAnalytics($this->analyticsClass);
        $data['SambaTech'] = $this->analyticsapi->getSambaTechAnalytics($this->analyticsClass);
        $data['tempoNaPagina'] = $this->analyticsapi->getTempoNaPaginaAnalytics($this->analyticsClass);        
 

        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,bootstrap-daterangepicker/daterangepicker.css';
        $open['assetsCSS'] = 'analytics/comportamento.css';
        $this->load->view('include/openDoc',$open);
        
        $data['mainNav'] = 'relatorios';
        $data['mainNavSub'] = 'analytics';
		$data['subMainNav'] = 'comportamento';
		$this->load->view('paginas/analytics/comportamento', $data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,bootstrap-daterangepicker/daterangepicker.js';        
        $footer['assetsJs'] = 'analytics/comportamento.js';
        $this->load->view('include/footer',$footer);
    }


    function getBrowserAnalytics(){
        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);
        $gaBrowser =  $this->analyticsapi->getBrowserAnalytics($this->analyticsClass);
        echo json_encode($gaBrowser);
    }

    function getInfoDemografAnalytics(){
        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);
        $gaInfoDemografic =  $this->analyticsapi->getInfoDemografAnalytics($this->analyticsClass);
        echo json_encode($gaInfoDemografic);
    }
 

    function getDispositivosAnalytics(){
        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);
        $gaDispositivos =  $this->analyticsapi->getDispositivosAnalytics($this->analyticsClass);
        echo json_encode($gaDispositivos);
    }

    function getVisitantesAnalytics(){
        $this->analyticsapi->setStartDate($_SESSION['startDate']);
        $this->analyticsapi->setEndDate($_SESSION['endDate']);
        $gaVisitantes =  $this->analyticsapi->getNewAndReturnUsersAnalytics($this->analyticsClass);
        echo json_encode($gaVisitantes);
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