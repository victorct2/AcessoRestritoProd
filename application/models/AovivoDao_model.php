<?php

Class AovivoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    

	function make_query(){
		$order_column = array("id","streaming","link",null,"status",null);
		
		$this->db->select('id,streaming,link,iframe,status');
		$this->db->from('tbl_aovivo');

		/*echo '<pre>';
		print_r($_POST['columns']);	
		echo '</pre>';*/

		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("streaming", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("link", $_POST['columns'][2]["search"]["value"]);
		}
		
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("status", $_POST['columns'][4]["search"]["value"]);  	
		}

		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('id ASC');
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
		$this->db->from('tbl_aovivo');
		return $this->db->count_all_results();
    }

	function ativarStreaming($id){
		//start the transaction
		$this->db->trans_begin();
			$arrayAovivoAtivar = array(
				'status' => 'ATIVO'
			);
			$this->db->where('id',$id);
			$this->db->update('tbl_aovivo',$arrayAovivoAtivar);

			$arrayAovivoDesativar = array(
				'status' => 'INATIVO'
			);
			$this->db->where_not_in('id',$id);
			$this->db->update('tbl_aovivo',$arrayAovivoDesativar);

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
