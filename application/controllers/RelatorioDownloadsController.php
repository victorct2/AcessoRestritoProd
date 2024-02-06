<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatorioDownloadsController extends CI_Controller {

    public $analyticsClass = null;

    function __construct() {
		parent:: __construct();

		$this->load->model('relatoriosDao_model');       
       
	}
   

    function relatorioDeDownload(){

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
                
        
        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,bootstrap-daterangepicker/daterangepicker.css';
        $open['assetsCSS'] = 'relatorios/relatorios.css';
        $this->load->view('include/openDoc',$open);

        $data['totalDownloadsOnDemand'] = $this->relatoriosDao_model->totalDownloadsOnDemand();
        $data['topFiveMaisBaixados'] = $this->relatoriosDao_model->topFiveMaisBaixados();
        $data['mainNav'] = 'relatorios';
		$data['subMainNav'] = 'relatoriosDownloads';
		$this->load->view('paginas/relatorios/downloads',$data);	
        
        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,bootstrap-daterangepicker/daterangepicker.js';
        $footer['assetsJs'] = 'relatorios/downloads.js';
        $this->load->view('include/footer',$footer);
    }


	 public function listaDownloadsDataTables(){

          
       
        $fetch_data = $this->relatoriosDao_model->make_datatablesDownloads();
        
        $data = array();
        foreach($fetch_data as $row){ 
            $sub_array = array();
            $sub_array[] = $row->nome;  
            $sub_array[] = $row->titulo;   
            $sub_array[] = $row->numeroPgm;            
            $sub_array[] = $row->total_download;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->relatoriosDao_model->get_all_dataDownloads(),  
            "recordsFiltered" => $this->relatoriosDao_model->get_filtered_dataDownloads(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }
	
}