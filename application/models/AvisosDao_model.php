<?php

Class AvisosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}
	
		
	function insertAvisos($data,$imagens){	
		//start the transaction
		$this->db->trans_begin();
			
			$this->db->insert('avisos',$data);	
			$idNoticia = $this->db->insert_id();
			
		
			if(count($imagens)>0){
				foreach ($imagens as $key => $imagem) {
					$novo_nome_imagem = $data['id'].'-'.$data['dia'].'-'.geraSenha(10). '.' . @end(explode(".",$imagem));
					$imagemData = array(
						'idImagem' => null,
						'nomeImagem' => $novo_nome_imagem,
						'noticia_id' => $idNoticia					
					);

					$this->db->insert('tb_imagem_avisos',$imagemData);	
	
					//atualziando o nome da imagem e copiando para a pasta específica
					chmod('uploadImagens/arquivos/'.$imagem, 0777);
					rename( 'uploadImagens/arquivos/'.$imagem,  'uploadImagens/arquivos/'.$novo_nome_imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/noticias/'.$novo_nome_imagem);
					chmod('assets/img/noticias/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}
			}
			
		
		//make transaction complete
		$this->db->trans_complete();
		//check if transaction status TRUE or FALSE
		if ($this->db->trans_status() === FALSE) {
			//if something went wrong, rollback everything
			$this->db->trans_rollback();
		return FALSE;
		} else {
			//if everything went right, commit the data to the database
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function make_query(){  
		$order_column = array(null,"dia","descricao","sinopse");  
		$this->db->select('*');  
		$this->db->from('avisos');

		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->where("dia", $_POST['columns'][1]["search"]["value"]);
		}

		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("descricao", $_POST['columns'][2]["search"]["value"]);
		}

		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->or_like("sinopse", $_POST['columns'][3]["search"]["value"]);
		}

		switch ($_POST['columns'][4]["search"]["value"]) {
			case 'ATIVO':
				$this->db->where("ativa", 'S');
				break;
			case 'INATIVO':
				$this->db->where("ativa", 'N');
				break;
				default:				
				break;
			
		} 
		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('id', 'DESC');  
		}  
	}

	function make_datatables(){  
		$this->make_query();  
		if($_POST["length"] != -1){  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}  
		$query = $this->db->get();  
		return $query->result();  
    } 

    function get_filtered_data(){  
		$this->make_query();  
		$query = $this->db->get();  
		return $query->num_rows();  
    }

	function get_all_data(){  
		$this->db->select("*");  
		$this->db->from('avisos');		
		return $this->db->count_all_results();  
    }

   
	 function selectAvisoByFriendly_url($friendly_url){
        $this->db->where('friendly_url',$friendly_url);
        $this->db->select('descricao,descricao_completa,link,friendly_url,dia,releaseAviso,ativa,id,alinfile,sinopse');	
        $this->db->from('avisos');        
        return $this->db->get()->result();
    }

     function countAllAvisos($dadosBusca){
        if($dadosBusca !=''){
            $this->db->like('descricao',$dadosBusca);
            $this->db->or_like('sinopse',$dadosBusca);
            $this->db->or_like('descricao_completa',$dadosBusca);
        }
        $this->db->where('ativa','S');
        //$this->db->where('(ativa = "S" OR site_novo = "S")',NULL,FALSE);
        //$this->db->where('releaseNoticia = "N" OR releaseNoticia = "NR"',NULL,FALSE);
        return $this->db->count_all_results('avisos');
    }

    function selectAllAvisos($dadosBusca,$limite,$offset){        
       if($dadosBusca != ''){
            $this->db->like('descricao',$dadosBusca);
            $this->db->or_like('sinopse',$dadosBusca);
            $this->db->or_like('descricao_completa',$dadosBusca);
        }
        $this->db->where('ativa','S');
       
        $this->db->order_by('dia','desc');
        $this->db->group_by('id');
        $this->db->limit($limite,$offset);
        $this->db->select('descricao,descricao_completa,link,friendly_url,dia,releaseAviso,ativa,id,alinfile,sinopse,imagem, GROUP_CONCAT(tb_imagem_avisos.nomeImagem) as imagens,legendaImagem');	
        $this->db->from('avisos');		
        $this->db->join('tb_imagem_avisos','tb_imagem_avisos.noticia_id = avisos.id','LEFT');
        return $this->db->get()->result();
    }

    function totalAvisos($ativos = false, $inativos= false){
		if($ativos == true){
			$this->db->where('ativa','S');
		}
		if($inativos == true){
			$this->db->where('ativa','N');
		}
		return $this->db->get('avisos')->num_rows();
	}

function selectAvisosById($id){
		$this->db->where('id',$id);
		return $this->db->get('avisos')->result();
	}

	function selectImagemAvisosById($id){
		$this->db->where('noticia_id',$id);
		return $this->db->get('tb_imagem_avisos')->result();
	}

	function updateAvisos($data,$imagens,$imagensExcluir){	
		//start the transaction
		$this->db->trans_begin();

			$this->db->where('id',$data['id']);			
			$this->db->update('avisos',$data);

			if(count($imagens)>0){
				foreach ($imagens as $key => $imagem) {
					$novo_nome_imagem = $data['id'].'-'.$data['dia'].'-'.geraSenha(10). '.' . @end(explode(".",$imagem));
					
					$imagemData = array(
						'idImagem' => null,
						'nomeImagem' => $novo_nome_imagem,
						'noticia_id' => $data['id']					
					);


					$this->db->insert('tb_imagem_avisos',$imagemData);	
	
					//atualziando o nome da imagem e copiando para a pasta específica
					chmod('uploadImagens/arquivos/'.$imagem, 0777);
					rename( 'uploadImagens/arquivos/'.$imagem,  'uploadImagens/arquivos/'.$novo_nome_imagem);
					copy('uploadImagens/arquivos/'.$novo_nome_imagem, 'assets/img/noticias/'.$novo_nome_imagem);
					chmod('assets/img/noticias/'.$novo_nome_imagem, 0777);
					unlink('uploadImagens/arquivos/'.$novo_nome_imagem);
				}
			}
			if(count($imagensExcluir)>0){
				foreach ($imagensExcluir as $img) {
					$this->db->where('idImagem',$img);
					$dadosImagem = $this->db->get('tb_imagem_avisos')->result();
					$this->db->where('idImagem',$img);	
					$this->db->delete('tb_imagem_avisos');		
					unlink('assets/img/noticias/'.$dadosImagem[0]->nomeImagem);
				}
			}
        //make transaction complete
		$this->db->trans_complete();
		//check if transaction status TRUE or FALSE
		if ($this->db->trans_status() === FALSE) {
			//if something went wrong, rollback everything
			$this->db->trans_rollback();
		return FALSE;
		} else {
			//if everything went right, commit the data to the database
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function deleteAvisos($id){	

		//start the transaction
		$this->db->trans_begin();

			$this->db->where('id',$id);	
			$this->db->delete('avisos');

			$this->db->where('id',$id);
			

		//make transaction complete
		$this->db->trans_complete();
		//check if transaction status TRUE or FALSE
		if ($this->db->trans_status() === FALSE) {
			//if something went wrong, rollback everything
			$this->db->trans_rollback();
		return FALSE;
		} else {
			//if everything went right, commit the data to the database
			$this->db->trans_commit();
			return TRUE;
		}
	}


}
?>