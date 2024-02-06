<?php

Class ImprensaDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}
	
	
	function selectImprensa(){		
		return $this->db->get('tbl_imprensa')->result();
	}	
	
	function updateImprensa($data){
		$this->db->where('idImprensa',$data['idImprensa']);
		return $this->db->update('tbl_imprensa',$data);
	}


	/*============================*/

	function make_query(){

		$order_column = array(null,"nome","nomeArtistico","resumoProfissional", null);
		$this->db->select('*');
		$this->db->from('tb_apresentador');


		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("nome", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->or_like("nomeArtistico", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->or_like("resumoProfissional", $_POST['columns'][3]["search"]["value"]);  	
		}
		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('nomeArtistico', 'ASC');
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
		$this->db->from('tb_apresentador');
		return $this->db->count_all_results();
	}
	
	function selectApresentador($id){
		$this->db->where('id',$id);
		return $this->db->get('tb_apresentador')->result();
	}
	
	function insertApresentador($data){
		return $this->db->insert('tb_apresentador',$data);
	}

	function updateApresentador($data){
		$this->db->where('id',$data['id']);
		return $this->db->update('tb_apresentador',$data);
	}
	
}
?>