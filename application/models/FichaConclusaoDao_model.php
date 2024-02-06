<?php 

Class FichaConclusaoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	function insertFichaConclusao($data,$bloco){
		//start the transaction
        $this->db->trans_begin();
		
			$this->db->insert('tbl_fichaConclusao',$data);
			foreach ($bloco as $key => $b) {				
				$this->fichaConclusaoDao->updateBloco($key,$b[0]);		
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

	function selectFichaConclusao($idIngest){
		$this->db->where('ingest_id',$idIngest);
		return $this->db->get('tbl_fichaConclusao')->result();
	}

	function selectIdFichaConclusao($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idFichaConclusao');
		return $this->db->get('tbl_fichaConclusao')->result();
	}

	function updateMateria($idMateria,$duracao){
		$data = array('duracao' => $duracao );
		$this->db->where('idMateriaFluxo',$idMateria);
		return $this->db->update('tbl_materiaFluxo',$data);		
	}

	function updateMateriaRedacao($idMateria,$duracao){
		$data = array('duracao' => $duracao );
		$this->db->where('idMateriaRedacaoFluxo',$idMateria);
		return $this->db->update('tbl_materiaRedacaoFluxo',$data);		
	}

	function updateBloco($idBlocoRevisao,$duracao){
		$data = array('duracao' => $duracao );
		$this->db->where('idBlocoRevisao',$idBlocoRevisao);
		return $this->db->update('tbl_blocoRevisao',$data);
	}

	function updateFichaConclusaoParceiros($data,$bloco){
		//start the transaction
        $this->db->trans_begin();
			
			$this->db->where('idFichaConclusao', $data['idFichaConclusao']);
			$this->db->update('tbl_fichaConclusao',$data);	
			
			foreach ($bloco as $key => $b) {				
				$this->fichaConclusaoDao->updateBloco($key,$b[0]);		
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


	function deleteFichaConclusaoParceiro($idIngest,$idFichaConclusao){
		$this->db->where('idFichaConclusao',$idFichaConclusao);
		$this->db->where('ingest_id',$idIngest);
		return $this->db->delete('tbl_fichaConclusao');
	}
}

?>