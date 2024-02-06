<?php 

Class PodcastDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarPodcast($limit = null,$offset = null){
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$offset);
		return $this->db->get('tbl_podcast')->result();
	}

    function listarEpisodios($idPodcast){
		$this->db->where('podcast_id',$idPodcast);
		$this->db->order_by('id','desc');
		return $this->db->get('tbl_podcast_episodio')->result();
	}

	function listarVideos($nomeVideo){
		$this->db->like('nome',$nomeVideo);
		$this->db->or_like('titulo',$nomeVideo);
		$this->db->or_like('sigla',$nomeVideo);
		$this->db->select('tb_video.id, CONCAT(nome," # ", titulo) as text');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa');
		return $this->db->get()->result();
	}

	function selectNomeVideoById($idVideo){
		$this->db->where('tb_video.id',$idVideo);
		$this->db->select('CONCAT(nome," # ", titulo) as nomeVideo');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa');
		return $this->db->get()->result();
	}


	function make_query(){  
		$order_column = array(null,"nome","url", null, null);  
		$this->db->select('*');  
		$this->db->from('tbl_podcast');
		if(isset($_POST["search"]["value"])){  
			$this->db->like("titulo", $_POST["search"]["value"]);  
			$this->db->or_like("descricao", $_POST["search"]["value"]);
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
		$this->db->from('tbl_podcast');  
		return $this->db->count_all_results();  
    }

	/*
	** VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
	*/
	function titulo_disponivel($titulo) {
		$this->db->where('titulo',$titulo);
		return $this->db->get('tbl_podcast')->result();		
	}

	function selectPodcastById($id){
        $this->db->where('id',$id);
		return $this->db->get('tbl_podcast')->result();
	}

	function selectEpisodioById($id){
        $this->db->where('id',$id);
		return $this->db->get('tbl_podcast_episodio')->result();
	}

	function selectAllEpisodiosDoPodcast($id){
		$this->db->where('podcast_id',$id);
		$this->db->select("midia");
		return $this->db->get('tbl_podcast_episodio')->result();
	}

	/*
	** Adicionar Podcast
	*/
	function insertPodcast($data){	
		return $this->db->insert('tbl_podcast',$data);	
	}

	/*
	** Adicionar Episódio
	*/
	function insertEpisodio($data){	
		return $this->db->insert('tbl_podcast_episodio',$data);	
	}

	function updatePodcast($data){
		$this->db->where('id',$data['id']);			
		return $this->db->update('tbl_podcast',$data);
	}

	function updateEpisodio($data){
		$this->db->where('id',$data['id']);			
		return $this->db->update('tbl_podcast_episodio',$data);
	}

	/*
	** Excluir Podcast
	*/
	function deletePodcast($id){
		//start the transaction
		$this->db->trans_begin();

		$this->db->where('id',$id);	
		$this->db->delete('tbl_podcast');

		$this->db->where('podcast_id',$id);	
		$this->db->delete('tbl_podcast_episodio');

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

	function deleteEpisodio($id){		

		$this->db->where('id',$id);	
		return $this->db->delete('tbl_podcast_episodio');
		
	}

}

?>