<?php 

Class RevisaoCatalogacaoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	function selectIdRevisaoCatalogacaoParceiro($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idRevisaoCatalogacao');
		return $this->db->get('tbl_revisaoCatalogacao')->result();
	}

	function selectClaquetesCatalogadasSemRevisar($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevCatalogacao',null);
		$this->db->where('correcaoRevCatalog',null);		
		return $this->db->get('tbl_claqueteRevisao')->result();
	}

	function selectBlocosCatalogadasSemRevisar($idIngest){
		$this->db->where('ingest_id',$idIngest);	
		$this->db->where('statusRevCatalogacao',null);
		$this->db->where('correcaoRevCatalog',null);		
		return $this->db->get('tbl_blocoRevisao')->result();
	}

	function selectClaquetesReprovadasRevisao($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevCatalogacao','REPROVADO');
		$this->db->where('correcaoRevCatalog','N');		
		return $this->db->get('tbl_claqueteRevisao')->result();
	}

	function selectBlocosReprovadasRevisao($idIngest){
		$this->db->where('ingest_id',$idIngest);	
		$this->db->where('statusRevCatalogacao','REPROVADO');
		$this->db->where('correcaoRevCatalog','N');		
		return $this->db->get('tbl_blocoRevisao')->result();
	}

	function selectClaquetesCorrigidas($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevCatalogacao','REPROVADO');
		$this->db->where('correcaoRevCatalog','S');		
		return $this->db->get('tbl_claqueteRevisao')->result();
	}

	function selectBlocosCorrigidas($idIngest){
		$this->db->where('ingest_id',$idIngest);	
		$this->db->where('statusRevCatalogacao','REPROVADO');
		$this->db->where('correcaoRevCatalog','S');		
		return $this->db->get('tbl_blocoRevisao')->result();
	}

	function selectClaquetes($idIngest){
		$this->db->where('ingest_id',$idIngest);	
		return $this->db->get('tbl_claqueteRevisao')->result();
	}
	function selectBlocos($idIngest){
		$this->db->where('ingest_id',$idIngest);	
		return $this->db->get('tbl_blocoRevisao')->result();
	}

	function selectProblemas($idIngest,$id,$tipoRevisao,$sessao){
		
		switch ($sessao) {
			case 'C':
				$this->db->where('claqueteRevisao_id',$id);
				break;
			case 'B':
				$this->db->where('blocoRevisao_id',$id);
				break;
			case 'M':
				$this->db->where('materiaFluxo_id',$id);
				break;
			case 'CH':
				$this->db->where('chamadaFluxo_id',$id);
				break;
			default:				
				break;
		}		
		$this->db->where('id_ingest',$idIngest);
		$this->db->where('tipoRevisao',$tipoRevisao);
		$this->db->where('sessao',$sessao);	
		$this->db->from('tbl_revisao_problema');
		$this->db->join('tbl_problema','tbl_problema.idProblema = tbl_revisao_problema.problema_id');	
		return $this->db->get()->result();	
		
	}
	
	function selectProblemaCorrigir($idIngest,$id,$tipoRevisao,$sessao){

		switch ($sessao) {
			case 'C':
				$this->db->where('claqueteRevisao_id',$id);
				break;
			case 'B':
				$this->db->where('blocoRevisao_id',$id);
				break;
			case 'M':
				$this->db->where('materiaFluxo_id',$id);
				break;
			case 'MR':
				$this->db->where('materiaRedacaoFluxo_id',$id);
				break;
			case 'CH':
				$this->db->where('chamadaFluxo_id',$id);
				break;
			default:
				break;
		}
		$this->db->where('corrigido','N');
		$this->db->where('id_ingest',$idIngest);
		$this->db->where('tipoRevisao',$tipoRevisao);
		$this->db->where('sessao',$sessao);
		$this->db->from('tbl_revisao_problema');
		$this->db->join('tbl_problema','tbl_problema.idProblema = tbl_revisao_problema.problema_id');
		return $this->db->get()->result();

	}

	function selectProblemasCorrigidos($idIngest,$id,$tipoRevisao,$sessao){

		switch ($sessao) {
			case 'C':
				$this->db->where('claqueteRevisao_id',$id);
				break;
			case 'B':
				$this->db->where('blocoRevisao_id',$id);
				break;
			case 'M':
				$this->db->where('materiaFluxo_id',$id);
				break;
			case 'CH':
				$this->db->where('chamadaFluxo_id',$id);
				break;
			default:
				break;
		}
		$this->db->where('corrigido','S');
		$this->db->where('id_ingest',$idIngest);
		$this->db->where('tipoRevisao',$tipoRevisao);
		$this->db->where('sessao',$sessao);
		$this->db->from('tbl_revisao_problema');
		$this->db->join('tbl_problema','tbl_problema.idProblema = tbl_revisao_problema.problema_id');
		return $this->db->get()->result();

	}

	function insertRevisao($data,$idIngest,$idCatalogacao,$claquetes,$obs_claquete,$blocos,$obs_bloco,$chamadas,$obs_chamada,$materias,$obs_materia,$materiasRedacao,$obs_materiaRedacao,$tipoIngest){
		//start the transaction
	   	$this->db->trans_begin();
	   
			$this->db->insert('tbl_revisaoCatalogacao',$data);
			$idRevisaoCatalogacao = $this->db->insert_id();
			
			if(count($claquetes)>0 ){
				foreach ($claquetes as $key => $claquete) {
					$this->revisaoCatalogacaoDao->insertClaqueteRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$key,$claquete[0],$obs_claquete[$key][0]);		
				}	
			}
			
			foreach ($blocos as $key => $bloco) {
				$this->revisaoCatalogacaoDao->insertBlocoRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$key,$bloco[0],$obs_bloco[$key][0]);
			}
			
			if($tipoIngest == 'C'){
				foreach ($materias as $key => $materia) {
					$idMateria = $key;				
					$this->revisaoCatalogacaoDao->insertMateriaRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idMateria,$materia[0],$obs_materia[$key][0]);
				}
				foreach ($materiasRedacao as $key => $materiaRedacao) {
					$idMateriaRedacao = $key;				
					$this->revisaoCatalogacaoDao->insertMateriaRedacaoRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idMateriaRedacao,$materiaRedacao[0],$obs_materiaRedacao[$key][0]);
				}
			}
			
			if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
				foreach ($chamadas as $key => $chamada) {
					$idChamadaFluxo = $key;				
					$this->revisaoCatalogacaoDao->insertChamadaRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idChamadaFluxo,$chamada[0],$obs_chamada[$key][0]);
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
   
	function insertClaqueteRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idClaqueteRevisao,$claquete,$observacao){
		$arrayClaquete = array(		
				'revisaoCatalogacao_id' => 	$idRevisaoCatalogacao,		
				'statusRevCatalogacao' => $claquete,
				'correcaoRevCatalog' => ($claquete == 'APROVADO')? 'S':'N',
				'observacaoRevCatalogacao' => $observacao
			);
		$this->db->where('idClaqueteRevisao', $idClaqueteRevisao);
		$this->db->where('ingest_id', $idIngest);
		$result =  $this->db->update('tbl_claqueteRevisao',$arrayClaquete);
		
		if($result == false){
			return false;
		}
		
		if($claquete == 'REPROVADO'){
				
			$arrayProblema = array(
					'idProblema' => null,				
					'descricao' => $observacao,
					'corrigido' => 'N'
			);
			$result = $this->db->insert('tbl_problema',$arrayProblema);	
			
			if($result == false){
				return false;
			}
			$problema_id = $this->db->insert_id();
			$arrayProblemaRevisao = array(
					'idRevisaoProblema' => null,				
					'id_ingest' => $idIngest,
					'id_catalogacao' => $idCatalogacao,
					'problema_id' => $problema_id,
					'claqueteRevisao_id' => $idClaqueteRevisao,
					'tipoRevisao' => 'C',
					'sessao' => 'C'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);	
		}
		
		return $result;			
	}
   
   function insertBlocoRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idBlocoRevisao,$bloco,$observacao){
		$arrayBloco = array(
				'revisaoCatalogacao_id' => 	$idRevisaoCatalogacao,
				'statusRevCatalogacao' => $bloco,
				'correcaoRevCatalog' => ($bloco == 'APROVADO')? 'S':'N',
				'observacaoRevCatalogacao' => $observacao
				);
		$this->db->where('idBlocoRevisao', $idBlocoRevisao);
		$this->db->where('ingest_id', $idIngest);
		$result =  $this->db->update('tbl_blocoRevisao',$arrayBloco);
		
		if($result == false){
			return false;
		}		
		
		if($bloco == 'REPROVADO'){
			$arrayProblema = array(
					'idProblema' => null,				
					'descricao' => $observacao,
					'corrigido' => 'N'
			);
			$result = $this->db->insert('tbl_problema',$arrayProblema);	
			
			if($result == false){
				return false;
			}
			$problema_id = $this->db->insert_id();
			$arrayProblemaRevisao = array(
					'idRevisaoProblema' => null,				
					'id_ingest' => $idIngest,
					'id_catalogacao' => $idCatalogacao,
					'problema_id' => $problema_id,
					'blocoRevisao_id' => $idBlocoRevisao,
					'tipoRevisao' => 'C',
					'sessao' => 'B'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);
		}
		
		
		
		return $result;
			
	}
	
	function insertMateriaRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idMateria,$materia,$observacao){
		$arrayMateria = array(	
					'revisaoCatalogacao_id' => 	$idRevisaoCatalogacao,			
					'statusRevCatalog' => $materia,
					'correcaoRevCatalog' => ($materia == 'APROVADO')? 'S':'N',
					'observacaoRevCatalog' => $observacao
					);
		$this->db->where('idMateriaFluxo', $idMateria);
		$this->db->where('ingest_id',$idIngest);
		$result =  $this->db->update('tbl_materiaFluxo',$arrayMateria);
		
		if($result == false){
			return false;
		}	
		
		if($materia == 'REPROVADO'){
			$arrayProblema = array(
				'idProblema' => null,				
				'descricao' => $observacao,
				'corrigido' => 'N'
			);
			$result = $this->db->insert('tbl_problema',$arrayProblema);	
			
			if($result == false){
				return false;
			}
			$problema_id = $this->db->insert_id();
			$arrayProblemaRevisao = array(
					'idRevisaoProblema' => null,				
					'id_ingest' => $idIngest,
					'id_catalogacao' => $idCatalogacao,
					'problema_id' => $problema_id,
					'materiaFluxo_id' => $idMateria,
					'tipoRevisao' => 'C',
					'sessao' => 'M'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);
		}	
		
		return $result;
		   
   	}

	function insertMateriaRedacaoRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idMateria,$materia,$observacao){
		$arrayMateria = array(	
					'revisaoCatalogacao_id' => 	$idRevisaoCatalogacao,			
					'statusRevCatalog' => $materia,
					'correcaoRevCatalog' => ($materia == 'APROVADO')? 'S':'N',
					'observacaoRevCatalog' => $observacao
					);
		$this->db->where('idMateriaRedacaoFluxo', $idMateria);
		$this->db->where('ingest_id',$idIngest);
		$result =  $this->db->update('tbl_materiaRedacaoFluxo',$arrayMateria);
		
		if($result == false){
			return false;
		}	
		
		if($materia == 'REPROVADO'){
			$arrayProblema = array(
				'idProblema' => null,				
				'descricao' => $observacao,
				'corrigido' => 'N'
			);
			$result = $this->db->insert('tbl_problema',$arrayProblema);	
			
			if($result == false){
				return false;
			}
			$problema_id = $this->db->insert_id();
			$arrayProblemaRevisao = array(
					'idRevisaoProblema' => null,				
					'id_ingest' => $idIngest,
					'id_catalogacao' => $idCatalogacao,
					'problema_id' => $problema_id,
					'materiaRedacaoFluxo_id' => $idMateria,
					'tipoRevisao' => 'C',
					'sessao' => 'MR'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);
		}		
		
		return $result;			
	}


	
	function insertChamadaRevisao($idRevisaoCatalogacao,$idCatalogacao,$idIngest,$idChamadaFluxo,$chamada,$observacao){
		$arrayChamada = array(
				'revisaoCatalogacao_id' => 	$idRevisaoCatalogacao,
				'statusRevCatalogacao' => $chamada,
				'correcaoRevCatalog' => ($chamada == 'APROVADO')? 'S':'N',
				'observacaoRevCatalogacao' => $observacao
				);
		$this->db->where('idChamadaFluxo', $idChamadaFluxo);
		$this->db->where('ingest_id', $idIngest);
		$result = $this->db->update('tbl_chamadaFluxo',$arrayChamada);
		
		if($result == false){
			return false;
		}		
		
		if($chamada == 'REPROVADO'){
			$arrayProblema = array(
				'idProblema' => null,				
				'descricao' => $observacao,
				'corrigido' => 'N'
			);
			$result = $this->db->insert('tbl_problema',$arrayProblema);	
			
			if($result == false){
				return false;
			}
			$problema_id = $this->db->insert_id();
			$arrayProblemaRevisao = array(
					'idRevisaoProblema' => null,				
					'id_ingest' => $idIngest,
					'id_catalogacao' => $idCatalogacao,
					'problema_id' => $problema_id,
					'chamadaFluxo_id' => $idChamadaFluxo,
					'tipoRevisao' => 'C',
					'sessao' => 'CH'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);
			
		}	
				
		return $result;		
		
	}


	
	function updateRevisaoCorrecao($revisao,$idIngest,$claquetes,$obs_claquete,$blocos,$obs_bloco,$materias,$obs_materia,$materiasRedacao,$obs_materiaRedacao,$chamadas,$obs_chamada,$tipoIngest){
		//start the transaction
        $this->db->trans_begin();
		
				
		$this->db->where('idRevisaoCatalogacao',$revisao['idRevisaoCatalogacao']);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_revisaoCatalogacao',$revisao);
		
			
			if (count($claquetes)){
				foreach ($claquetes as $key => $claquete) {
					$this->revisaoCatalogacaoDao->revisaoCorrecaoClaqueteRevisao($revisao['idRevisaoCatalogacao'],$idIngest,$key,$claquete[0],$obs_claquete[$key][0]);		
				}	
			}
			
			if (count($blocos)){
				foreach ($blocos as $key => $bloco) {
					$this->revisaoCatalogacaoDao->revisaoCorrecaoBlocoRevisao($revisao['idRevisaoCatalogacao'],$idIngest,$key,$bloco[0],$obs_bloco[$key][0]);
				}
			}
			
			if($tipoIngest == 'C'){
				if (count($materias)){
					foreach ($materias as $key => $materia) {
						$idMateria = $key;				
						$this->revisaoCatalogacaoDao->revisaoCorrecaoMateriaRevisao($revisao['idRevisaoCatalogacao'],$idIngest,$idMateria,$materia[0],$obs_materia[$key][0]);
					}
				}
				if (count($materiasRedacao)){
					foreach ($materiasRedacao as $key => $materiaRedacao) {
						$idMateriaRedacao = $key;				
						$this->revisaoCatalogacaoDao->revisaoCorrecaoMateriaRedacaoRevisao($revisao['idRevisaoCatalogacao'],$idIngest,$idMateriaRedacao,$materiaRedacao[0],$obs_materiaRedacao[$key][0]);
					}
				}
			}
			
			if($tipoIngest == 'CHP' || $tipoIngest == 'CH'){
				if (count($chamadas)){
					foreach ($chamadas as $key => $chamada) {
						$idChamadaFluxo = $key;				
						$this->revisaoCatalogacaoDao->revisaoCorrecaoChamadaRevisao($revisao['idRevisaoCatalogacao'],$idIngest,$idChamadaFluxo,$chamada[0],$obs_chamada[$key][0]);
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

	function revisaoCorrecaoClaqueteRevisao($idRevisaoCatalogacao,$idIngest,$idClaqueteRevisao,$claquete,$observacao){
		$arrayClaquete = array(				
				'statusRevCatalogacao' => $claquete,
				'correcaoRevCatalog' => ($claquete == 'APROVADO')? 'S':'N',
				'observacaoRevCatalogacao' => $observacao
			);
		$this->db->where('idClaqueteRevisao', $idClaqueteRevisao);
		$this->db->where('ingest_id', $idIngest);
		$this->db->where('revisaoCatalogacao_id', $idRevisaoCatalogacao);
		//return $this->db->update('tbl_claqueteRevisao',$arrayClaquete);
		
		
		if($claquete == 'APROVADO'){
			return $this->db->update('tbl_claqueteRevisao',$arrayClaquete);
		}else{
			$result = $this->db->update('tbl_claqueteRevisao',$arrayClaquete);
		}


		if($result == false){
			return false;
		}
		$claqueteRevisao_id = $this->db->insert_id();
		$arrayProblema = array(
				'idProblema' => null,
				'descricao' => $observacao,
				'corrigido' => 'N'
		);
		$result = $this->db->insert('tbl_problema',$arrayProblema);

		if($result == false){
			return false;
		}
		$problema_id = $this->db->insert_id();
		$arrayProblemaRevisao = array(
				'idRevisaoProblema' => null,
				'id_ingest' => $idIngest,
				'problema_id' => $problema_id,
				'claqueteRevisao_id' => $idClaqueteRevisao,
				'tipoRevisao' => 'C',
				'sessao' => 'C'
			);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;
		
			
	}
	
	function revisaoCorrecaoBlocoRevisao($idRevisaoCatalogacao,$idIngest,$idBlocoRevisao,$bloco,$observacao){
		$arrayBloco = array(
				'statusRevCatalogacao' => $bloco,
				'correcaoRevCatalog' => ($bloco == 'APROVADO')? 'S':'N',
				'observacaoRevCatalogacao' => $observacao
				);
		$this->db->where('idBlocoRevisao', $idBlocoRevisao);
		$this->db->where('ingest_id', $idIngest);
		$this->db->where('revisaoCatalogacao_id', $idRevisaoCatalogacao);
		//return $this->db->update('tbl_blocoRevisao',$arrayBloco);
		
		if($bloco == 'APROVADO'){
			return $this->db->update('tbl_blocoRevisao',$arrayBloco);
		}else{
			$result = $this->db->update('tbl_blocoRevisao',$arrayBloco);
		}

		if($result == false){
			return false;
		}
		$blocoRevisao_id = $this->db->insert_id();
		$arrayProblema = array(
				'idProblema' => null,
				'descricao' => $observacao,
				'corrigido' => 'N'
		);
		$result = $this->db->insert('tbl_problema',$arrayProblema);

		if($result == false){
			return false;
		}
		$problema_id = $this->db->insert_id();
		$arrayProblemaRevisao = array(
				'idRevisaoProblema' => null,
				'id_ingest' => $idIngest,
				'problema_id' => $problema_id,
				'blocoRevisao_id' => $idBlocoRevisao,
				'tipoRevisao' => 'C',
				'sessao' => 'B'
			);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;
			
	}
	
	function revisaoCorrecaoMateriaRevisao($idRevisaoCatalogacao,$idIngest,$idMateria,$materia,$observacao){
		$arrayMateria = array(					
					'statusRevCatalog' => $materia,
					'correcaoRevCatalog' => ($materia == 'APROVADO')? 'S':'N',
					'observacaoRevCatalog' => $observacao
					);
		$this->db->where('idMateriaFluxo', $idMateria);
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('revisaoCatalogacao_id',$idRevisaoCatalogacao);
		//return $this->db->update('tbl_materiaFluxo',$arrayMateria);
		
		if($materia == 'APROVADO'){
			return $this->db->update('tbl_materiaFluxo',$arrayMateria);
		}else{
			$result = $this->db->update('tbl_materiaFluxo',$arrayMateria);
		}

		if($result == false){
			return false;
		}

		$arrayProblema = array(
				'idProblema' => null,
				'descricao' => $observacao,
				'corrigido' => 'N'
		);
		$result = $this->db->insert('tbl_problema',$arrayProblema);

		if($result == false){
			return false;
		}
		$problema_id = $this->db->insert_id();
		$arrayProblemaRevisao = array(
				'idRevisaoProblema' => null,
				'id_ingest' => $idIngest,
				'problema_id' => $problema_id,
				'materiaFluxo_id' => $idMateria,
				'tipoRevisao' => 'C',
				'sessao' => 'M'
			);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;
			
	}

	function revisaoCorrecaoMateriaRedacaoRevisao($idRevisaoCatalogacao,$idIngest,$idMateria,$materia,$observacao){
		$arrayMateria = array(					
					'statusRevCatalog' => $materia,
					'correcaoRevCatalog' => ($materia == 'APROVADO')? 'S':'N',
					'observacaoRevCatalog' => $observacao
					);
		$this->db->where('idMateriaRedacaoFluxo', $idMateria);
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('revisaoCatalogacao_id',$idRevisaoCatalogacao);
		//return $this->db->update('tbl_materiaFluxo',$arrayMateria);
		
		if($materia == 'APROVADO'){
			return $this->db->update('tbl_materiaRedacaoFluxo',$arrayMateria);
		}else{
			$result = $this->db->update('tbl_materiaRedacaoFluxo',$arrayMateria);
		}

		if($result == false){
			return false;
		}

		$arrayProblema = array(
				'idProblema' => null,
				'descricao' => $observacao,
				'corrigido' => 'N'
		);
		$result = $this->db->insert('tbl_problema',$arrayProblema);

		if($result == false){
			return false;
		}
		$problema_id = $this->db->insert_id();
		$arrayProblemaRevisao = array(
				'idRevisaoProblema' => null,
				'id_ingest' => $idIngest,
				'problema_id' => $problema_id,
				'materiaRedacaoFluxo_id' => $idMateria,
				'tipoRevisao' => 'C',
				'sessao' => 'MR'
			);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;
			
	}
	
	function revisaoCorrecaoChamadaRevisao($idRevisaoCatalogacao,$idIngest,$idChamadaFluxo,$chamada,$observacao){
		$arrayChamada = array(
				'statusRevCatalogacao' => $chamada,
				'correcaoRevCatalog' => ($chamada == 'APROVADO')? 'S':'N',
				'observacaoRevCatalogacao' => $observacao
				);
		$this->db->where('idChamadaFluxo', $idChamadaFluxo);
		$this->db->where('ingest_id', $idIngest);
		$this->db->where('revisaoCatalogacao_id', $idRevisaoCatalogacao);
		
		if($chamada == 'APROVADO'){
			return $this->db->update('tbl_chamadaFluxo',$arrayChamada);
		}else{
			$result = $this->db->update('tbl_chamadaFluxo',$arrayChamada);
		}

		if($result == false){
			return false;
		}

		$arrayProblema = array(
				'idProblema' => null,
				'descricao' => $observacao,
				'corrigido' => 'N'
		);
		$result = $this->db->insert('tbl_problema',$arrayProblema);

		if($result == false){
			return false;
		}
		$problema_id = $this->db->insert_id();
		$arrayProblemaRevisao = array(
				'idRevisaoProblema' => null,
				'id_ingest' => $idIngest,
				'problema_id' => $problema_id,
				'chamadaFluxo_id' => $idChamadaFluxo,
				'tipoRevisao' => 'C',
				'sessao' => 'CH'
			);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;
		
	}



	function atualizaRevisaoCorrigido($idIngest){
		$data = array(
			'statusRevCatalog' => 'C', 
		);
		$this->db->where('ingest_id',$idIngest);
		return $this->db->update('tbl_revisaoCatalogacao',$data);
	}

	function deleteRevisaoCatalogacaoParceiro($idIngest,$idRevisaoCatalogacao){
		//start the transaction
		$this->db->trans_begin();
					
			$this->db->where('id_ingest',$idIngest);
			$this->db->where('tipoRevisao','C');
			$this->db->from('tbl_revisao_problema');
			$this->db->join('tbl_problema','tbl_problema.idProblema = tbl_revisao_problema.problema_id');	
			$dados = $this->db->get()->result();

			foreach ($dados as $value) {
				$this->db->where('idProblema',$value->problema_id);
				$this->db->delete('tbl_problema');
				
				$this->db->where('idRevisaoProblema',$value->idRevisaoProblema);
				$this->db->delete('tbl_revisao_problema');
			}		
			
			$data = array(
				'revisaoCatalogacao_id' => null, 
				'statusRevCatalogacao' => null, 
				'correcaoRevCatalog' => null, 
				'observacaoRevCatalogacao' => null, 
			);
			$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_blocoRevisao',$data);

			$this->db->where('ingest_id',$idIngest);
			$this->db->update('tbl_claqueteRevisao',$data);
			
			$this->db->where('ingest_id',$idIngest);
			$this->db->where('idRevisaoCatalogacao',$idRevisaoCatalogacao);
			$this->db->delete('tbl_revisaoCatalogacao');
		 

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