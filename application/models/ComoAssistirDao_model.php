<?php

Class ComoAssistirDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}
	
	
	function selectTextoOutroCanal(){		
		return $this->db->get('tbl_outrosCanaisTexto')->result();
	}	

	function selectTextoOiTv(){		
		return $this->db->get('tbl_comoAssistirOiTv')->result();
	}

	function selectTextoInternet(){		
		return $this->db->get('tbl_comoAssistirInternet')->result();
	}

	function selectTextoTvAberta(){		
		return $this->db->get('tbl_comoAssistirTvAberta')->result();
	}	
	
	function updateCanaisParceirosTexto($data){
		$this->db->where('idOutrosCanaisTexto',$data['idOutrosCanaisTexto']);
		return $this->db->update('tbl_outrosCanaisTexto',$data);
	}

	function updateOiTvTexto($data){
		$this->db->where('idOiTv',$data['idOiTv']);
		return $this->db->update('tbl_comoAssistirOiTv',$data);
	}

	function updateInternetTexto($data){
		$this->db->where('idInternet',$data['idInternet']);
		return $this->db->update('tbl_comoAssistirInternet',$data);
	}

	function updateTvAbertaTexto($data){
		$this->db->where('idTvAberta',$data['idTvAberta']);
		return $this->db->update('tbl_comoAssistirTvAberta',$data);
	}


	/*============================*/

	function make_query(){

		$order_column = array("idOutrosCanais","canal","link",null);
		$this->db->select('*');
		$this->db->from('tbl_outrosCanais');


		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->where("idOutrosCanais", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("canal", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->or_like("link", $_POST['columns'][3]["search"]["value"]);  	
		}
		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('canal', 'ASC');
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
		$this->db->from('tbl_outrosCanais');
		return $this->db->count_all_results();
	}
	
	
	function selectCanalById($idCanaisParceiros){
		$this->db->where('idOutrosCanais',$idCanaisParceiros);
		return $this->db->get('tbl_outrosCanais')->result();
	}

	function updateCanal($data){
		$this->db->where('idOutrosCanais',$data['idOutrosCanais']);
		return $this->db->update('tbl_outrosCanais',$data);
	}
	
	function insertCanal($data){
		return $this->db->insert('tbl_outrosCanais',$data);
	}

	function deleteCanal($id){
		$this->db->where('idOutrosCanais',$id);
		return $this->db->delete('tbl_outrosCanais');
	}

}
?>
