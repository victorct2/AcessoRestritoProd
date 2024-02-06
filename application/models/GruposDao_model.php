<?php 

Class GruposDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarGrupos(){
		$this->db->order_by('nome','asc');		
		return $this->db->get('grupos')->result();
	}

	function make_query(){  
		$order_column = array("id","nome","descricao", null, null);  
		$this->db->select('*');  
		$this->db->from('grupos');
		if(isset($_POST["search"]["value"])){  
			$this->db->like("id", $_POST["search"]["value"]);  
			$this->db->or_like("nome", $_POST["search"]["value"]);
			$this->db->or_like("descricao", $_POST["search"]["value"]); 
			$this->db->or_like("status", $_POST["search"]["value"]); 
		}  
		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('id', 'ASC');  
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
		$this->db->from('grupos');  
		return $this->db->count_all_results();  
    }

	function selectGruposById($id){
		$this->db->where('id', $id);		
		return $this->db->get('grupos')->result();
	}

	/*
	** Adicionar Grupos
	*/
	function insertGrupo($data){	
		return $this->db->insert('grupos',$data);	
	}

	/*
	** Gravar Alteração de GRUPO
	*/
	function updateGrupo($data){	
		$this->db->where('id',$data['id']);			
		return $this->db->update('grupos',$data);
	}

	/*
	** Excluir Grupos
	*/
	function deleteGrupo($id){		
		$this->db->where('id',$id);	
		return $this->db->delete('grupos');
	}


}

?>