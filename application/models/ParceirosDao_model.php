<?php

Class ParceirosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function selectProgramasParceiros(){
		$this->db->order_by('idParceiros','desc');
		return $this->db->get('tbl_parceiros')->result();
	}

	function selectSerieParceiros($idParceiro){
		$this->db->where('parceiros_id',$idParceiro);
		#$this->db->order_by('idProgramasParceiros','desc');
		$this->db->order_by('sigla','nomePrograma');
			return $this->db->get('tbl_programasParceiros')->result();
		}

		function make_query_AreaParceiros(){
			$order_column = array(null,"nomeParceiro","descriao",null);
			$this->db->select('*');
			$this->db->from('tbl_parceiros');

			if(!empty($_POST['columns'][1]["search"]["value"])){
				$this->db->where("idParceiros", $_POST['columns'][1]["search"]["value"]);
			}
			if(!empty($_POST['columns'][2]["search"]["value"])){
				$this->db->or_like("descricao", $_POST['columns'][3]["search"]["value"]);
			}

			switch ($_POST['columns'][3]["search"]["value"]) {
				case 'ATIVO':
					$this->db->where("ativo", 'S');
					break;
				case 'INATIVO':
					$this->db->where("ativo", 'N');
					break;
				case 'SITE':
					$this->db->where("site", 'S');
					break;
				case 'FORASITE':
					$this->db->where("site", 'N');
					break;
				default:

					break;

			}

			if(isset($_POST["order"])){
				$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			}
			else{
				$this->db->order_by('idParceiros DESC, nomeParceiro ASC');
			}
		}

		function make_datatables_AreaParceiros(){
			$this->make_query_AreaParceiros();
			if($_POST["length"] != -1){
				$this->db->limit($_POST['length'], $_POST['start']);
			}
			$query = $this->db->get();
			return $query->result();
	    }

		function get_filtered_data_AreaParceiros(){
			$this->make_query_AreaParceiros();
			$query = $this->db->get();
			return $query->num_rows();
	    }

		function get_all_data_AreaParceiros(){
			$this->db->select("*");
			$this->db->from('tbl_parceiros');
			return $this->db->count_all_results();
		}

		function autorizar($data){
			return $this->db->insert('tbl_autorizacao',$data);
		}

		function autorizarClosedCaption($data){
			$this->db->where('idAutorizacao',$data['idAutorizacao']);
			return $this->db->update('tbl_autorizacao',$data);
		}

		function deleteAutorizacao($idIngest,$idAutorizacao){
			$this->db->where('idAutorizacao',$idAutorizacao);
			$this->db->where('ingest_id',$idIngest);
			return $this->db->delete('tbl_autorizacao');
		}

		function selectIdAutorizacao($idIngest){
			$this->db->where('ingest_id',$idIngest);
			$this->db->select('idAutorizacao');
			return $this->db->get('tbl_autorizacao')->result();
		}

		function verificarParceiro($nome){
			$this->db->where('nomeParceiro',$nome);
			return $this->db->get('tbl_parceiros')->result();
		}

		function verificarProgramaParceiro($nome){
			$this->db->where('nomePrograma',$nome);
			return $this->db->get('tbl_programasParceiros')->result();
		}

		function selectParceiroById($idParceiro){
			$this->db->where('idParceiros',$idParceiro);
			return $this->db->get('tbl_parceiros')->result();
		}

		function selectProgramaParceiroById($idProgramaParceiro){
			$this->db->where('idProgramasParceiros',$idProgramaParceiro);
			return $this->db->get('tbl_programasParceiros')->result();
		}

		function insertParceiro($data){
			return $this->db->insert('tbl_parceiros',$data);
		}

		function insertProgramaParceiro($data){
			return $this->db->insert('tbl_programasParceiros',$data);
		}

		function updateParceiro($data){
			$this->db->where('idParceiros',$data['idParceiros']);
			return $this->db->update('tbl_parceiros',$data);
		}

		function updateProgramaParceiro($data){
			$this->db->where('idProgramasParceiros',$data['idProgramasParceiros']);
			return $this->db->update('tbl_programasParceiros',$data);
		}

		function updateAtivarSite($idParceiros){
			$this->db->where('idParceiros',$idParceiros);
			$result =  $this->db->get('tbl_parceiros')->result();
			$ativarSite = '';

			if($result[0]->site != ''){
				if($result[0]->site == 'S'){
					$ativarSite = 'N';
				}else if($result[0]->site == 'N'){
					$ativarSite = 'S';
				}
			}else{
				$ativarSite = 'S';
			}

			$data = array(
				'site' => $ativarSite
			);
			$this->db->where('idParceiros',$idParceiros);
			return $this->db->update('tbl_parceiros',$data);
		}

		function deleteParceiros($idParceiro){
			//start the transaction
			$this->db->trans_begin();

				$this->db->where('parceiros_id',$parceiros_id);
				$this->db->delete('tbl_programasParceiros');

				$this->db->where('idParceiros',$idParceiro);
				$this->db->delete('tbl_parceiros');

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

		function deleteProgramaParceiros($idProgramaParceiro){
			$this->db->where('idProgramasParceiros',$idProgramaParceiro);
			return $this->db->delete('tbl_programasParceiros');
	}

	function excluir($data){
		return $this->db->insert('tbl_exclusao',$data);
	}

	function excluirClosedCaption($data){
		$this->db->where('idExclusao',$data['idExclusao']);
		return $this->db->update('tbl_exclusao',$data);
	}


	/*================== Totais ========================*/

	function selectTotalCorrecao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevisao','R');
		$this->db->select('count(parceiro_id) as totalCorrecao');
		$this->db->from('tbl_parceiros');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.parceiro_id = tbl_parceiros.idParceiros');
		$this->db->join('tbl_ingest','tbl_ingest.IdIngest = tbl_ingestParceiro.ingest_id');
		$this->db->join('tbl_revisao','tbl_revisao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalRevisao($idParceiro){
		$this->db->where('statusIngest','LIBERADO');
		$this->db->where('dataFim !=',null);
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('(dataRevisao is null  or statusRevisao = "C")',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalRevisao');
		$this->db->from('tbl_revisao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_revisao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalFichaConclusao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		//$this->db->where('statusRevisaoClosedCaption','A');
		$this->db->where('(closedCaption = "N"  or statusRevisaoClosedCaption = "A")',NULL,FALSE);
		$this->db->where('dataFichaConclusao is null',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalFichaConclusao');
		$this->db->from('tbl_fichaConclusao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_fichaConclusao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_revisao','tbl_revisao.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		$this->db->join('tbl_revisaoClosedCaption','tbl_revisaoClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		return $this->db->get()->result();
	}

	function selectTotalCatalogacao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('dataFichaConclusao !=',null);
		$this->db->where('dataFimCatalogacao is null',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalCatalogacao');
		$this->db->from('tbl_catalogacao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_catalogacao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_fichaConclusao','tbl_fichaConclusao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalRevisaoCatalogacao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		//$this->db->where('dataFimCatalogacao != null',NULL,FALSE);
		$this->db->where('dataFimCatalogacao !=', null);
		$this->db->where('(dataRevisaoCatalogacao is null  or statusRevCatalog = "C")',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalRevisaoCatalogacao');
		$this->db->from('tbl_revisaoCatalogacao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_revisaoCatalogacao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalCorrecaoCatalogacao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevCatalog', 'R');
		$this->db->select('count(parceiro_id) as totalCorrecaoCatalogacao');
		$this->db->from('tbl_revisaoCatalogacao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_revisaoCatalogacao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalAutorizacao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('dataFimCatalogacao !=',null);
		$this->db->where('(dataAutorizacao is null)',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalAutorizacao');
		$this->db->from('tbl_autorizacao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_autorizacao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}



	function selectTotalExclusao($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevCatalog', 'A');
		$this->db->where('(dataExclusao is null)',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalExclusao');
		$this->db->from('tbl_exclusao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_exclusao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_revisaoCatalogacao','tbl_revisaoCatalogacao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}



	function selectTotalIngestClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevisao','A');
		$this->db->where('closedCaption',null);
		//$this->db->where('(closedCaption is null OR closedCaption)',NULL,FALSE);
		$this->db->where('(dataIngestClosedCaption is null)',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalIngestClosedCaption');
		$this->db->from('tbl_parceiros');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.parceiro_id = tbl_parceiros.idParceiros');
		$this->db->join('tbl_ingest','tbl_ingest.IdIngest = tbl_ingestParceiro.ingest_id');
		$this->db->join('tbl_revisao','tbl_revisao.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		return $this->db->get()->result();
	}

	function selectTotalRevisaoClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevisao','A');
		$this->db->where('closedCaption','S');
		$this->db->where('dataIngestClosedCaption !=',null);
		$this->db->where('(dataRevisaoClosedCaption is null  or statusRevisaoClosedCaption = "C")',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalRevisaoClosedCaption');
		$this->db->from('tbl_parceiros');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.parceiro_id = tbl_parceiros.idParceiros');
		$this->db->join('tbl_ingest','tbl_ingest.IdIngest = tbl_ingestParceiro.ingest_id');
		$this->db->join('tbl_revisao','tbl_revisao.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		$this->db->join('tbl_revisaoClosedCaption','tbl_revisaoClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		return $this->db->get()->result();
	}

	function selectTotalCorrecaoIngestClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevisao','A');
		$this->db->where('closedCaption','S');
		$this->db->where('statusRevisaoClosedCaption','R');
		$this->db->select('count(parceiro_id) as totalCorrecaoClosedCaption');
		$this->db->from('tbl_parceiros');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.parceiro_id = tbl_parceiros.idParceiros');
		$this->db->join('tbl_ingest','tbl_ingest.IdIngest = tbl_ingestParceiro.ingest_id');
		$this->db->join('tbl_revisao','tbl_revisao.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		$this->db->join('tbl_revisaoClosedCaption','tbl_revisaoClosedCaption.ingest_id = tbl_ingest.idIngest','LEFT');
		return $this->db->get()->result();
	}

	function selectTotalCatalogacaoClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('closedCaption','S');
		$this->db->where('dataIngestClosedCaption > dataFimCatalogacao',NULL,FALSE);
		$this->db->where('dataCatalogacaoClosedCaption is null',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalCatalogacaoClosedCaption');
		$this->db->from('tbl_catalogacao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_catalogacao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalAutorizacaoClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('closedCaption','S');
		$this->db->where('dataIngestClosedCaption > dataAutorizacao',NULL,FALSE);
		$this->db->where('dataCatalogacaoClosedCaption !=',null);
		$this->db->where('(dataAutorizacaoClosedCaption is null)',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalAutorizacaoClosedCaption');
		$this->db->from('tbl_autorizacao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_autorizacao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_ingestClosedCaption','tbl_ingestClosedCaption.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalRevisaoCatalogacaoClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('dataCatalogacaoClosedCaption !=',null);
		$this->db->where('(dataRevisaoCatalogacaoClosedCaption is null  or statusRevisaoCatalogacaoClosedCaption = "C")',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalRevisaoCatalogacaoClosedCaption');
		$this->db->from('tbl_revisaoCatalogacaoClosedCaption');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_revisaoCatalogacaoClosedCaption.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}


	function selectTotalCorrecaoCatalogacaoClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevisaoCatalogacaoClosedCaption', 'R');
		$this->db->select('count(parceiro_id) as totalCorrecaoCatalogacaoClosedCaption');
		$this->db->from('tbl_revisaoCatalogacaoClosedCaption');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_revisaoCatalogacaoClosedCaption.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_catalogacao','tbl_catalogacao.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}

	function selectTotalExclusaoClosedCaption($idParceiro){
		$this->db->where('parceiro_id',$idParceiro);
		$this->db->where('statusRevisaoCatalogacaoClosedCaption', 'A');
		$this->db->where('(dataExclusaoClosedCaption is null)',NULL,FALSE);
		$this->db->select('count(parceiro_id) as totalExclusaoClosedCaption');
		$this->db->from('tbl_exclusao');
		$this->db->join('tbl_ingest','tbl_ingest.idIngest = tbl_exclusao.ingest_id','RIGHT');
		$this->db->join('tbl_ingestParceiro','tbl_ingestParceiro.ingest_id = tbl_ingest.idIngest');
		$this->db->join('tbl_revisaoCatalogacaoClosedCaption','tbl_revisaoCatalogacaoClosedCaption.ingest_id = tbl_ingest.idIngest');
		return $this->db->get()->result();
	}



}

?>
