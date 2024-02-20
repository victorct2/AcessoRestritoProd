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

        $data['mainNav'] = 'restrito';      
        $data['listGrupos'] = $this->RestritoDao_model->listarGrupos();
        
        $this->load->view('paginas/restrito/lista',$data);

      
        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'restrito/usuarios-home.js';
        $this->load->view('include/footer',$footer);
    }
   public function viewCadastroArquivo(){
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

        $open['assetsBower'] = 'select2/dist/css/select2.min.css';        
        $this->load->view('include/openDoc',$open);

        $data['mainNav'] = 'restrito';
        $data['subMainNav'] = 'alteraTipoArquivo';
        $this->load->view('paginas/restrito/cadastroTipoArquivo',$data); 

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'grupos/grupos-cadastro.js';
        $this->load->view('include/footer',$footer);
    }

     public function viewAlterar($id){
        //$open['assetsBower'] = 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css,select2/dist/css/select2.min.css';
         $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css,select2/dist/css/select2.min.css';
         $open['pluginCSS'] = 'fancybox/source/jquery.fancybox.css?v=2.1.7,jqueryUi/jquery-ui.min.css';
         $open['assetsCSS'] = 'usuarios/usuarios-list.css';       
         $this->load->view('include/openDoc',$open);

        $data['mainNav'] = 'restrito';
        $data['listGrupos'] = $this->gruposDao_model->listarGrupos();       
        $data['usuario'] = $this->usuariosDao_model->selectUsuarioById($id);
        $data['id'] = $id;
        $data['listTipoArquivo'] = $this->RestritoDao_model->listarSituacao();
       # $data['filter_tipo_arquivo'] = $this->RestritoDao_model->listarSituacao('descricao');

        

        $this->load->view('paginas/restrito/alterar',$data);
        
         $data['listArquivoUsuario'] = $this->RestritoDao_model->selectArquivoUsuario($id);
         

         

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js,select2/dist/js/select2.full.min.js';
        $footer['pluginJS'] = 'fancybox/source/jquery.fancybox.pack.js?v=2.1.7,fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6,jqueryUi/jquery-ui.min.js';
        $footer['assetsJs'] = 'restrito/usuarios-list.js';
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
           
            $sub_array[] = '<a href="'.base_url('RestritoController/index/'.$row->id).'" class="btn btn-app"><i class="fa fa-file"></i> Listar Arquivos</a>
                            ';

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

      public function listaArquivoDataTables($id){
        $fetch_data = $this->RestritoDao_model->make_datatables2($id);

        $data = array();
        foreach($fetch_data as $row){
            $sub_array = array();
            $sub_array[] = $row->descr; 
            $sub_array[] = $row->nome_arquivo;
            $sub_array[] = "<a target=_blank href=".base_url().RESTRITO_UPLOAD.$row->arquivo.">$row->arquivo</a>";
            $sub_array[] =  $row->Data_cadastro;
            $sub_array[] = '<a href="'.base_url('RestritoController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir Arquivo</a>
                            ';
            
           
            
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $this->RestritoDao_model->get_all_files($id),
            "recordsFiltered" => $this->RestritoDao_model->get_filtered_data2($id),
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
	
	  public function viewCadastroGeral(){
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
        $open['pluginCSS'] = 'bootstrap-fileinput/css/fileinput.min.css';
        
        $this->load->view('include/openDoc',$open);
        $data['listCooperado'] = $this->RestritoDao_model->listarCooperado();
        $data['listTipoArquivo'] = $this->RestritoDao_model->listarSituacao();
        $data['mainNav'] = 'restrito';
        $data['subMainNav'] = 'cadastroRestrito';
        $this->load->view('paginas/restrito/cadastroGeral',$data);   

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js,bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';
        $footer['pluginJS'] = 'input-mask/jquery.inputmask.js,bootstrap-fileinput/js/fileinput.min.js,bootstrap-fileinput/js/fileinput_locale_pt-BR.js';
        $footer['assetsJs'] = 'restrito/restrito-cadastro.js';

        $this->load->view('include/footer',$footer);
    }
     public function AlteraTipoCadastro(){

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
        $arquivos = is_array($this->input->post('listaArquivo'))? $this->input->post('listaArquivo') : null;
		$termo = $this->input->post('cooperado');
        $explodetermo = (explode("-",$termo));
		$idCooperado= trim($explodetermo[0]);
		#$email= trim($explodetermo[1]);
		$TipoArquivo = $this->input->post('TipoArquivo');
				
		if ($idCooperado == "GERAL"){
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

		}
            
            
            
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
                $searchString = " ";
                $replaceString = "";
                $originalString =$descricao;
                
                $trataString=$outputString = str_replace($searchString, $replaceString, $originalString);
                
                $nome_arquivo= $descricao;  
                $ext = @end(explode(".",$arquivos[0]));
                $arquivo = $trataString.'.'.$ext;
                //die($arquivo);                
                
                if($this->RestritoDao_model->completar_cadastro($nome_arquivo,$arquivo,$id)){
                    chmod('uploadArquivos/arquivos/'.$arquivos[0], 0777);
                    rename('uploadArquivos/arquivos/'.$arquivos[0],  'uploadArquivos/arquivos/'.$arquivo);
                    chmod('uploadArquivos/arquivos/'.$arquivo, 0777);                     
                    copy('uploadArquivos/arquivos/'.$arquivo, 'assets/arquivos/restrito/'.$arquivo);
                    unlink('uploadArquivos/arquivos/'.$arquivo);

                }  
			}
							
		$consultaEmail = $this->RestritoDao_model->listarEmail();
		$total=$this->RestritoDao_model->get_filtered_email();
		
		foreach($consultaEmail		as $row){
			$email =$row["email"];
			$nome =$row["nome"];
			
			
			#print_r ($email);
			#print_r ($consultaEmail);
			 $this->load->library('email');
                $this->email->from("intranetcoopas@gmail.com", 'Novo arquivo na intranet');
				$this->email->subject(" COOPAS");
				$this->email->to($email);		
				#$this->email->message("Olá, $nome. O arquivo $descricao está disponível e pode ser acessado em  http://intranet.coopas.tv.br");
				$this->email->message("Olá, $nome. $descricao  pode ser acessado em  https://intranet.coopas.tv.br. Através do menu 'Acesso Restrito -> Lista'");
				$this->email->send();	
				
				
			
		}
		
	  redirect(base_url() . 'RestritoController/viewCadastro','refresh');
	 
        }else{
       $email= trim($explodetermo[1]);	
	   $nome= trim($explodetermo[2]);	   
		
		
	
	    
		                
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
                $searchString = " ";
                $replaceString = "";
                $originalString =$descricao;
                
                $trataString=$outputString = str_replace($searchString, $replaceString, $originalString);
                
                $nome_arquivo= $descricao;  
                $ext = @end(explode(".",$arquivos[0]));
                $arquivo = md5($idCooperado.$trataString.$id).'.'.$ext;
                //die($arquivo);                
                
                if($this->RestritoDao_model->completar_cadastro($nome_arquivo,$arquivo,$id)){
                    chmod('uploadArquivos/arquivos/'.$arquivos[0], 0777);
                    rename('uploadArquivos/arquivos/'.$arquivos[0],  'uploadArquivos/arquivos/'.$arquivo);
                    chmod('uploadArquivos/arquivos/'.$arquivo, 0777);                     
                    copy('uploadArquivos/arquivos/'.$arquivo, 'assets/arquivos/restrito/'.$arquivo);
                    unlink('uploadArquivos/arquivos/'.$arquivo);

                }                               
                
                
                $this->session->set_flashdata('resultado_ok','Arquivo cadastrado com sucesso!');   
				$this->load->library('email');
                $this->email->from("coopascti@gmail.com", 'Novo arquivo na intranet');
				$this->email->subject(" COOPAS");
				$this->email->to($email);		
				#$this->email->message("Olá, $nome. O arquivo $descricao está disponível e pode ser acessado em  http://intranet.coopas.tv.br");
				$this->email->message("Olá, $nome. $descricao  pode ser acessado em  https://intranet.coopas.tv.br. Através do menu 'Acesso Restrito -> Lista'");
				$this->email->send();		
				
				#if ( ! $this->email->send()) {
        #show_error($this->email->print_debugger());
    #}            
                redirect(base_url() . 'RestritoController/viewCadastro','refresh'); 
				
            }
            else {
                $this->session->set_flashdata('resultado_error','Erro ao cadastrar o Arquivo!');            
                redirect(base_url() . 'RestritoController/viewCadastro','refresh'); 
            }
        
		}
		}    
	}
	
	 public function cadastrarRestritoGeral(){
		 $descricao   = $this->input->post('descricao');
        $arquivos = is_array($this->input->post('listaArquivo'))? $this->input->post('listaArquivo') : null;
		$termo = $this->input->post('cooperado');
        $explodetermo = (explode("-",$termo));
		$idCooperado= trim($explodetermo[0]);
		#$email= trim($explodetermo[1]);
		$TipoArquivo = $this->input->post('TipoArquivo');
				
		if ($idCooperado == "GERAL"){
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

		}
            
            
            
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
                $searchString = " ";
                $replaceString = "";
                $originalString =$descricao;
                
                $trataString=$outputString = str_replace($searchString, $replaceString, $originalString);
                
                $nome_arquivo= $descricao;  
                $ext = @end(explode(".",$arquivos[0]));
                $arquivo = $trataString.'.'.$ext;
                //die($arquivo);                
                
                if($this->RestritoDao_model->completar_cadastro($nome_arquivo,$arquivo,$id)){
                    chmod('uploadArquivos/arquivos/'.$arquivos[0], 0777);
                    rename('uploadArquivos/arquivos/'.$arquivos[0],  'uploadArquivos/arquivos/'.$arquivo);
                    chmod('uploadArquivos/arquivos/'.$arquivo, 0777);                     
                    copy('uploadArquivos/arquivos/'.$arquivo, 'assets/arquivos/restrito/'.$arquivo);
                    unlink('uploadArquivos/arquivos/'.$arquivo);

                }  
			}
							
		$consultaEmail = $this->RestritoDao_model->listarEmail();
		$total=$this->RestritoDao_model->get_filtered_email();
		
		foreach($consultaEmail		as $row){
			$email =$row["email"];
			$nome =$row["nome"];
			
			
			#print_r ($email);
			#print_r ($consultaEmail);
			 $this->load->library('email');
                $this->email->from("intranetcoopas@gmail.com", 'Novo arquivo na intranet');
				$this->email->subject(" COOPAS");
				$this->email->to($email);		
				#$this->email->message("Olá, $nome. O arquivo $descricao está disponível e pode ser acessado em  http://intranet.coopas.tv.br");
				$this->email->message("Olá, $nome. $descricao  pode ser acessado em  https://intranet.coopas.tv.br. Através do menu 'Acesso Restrito -> Lista'");
				$this->email->send();	
				
				
			
		}
		
	  redirect(base_url() . 'RestritoController/viewCadastro','refresh');
	 
        }
		 
	 }

     public function cadastrarTipoArquivo(){

        
        $descricao = $this->input->post('descricao');
        $status = $this->input->post('status');
        
        $mensagem = array();
        
        if(empty($descricao)){
        $mensagem[] = "A<b>Descrição</b> é obrigatório.";
        }
        
        if(empty($status)){
        $mensagem[]="O campo <b>STATUS</b> é obrigatório.";
        }
        
        if(count($mensagem)>0){        
            $this->session->set_flashdata('mensagem',$mensagem);    
            redirect(base_url() . 'RestritoController/viewCadastro','refresh');       
        }
        else{
        
            /**
            * Armazenando os valores para serem gravados no BANCO
            */
            $data['descricao'] = $descricao;
            $data['ativa'] = $status;
            
            if($this->RestritoDao_model->insertTipoArquivo($data)){            
                $this->session->set_flashdata('resultado_ok','Grupo cadastrado com sucesso!');          
                redirect(base_url() . 'RestritoController/viewCadastro','refresh');             
            }else{            
                $this->session->set_flashdata('resultado_error','Erro ao cadastrar o Grupo!');          
                redirect(base_url() . 'RestritoController/viewCadastro','refresh');             
            }
        
        }

    }

     public function viewListaTipoArquivo($offset=0){

        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
        $open['assetsCSS'] = 'grupos/grupos-list.css';
        $this->load->view('include/openDoc',$open);

        $data['mainNav'] = 'restrito';
        $data['subMainNav'] = 'listaTipoArquivo';
        $this->load->view('paginas/restrito/listaTipoArquivo',$data);    

       $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
        $footer['assetsJs'] = 'restrito/lista_tipoArquivo.js'; 
        $this->load->view('include/footer',$footer);
    }

    public function listaTipoArquivoDataTables(){
        $fetch_data = $this->RestritoDao_model->make_datatablesTipoArquivo();
        $data = array();
        foreach($fetch_data as $row){  
            

            $sub_array = array();  
            $sub_array[] = $row->id;             
            $sub_array[] = $row->descricao;   
            $sub_array[] = $row->ativa;
            $sub_array[] = '<a href="'.base_url('RestritoController/viewAlterarTipoArquivo/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>';                            
            $sub_array[] ='<a href="'.base_url('RestritoController/excluirTipoArquivo/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';  

            
            
            $data[] = $sub_array; 

            } 
         
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->RestritoDao_model->get_all_dataLista(),  
            "recordsFiltered" => $this->RestritoDao_model->get_filtered_dataLista(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }

     public function viewAlterarTipoArquivo($id){

        
        $open['assetsBower'] = 'select2/dist/css/select2.min.css';        
        $this->load->view('include/openDoc',$open);

        $data['restritoTipo'] = $this->RestritoDao_model->selectTipoArquivoById($id);
        $this->load->view('paginas/restrito/alterarTipoArquivo',$data);  

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        #$footer['assetsJs'] = 'grupos/grupos-cadastro.js';
        $this->load->view('include/footer',$footer);


    }


    public function alterarTipoArquivo(){

        $id = $this->input->post('id');
        $descricao = $this->input->post('descricao');
        $status = $this->input->post('status');
        
        $mensagem = array();
        
        if(empty($descricao)){
        $mesangem[] = "O campo <b>DESCRICAO</b> é obrigatório.";
        }
        
        if(empty($status)){
        $mensagem[]="O campo <b>STATUS</b> é obrigatório.";
        }
        
        if(count($mensagem)>0){        
            $this->session->set_flashdata('mensagem',$mensagem);    
            redirect(base_url() . 'RestritoController/viewListaTipoArquivo/'.$id,'refresh');       
        }
        else{
        
            /**
            * Armazenando os valores para serem gravados no BANCO
            */
            $data['id'] = $id;
            $data['descricao'] = $descricao;
            $data['ativa'] = $status;
            
            if($this->RestritoDao_model->updateTipoArquivo($data)){ 
                  
                $this->session->set_flashdata('resultado_ok','Grupo cadastrado com sucesso!');          
                redirect(base_url() . 'RestritoController/viewListaTipoArquivo','refresh');             
            }else{            
                $this->session->set_flashdata('resultado_error','Erro ao cadastrar o Grupo!');          
                redirect(base_url() . 'RestritoController/viewListaTipoArquivo','refresh');             
            }
        
        }

    }

    function excluirTipoArquivo($id){         
        if($this->RestritoDao_model->deleteTipoArquivo($id)){
            $this->session->set_flashdata('resultado_ok', 'Exclusão efetuada com sucesso!');
            redirect(base_url() . 'RestritoController/viewListaTipoArquivo', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_ok', 'Erro ao Excluir o Grupo!');
            redirect(base_url() . 'RestritoController/viewListaTipoArquivo','refresh'); 
        } 
    }
 function index($id)
 {
  
    $data['mainNav'] = 'restrito';
  $this->load->view('include/openDoc');
  $data['descricao_data'] = $this->RestritoDao_model->fetch_filter_type('tipo_arquivo.descricao');
  $data['id_user'] = $this->RestritoDao_model->fetch_filter_type('cooperado_arquivo.id_user');
  $data['listGrupos'] = $this->gruposDao_model->listarGrupos();     
  $data['usuario'] = $this->RestritoDao_model->selectUsuarioById($id);
  $data['id'] = $id;
  #$data['ram_data'] = $this->product_filter_model2->fetch_filter_type('product_ram');
  #$data['product_storage'] = $this->product_filter_model2->fetch_filter_type('product_storage');
  $this->load->view('paginas/restrito/product_filter', $data);
  $footer['assetsJs'] = 'restrito/usuarios-list.js';
 # $data['listArquivoUsuario'] = $this->RestritoDao_model->selectArquivoUsuario($id);
 
 
  
 }

 function fetch_data()
 {
  sleep(1);
  $descricao = $this->input->post('descricao');
  $id_user=$this->input->post('id');
  
  #$ativa = $this->input->post('ativa');
  #$id = $this->input->post('id');
  $this->load->library('pagination');
  $config = array();
  $config['base_url'] = '#';
  $config['total_rows'] = $this->RestritoDao_model->count_all($descricao,$id_user);
  $config['per_page'] = 8;
  $config['uri_segment'] = 3;
  $config['use_page_numbers'] = TRUE;
  $config['full_tag_open'] = '<ul class="pagination">';
  $config['full_tag_close'] = '</ul>';
  $config['first_tag_open'] = '<li>';
  $config['first_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li>';
  $config['last_tag_close'] = '</li>';
  $config['next_link'] = '&gt;';
  $config['next_tag_open'] = '<li>';
  $config['next_tag_close'] = '</li>';
  $config['prev_link'] = '&lt;';
  $config['prev_tag_open'] = '<li>';
  $config['prev_tag_close'] = '</li>';
  $config['cur_tag_open'] = "<li class='active'><a href='#'>";
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li>';
  $config['num_tag_close'] = '</li>';
  $config['num_links'] = 3;
  $this->pagination->initialize($config);
  $page = $this->uri->segment(3);
  $start = ($page - 1) * $config['per_page'];
  $output = array(
   'pagination_link'  => $this->pagination->create_links(),
   'product_list'   => $this->RestritoDao_model->fetch_data($config["per_page"], $start, $descricao, $id_user)
  );
  echo json_encode($output);
 }

    }
    


