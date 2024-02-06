<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RestritoController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("49", $grupos)){             
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

	
		$this->load->model('RestritoDao_model');
		$this->load->model('usuariosDao_model');
		$this->load->model('gruposDao_model');
		$this->load->model('programasDao_model');

	}


   public function viewLista(){

		//$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'usuarios/usuarios-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'usuarios';
		$data['subMainNav'] = 'listaRestrito';
		$data['listGrupos'] = $this->RestritoDao_model->listarGrupos();
		$this->load->view('paginas/restrito/lista',$data);

      
		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
		$footer['assetsJs'] = 'restrito/usuarios-home.js';
        $this->load->view('include/footer',$footer);
	}


     public function listaUsuariosDataTables(){

        $fetch_data = $this->RestritoDao_model->make_datatables();

        $data = array();
        foreach($fetch_data as $row){

            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->nome;
            $sub_array[] = $row->login;
            $sub_array[] = $row->email;
           
            $sub_array[] = '<a href="'.base_url('RestritoController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('RestritoController/excluirUsuario/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->RestritoDao_model->get_all_data(),
            "recordsFiltered" => $this->RestritoDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

	
	public function viewCadastro(){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        
        $this->load->view('include/openDoc',$open);
        $data['listCooperado'] = $this->RestritoDao_model->listarCooperado();
		$data['listTipoArquivo'] = $this->RestritoDao_model->listarSituacao();
		$data['mainNav'] = 'restrito';
		$data['subMainNav'] = 'cadastroRestrito';
		$this->load->view('paginas/restrito/cadastro',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'restrito/restrito-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function cadastrarRestrito(){

        	
		$descricao   = $this->input->post('descricao');
		$arquivos = is_array($this->input->post('listaArquivo'))? $this->input->post('listaArquivo') : null;;
		$idCooperado   = $this->input->post('cooperado');
		$TipoArquivo   = $this->input->post('TipoArquivo');
						
		$mensagem = array();
		
		if(empty($descricao)){
			$mensagem[] = 'A <b>DESCRIÇÃO</b> do arquivo é Obrigatória.';
		}
		
		if(empty($arquivos)){
			$arquivos[] = 'O <b>arquivo</b> é Obrigatório.';
		}
		
		
		
		if(empty($TipoArquivo)){
			$mensagem[] = 'O <b>Tipo</b> de arquivo é Obrigatório.';
		}
		
		
		if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'RestritoController/viewCadastro','refresh');			
		}		
		else{ 			
			
			/*
			** Armazenando dados do formulário no Array $data
			*/		
			$data['id'] = null;
			$data['descricao'] = $descricao;	
			$data['tipo_arquivo']=$TipoArquivo ;

			
			
			
			
			if($this->RestritoDao_model->insertArquivo($data)){ #aqui o correto é só adicionar a referência da outra tabela (arquivo_upload)
				
				$id = $this->db->insert_id();	
				$idArquivo = $this->RestritoDao_model->selectArquivoById($id);
				
				$data2['id_arquivo'] = $id;
				$data2['id'] = null;					
			    $data2['id_user'] = $idCooperado ; 

			    $this->RestritoDao_model->insertRestrito($data2);

			    /*
			  	* Foto
			  	*/
			  	$nome_arquivo= $descricao;	
				$ext = @end(explode(".",$arquivos[0]));
				$arquivo = $descricao.'.'.$ext;					
				
				if($this->RestritoDao_model->completar_cadastro($nome_arquivo,$arquivo,$id)){
					chmod('uploadArquivos/arquivos/' . $arquivos[0], 0777);
					rename('uploadArquivos/arquivos/' . $arquivos[0],  'uploadArquivos/arquivos/' . $arquivo);
					chmod('uploadArquivos/arquivos/' . $arquivo, 0777); 					
					copy('uploadArquivos/arquivos/' . $arquivo, 'assets/arquivos/restrito/' . $arquivo);
					unlink('uploadArquivos/arquivos/' . $arquivo);

				}
				



									
				
				
				$this->session->set_flashdata('resultado_ok','Arquivo cadastrado com sucesso!');			
				redirect(base_url() . 'RestritoController/viewLista','refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Arquivo!');			
				redirect(base_url() . 'RestritoController/viewLista','refresh'); 
			}

			
			
		}



    }

     public function viewAlterar($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        
        $this->load->view('include/openDoc',$open);

        $data['listGrupos'] = $this->gruposDao_model->listarGrupos();       
        $data['usuario'] = $this->usuariosDao_model->selectUsuarioById($id);
        $gruposUsuarios = $this->usuariosDao_model->selectGruposUsuarioById($id);

        
        $data['listArquivoUsuario'] = $this->RestritoDao_model->selectArquivoUsuario($id);
         $data['selectTipoAr'] = $this->RestritoDao_model->selectTipoAr($id);
         $footer['assetsJs'] = 'restrito/usuarios-list.js';
         $open['assetsCSS'] = 'usuarios/usuarios-list.css';


		$this->load->view('paginas/restrito/alterar',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js';
        $footer['assetsJs'] = 'restrito/usuarios-list.js';

		$this->load->view('include/footer',$footer);
	}

	
  public function selectArquivoUsuario(){

        $fetch_data = $this->RestritoDao_model->make_datatables2();

        $data = array();
        foreach($fetch_data as $row){

            $sub_array = array();
            $sub_array[] = $row->nome_arquivo;
            $sub_array[] = $row->arquivo;
            $sub_array[] = $row->Data_cadastro;
            $sub_array[] = $row->idArquivo;
           // $sub_array[] = $row->email;
           
            $sub_array[] = '<a href="'.base_url('RestritoController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('RestritoController/excluirUsuario/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->RestritoDao_model->get_all_data(),
            "recordsFiltered" => $this->RestritoDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }
	


	
}
