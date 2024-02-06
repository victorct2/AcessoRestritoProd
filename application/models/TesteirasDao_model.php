<?php 

Class TesteirasDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarTesteiras($limit = null,$offset = null){
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$offset);
		return $this->db->get('testeiras')->result();
	}

	function make_query(){  
		$order_column = array(null,"nome","url", null, null);  
		$this->db->select('*');  
		$this->db->from('testeiras');
		if(isset($_POST["search"]["value"])){  
			$this->db->like("nome", $_POST["search"]["value"]);  
			$this->db->or_like("url", $_POST["search"]["value"]);
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
		$this->db->from('testeiras');  
		return $this->db->count_all_results();  
    }

	/*
	** VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
	*/
	function nome_disponivel($nome) {
		$this->db->where('nome',$nome);
		return $this->db->get('testeiras')->result();		
	}

	function selectTesteiraById($id){
        $this->db->where('id',$id);
		return $this->db->get('testeiras')->result();
	}

	/*
	** Adicionar testeiras
	*/
	function insertTesteira($data){	
		return $this->db->insert('testeiras',$data);	
	}

	function updateTesteira($data){
		$this->db->where('id',$data['id']);			
		return $this->db->update('testeiras',$data);
	}

	/*
	** Excluir testeiras
	*/
	function deleteTesteira($id){		
		$this->db->where('id',$id);	
		return $this->db->delete('testeiras');
	}

}

?>