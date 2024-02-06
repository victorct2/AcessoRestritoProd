<?php 

Class RevisaoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	function selectClaquetes($idIngest){
		$this->db->where('ingest_id',$idIngest);
		return $this->db->get('tbl_claqueteRevisao')->result();
	}
	function selectBlocos($idIngest){
		$this->db->where('ingest_id',$idIngest);
		return $this->db->get('tbl_blocoRevisao')->result();
	}

	function selectIdRevisao($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->select('idRevisao');
		return $this->db->get('tbl_revisao')->result();
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
			case 'MR':
				$this->db->where('materiaRedacaoFluxo_id',$id);
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

	function insertRevisao($data,$idIngest,$claquetes,$obs_claquete,$blocos,$obs_bloco,$materias,$obs_materia,$materiasRedacao,$obs_materiasRedacao,$tipoIngest){
		//start the transaction
	   $this->db->trans_begin();
			
			$this->db->insert('tbl_revisao',$data);
			$idRevisao = $this->db->insert_id();

			for ($c = 1; $c <= count($claquetes); $c++) {
				$this->revisaoDao->insertClaqueteRevisao($idRevisao,$idIngest,$c,$claquetes[$c][0],$obs_claquete[$c][0]);
			}
			for ($b = 1; $b <= count($blocos); $b++) {
				$this->revisaoDao->insertBlocoRevisao($idRevisao,$idIngest,$b,$blocos[$b][0],$obs_bloco[$b][0]);
			}

			if($tipoIngest == 'P'){
				/*for ($m = 1; $m <= count($materias); $m++) {
					$this->dao_revisao_model->insertMateriaRevisaoParceiro($idRevisao,$idIngest,$m,$materias[$m][0],$obs_materia[$m][0],$idIngestParceiro);
				}	*/
			}else if($tipoIngest == 'C' || $tipoIngest == 'CH'){

				if(count($materias)>0){
					foreach ($materias as $key => $materia) {
						$idMateria = $key;
						$this->revisaoDao->insertMateriaRevisao($idRevisao,$idIngest,$idMateria,$materia[0],$obs_materia[$key][0]);
					}
				}

				if(count($materiasRedacao)>0){
					foreach ($materiasRedacao as $key => $materiaRedacao) {
						$idMateriaRedacao = $key;
						$this->revisaoDao->insertMateriaRedacaoRevisao($idRevisao,$idIngest,$idMateriaRedacao,$materiaRedacao[0],$obs_materiasRedacao[$key][0]);
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

   function insertClaqueteRevisao($idRevisao,$idIngest,$numeroClaquete,$claquete,$observacao){
		$arrayClaquete = array(
				'idClaqueteRevisao' => null,
				'numeroClaquete' => $numeroClaquete,
				'ingest_id' => $idIngest,
				'revisao_id' => $idRevisao,
				'statusRevisao' => $claquete,
				'correcaoRevisao' => 'N',
				'observacaoRevisao' => $observacao
			);
		$result = $this->db->insert('tbl_claqueteRevisao',$arrayClaquete);

		if($result == false){
			return false;
		}
		if($claquete =='REPROVADO'){
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
					'claqueteRevisao_id' => $claqueteRevisao_id,
					'tipoRevisao' => 'I',
					'sessao' => 'C'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);
		}

		return $result;

	}

	function insertBlocoRevisao($idRevisao,$idIngest,$numeroBloco,$bloco,$observacao){
		$arrayBloco = array(
				'idBlocoRevisao' => null,
				'numeroBloco' => $numeroBloco,
				'ingest_id' => $idIngest,
				'revisao_id' => $idRevisao,
				'statusRevisao' => $bloco,
				'correcaoRevisao' => 'N',
				'observacaoRevisao' => $observacao
				);
		$result = $this->db->insert('tbl_blocoRevisao',$arrayBloco);

		if($result == false){
			return false;
		}

		if($bloco == 'REPROVADO'){
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
					'blocoRevisao_id' => $blocoRevisao_id,
					'tipoRevisao' => 'I',
					'sessao' => 'B'
				);
			$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);
		}

		return $result;

	}
	

	function selectClaquetesReprovadasRevisao($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevisao','REPROVADO');
		$this->db->where('correcaoRevisao','N');
		return $this->db->get('tbl_claqueteRevisao')->result();
	}
	function selectBlocosReprovadasRevisao($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevisao','REPROVADO');
		$this->db->where('correcaoRevisao','N');
		return $this->db->get('tbl_blocoRevisao')->result();
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

	function atualizaRevisaoCorrigido($idIngest){
		$data = array(
			'statusRevisao' => 'C',
		);
		$this->db->where('ingest_id',$idIngest);
		return $this->db->update('tbl_revisao',$data);
	}

	function selectRevisaoByIdIngest($idIngest){
		$this->db->where('ingest_id',$idIngest);
		return $this->db->get('tbl_revisao')->result();
	}

	function selectClaquetesCorrigidas($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevisao','REPROVADO');
		$this->db->where('correcaoRevisao','S');
		return $this->db->get('tbl_claqueteRevisao')->result();
	}

	function selectBlocosCorrigidas($idIngest){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('statusRevisao','REPROVADO');
		$this->db->where('correcaoRevisao','S');
		return $this->db->get('tbl_blocoRevisao')->result();
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
			case 'MR':
				$this->db->where('materiaRedacaoFluxo_id',$id);
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

	function updateRevisaoCorrecao($revisao,$idIngest,$claquetes,$obs_claquete,$blocos,$obs_bloco,$materias,$obs_materia,$materiasRedacao,$obs_materiasRedacao,$chamadas,$obs_chamada,$tipoIngest){
		//start the transaction
        $this->db->trans_begin();

		$this->db->where('idRevisao',$revisao['idRevisao']);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_revisao',$revisao);

		if(count($claquetes)){
			foreach ($claquetes as $key => $claquete) {
				$this->revisaoDao->revisaoCorrecaoClaqueteRevisao($revisao['idRevisao'],$idIngest,$key,$claquete[0],$obs_claquete[$key][0]);
			}
		}

		if(count($blocos)){
			foreach ($blocos as $key => $bloco) {
				$this->revisaoDao->revisaoCorrecaoBlocoRevisao($revisao['idRevisao'],$idIngest,$key,$bloco[0],$obs_bloco[$key][0]);
			}
		}

		if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
			 if(count($chamadas)){
				foreach ($chamadas as $key => $chamada) {
					$idChamadaFluxo = $key;
					$this->revisaoDao->revisaoCorrecaoChamadaRevisao($revisao['idRevisao'],$idIngest,$idChamadaFluxo,$chamada[0],$obs_chamada[$key][0]);
				}
			}
		}else if($tipoIngest == 'C'){
			if(count($materias)){
				foreach ($materias as $key => $materia) {
					$idMateria = $key;
					$this->revisaoDao->revisaoCorrecaoMateriaRevisao($revisao['idRevisao'],$idIngest,$idMateria,$materia[0],$obs_materia[$key][0]);
				}
			}
			if(count($materiasRedacao)){
				foreach ($materiasRedacao as $key => $materiaRedacao) {
					$idMateriaRedacao = $key;
					$this->revisaoDao->revisaoCorrecaoMateriaRedacaoRevisao($revisao['idRevisao'],$idIngest,$idMateriaRedacao,$materiaRedacao[0],$obs_materiasRedacao[$key][0]);
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

	function revisaoCorrecaoClaqueteRevisao($idRevisao,$idIngest,$idClaqueteRevisao,$claquete,$observacao){
		$arrayClaquete = array(
			'statusRevisao' => $claquete,
			'correcaoRevisao' => ($claquete == 'APROVADO')? 'S':'N',
			'observacaoRevisao' => $observacao
		);
		$this->db->where('idClaqueteRevisao', $idClaqueteRevisao);
		$this->db->where('ingest_id', $idIngest);
		$this->db->where('revisao_id', $idRevisao);

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
			'tipoRevisao' => 'I',
			'sessao' => 'C'
		);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;



	}

	function revisaoCorrecaoBlocoRevisao($idRevisao,$idIngest,$idBlocoRevisao,$bloco,$observacao){
		$arrayBloco = array(
			'statusRevisao' => $bloco,
			'correcaoRevisao' => ($bloco == 'APROVADO')? 'S':'N',
			'observacaoRevisao' => $observacao
		);
		$this->db->where('idBlocoRevisao', $idBlocoRevisao);
		$this->db->where('ingest_id', $idIngest);
		$this->db->where('revisao_id', $idRevisao);


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
			'tipoRevisao' => 'I',
			'sessao' => 'B'
		);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;


	}

	function revisaoCorrecaoMateriaRevisao($idRevisao,$idIngest,$idMateria,$materia,$observacao){
		$arrayMateria = array(
			'statusRevisao' => $materia,
			'correcaoRevisao' => ($materia == 'APROVADO')? 'S':'N',
			'observacaoRevisao' => $observacao
		);
		$this->db->where('idMateriaFluxo', $idMateria);
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('revisao_id',$idRevisao);

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
			'tipoRevisao' => 'I',
			'sessao' => 'M'
		);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;

	}


	function revisaoCorrecaoMateriaRedacaoRevisao($idRevisao,$idIngest,$idMateria,$materia,$observacao){
		$arrayMateria = array(
			'statusRevisao' => $materia,
			'correcaoRevisao' => ($materia == 'APROVADO')? 'S':'N',
			'observacaoRevisao' => $observacao
		);
		$this->db->where('idMateriaRedacaoFluxo', $idMateria);
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('revisao_id',$idRevisao);

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
			'tipoRevisao' => 'I',
			'sessao' => 'MR'
		);
		$result = $this->db->insert('tbl_revisao_problema',$arrayProblemaRevisao);

		return $result;

	}

/*======================== Alterar Revisão ===================================*/


	function updateRevisao($data,$idIngest,$claquetes,$obs_claquete,$blocos,$obs_bloco,$materias,$obs_materia,$materiasRedacao,$obs_materiasRedacao,$tipoIngest,$blocoProblema,$claqueteProblema){
		//start the transaction
		$this->db->trans_begin();

			$this->db->where('idRevisao',$data['idRevisao']);
			$this->db->update('tbl_revisao',$data);			

			$countA = 0;
			for ($c = 1; $c <= count($claquetes); $c++) {
				$claquete = $this->revisaoDao->selectClaquete($idIngest,$c);
				if($claquete[0]->statusRevisao != $claquetes[$c][0]){
					if($claquetes[$c][0] == 'APROVADO'){
						$this->revisaoDao->UpdateRevisaoReprovadoParaAprovado($idIngest,$data['idRevisao'],$claquete[0]->idClaqueteRevisao,'I','C');
					}else if($claquetes[$c][0] == 'REPROVADO'){
						$this->revisaoDao->revisaoCorrecaoClaqueteRevisao($data['idRevisao'],$idIngest,$claquete[0]->idClaqueteRevisao,$claquetes[$c][0],$obs_claquete[$c][0]);
					}
				}else if($obs_claquete[$c][0] != ""){
					//echo $obs_claquete[$c][0] . '<br>';
					//echo $claqueteProblema[$countB] . '<br>';
					$this->revisaoDao->updateInfoProblema($claqueteProblema[$countA],$obs_claquete[$c][0]);
					$countA ++;
				}				
			}
			$countB = 0;
			for ($b = 1; $b <= count($blocos); $b++) {
				$bloco = $this->revisaoDao->selectBloco($idIngest,$b);
				if($bloco[0]->statusRevisao != $blocos[$b][0]){
					if($blocos[$b][0] == 'APROVADO'){
						$this->revisaoDao->UpdateRevisaoReprovadoParaAprovado($idIngest,$data['idRevisao'],$bloco[0]->idBlocoRevisao,'I','B');
					}else if($blocos[$b][0] == 'REPROVADO'){
						$this->revisaoDao->revisaoCorrecaoBlocoRevisao($data['idRevisao'],$idIngest,$bloco[0]->idBlocoRevisao,$blocos[$b][0],$obs_bloco[$b][0]);
					}
				}else if($obs_bloco[$b][0] != ""){
					//echo $obs_bloco[$b][0] . '<br>';
					//echo $blocoProblema[$countB] . '<br>';
					$this->revisaoDao->updateInfoProblema($blocoProblema[$countB],$obs_bloco[$b][0]);
					$countB ++;
				}				
			}

			
			if($tipoIngest == 'C' || $tipoIngest == 'CH'){

				if(count($materias)>0){
					foreach ($materias as $key => $materia) {
						$idMateria = $key;
						$this->revisaoDao->insertMateriaRevisao($idRevisao,$idIngest,$idMateria,$materia[0],$obs_materia[$key][0]);
					}
				}

				if(count($materiasRedacao)>0){
					foreach ($materiasRedacao as $key => $materiaRedacao) {
						$idMateriaRedacao = $key;
						$this->revisaoDao->insertMateriaRedacaoRevisao($idRevisao,$idIngest,$idMateriaRedacao,$materiaRedacao[0],$obs_materiasRedacao[$key][0]);
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


	function selectClaquete($idIngest,$numeroClaquete){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('numeroClaquete',$numeroClaquete);
		return $this->db->get('tbl_claqueteRevisao')->result();
	}
	function selectBloco($idIngest,$numeroBloco){
		$this->db->where('ingest_id',$idIngest);
		$this->db->where('numeroBloco',$numeroBloco);
		return $this->db->get('tbl_blocoRevisao')->result();
	}

	
	

	function UpdateRevisaoReprovadoParaAprovado($idIngest,$idRevisao,$id,$tipoRevisao,$sessao){
		//start the transaction
		$this->db->trans_begin();

			$dados = $this->revisaoDao->selectProblemas($idIngest,$id,$tipoRevisao,$sessao);

			//tblProblema
			$this->db->where('idProblema',$dados[0]->idProblema);
			$this->db->delete('tbl_problema');
			//tblRevisaoProblema
			$this->db->where('idRevisaoProblema',$dados[0]->idRevisaoProblema);
			$this->db->delete('tbl_revisao_problema');

			switch ($sessao) {
				case 'C':
						$arrayClaquete = array(
							'statusRevisao' => 'APROVADO',
							'correcaoRevisao' => 'N',
							'observacaoRevisao' => ''
						);
						$this->db->where('idClaqueteRevisao', $id);
						$this->db->where('ingest_id', $idIngest);
						$this->db->where('revisao_id', $idRevisao);
						$this->db->update('tbl_claqueteRevisao',$arrayClaquete);						
					break;
				case 'B':
						$arrayBloco = array(
							'statusRevisao' => 'APROVADO',
							'correcaoRevisao' => 'N',
							'observacaoRevisao' => ''
						);
						$this->db->where('idBlocoRevisao', $id);
						$this->db->where('ingest_id', $idIngest);
						$this->db->where('revisao_id', $idRevisao);
						$this->db->update('tbl_blocoRevisao',$arrayBloco);						
					break;
				
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

	function updateInfoProblema($idProblema,$texto){
		//start the transaction
		$this->db->trans_begin();

			$problema = array(
				'descricao' => $texto
			);
			$this->db->where('idProblema', $idProblema);
			$this->db->update('tbl_problema',$problema);

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



/*======================== Delete Revisão ====================================*/

	function deleteRevisaoParceiro($idIngest,$idRevisaoIngest){
		//start the transaction
		$this->db->trans_begin();

			//revisão de catalogação
			/*$revisaoCatalogacao = $this->revisaoCatalogacaoDao->selectIdRevisaoCatalogacaoParceiro($idIngest);
			if(count($revisaoCatalogacao)>0){
				$this->revisaoCatalogacaoDao->deleteRevisaoCatalogacaoParceiro($idIngest,$revisaoCatalogacao[0]->idRevisaoCatalogacao);
			}*/
			
			//autorização
			$autorizacao = $this->parceirosDao->selectIdAutorizacao($idIngest);
			if(count($autorizacao)>0){
				$this->parceirosDao->deleteAutorizacao($idIngest,$autorizacao[0]->idAutorizacao);
			}
			
			//catalogação
			$catalogacao = $this->catalogacaoDao->selectIdCatalogacaoParceiro($idIngest);
			if(count($catalogacao)>0){
				$this->catalogacaoDao->deleteCatalogacaoParceiro($idIngest,$catalogacao[0]->idCatalogacao);
			}
			
			//Ficha de conclusão
			$fichaConclusao = $this->fichaConclusaoDao->selectIdFichaConclusao($idIngest);
			if(count($fichaConclusao)>0){
				$this->fichaConclusaoDao->deleteFichaConclusaoParceiro($idIngest,$fichaConclusao[0]->idFichaConclusao);	
			}		
			
			$this->db->where('id_ingest',$idIngest);
			$this->db->where('tipoRevisao','I');
			$this->db->from('tbl_revisao_problema');
			$this->db->join('tbl_problema','tbl_problema.idProblema = tbl_revisao_problema.problema_id');	
			$dados = $this->db->get()->result();

			foreach ($dados as $value) {
				$this->db->where('idProblema',$value->problema_id);
				$this->db->delete('tbl_problema');
				
				$this->db->where('idRevisaoProblema',$value->idRevisaoProblema);
				$this->db->delete('tbl_revisao_problema');
			}	
			
			//blocos
			$this->db->where('ingest_id',$idIngest);
			$this->db->delete('tbl_blocoRevisao');
			//claquetes
			$this->db->where('ingest_id',$idIngest);
			$this->db->delete('tbl_claqueteRevisao');
			//revisão
			$this->db->where('ingest_id',$idIngest);
			$this->db->where('idRevisao',$idRevisaoIngest);
			$this->db->delete('tbl_revisao');
		 

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