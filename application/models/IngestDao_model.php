<?php

Class IngestDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}




	/*======================================= Programas inserridos antes do ingest ===========================*/

	function make_queryProgramasParceiros($idParceiro){
		$order_column = array(null,"nomePrograma","tituloPrograma","numeroPGM","versao","dataFim","nome", null);
		$this->db->distinct();
		$this->db->group_by('idIngest,tbl_programasParceiros.nomePrograma,tbl_programasParceiros.sigla,tbl_ingestParceiro.idIngestParceiro');
		$this->db->select('idIngest,nomePrograma,sigla,idIngestParceiro,idPrograma,tituloPrograma,numeroPGM,
			idParceiros,tbl_parceiros.imagem,tbl_programasParceiros.imagem as imgPgmParceiro,idIngest,recebido,statusIngest,dataCadastro,observacao,closedCaption');
		$this->db->from('tbl_ingest');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_programasParceiros','tbl_programasParceiros.idProgramasParceiros = tbl_ingestParceiro.idPrograma');
		$this->db->join('tbl_parceiros','tbl_parceiros.idParceiros = tbl_ingestParceiro.parceiro_id');
		$this->db->join('usuarios','usuarios.id = tbl_ingest.usuario_id', 'left');
		$this->db->where('idParceiros',$idParceiro);
		$this->db->where('tipoIngest', 'P');

		if(!empty($_POST['columns'][0]["search"]["value"])){
			$this->db->where("tbl_ingestParceiro.idPrograma", $_POST['columns'][0]["search"]["value"]);
		}
		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("nomePrograma", $_POST['columns'][1]["search"]["value"]);
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("tituloPrograma", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->where("numeroPGM", $_POST['columns'][3]["search"]["value"]);
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("recebido", $_POST['columns'][4]["search"]["value"]);
		}
		if(!empty($_POST['columns'][5]["search"]["value"])){
			$this->db->like("observacao", $_POST['columns'][5]["search"]["value"]);
		}
		if(!empty($_POST['columns'][6]["search"]["value"])){
			$this->db->where("dataFim", $_POST['columns'][6]["search"]["value"]);
		}
		if(!empty($_POST['columns'][7]["search"]["value"])){
			$this->db->where("statusIngest", $_POST['columns'][7]["search"]["value"]);
		}

		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('idIngest', 'DESC');
		}
	}

	function make_datatablesProgramasParceiros($idParceiro){
		$this->make_queryProgramasParceiros($idParceiro);
		if($_POST["length"] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
    }

	function get_filtered_dataProgramasParceiros($idParceiro){
		$this->make_queryProgramasParceiros($idParceiro);
		$query = $this->db->get();
		return $query->num_rows();
      }

	function get_all_dataProgramasParceiros($idParceiro){
		$this->db->where('idParceiros',$idParceiro);
		$this->db->where('tipoIngest', 'P');
		$this->db->select("*");
		$this->db->from('tbl_ingest');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_programasParceiros','tbl_programasParceiros.idProgramasParceiros = tbl_ingestParceiro.idPrograma');
		$this->db->join('tbl_parceiros','tbl_parceiros.idParceiros = tbl_ingestParceiro.parceiro_id');
		return $this->db->count_all_results();
	}





	/* ============================================== Tabela do Fluxo completo ======================================*/

	function make_query($idParceiro){
		$order_column = array(null,"nomePrograma","tituloPrograma","numeroPGM","versao","dataFim","nome", null);
		$this->db->distinct();
		$this->db->group_by('idIngest,tbl_programasParceiros.nomePrograma,tbl_programasParceiros.sigla,tbl_ingestParceiro.idIngestParceiro,
		tbl_revisao.idRevisao,tbl_ingestClosedCaption.idIngestClosedCaption,tbl_revisaoClosedCaption.idRevisaoClosedCaption,
		tbl_fichaConclusao.idFichaConclusao,tbl_catalogacao.idCatalogacao,tbl_revisaoCatalogacao.statusRevCatalog,tbl_autorizacao.idAutorizacao,
		tbl_revisaoCatalogacao.idRevisaoCatalogacao,tbl_revisaoCatalogacaoClosedCaption.idRevisaoCatalogacaoClosedCaption,tbl_exclusao.idExclusao');
		$this->db->select('idIngest,nomePrograma,sigla,idIngestParceiro,idPrograma,tituloPrograma,numeroPGM,idParceiros,tbl_parceiros.imagem,
		tbl_programasParceiros.imagem as imgPgmParceiro,idIngest,dataInicio,dataFim,usuario_id,versao,tipoFluxo,tbl_ingest.pauta_id,closedCaption,
		idRevisao,dataRevisao,usuario_id_revisao,statusRevisao,idIngestClosedCaption,dataIngestClosedCaption,usuario_id_ingest_closedCaption,ingestPosterior,
		idRevisaoClosedCaption,dataRevisaoClosedCaption,statusRevisaoClosedCaption,usuario_id_revisao_closedCaption,idFichaConclusao,dataFichaConclusao,usuario_id_fichaConclusao,
		idCatalogacao,dataInicioCatalogacao,dataFimCatalogacao,dataCatalogacaoClosedCaption,usuario_id_catalogacao,statusRevCatalog,idAutorizacao,
		dataAutorizacao,dataAutorizacaoClosedCaption,usuario_id_autorizacao, idRevisaoCatalogacao, dataRevisaoCatalogacao,usuario_id_revCatalog,
		statusRevCatalog,idRevisaoCatalogacaoClosedCaption,dataRevisaoCatalogacaoClosedCaption,usuario_id_revisaoCatalogacao_closedCaption,statusRevisaoCatalogacaoClosedCaption,
		idExclusao, exclusao, dataExclusao,dataExclusaoClosedCaption, nome,usuario_id_exclusao');
		$this->db->from('tbl_ingest');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_programasParceiros','tbl_programasParceiros.idProgramasParceiros = tbl_ingestParceiro.idPrograma');
		$this->db->join('tbl_parceiros','tbl_parceiros.idParceiros = tbl_ingestParceiro.parceiro_id');
		$this->db->join('tbl_revisao','tbl_revisao.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_revisaoClosedCaption','tbl_revisaoClosedCaption.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_fitaMaster','tbl_fitaMaster.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_fichaConclusao','tbl_fichaConclusao.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_revisaoCatalogacao','tbl_revisaoCatalogacao.catalogacao_id = tbl_catalogacao.idCatalogacao', 'left');
		$this->db->join('tbl_revisaoCatalogacaoClosedCaption','tbl_revisaoCatalogacaoClosedCaption.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_autorizacao','tbl_autorizacao.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('tbl_exclusao','tbl_exclusao.ingest_id = tbl_ingest.idIngest', 'left');
		$this->db->join('usuarios','usuarios.id = tbl_ingest.usuario_id', 'left');

		$this->db->where('idParceiros',$idParceiro);
		$this->db->where('tipoIngest', 'P');
		$this->db->where('statusIngest', 'LIBERADO');


		if(!empty($_POST['columns'][0]["search"]["value"])){
			$this->db->where("tbl_ingestParceiro.idPrograma", $_POST['columns'][0]["search"]["value"]);
		}
		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("nomePrograma", $_POST['columns'][1]["search"]["value"]);
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("tituloPrograma", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->where("numeroPGM", $_POST['columns'][3]["search"]["value"]);
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("versao", $_POST['columns'][4]["search"]["value"]);
		}
		if(!empty($_POST['columns'][5]["search"]["value"])){
			$this->db->where("dataFim", $_POST['columns'][5]["search"]["value"]);
		}
		if(!empty($_POST['columns'][6]["search"]["value"])){
			$this->db->like("nome", $_POST['columns'][6]["search"]["value"]);
		}

		switch ($_POST['columns'][7]["search"]["value"]) {
			case 'CORRIGIDO':
				$this->db->where("statusRevisao", 'C');
				break;
			case 'REPROVADO':
				$this->db->where("statusRevisao", 'R');
				break;
			case 'APROVADO':
				$this->db->where("statusRevisao", 'A');
				break;
			case 'NAOREVISADO':
				$this->db->where("dataFim !=", null);
				$this->db->where("idRevisao", null);
				break;
			case 'SEMINGESTCC':
				$this->db->where("closedCaption", null);
				break;
			case 'NAOCC':
				$this->db->where("closedCaption", 'N');
				break;
			case 'INGESTCC':
				$this->db->where("closedCaption", 'S');
				break;
			case 'CORRIGIDOCC':
				$this->db->where("statusRevisaoClosedCaption", 'C');
				break;
			case 'REPROVADOCC':
				$this->db->where("statusRevisaoClosedCaption", 'R');
				break;
			case 'APROVADOCC':
				$this->db->where("statusRevisaoClosedCaption", 'A');
				break;
			case 'NAOREVISADOCC':
				$this->db->where("idRevisaoClosedCaption", null);
				break;
			case 'COMFICHA':
				$this->db->where("statusRevisao", 'A');
				$this->db->where("idFichaConclusao !=", null);
				break;
			case 'SEMFICHA':
				$this->db->where("statusRevisao", 'A');
				$this->db->where("idFichaConclusao", null);
				break;
			case 'NAOCATALOGADA':
				$this->db->where("idFichaConclusao !=", null);
				$this->db->where("idCatalogacao", null);
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				$this->db->where("statusRevisao", 'A');
				break;

			case 'CATINICIADA':
				$this->db->where("idCatalogacao !=", null);
				$this->db->where("dataInicioCatalogacao !=", null);
				$this->db->where("dataFimCatalogacao", null);
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'CATFINALIZADA':
			$this->db->where("idCatalogacao !=", null);
				$this->db->where("dataInicioCatalogacao !=", null);
				$this->db->where("dataFimCatalogacao !=", null);
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'CATCORRIGIDO':
				$this->db->where("statusRevCatalog", 'C');
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'CATREPROVADO':
				$this->db->where("statusRevCatalog", 'R');
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'CATAPROVADO':
				$this->db->where("statusRevCatalog", 'A');
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'CATNAOREVISADO':
			//$this->db->where("idRevisaoCatalogacao", null);
			$this->db->where('(dataRevisaoCatalogacao is null  or statusRevCatalog = "C")',NULL,FALSE);
			$this->db->where("dataFimCatalogacao !=", null);
			$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'NAOCATALOGADACC':
				$this->db->where("idCatalogacao !=", null);
				$this->db->where("dataCatalogacaoClosedCaption", null);
				$this->db->where("ingestPosterior", 'S');
				$this->db->where("statusRevisaoClosedCaption", 'A');
				$this->db->where("statusRevisao", 'A');
				break;
			case 'CATALOGADACC':
				$this->db->where("idCatalogacao !=", null);
				$this->db->where("dataCatalogacaoClosedCaption !=", null);
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'CATCORRIGIDOCC':
				$this->db->where("statusRevisaoCatalogacaoClosedCaption", 'C');
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'CATREPROVADOCC':
				$this->db->where("statusRevisaoCatalogacaoClosedCaption", 'R');
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'CATAPROVADOCC':
				$this->db->where("statusRevisaoCatalogacaoClosedCaption", 'A');
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'CATNAOREVISADOCC':
				$this->db->where("idRevisaoCatalogacaoClosedCaption", null);
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'AUTORIZADO':
				$this->db->where("idAutorizacao !=", null);
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'NAOAUTORIZADO':
				$this->db->where("idAutorizacao", null);
				$this->db->where("dataFimCatalogacao !=", null);
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'AUTORIZADOCC':
				$this->db->where("idAutorizacao !=", null);
				$this->db->where("dataAutorizacaoClosedCaption !=", null);
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'NAOAUTORIZADOCC':
				$this->db->where("idAutorizacao !=", null);
				$this->db->where("dataAutorizacaoClosedCaption", null);
				$this->db->where("dataCatalogacaoClosedCaption !=", null);
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'EXCLUIDO':
				$this->db->where("idExclusao !=", null);
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'NAOEXCLUIDO':
				$this->db->where("idExclusao", null);
				$this->db->where("statusRevCatalog", 'A');
				$this->db->where("(ingestPosterior is null or ingestPosterior = 'N')",NULL,FALSE);
				break;
			case 'EXCLUIDOCC':
				$this->db->where("idExclusao !=", null);
				$this->db->where("dataExclusaoClosedCaption !=", null);
				$this->db->where("ingestPosterior", 'S');
				break;
			case 'NAOEXCLUIDOCC':
				$this->db->where("idExclusao !=", null);
				$this->db->where("dataExclusaoClosedCaption", null);
				$this->db->where("statusRevisaoCatalogacaoClosedCaption", 'A');
				$this->db->where("ingestPosterior", 'S');
				break;
			default:
				break;
		}

		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('idIngest', 'DESC');
		}
	}

	function make_datatables($idParceiro){
		$this->make_query($idParceiro);
		if($_POST["length"] != -1){
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
    }

	function get_filtered_data($idParceiro){
		$this->make_query($idParceiro);
		$query = $this->db->get();
		return $query->num_rows();
      }

	function get_all_data($idParceiro){
		$this->db->where('idParceiros',$idParceiro);
		$this->db->where('tipoIngest', 'P');
		$this->db->where('statusIngest', 'LIBERADO');
		$this->db->select("*");
		$this->db->from('tbl_ingest');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_programasParceiros','tbl_programasParceiros.idProgramasParceiros = tbl_ingestParceiro.idPrograma');
		$this->db->join('tbl_parceiros','tbl_parceiros.idParceiros = tbl_ingestParceiro.parceiro_id');
		return $this->db->count_all_results();
	}

	function verificarNumeroProgramaLiberado($idPrograma,$numeroPrograma,$tipoIngest){

		switch ($tipoIngest) {
			case 'P':
			    $this->db->where('idPrograma',$idPrograma);
				$this->db->where('numeroPGM',$numeroPrograma);
				$result = $this->db->get('tbl_ingestParceiro')->result();
				if(count($result)>0){
					return FALSE;
				}else{
					return TRUE;
				}
				break;
			case 'IC':
			    $this->db->where('idInterProgramaCasa',$idPrograma);
				$this->db->where('numeroPGM',$numeroPrograma);
				$result = $this->db->get('tbl_ingestInterCasa')->result();
				if(count($result)>0){
					return FALSE;
				}else{
					return TRUE;
				}
				break;
			case 'IP':
			     $this->db->where('idPrograma',$idPrograma);
				$this->db->where('numeroPGM',$numeroPrograma);
				$result = $this->db->get('tbl_ingestInterProgramas')->result();
				if(count($result)>0){
					return FALSE;
				}else{
					return TRUE;
				}
				break;

			default:

				break;
		}

	}

	function selectIngest($idIngest){
		$this->db->where('idIngest',$idIngest);
		$this->db->select('idIngest,claquetes,blocos,pauta_id,versao,tipoFluxo');
		$this->db->from('tbl_ingest');
		return $this->db->get()->result();
	}

	function selectIngestPosterior($idIngest){

	}


	//function updateCorrecaoIngest($data,$idIngest,$materias,$materiasRedacao,$claquetes,$chamadas,$blocos,$tipoIngest,$problemaClaquete,$blocoProblema,$materiaProblema,$materiaRedacaoProblema,$chamadaProblema){
	function updateCorrecaoIngest($data,$idIngest,$materias,$materiasRedacao,$claquetes,$chamadas,$blocos,$tipoIngest,$problemaClaquete,
		$blocoProblema,$materiaProblema,$materiaRedacaoProblema,$chamadaProblema,$respostaBlocoProblema,$respostaClaqueteProblema){
		//start the transaction
	   	$this->db->trans_begin();

		$this->db->where('idIngest',$idIngest);
		$this->db->update('tbl_ingest',$data);

		if(count($claquetes) >0){
			foreach ($claquetes as $key => $c) {
				$this->ingestDao->updateCorrecaoClaquete($key);
				//$this->dao_ingest_model->updateCorrecaoProblema($problemaClaquete);
			}
		}

		if(count($problemaClaquete) >0){
			foreach ($problemaClaquete as $idProblema) {
				$this->ingestDao->updateCorrecaoProblema($idProblema,$respostaClaqueteProblema[$idProblema]);
			}
		}

		if(count($blocos) >0){
			foreach ($blocos as $key => $b) {
				$this->ingestDao->updateCorrecaoBloco($key);
				//$this->dao_ingest_model->updateCorrecaoProblema($blocoProblema);
			}
		}

		if(count($blocoProblema) >0){
			foreach ($blocoProblema as $idProblema) {
				$this->ingestDao->updateCorrecaoProblema($idProblema,$respostaBlocoProblema[$idProblema]);
			}
		}

	   	if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
			if(count($chamadas) >0){
				foreach ($chamadas as $key => $ch) {
					$this->ingestDao->updateCorrecaoChamadas($key);
					//$this->dao_ingest_model->updateCorrecaoProblema($materiaProblema);
				}
			}

			if(count($chamadaProblema) >0){
				foreach ($chamadaProblema as $idProblema) {
					$this->ingestDao->updateCorrecaoProblema($idProblema);
				}
			}
		}

		if($tipoIngest == 'C'){
			if(count($materias) >0){
				foreach ($materias as $key => $m) {
					$this->ingestDao->updateCorrecaoMateria($key);
					//$this->dao_ingest_model->updateCorrecaoProblema($chamadaProblema);
				}
			}

			if(count($materiaProblema) >0){
				foreach ($materiaProblema as $idProblema) {
					$this->ingestDao->updateCorrecaoProblema($idProblema);
				}
			}

			if(count($materiasRedacao) >0){
				foreach ($materiasRedacao as $key => $mr) {
					$this->ingestDao->updateCorrecaoMateriaRedacao($key);
					//$this->dao_ingest_model->updateCorrecaoProblema($chamadaProblema);
				}
			}

			if(count($materiaRedacaoProblema) >0){
				foreach ($materiaRedacaoProblema as $idProblemaRedacao) {
					$this->ingestDao->updateCorrecaoProblema($idProblemaRedacao);
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

   function updateCorrecaoIngestClosedCaption($data,$idIngest,$idRevisaoClosedCaptionProblema,$resposta){
	//start the transaction
	   $this->db->trans_begin();

		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_ingestClosedCaption',$data);

		$data = array(
			'corrigido' => 'S',
			'resposta' => $resposta
		);
		$this->db->where('idRevisaoClosedCaptionProblema',$idRevisaoClosedCaptionProblema);
		$this->db->update('tbl_revisaoClosedCaption_problema',$data);

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
		$data = array('correcaoRevisao' => 'S');
		$this->db->where('idClaqueteRevisao',$idClaqueteRevisao);
		return $this->db->update('tbl_claqueteRevisao',$data);
	}

	function updateCorrecaoProblema($idProblema,$resposta){
		$data = array(
			'corrigido' => 'S',
			'resposta' => $resposta
		);
		$this->db->where('idProblema',$idProblema);
		return $this->db->update('tbl_problema',$data);
	}


	function updateCorrecaoBloco($idBlocoRevisao){
		$data = array( 'correcaoRevisao' => 'S');
		$this->db->where('idBlocoRevisao',$idBlocoRevisao);
		return $this->db->update('tbl_blocoRevisao',$data);
	}

	function updateCorrecaoMateria($idMateriaFluxo){
		$data = array('correcaoRevisao' => 'S');
		$this->db->where('idMateriaFluxo',$idMateriaFluxo);
		return $this->db->update('tbl_materiaFluxo',$data);
	}

	function updateCorrecaoMateriaRedacao($idMateriaFluxo){
		$data = array('correcaoRevisao' => 'S');
		$this->db->where('idMateriaRedacaoFluxo',$idMateriaFluxo);
		return $this->db->update('tbl_materiaRedacaoFluxo',$data);
	}

	function updateCorrecaoChamadas($idChamadaFluxo){
		$data = array('correcaoRevisao' => 'S');
		$this->db->where('idChamadaFluxo',$idChamadaFluxo);
		return $this->db->update('tbl_chamadaFluxo',$data);
	}

/*=================== Área INGEST Parceiro ===========================================*/
	function insertProgramaParceiro($ingest,$ingestParceiro){
		//start the transaction
		$this->db->trans_begin();

			$this->db->insert('tbl_ingest',$ingest);
			$idIngest = $this->db->insert_id();

			$ingestParceiro['ingest_id'] = $idIngest;
			$this->db->insert('tbl_ingestParceiro',$ingestParceiro);

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

	function insertIngestParceiro($ingest,$ingestParceiro){
		//start the transaction
	   $this->db->trans_begin();

	   $this->db->insert('tbl_ingest',$ingest);
	   $idIngest = $this->db->insert_id();

	   $ingestParceiro['ingest_id'] = $idIngest;
	   $this->db->insert('tbl_ingestParceiro',$ingestParceiro);

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

	function insertIngestClosedCaption($data){
		//start the transaction
		$this->db->trans_begin();

		$this->db->insert('tbl_ingestClosedCaption',$data);

		$ingest = array( 'closedCaption' => 'S');
		$this->db->where('ingest_id',$data['ingest_id']);
		$this->db->update('tbl_ingestParceiro',$ingest);

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

	function insertSemIngestClosedCaption($idIngest){
		//start the transaction
		$this->db->trans_begin();

		$ingest = array( 'closedCaption' => 'N');
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_ingestParceiro',$ingest);

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

	function desfazerClosedCaption($idIngest){
		//start the transaction
		$this->db->trans_begin();

		$ingest = array( 'closedCaption' => null);
		$this->db->where('ingest_id',$idIngest);
		$this->db->update('tbl_ingestParceiro',$ingest);

		$this->db->where('ingest_id',$idIngest);
		$this->db->delete('tbl_ingestClosedCaption');

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

   	function selectIngestParceiro($idIngest){
		$this->db->where('idIngest',$idIngest);
		$this->db->select('idIngest,claquetes,blocos,pauta_id,versao,idPrograma,tituloPrograma,numeroPGM,parceiro_id,idIngestParceiro,observacao,recebido,statusIngest,closedCaption');
		$this->db->from('tbl_ingest');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest','inner');
		return $this->db->get()->result();
	}


	function updateIngestParceiro($ingest,$ingestParceiro){
		//start the transaction
		$this->db->trans_begin();

		$this->db->where('idIngest',$ingest['idIngest']);
		$this->db->update('tbl_ingest',$ingest);

		$this->db->where('idIngestParceiro',$ingestParceiro['idIngestParceiro']);
		$this->db->update('tbl_ingestParceiro',$ingestParceiro);

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

	function updateInfoParceiro($ingestParceiro,$ingest){

		//start the transaction
		$this->db->trans_begin();

			$this->db->where('idIngestParceiro',$ingestParceiro['idIngestParceiro']);
			$this->db->update('tbl_ingestParceiro',$ingestParceiro);

			if($ingestParceiro['statusIngest'] == 'CANCELADO'){
				$this->db->where('idIngest',$ingest['idIngest']);
				$this->db->update('tbl_ingest',$ingest);

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


	function deleteIngestParceiro($idIngest){
		//start the transaction
		$this->db->trans_begin();

			//Ingest
			$revisao = $this->revisaoDao->selectIdRevisao($idIngest);
			if(count($revisao)>0){
				$this->revisaoDao->deleteRevisaoParceiro($idIngest,$revisao[0]->idRevisao);
			}

			//ingest Parceiro
			$this->db->where('ingest_id',$idIngest);
			$this->db->delete('tbl_ingestParceiro');

			//ingest
			$this->db->where('idIngest',$idIngest);
			$this->db->delete('tbl_ingest');



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
