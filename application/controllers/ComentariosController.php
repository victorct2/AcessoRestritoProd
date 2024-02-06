<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComentariosController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("14", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

		$this->load->model('usuariosDao_model');
		$this->load->model('gruposDao_model');
		$this->load->model('comentariosDao_model');

	}


    public function viewComentarios(){

		//$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'comentarios/comentarios-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'comentarios';
		//$data['subMainNav'] = 'listaUsuarios';
		$this->load->view('paginas/comentarios/lista',$data);

        //$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
		$footer['assetsJs'] = 'comentarios/comentarios-home.js';
        $this->load->view('include/footer',$footer);
	}
	
	

    public function listaComentariosDataTables(){

        $fetch_data = $this->comentariosDao_model->make_datatables();

        $data = array();
        foreach($fetch_data as $row){
            
            if($row->ativo == 'S'){
                $situacao = '<span class="label pull-right bg-green infoStatus">ATIVO</span><br>';
            }else if($row->ativo == 'N'){
                $situacao = '<span class="label pull-right bg-red infoStatus">INATIVO</span><br>';
            }else if($row->ativo == 'AC'){
                $situacao = '<span class="label pull-right bg-yellow infoStatus">À LIBERAR</span><br>';
            }            

            $sub_array = array();
            $sub_array[] = $row->idComentario;
            $sub_array[] = $row->nomeUsuario;
            $sub_array[] = $row->nomeVideo;
            $sub_array[] = wordwrap($row->comentario,60,"<br />\n");
            $sub_array[] = converteDataInterface($row->data_cadastro);			
			$sub_array[] = '<a href="http://www.canal.fiocruz.br/video/index.php?v='.$row->friendly_url.'" target="_blank">http://www.canal.fiocruz.br/video/index.php?v='.$row->friendly_url.'</a>';
			$sub_array[] = $situacao;
			if($row->ativo == 'AC'){
				$sub_array[] = '<a class="btn bg-olive btn-app" id="liberar" title="'.$row->idComentario.'"><i class="fa fa-thumbs-o-up"></i> Liberar</a>
                            <a class="btn bg-maroon btn-app" id="negar" title="'.$row->idComentario.'"><i class="fa fa-thumbs-o-down"></i> Negar</a>';
            }else if($row->ativo == 'S'){
				$sub_array[] = '<a class="btn bg-olive btn-app inative" title="'.$row->idComentario.'"><i class="fa fa-thumbs-o-up"></i> Liberar</a>
                            <a class="btn bg-maroon btn-app" id="negar" title="'.$row->idComentario.'"><i class="fa fa-thumbs-o-down"></i> Negar</a>';
            }
            else if($row->ativo == 'N'){
				$sub_array[] = '<a class="btn bg-olive btn-app" id="liberar" title="'.$row->idComentario.'"><i class="fa fa-thumbs-o-up"></i> Liberar</a>
                            <a class="btn bg-maroon btn-app inative" title="'.$row->idComentario.'"><i class="fa fa-thumbs-o-down"></i> Negar</a>';
			}            

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->comentariosDao_model->get_all_data(),
            "recordsFiltered" => $this->comentariosDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

    function liberarComentario(){
        $idComentario = $this->input->post('idComentario');		
		if($this->comentariosDao_model->liberarComentarioBD($idComentario)){
			echo 'success';
		}else{
			echo 'false';
		}
    }

    function negarComentario(){
        $idComentario = $this->input->post('idComentario');		
		if($this->comentariosDao_model->negarComentarioBD($idComentario)){
			echo 'success';
		}else{
			echo 'false';
		}
    }

}
