<?php

Class parceriasInstitucionaisDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}
	
	function make_query(){

		$order_column = array(null,"title","descricao","link",null,null);
		$this->db->select('*');
		$this->db->from('tbl_parceirosInstitucionais');


		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("title", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("descricao", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->or_like("link", $_POST['columns'][3]["search"]["value"]);  	
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("status", $_POST['columns'][4]["search"]["value"]);  	
		}
		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('idParceirosInstitucionais', 'ASC');
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
		$this->db->from('tbl_parceirosInstitucionais');
		return $this->db->count_all_results();
	}
	

	/*========================================================*/

	function selectParceirosInstitucionais($idParceirosInstitucionais){
		$this->db->where('idParceirosInstitucionais',$idParceirosInstitucionais);
		return $this->db->get('tbl_parceirosInstitucionais')->result();		
	}

	function selectTexto(){
		return $this->db->get('tbl_parceirosInstitucionaisTexto')->result();
	}

	function verificarParceiroInsitucional($title){
		$this->db->where('title',$title);
		return $this->db->get('tbl_parceirosInstitucionais')->result();
	}

	function insertParceiroInstitucional($data){
		return $this->db->insert('tbl_parceirosInstitucionais',$data);
	}

	function updateParceiroInstitucional($data){
		$this->db->where('idParceirosInstitucionais',$data['idParceirosInstitucionais']);
		return $this->db->update('tbl_parceirosInstitucionais',$data);
	}

	function updateTexto($data){
		$this->db->where('idParceirosInstitucionaisTexto',$data['idParceirosInstitucionaisTexto']);
		return $this->db->update('tbl_parceirosInstitucionaisTexto',$data);
	}

	function deleteParceiroInstitucional($idParceirosInstitucionais){
		$this->db->where('idParceirosInstitucionais',$idParceirosInstitucionais);
		return $this->db->delete('tbl_parceirosInstitucionais');
	}
	

}
?>
