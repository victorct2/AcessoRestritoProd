<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		/*if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos)){             
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }*/

		$this->load->model('usuariosDao_model');
		$this->load->model('gruposDao_model');
		$this->load->model('programasDao_model');

	}


    public function viewLista(){
    	if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos)){             
        }
        if(in_array("50", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }
        

		//$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
		$open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
        $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
        $open['assetsCSS'] = 'usuarios/usuarios-list.css';
        $this->load->view('include/openDoc',$open);

		$data['mainNav'] = 'usuarios';
		$data['subMainNav'] = 'listaUsuarios';
		$data['listGrupos'] = $this->gruposDao_model->listarGrupos();
		$this->load->view('paginas/usuarios/lista',$data);

        //$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
		$footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
		$footer['assetsJs'] = 'usuarios/usuarios-home.js';
        $this->load->view('include/footer',$footer);
	}


     public function listaUsuariosDataTables(){

        $fetch_data = $this->usuariosDao_model->make_datatables();

        $data = array();
        foreach($fetch_data as $row){

            $cargo = '<span class="label pull-right bg-navy">'.$row->cargo.'</span><br>';
			$profissao = '<span class="label pull-right bg-purple">'.$row->profissao.'</span><br>';
            $situacao = '';
            if($row->ativo == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>';
            }else if($row->ativo == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';
            }
           

            $sub_array = array();
            $sub_array[] = $row->id;
            $sub_array[] = $row->nome;
            $sub_array[] = $row->login;
            $sub_array[] = $row->nome_grupo;
            $sub_array[] = $row->email;
            $sub_array[] = $cargo.$profissao.$situacao;
            $sub_array[] = '<a href="'.base_url('UsuariosController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>
                            <a href="'.base_url('UsuariosController/excluirUsuario/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';

            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->usuariosDao_model->get_all_data(),
            "recordsFiltered" => $this->usuariosDao_model->get_filtered_data(),
            "data" => $data
        );
        echo json_encode($output);
    }

	
	public function viewCadastro(){

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos)){             
        }
        if(in_array("50", $grupos)){
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        
        $this->load->view('include/openDoc',$open);

		$data['listGrupos'] = $this->gruposDao_model->listarGrupos();
		$data['listProgramas'] = $this->programasDao_model->listarProgramas();
		$data['mainNav'] = 'usuarios';
		$data['subMainNav'] = 'cadastroUsuario';
		$this->load->view('paginas/usuarios/cadastro',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js';
        $footer['assetsJs'] = 'usuarios/usuarios-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    /**
	 * Verificando O LOGIN 
	 */
	function loginExistente(){		
		$loginUsuario = $this->input->post('loginUsuario');		
		$login_atual = $this->usuariosDao_model->login_disponivel($loginUsuario);		
		if (count($login_atual) > 0) {
			if($login_atual[0]->login == $loginUsuario){
				echo 'success';
			}else{
				echo 'false';
			}					
		}else{
			echo 'success';
		}		
	}


    public function cadastrarUsuario(){

        
        $nome        = $this->input->post('nome');
		$login       = $this->input->post('login');
		$senha       = $this->input->post('senha');
		$grupos      = $this->input->post('grupos');
		//$programas      = $this->input->post('programas');
		$email 		 = $this->input->post('email');
		$telefone    = $this->input->post('telefone');
        $celular     = $this->input->post('celular');
		$profissao   = $this->input->post('profissao');
		$instituicao = $this->input->post('instituicao');
		$cargo  	 = $this->input->post('cargo');
		//$mobilizacao = $this->input->post('mobilizacao');
		//$autorizar   = $this->input->post('autorizar');
        //$api         = $this->input->post('api');
		$ativo       = $this->input->post('situacao'); 
        $dataNascimento = $this->input->post('dataNascimento'); 
        //$freelancer = $this->input->post('freelancer'); 
		
		$mensagem = array();

		if (empty($nome)){ 
			$mensagem[] = 'o campo <b>NOME</b> é obrigatório';	
		}	

		if (empty($login)){
			$mensagem[] = 'o campo <b>LOGIN</b> é obrigatório';
		}

		if (empty($senha)){ 
			$mensagem[] = 'o campo <b>SENHA</b> é obrigatório';
		}	

		if (empty($email)){
			$mensagem[] = 'o campo <b>EMAIL</b> é obrigatório';		    
		}else if(!valid_email($email)){
            $mensagem[] = 'o campo <b>EMAIL</b> está incorreto';		    
        }	

		if (empty($ativo)){
			$mensagem[] = 'o campo <b>ATIVO</b> é obrigatório';		    
		}

        if(empty($dataNascimento)){
			//$mensagem[] = 'O <b>DATA NASCIMENTO</b> de exibição da programação é Obrigatória.';
		}else if(!validaData($dataNascimento)){
			$mensagem[] = '<b>DATA NASCIMENTO</b> Inválida.';
		}

        if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'UsuariosController/viewCadastro','refresh');				
		}
        else{

            $data['dia']        = date('Y-m-d'); 
          //  $data['freelancer'] = $freelancer; 
			$data['login']      = $login;
			$data['senha']      = md5($senha);
			$data['nome']       = $nome;
			if (!empty($telefone)) {
			$data['telefones']  = tratarTelefone($telefone);
		    }
			if (!empty($celular)) {
			$data['celular']    = tratarTelefone($celular);
			}
			$data['email']      = $email;
			$data['profissao']  = $profissao;
			$data['cargo']      = $cargo;
			//$data['mobilizacao']= $mobilizacao;
			//$data['autorizar']  = $autorizar;
            //$data['api']        = $api;
			$data['ativo']	    = $ativo;
            $data['dataNascimento'] = converteDataBanco($dataNascimento);

            if($this->usuariosDao_model->insertUsuario($data,$grupos,$programas)){				
				$this->session->set_flashdata('resultado_ok','Usuário <b>'.$nome.'</b> cadastrado com sucesso!');			
				redirect(base_url() . 'UsuariosController/viewLista','refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o usuário!');			
				redirect(base_url() . 'UsuariosController/viewLista','refresh'); 
			}
        }

    }

    

    public function viewAlterar($id){

        $open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
        
        $this->load->view('include/openDoc',$open);

        $data['listGrupos'] = $this->gruposDao_model->listarGrupos();
        $data['listProgramas'] = $this->programasDao_model->listarProgramas();
        $data['usuario'] = $this->usuariosDao_model->selectUsuarioById($id);
        $gruposUsuarios = $this->usuariosDao_model->selectGruposUsuarioById($id);
        foreach ($gruposUsuarios as $value) {
            $data['gruposUsuario'][] = $value->idGrupo;
        }   
        $programasUsuarios = $this->usuariosDao_model->selectProgramasUsuarioById($id);
        foreach ($programasUsuarios as $value) {
            $data['programasUsuario'][] = $value->idPrograma;
        }     

		$this->load->view('paginas/usuarios/alterar',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js';
        $footer['assetsJs'] = 'usuarios/usuarios-cadastro.js';

		$this->load->view('include/footer',$footer);
	}

    public function alterarUsuario(){

        
        $nome        = $this->input->post('nome');
		$login       = $this->input->post('login');
		$senha       = $this->input->post('senha');
		$grupos      = $this->input->post('grupos');
		//$programas   = $this->input->post('programas');
		$email 		 = $this->input->post('email');
		$telefone    = $this->input->post('telefone');
        $celular     = $this->input->post('celular');
		$profissao   = $this->input->post('profissao');
		$instituicao = $this->input->post('instituicao');
		$cargo  	 = $this->input->post('cargo');
		//$mobilizacao = $this->input->post('mobilizacao');
		//$autorizar   = $this->input->post('autorizar');
        //$api         = $this->input->post('api');
		$ativo       = $this->input->post('situacao'); 
        $dataNascimento = $this->input->post('dataNascimento'); 
        //$freelancer = $this->input->post('freelancer'); 
        $id          = $this->input->post('id');
		
        $dadosAtuais = $this->usuariosDao_model->selectUsuarioById($id);
		$mensagem = array();

		if (empty($nome)){ 
			$mensagem[] = 'o campo <b>NOME</b> é obrigatório';	
		}	

		if (empty($login)){
			$mensagem[] = 'o campo <b>LOGIN</b> é obrigatório';
		}

		if (empty($senha)){ 			
            $senha = $dadosAtuais[0]->senha; 
		}else{
            $senha = md5($senha);
        }	

		if (empty($email)){
			$mensagem[] = 'o campo <b>EMAIL</b> é obrigatório';		    
		}else if(!valid_email($email)){
            $mensagem[] = 'o campo <b>EMAIL</b> está incorreto';		    
        }	

		if (empty($ativo)){
			$mensagem[] = 'o campo <b>ATIVO</b> é obrigatório';		    
		}

        if(empty($dataNascimento)){
			//$mensagem[] = 'O <b>DATA NASCIMENTO</b> de exibição da programação é Obrigatória.';
		}else if(!validaData($dataNascimento)){
			$mensagem[] = '<b>DATA NASCIMENTO</b> Inválida.';
		}

        if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'UsuariosController/viewAlterar/'.$id,'refresh');				
		}
        else{

            
        //    $data['freelancer'] = $freelancer; 
			$data['login']      = $login;
			$data['senha']      = $senha;
			$data['nome']       = $nome;
			if (!empty($telefone)) {
			$data['telefones']  = tratarTelefone($telefone);
		    }
			if (!empty($celular)) {
			$data['celular']    = tratarTelefone($celular);
			}
			$data['email']      = $email;
			$data['profissao']  = $profissao;
			$data['cargo']      = $cargo;
			//$data['mobilizacao']= $mobilizacao;
			//$data['autorizar']  = $autorizar;
            //$data['api']        = $api;
			$data['ativo']	    = $ativo;
            $data['dataNascimento'] = converteDataBanco($dataNascimento);
            $data['id'] = $id;

            if($this->usuariosDao_model->updateUsuario($data,$grupos,$programas)){				
				$this->session->set_flashdata('resultado_ok','Usuário <b>'.$nome.'</b> cadastrado com sucesso!');			
				redirect(base_url() . 'UsuariosController/viewLista','refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o usuário!');			
				redirect(base_url() . 'UsuariosController/viewLista','refresh'); 
			}
        }

    }

    
    /**
	* Excluindo o usuário 
	*/
	function excluirUsuario($id){		

        if($this->usuariosDao_model->deleteUsuario($id)){
            $this->session->set_flashdata('resultado_ok', 'Exclusão efetuada com sucesso!');
            redirect(base_url() . 'UsuariosController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_error', 'Erro ao Excluir o usuário!');
            redirect(base_url() . 'UsuariosController/viewLista','refresh'); 
        }	
	}

	public function viewPerfil(){

		$id = $this->session->userdata("idUsuario");
		
	
		$open['assetsCSS'] = 'usuarios/usuarios-avatar.css';
		$open['assetsBower'] = 'select2/dist/css/select2.min.css';
		$open['pluginCSS'] = 'jqueryUi/jquery-ui.min.css,bootstrap-fileinput/css/fileinput.min.css';
    	$open['assetsCSS'] = 'noticias/noticias-cadastro.css';
		
		$this->load->view('include/openDoc',$open);
		
		

		$data['listGrupos'] = $this->gruposDao_model->listarGrupos();
		$data['usuario'] = $this->usuariosDao_model->selectUsuarioById($id);
		$gruposUsuarios = $this->usuariosDao_model->selectGruposUsuarioById($id);
		foreach ($gruposUsuarios as $value) {
			$data['gruposUsuario'][] = $value->idGrupo;
		}        

		$data['mainNav'] = 'perfil';
		$this->load->view('paginas/usuarios/perfil',$data);	

		$footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,ckeditor/ckeditor.js';
		$footer['pluginJS'] = 'input-mask/jquery.inputmask.js,jqueryUi/jquery-ui.min.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'noticias/noticias-cadastro.js';
		$this->load->view('include/footer',$footer);
	}

	public function alterarPerfil(){

		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		exit();*/

		$id = $this->session->userdata("idUsuario");
		 
        $nome        = $this->input->post('nome');
		$login       = $this->input->post('login');
		$senha       = $this->input->post('senha');
		$email 		 = $this->input->post('email');
		$telefone    = $this->input->post('telefone');
        $celular     = $this->input->post('celular');
		
        $dadosAtuais = $this->usuariosDao_model->selectUsuarioById($id);
		$mensagem = array();

		if (empty($nome)){ 
			$mensagem[] = 'o campo <b>NOME</b> é obrigatório';	
		}	

		if (empty($login)){
			$mensagem[] = 'o campo <b>LOGIN</b> é obrigatório';
		}

		if (empty($senha)){ 			
            $senha = $dadosAtuais[0]->senha; 
		}else{
            $senha = md5($senha);
        }	

		if (empty($email)){
			$mensagem[] = 'o campo <b>EMAIL</b> é obrigatório';		    
		}else if(!valid_email($email)){
            $mensagem[] = 'o campo <b>EMAIL</b> está incorreto';		    
        }	


        if (count($mensagem) > 0) {		
			$this->session->set_flashdata('mensagem',$mensagem);	
			redirect(base_url() . 'UsuariosController/viewPerfil/'.$id,'refresh');				
		}
        else{

            
			$data['login']      = $login;
			$data['senha']      = $senha;
			$data['nome']       = $nome;
			if (!empty($telefone)) {
			$data['telefones']  = tratarTelefone($telefone);
		    }
			if (!empty($celular)) {
			$data['celular']    = tratarTelefone($celular);
			}
			$data['email']      = $email;
            $data['id'] = $id;

            if($this->usuariosDao_model->updatePerfil($data)){				
				$this->session->set_flashdata('resultado_ok','Perfil do usuário <b>'.$nome.'</b> foi alterado com sucesso!');			
				redirect(base_url() . 'UsuariosController/viewPerfil','refresh'); 
			}
			else {
				$this->session->set_flashdata('resultado_error','Erro ao alterar o perfil do usuário!');			
				redirect(base_url() . 'UsuariosController/viewPerfil','refresh'); 
			}
        }

	}

	function alterarAvatar(){

	   $id = $this->session->userdata("idUsuario");		
	   $avatar = $this->input->post('avatar');
	   		
	   if($this->usuariosDao_model->updateAvatar($id, $avatar)) {
			$this->session->set_userdata('avatar', $avatar);
			echo 'success';
	   }else{
		   echo 'false';
	   }		

	}

	function updateUsuariosGrupos(){
		$usuarios = $this->usuariosDao_model->listarUsuarios();
		foreach ($usuarios as $value) {
			$data = array(
				'idUsuario' => $value->id,
				'idGrupo' => $value->grupo
			);
			$this->usuariosDao_model->insertUsuariosGrupo($data);
		}
		$this->viewLista();
	}
	
	 	  function upload(){

  		$this->load->library("upload");
  		 $this->upload->initialize(array(
  				 "upload_path" => './uploadImagens/arquivos/',
  				 'allowed_types' => 'png|jpg|jpeg|png|gif|psd',
  				 "overwrite" => FALSE,
  				 "max_filename" => 0,
  				 "encrypt_name" => TRUE,
  				 'multi' => 'all'
  		 ));

  		 $successful = $this->upload->do_upload('userfile');
  		 $fileName = array();
  		 $data = array();

  		 if($successful)
  		 {
  			$data[] = $this->upload->data();
  			$resp =  is_array($data);

  			if(count($data[0])>6){
  				foreach ($data as $key => $value) {
  					$fileName[] = $value['file_name'];
  				}
  			}else{
  				foreach ($data as $key => $value) {
  					if(count($value)> 1){
  						foreach ($value as $file) {
  							$fileName[] = $file['file_name'];
  						}
  					}
  				}
  			}



  		 } else {

  			 $msg = $this->upload->display_errors();
  		 }

  		echo json_encode(['result' => $successful, 'file_name'=>$fileName]);

  	 }


}