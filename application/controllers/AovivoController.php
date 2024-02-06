<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AovivoController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("12", $grupos) | in_array("14", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

		$this->load->model('aovivoDao_model');

	}


    public function viewAovivo(){

		//$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'aovivo/aovivo-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'aovivo';
		//$data['subMainNav'] = 'listaUsuarios';
		$this->load->view('paginas/aovivo/lista',$data);

        //$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
		$footer['assetsJs'] = 'aovivo/aovivo-home.js';
        $this->load->view('include/footer',$footer);
	}
	
	

    public function listaAovivoDataTables(){

        $fetch_data = $this->aovivoDao_model->make_datatables();


        $dataArray = array();
        foreach($fetch_data as $row){

            
            if($row->status == 'ATIVO'){
                $situacao = '<span class="label pull-right bg-green infoStatus">ATIVO</span><br>';
            }else if($row->status == 'INATIVO'){
                $situacao = '<span class="label pull-right bg-red infoStatus">INATIVO</span><br>';
            }           

            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->streaming;
            $sub_array[] = $row->link;		
			$sub_array[] = $row->iframe;		
			$sub_array[] = $situacao;
			if($row->status == 'INATIVO'){
				$sub_array[] = '<a class="btn bg-olive btn-app ativar" title="'.$row->id.'"><i class="fa fa-power-off"></i> ATIVAR <b>'.$row->streaming.'</b></a>';
            }else{
                $sub_array[] = '';
            }

            $dataArray[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->aovivoDao_model->get_all_data(),
            "recordsFiltered" => $this->aovivoDao_model->get_filtered_data(),
            "data" => $dataArray
        );


        echo json_encode($output);
    }

    function ativarAovivo(){
        $id = $this->input->post('id');		
		if($this->aovivoDao_model->ativarStreaming($id)){
			echo 'success';
		}else{
			echo 'false';
		}
    }

    

}
