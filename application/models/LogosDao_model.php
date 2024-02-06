<?php 

Class LogosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarLogos(){
		$this->db->order_by('id','asc');
		return $this->db->get('tbl_logos')->result();
	}

	function selectLogoById($id){
        $this->db->where('id',$id);
		return $this->db->get('tbl_logos')->result();
	}

	function updateLogo($data){
		$this->db->where('id',$data['id']);			
		return $this->db->update('tbl_logos',$data);
	}


}

?>