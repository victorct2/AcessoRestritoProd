<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatorioAcessosController extends CI_Controller {

    public $analyticsClass = null;

    function __construct() {
		parent:: __construct();

		$this->load->model('relatoriosDao_model');     
        
	}

   

    function relatorioDeAcessos(){

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

                
        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,datatables.net/css/buttons.dataTables.min.css,bootstrap-daterangepicker/daterangepicker.css';
        $open['assetsCSS'] = 'relatorios/relatorios.css';
        $this->load->view('include/openDoc',$open);
        
        $data['totalAcessosOnDemand'] = $this->relatoriosDao_model->totalAcessosOnDemand();
        $data['topFiveMaisAcessados'] = $this->relatoriosDao_model->topFiveMaisAcessados();
        $data['mainNav'] = 'relatorios';
		$data['subMainNav'] = 'relatoriosAcessos';
		$this->load->view('paginas/relatorios/acessos',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,datatables.net/js/buttons.html5.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,bootstrap-daterangepicker/daterangepicker.js';
        $footer['assetsJs'] = 'relatorios/acessos.js';
        $this->load->view('include/footer',$footer);
    }

    public function listaAcessosDataTables(){
    
       
        $fetch_data = $this->relatoriosDao_model->make_datatablesAcessos();
        
        $data = array();
        foreach($fetch_data as $row){ 
            $sub_array = array();
            $sub_array[] = $row->nome;  
            $sub_array[] = $row->titulo;   
            $sub_array[] = $row->numeroPgm;            
            $sub_array[] = $row->total_acesso;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->relatoriosDao_model->get_all_dataAcessos(),  
            "recordsFiltered" => $this->relatoriosDao_model->get_filtered_dataAcessos(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }

   
	
}