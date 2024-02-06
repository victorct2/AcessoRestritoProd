<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GruposController extends CI_Controller {

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

        $this->load->model('gruposDao_model');

	}


    public function viewLista($offset=0){

        $open['assetsBower'] = 'datatables.net-bs/css/dataTables.bootstrap.min.css';
        $open['assetsCSS'] = 'grupos/grupos-list.css';
        $this->load->view('include/openDoc',$open);

        $data['mainNav'] = 'grupos';
		$data['subMainNav'] = 'listaGrupos';
		$this->load->view('paginas/grupos/lista',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,datatables.net/js/jquery.dataTables.min.js,datatables.net-bs/js/dataTables.bootstrap.min.js';
        $footer['assetsJs'] = 'grupos/grupos-home.js'; 
        $this->load->view('include/footer',$footer);
    }

    public function listaGruposDataTables(){

        $fetch_data = $this->gruposDao_model->make_datatables();
        $data = array();
        foreach($fetch_data as $row){         
            
            $situacao="";
            if($row->status == 'S'){
                $situacao = '<span class="label pull-right bg-green">ATIVO</span><br>'; 
            }else if($row->status == 'N'){
                $situacao = '<span class="label pull-right bg-red">INATIVO</span><br>';  
            }             

            $sub_array = array();  
            $sub_array[] = $row->id;
            $sub_array[] = $row->nome;  
            $sub_array[] = $row->descricao;   
            $sub_array[] = $situacao;
            $sub_array[] = '<a href="'.base_url('GruposController/viewAlterar/'.$row->id).'" class="btn btn-app"><i class="fa fa-edit"></i> Alterar</a>';
            $sub_array[] = '<a href="'.base_url('GruposController/excluirGrupo/'.$row->id).'" class="btn btn-app"><i class="fa fa-trash"></i> Excluir</a>';  
            
            $data[] = $sub_array;  
        }  
        $output = array(  
            "draw" => intval($_POST["draw"]),  
            "recordsTotal" => $this->gruposDao_model->get_all_data(),  
            "recordsFiltered" => $this->gruposDao_model->get_filtered_data(),  
            "data" => $data  
        );  
        echo json_encode($output);
    }

	
	public function viewCadastro(){

        $open['assetsBower'] = 'select2/dist/css/select2.min.css';        
        $this->load->view('include/openDoc',$open);

        $data['mainNav'] = 'grupos';
		$data['subMainNav'] = 'cadastroGrupo';
		$this->load->view('paginas/grupos/cadastro',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'grupos/grupos-cadastro.js';
		$this->load->view('include/footer',$footer);
	}

    public function cadastrarGrupo(){

        $nome = $this->input->post('nome');
        $descricao = $this->input->post('descricao');
        $nivel = $this->input->post('nivel');
        $status = $this->input->post('status');
        
        $mensagem = array();
        
        if(empty($nome)){
        $mesangem[] = "O campo <b>NOME</b> é obrigatório.";
        }
        
        if(empty($status)){
        $mensagem[]="O campo <b>STATUS</b> é obrigatório.";
        }
        
        if(count($mensagem)>0){        
            $this->session->set_flashdata('mensagem',$mensagem);	
            redirect(base_url() . 'GruposController/viewCadastro/','refresh');       
        }
        else{
        
            /**
            * Armazenando os valores para serem gravados no BANCO
            */
            $data['nome'] = $nome;
            $data['descricao'] = $descricao;
            $data['nivel'] = $nivel;
            $data['status'] = $status;
            
            if($this->gruposDao_model->insertGrupo($data)){            
                $this->session->set_flashdata('resultado_ok','Grupo cadastrado com sucesso!');			
                redirect(base_url() . 'GruposController/viewLista','refresh');             
            }else{            
                $this->session->set_flashdata('resultado_error','Erro ao cadastrar o Grupo!');			
                redirect(base_url() . 'GruposController/viewLista','refresh');             
            }
        
        }

    }


    public function viewAlterar($id){

        $open['assetsBower'] = 'select2/dist/css/select2.min.css';        
        $this->load->view('include/openDoc',$open);

        $data['grupo'] = $this->gruposDao_model->selectGruposById($id);
		$this->load->view('paginas/grupos/alterar',$data);	

        $footer['assetsJsBower'] = 'moment/min/moment.min.js,select2/dist/js/select2.full.min.js';
        $footer['assetsJs'] = 'grupos/grupos-cadastro.js';
		$this->load->view('include/footer',$footer);
	}

    public function alterarGrupo(){

        $id = $this->input->post('id');
        $nome = $this->input->post('nome');
        $descricao = $this->input->post('descricao');
        $nivel = $this->input->post('nivel');
        $status = $this->input->post('status');
        
        $mensagem = array();
        
        if(empty($nome)){
        $mesangem[] = "O campo <b>NOME</b> é obrigatório.";
        }
        
        if(empty($status)){
        $mensagem[]="O campo <b>STATUS</b> é obrigatório.";
        }
        
        if(count($mensagem)>0){        
            $this->session->set_flashdata('mensagem',$mensagem);	
            redirect(base_url() . 'GruposController/viewAlterar/'.$id,'refresh');       
        }
        else{
        
            /**
            * Armazenando os valores para serem gravados no BANCO
            */
            $data['id'] = $id;
            $data['nome'] = $nome;
            $data['descricao'] = $descricao;
            $data['nivel'] = $nivel;
            $data['status'] = $status;
            
            if($this->gruposDao_model->updateGrupo($data)){            
                $this->session->set_flashdata('resultado_ok','Grupo cadastrado com sucesso!');			
                redirect(base_url() . 'GruposController/viewLista','refresh');             
            }else{            
                $this->session->set_flashdata('resultado_error','Erro ao cadastrar o Grupo!');			
                redirect(base_url() . 'GruposController/viewLista','refresh');             
            }
        
        }

    }

    function excluirGrupo($id){			
        if($this->gruposDao_model->deleteGrupo($id)){
            $this->session->set_flashdata('resultado_ok', 'Exclusão efetuada com sucesso!');
            redirect(base_url() . 'GruposController/viewLista', 'refresh');
        }
        else {
            $this->session->set_flashdata('resultado_ok', 'Erro ao Excluir o Grupo!');
            redirect(base_url() . 'GruposController/viewLista','refresh'); 
        } 
	}
   


}