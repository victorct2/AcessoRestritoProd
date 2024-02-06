<?php 

Class CatalogacaoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	function selectCatalogacao($idIngest,$idPauta){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('pauta_id',$idPauta);
		return $this->db->get('tbl_catalogacao')->result();
	}

	function selectCatalogacaoByIdIngest($idIngest){
		$this->db->where('ingest_id',$idIngest);
		return $this->db->get('tbl_catalogacao')->result();
	}
	
	function selectIdCatalogacao($idIngest,$idPauta){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('pauta_id',$idPauta);
		$this->db->select('idCatalogacao');
		return $this->db->get('tbl_catalogacao')->result();
	}
	
	function selectIdCatalogacaoParceiro($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idCatalogacao');
		return $this->db->get('tbl_catalogacao')->result();
	}

	function selectIdCatalogacaoInterCasa($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idCatalogacao');
		return $this->db->get('tbl_catalogacao')->result();
	}

	function iniciarCatalogacaoBanco($data){
		return $this->db->insert('tbl_catalogacao',$data);
	}

	function updateCatalogacao($data,$idIngest){
		//start the transaction
	   	$this->db->trans_begin();
	   
			$this->db->where('idCatalogacao',$data['idCatalogacao']);
			$this->db->update('tbl_catalogacao',$data);
			
			$dados = array(
				'catalogacao_id' => $data['idCatalogacao'],		
			);
			
			$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_claqueteRevisao',$dados);
			
			$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_blocoRevisao',$dados);
			
			/*$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_materiaFluxo',$dados);

			$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_materiaRedacaoFluxo',$dados);*/
	   
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

	function updateCatalogacaoClosedCaption($data){
		//start the transaction
	   	$this->db->trans_begin();
	   
			$this->db->where('idCatalogacao',$data['idCatalogacao']);
			$this->db->update('tbl_catalogacao',$data);
				   
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

	function updateCorrecaoIngestClosedCaption($data,$idIngest,$idRevisaoCatalogacaoClosedCaptionProblema,$resposta){
		//start the transaction
		   $this->db->trans_begin();
	
			$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_revisaoCatalogacaoClosedCaption',$data);
		
			$data = array(
				'corrigido' => 'S',
				'resposta' => $resposta
			);
			$this->db->where('idRevisaoCatalogacaoClosedCaptionProblema',$idRevisaoCatalogacaoClosedCaptionProblema);
			$this->db->update('tbl_revisaoCatalogacaoClosedCaption_problema',$data);
	
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
	   
	function updateCorrecaoCatalogacao($data,$idIngest,$materias,$materiasRedacao,$claquetes,$blocos,$chamada,$idCatalogacao,$tipoIngest,
		$problemaClaquete,$blocoProblema,$materiaProblema,$materiaRedacaoProblema,$chamadaProblema,$respostaClaqueteProblema,$respostaBlocoProblema){
		//start the transaction
		$this->db->trans_begin();
		
		$this->db->where('idCatalogacao',$idCatalogacao);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_catalogacao',$data);
		
		if(count($claquetes) >0){
			foreach ($claquetes as $key => $c) {				
				$this->catalogacaoDao->updateCorrecaoClaquete($key);			
			}
		}
		
		if(count($problemaClaquete) >0){
			foreach ($problemaClaquete as $idProblema) {						
				$this->catalogacaoDao->updateCorrecaoProblema($idProblema,$respostaClaqueteProblema[$idProblema]);			
			}
		}
			
		
		if(count($blocos) >0){
			foreach ($blocos as $key => $b) {				
				$this->catalogacaoDao->updateCorrecaoBloco($key);		
			}
		}	
		
		if(count($blocoProblema) >0){
			foreach ($blocoProblema as $idProblema) {						
				$this->catalogacaoDao->updateCorrecaoProblema($idProblema,$respostaBlocoProblema[$idProblema]);			
			}
		}
		
		
		if($tipoIngest == 'C'){
			if(count($materias) >0){
				foreach ($materias as $key => $m) {				
					$this->catalogacaoDao->updateCorrecaoMateria($key);				
				}
			}
			
			if(count($materiaProblema) >0){
				foreach ($materiaProblema as $idProblema) {						
					$this->catalogacaoDao->updateCorrecaoProblema($idProblema);			
				}
			}
			
			if(count($materiasRedacao) >0){
				foreach ($materiasRedacao as $key => $mr) {				
					$this->catalogacaoDao->updateCorrecaoMateriaRedacao($key);				
				}
			}
			
			if(count($materiaRedacaoProblema) >0){
				foreach ($materiaRedacaoProblema as $idProblema) {						
					$this->catalogacaoDao->updateCorrecaoProblema($idProblema);			
				}
			}
		}
		
		if($tipoIngest == 'CHP' || $tipoIngest == 'CH'){
			if(count($chamada) >0){
				foreach ($chamada as $key => $ch) {				
					$this->catalogacaoDao->updateCorrecaoChamada($key);				
				}
			}
			
			if(count($chamadaProblema) >0){
				foreach ($chamadaProblema as $idProblema) {						
					$this->catalogacaoDao->updateCorrecaoProblema($idProblema);			
				}
			}		
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

		function updateCorrecaoClaquete($idClaqueteRevisao){
		$data = array('correcaoRevCatalog' => 'S');
		$this->db->where('idClaqueteRevisao',$idClaqueteRevisao);
		return $this->db->update('tbl_claqueteRevisao',$data);
	}
	
	function updateCorrecaoBloco($idBlocoRevisao){
		$data = array( 'correcaoRevCatalog' => 'S');
		$this->db->where('idBlocoRevisao',$idBlocoRevisao);
		return $this->db->update('tbl_blocoRevisao',$data);
	}
	
	function updateCorrecaoMateria($idMateria){
		$data = array('correcaoRevCatalog' => 'S');
		$this->db->where('idMateriaFluxo',$idMateria);
		return $this->db->update('tbl_materiaFluxo',$data);
	}

	function updateCorrecaoMateriaRedacao($idMateria){
		$data = array('correcaoRevCatalog' => 'S');
		$this->db->where('idMateriaRedacaoFluxo',$idMateria);
		return $this->db->update('tbl_materiaRedacaoFluxo',$data);
	}
	
	function updateCorrecaoChamada($idChamadaFluxo){
		$data = array( 'correcaoRevCatalog' => 'S');
		$this->db->where('idChamadaFluxo',$idChamadaFluxo);
		return $this->db->update('tbl_chamadaFluxo',$data);
	}
	
	function updateCorrecaoProblema($idProblema,$resposta){
		$data = array(
			'corrigido' => 'S',
			'resposta' => $resposta
		);
		$this->db->where('idProblema',$idProblema);
		return $this->db->update('tbl_problema',$data);
	}		
	
	
	function deleteCatalogacaoParceiro($idIngest,$idCatalogacao){
		//start the transaction
		$this->db->trans_begin();

		$revisaoCatalogacao = $this->revisaoCatalogacaoDao->selectIdRevisaoCatalogacaoParceiro($idIngest);
		if(count($revisaoCatalogacao)){
			$this->revisaoCatalogacaoDao->deleteRevisaoCatalogacaoParceiro($idIngest,$revisaoCatalogacao[0]->idRevisaoCatalogacao);			
		}
		

		$catalogacaoBlocoClaquete = array(
			'catalogacao_id' => null
		);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_blocoRevisao',$catalogacaoBlocoClaquete);

		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_claqueteRevisao',$catalogacaoBlocoClaquete);

		$this->db->where('ingest_id',$idIngest);
		$this->db->where('idCatalogacao',$idCatalogacao);
		$this->db->delete('tbl_catalogacao');

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