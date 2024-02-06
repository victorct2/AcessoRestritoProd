<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatorioStreamingController extends CI_Controller {

	    
    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
		$grupos = $this->session->userdata('grupos');
		if(in_array("1", $grupos)){
		}else{
			redirect(base_url() . 'Home', 'refresh');
		}

		$this->load->model('relatoriosDao_model');       
       
	}
   

    function relatorioStreaming(){

        if(count($_POST)>0){
			$periodo = explode('-', $_POST['periodo']);
			
			$horaInicial = @end(explode(' ',trim($periodo[0])));
			$horaFinal = @end(explode(' ',trim($periodo[1])));
			
			$dataHoraInicial = explode(' ',trim($periodo[0]));
			$dataHoraFinal = explode(' ',trim($periodo[1]));

            $_SESSION['startDate'] = converteDataBanco($dataHoraInicial[0]);
			$_SESSION['endDate'] = converteDataBanco($dataHoraFinal[0]);
			$_SESSION['horaInicial'] = $dataHoraInicial[1];
            $_SESSION['horaFinal'] = $dataHoraFinal[1];
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
			$_SESSION['horaInicial'] = '';
			$_SESSION['horaFinal'] = '';
        } 
                
        
        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,bootstrap-daterangepicker/daterangepicker.css';
        $open['assetsCSS'] = 'relatorios/relatorios.css';
        $this->load->view('include/openDoc',$open);

        $data['totalStreaming'] = $this->relatoriosDao_model->totalStreaming();
        $data['topFiveStreaming'] = $this->relatoriosDao_model->topFiveStreaming();
        $data['mainNav'] = 'relatorios';
		$data['subMainNav'] = 'relatoriosStreaming';
		$this->load->view('paginas/relatorios/streaming',$data);	
        
        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,bootstrap-daterangepicker/daterangepicker.js';
        $footer['assetsJs'] = 'relatorios/streaming.js';
        $this->load->view('include/footer',$footer);
    }


	 public function listaStreamingDataTables(){

          
       
        $fetch_data = $this->relatoriosDao_model->make_datatablesStreaming();
        
        $data = array();
        foreach($fetch_data as $row){ 
            $sub_array = array();
            $sub_array[] = $row->titulo;  
            $sub_array[] = $row->programa;            
            $sub_array[] = $row->total_streaming;
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->relatoriosDao_model->get_all_dataStreaming(),  
            "recordsFiltered" => $this->relatoriosDao_model->get_filtered_dataStreaming(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }
	
}
