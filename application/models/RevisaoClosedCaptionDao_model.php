<?php 

Class RevisaoClosedCaptionDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	function selectRevisaoById($idRevisaoClosedCaption){
		$this->db->where('idRevisaoClosedCaption',$idRevisaoClosedCaption);
		return $this->db->get('tbl_revisaoClosedCaption')->result();
	}

	function selectIdRevisaoClosedCaption($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idRevisaoClosedCaption');
		return $this->db->get('tbl_revisaoClosedCaption')->result();
	}

	function selectProblemasClosedCaption($idRevisaoClosedCaption){
		$this->db->where('revisaoClosedCaption_id',$idRevisaoClosedCaption);
		$this->db->from('tbl_revisaoClosedCaption_problema');
		return $this->db->get()->result();

	}

	function selectProblemasClosedCaptionCorrigir($idRevisaoClosedCaption){
		$this->db->where('corrigido','N');
		$this->db->where('revisaoClosedCaption_id',$idRevisaoClosedCaption);
		$this->db->from('tbl_revisaoClosedCaption_problema');
		return $this->db->get()->result();

	}

	function selectProblemasClosedCaptionCorrigidos($idRevisaoClosedCaption){
		$this->db->where('corrigido','S');
		$this->db->where('revisaoClosedCaption_id',$idRevisaoClosedCaption);
		$this->db->from('tbl_revisaoClosedCaption_problema');
		return $this->db->get()->result();
	}

	function insertRevisao($revisao,$idIngest,$obs_closedCaption){
		//start the transaction
	   $this->db->trans_begin();
			
			$this->db->insert('tbl_revisaoClosedCaption',$revisao);
			$idRevisaoClosedCaption = $this->db->insert_id();

			$this->revisaoClosedCaptionDao->insertClosedCaptionRevisao($idRevisaoClosedCaption,$idIngest,$obs_closedCaption);
			

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

   	function insertClosedCaptionRevisao($idRevisaoClosedCaption,$idIngest,$obs_closedCaption){
		$arrayClosedCaption = array(
				'idRevisaoClosedCaptionProblema' => null,
				'revisaoClosedCaption_id' => $idRevisaoClosedCaption,
				'ingest_id' => $idIngest,
				'problema' => $obs_closedCaption,
				'corrigido' => 'N'
			);
		return $this->db->insert('tbl_revisaoClosedCaption_problema',$arrayClosedCaption);

	}


	function atualizaRevisaoCorrigido($idIngest){
		$data = array(
			'statusRevisaoClosedCaption' => 'C',
		);
		$this->db->where('ingest_id',$idIngest);
		return $this->db->update('tbl_revisaoClosedCaption',$data);
	}


	
	function updateClosedCaptionRevisao($idRevisaoClosedCaptionProblema){
		$arrayClosedCaption = array(
				'corrigido' => 'S'
			);
		$this->db->where('idRevisaoClosedCaptionProblema',$idRevisaoClosedCaptionProblema);
		return $this->db->update('tbl_revisaoClosedCaption_problema',$arrayClosedCaption);

	}
	
	

	function updateRevisaoCorrecao($revisaoClosedCaption,$idRevisaoClosedCaption,$idIngest,$idRevisaoClosedCaptionProblema,$obs_closedCaption){
		//start the transaction
        $this->db->trans_begin();

		$this->db->where('idRevisaoClosedCaption',$revisaoClosedCaption['idRevisaoClosedCaption']);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_revisaoClosedCaption',$revisaoClosedCaption);
		
		$this->revisaoClosedCaptionDao->updateClosedCaptionRevisao($idRevisaoClosedCaptionProblema);

		if($revisaoClosedCaption['statusRevisaoClosedCaption'] != 'A'){
			$this->revisaoClosedCaptionDao->insertClosedCaptionRevisao($idRevisaoClosedCaption,$idIngest,$obs_closedCaption);
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


	/*============================= Catalogação =============================*/


	function selectRevisaoCatalogacaoById($idRevisaoCatalogacaoClosedCaption){
		$this->db->where('idRevisaoCatalogacaoClosedCaption',$idRevisaoCatalogacaoClosedCaption);
		return $this->db->get('tbl_revisaoCatalogacaoClosedCaption')->result();
	}

	function selectIdRevisaoCatalogacaoClosedCaption($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idRevisaoCatalogacaoClosedCaption');
		return $this->db->get('tbl_revisaoCatalogacaoClosedCaption')->result();
	}

	function selectProblemasCatalogacaoClosedCaption($idRevisaoCatalogacaoClosedCaption){
		$this->db->where('revisaoCatalogacaoClosedCaption_id',$idRevisaoCatalogacaoClosedCaption);
		$this->db->from('tbl_revisaoCatalogacaoClosedCaption_problema');
		return $this->db->get()->result();

	}

	function selectProblemasCatalogacaoClosedCaptionCorrigir($idRevisaoCatalogacaoClosedCaption){
		$this->db->where('corrigido','N');
		$this->db->where('revisaoCatalogacaoClosedCaption_id',$idRevisaoCatalogacaoClosedCaption);
		$this->db->from('tbl_revisaoCatalogacaoClosedCaption_problema');
		return $this->db->get()->result();

	}

	function selectProblemasCatalogacaoClosedCaptionCorrigidos($idRevisaoCatalogacaoClosedCaption){
		$this->db->where('corrigido','S');
		$this->db->where('revisaoCatalogacaoClosedCaption_id',$idRevisaoCatalogacaoClosedCaption);
		$this->db->from('tbl_revisaoCatalogacaoClosedCaption_problema');
		return $this->db->get()->result();
	}

	function insertRevisaoCatalogacao($revisao,$idIngest,$obs_closedCaption){
		//start the transaction
	   $this->db->trans_begin();
			
			$this->db->insert('tbl_revisaoCatalogacaoClosedCaption',$revisao);
			$idRevisaoCatalogacaoClosedCaption = $this->db->insert_id();

			$this->revisaoClosedCaptionDao->insertClosedCaptionRevisaoCatalogacao($idRevisaoCatalogacaoClosedCaption,$idIngest,$obs_closedCaption);
			

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

   	function insertClosedCaptionRevisaoCatalogacao($idRevisaoClosedCaption,$idIngest,$obs_closedCaption){
		$arrayClosedCaption = array(
				'idRevisaoCatalogacaoClosedCaptionProblema' => null,
				'revisaoCatalogacaoClosedCaption_id' => $idRevisaoClosedCaption,
				'ingest_id' => $idIngest,
				'problema' => $obs_closedCaption,
				'corrigido' => 'N'
			);
		return $this->db->insert('tbl_revisaoCatalogacaoClosedCaption_problema',$arrayClosedCaption);

	}


	function atualizaRevisaoCatalogacaoCorrigido($idIngest){
		$data = array(
			'statusRevisaoCatalogacaoClosedCaption' => 'C',
		);
		$this->db->where('ingest_id',$idIngest);
		return $this->db->update('tbl_revisaoCatalogacaoClosedCaption',$data);
	}


	
	function updateClosedCaptionRevisaoCatalogacao($idRevisaoCatalogacaoClosedCaptionProblema){
		$arrayClosedCaption = array(
				'corrigido' => 'S'
			);
		$this->db->where('idRevisaoCatalogacaoClosedCaptionProblema',$idRevisaoCatalogacaoClosedCaptionProblema);
		return $this->db->update('tbl_revisaoCatalogacaoClosedCaption_problema',$arrayClosedCaption);

	}
	
	

	function updateRevisaoCatalogacaoCorrecao($revisaoClosedCaption,$idRevisaoClosedCaption,$idIngest,$idRevisaoClosedCaptionProblema,$obs_closedCaption){
		//start the transaction
        $this->db->trans_begin();

		$this->db->where('idRevisaoCatalogacaoClosedCaption',$revisaoClosedCaption['idRevisaoCatalogacaoClosedCaption']);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_revisaoCatalogacaoClosedCaption',$revisaoClosedCaption);
		
		$this->revisaoClosedCaptionDao->updateClosedCaptionRevisaoCatalogacao($idRevisaoClosedCaptionProblema);

		if($revisaoClosedCaption['statusRevisaoCatalogacaoClosedCaption'] != 'A'){
			$this->revisaoClosedCaptionDao->insertClosedCaptionRevisaoCatalogacao($idRevisaoClosedCaption,$idIngest,$obs_closedCaption);
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




	
	




}

?>