<?php 

Class NoticiasDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarNoticias($limit = null,$offset = null){
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$offset);
		return $this->db->get('novidades')->result();
	}

	function totalNoticias($ativos = false, $inativos= false){
		if($ativos == true){
			$this->db->where('ativa','S');
		}
		if($inativos == true){
			$this->db->where('ativa','N');
		}
		return $this->db->get('novidades')->num_rows();
	}

	function make_query(){  
		$order_column = array(null,"dia","descricao","sinopse", null, null);  
		$this->db->select('*');  
		$this->db->from('novidades');

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
			case 'NOTICIA':
				$this->db->where("releaseNoticia", 'N');
				break;
			case 'RELEASE':
				$this->db->where("releaseNoticia", 'R');
				break;
			case 'NOTICIARELEASE':
				$this->db->where("releaseNoticia", 'NR');
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
		$this->db->from('novidades');  
		$this->db->join('tb_imagem_noticia','tb_imagem_noticia.noticia_id = novidades.id','left');
		return $this->db->count_all_results();  
    }

	function selectNoticiasById($id){
		$this->db->where('id',$id);
		return $this->db->get('novidades')->result();
	}

	function selectImagemNoticiasById($id){
		$this->db->where('noticia_id',$id);
		return $this->db->get('tb_imagem_noticia')->result();
	}

	function selectImagemByIdImagem($idImagem){
		$this->db->where('idImagem',$idImagem);
		return $this->db->get('tb_imagem_noticia')->result();
	}

	function updateNoticia($data,$imagens,$imagensExcluir){	
		//start the transaction
		$this->db->trans_begin();

			$this->db->where('id',$data['id']);			
			$this->db->update('novidades',$data);

			if(count($imagens)>0){
				foreach ($imagens as $key => $imagem) {
					$novo_nome_imagem = $data['id'].'-'.$data['dia'].'-'.geraSenha(10). '.' . @end(explode(".",$imagem));
					$imagemData = array(
						'idImagem' => null,
						'nomeImagem' => $novo_nome_imagem,
						'noticia_id' => $data['id']					
					);
					$this->db->insert('tb_imagem_noticia',$imagemData);	
	
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
					$dadosImagem = $this->db->get('tb_imagem_noticia')->result();
					$this->db->where('idImagem',$img);	
					$this->db->delete('tb_imagem_noticia');		
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

	/*
	** Adicionar novidades
	*/
	function insertNoticia($data,$imagens){	
		//start the transaction
		$this->db->trans_begin();
			
			$this->db->insert('novidades',$data);	
			$idNoticia = $this->db->insert_id();

			if(count($imagens)>0){
				foreach ($imagens as $key => $imagem) {
					$novo_nome_imagem = $data['id'].'-'.$data['dia'].'-'.geraSenha(10). '.' . @end(explode(".",$imagem));
					$imagemData = array(
						'idImagem' => null,
						'nomeImagem' => $novo_nome_imagem,
						'noticia_id' => $idNoticia					
					);
					$this->db->insert('tb_imagem_noticia',$imagemData);	
	
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

	/*
	** Excluir novidades
	*/
	function deleteNoticias($id){	

		//start the transaction
		$this->db->trans_begin();

			$this->db->where('id',$id);	
			$this->db->delete('novidades');

			$this->db->where('noticia_id',$id);
			$dadosImagem = $this->db->get('tb_imagem_noticia')->result();
			if(count($dadosImagem)>0){
				$this->db->where('noticia_id',$id);	
				$this->db->delete('tb_imagem_noticia');

				foreach($dadosImagem as $imagem){
					unlink('assets/img/noticias/'.$imagem->nomeImagem);
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

	function noticiasNotFriendlyUrl(){
		$this->db->where('friendly_url',null);
		return $this->db->get('novidades')->result();
	}

	function updateFriendlyUrl($noticia){						
		$data = array(
			'friendly_url' => getRawUrl($noticia->sinopse.'-'.$noticia->dia)
		);
		$this->db->where('id',$noticia->id);
		return $this->db->update('novidades',$data);
	}

	function updateLegendaImagem($legendaImagem){
		//start the transaction
		$this->db->trans_begin();

		foreach ($legendaImagem as $key => $legenda) {
			$data = array(
				'legendaImagem' => $legenda
			);
			$this->db->where('idImagem',$key);
			$this->db->update('tb_imagem_noticia',$data);
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

		function selectAllNoticias($dadosBusca,$limite,$offset){        
        if($dadosBusca != ''){
            $this->db->like('descricao',$dadosBusca);
            $this->db->or_like('sinopse',$dadosBusca);
            $this->db->or_like('descricao_completa',$dadosBusca);
        }        
        //$this->db->where('ativa','S');
        $this->db->where('(ativa = "S" OR site_novo = "S")',NULL,FALSE);
        $this->db->where('(releaseNoticia = "N" OR releaseNoticia = "NR")',NULL,FALSE);
        $this->db->order_by('id','desc');
        $this->db->group_by('id');
        $this->db->limit($limite,$offset);
        $this->db->select('descricao,sinopse,subtitulo,descricao_completa,link,friendly_url,imagem,dia,codigoEmbed,releaseNoticia,ativa,id,GROUP_CONCAT(tb_imagem_noticia.nomeImagem) as imagens,legendaImagem');	
        $this->db->from('novidades');
		$this->db->join('tb_imagem_noticia','tb_imagem_noticia.noticia_id = novidades.id','LEFT');
        return $this->db->get()->result();
    }

     function countAllNoticias($dadosBusca){
        if($dadosBusca !=''){
            $this->db->like('descricao',$dadosBusca);
            $this->db->or_like('sinopse',$dadosBusca);
            $this->db->or_like('descricao_completa',$dadosBusca);
        }
        //$this->db->where('ativa','S');
        $this->db->where('(ativa = "S" OR site_novo = "S")',NULL,FALSE);
        $this->db->where('releaseNoticia = "N" OR releaseNoticia = "NR"',NULL,FALSE);
        return $this->db->count_all_results('novidades');
    }


     function listarLogos(){
		$this->db->order_by('id','asc');
		$this->db->where('status','S');
		return $this->db->get('tbl_logos')->result();
	}

	

}

?>