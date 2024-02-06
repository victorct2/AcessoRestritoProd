<?php

Class ProgramacaoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarProgramacao($limit = null,$offset = null){
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$offset);
		return $this->db->get('programacao')->result();
	}

	function make_query(){
		$order_column = array(null,null,"programa","dia","hrinicial","hrfinal","tema","descricao", null, null);
		$this->db->select('*');
		$this->db->from('programacao');

		if(!empty($_POST['columns'][1]["search"]["value"])){
			if($_POST['columns'][1]["search"]["value"] == "Ciência & Letras"){
				$titulo = "Ciência e Letras";
			}else{
				$titulo = $_POST['columns'][1]["search"]["value"];
			}
			$this->db->like("programa", $titulo);
		}

		if(!empty($_POST['columns'][3]["search"]["value"])){

			$this->db->or_like("tema", $_POST['columns'][3]["search"]["value"]);
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){

			$this->db->or_like("descricao", $_POST['columns'][4]["search"]["value"]);
		}

		if(!empty($_POST['columns'][2]["search"]["value"])){

			$this->db->where("dia", $_POST['columns'][2]["search"]["value"]);
		}

		switch ($_POST['columns'][5]["search"]["value"]) {
			case 'ATIVO':
				$this->db->where("ativo", 'S');
				break;
			case 'INATIVO':
				$this->db->where("ativo", 'N');
				break;
			case 'DESTAQUE':
				$this->db->where("destaque", 'S');
				break;
			case 'SEMDESTAQUE':
				$this->db->where("destaque", 'N');
				break;
			case 'INEDITO':
				$this->db->where("inedito", 'S');
				break;
			case 'SEMINEDITO':
				$this->db->where("inedito", 'N');
				break;
			default:
				
				break;
			
		}


		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('dia DESC, hrinicial ASC');
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
		$this->db->from('programacao');
		return $this->db->count_all_results();

	}


	function verifyNotExist($data){
		$this->db->where('ativo',$data['ativo']);
		$this->db->where('dia',$data['dia']);
		$this->db->where('hrinicial',$data['hrinicial']);
		$this->db->where('hrfinal',$data['hrfinal']);
		$this->db->where('tema',$data['tema']);
		$this->db->where('programa',$data['programa']);
		$this->db->from('programacao');
		$resultado =  $this->db->get()->result();
		if(count($resultado)>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function todosOsProgramas(){
		$this->db->order_by('titulo','asc');
		$this->db->select('titulo');
		$arrayProgramas =  $this->db->get('tb_programa')->result();

		$this->db->order_by('nomePrograma','asc');
		$this->db->select('nomePrograma AS titulo');
		$arrayParceiros =  $this->db->get('tbl_programasParceiros')->result();

		return array_merge($arrayProgramas, $arrayParceiros);
	}

	function selectImagePrograma($titulo){
		//if($titulo == "Ciência e Letras"){
			//$titulo = "Ciência & Letras";
		//}

		
		$this->db->where('titulo',$titulo);
		$this->db->select('imagem');
		$dadosImagem =  $this->db->get('tb_programa')->result();
		if(count($dadosImagem) > 0){
			//echo IMAGEM_PROGRAMA.$dadosImagem[0]->imagem;
			return IMAGEM_PROGRAMA.$dadosImagem[0]->imagem;
		}else{

			$this->db->where('nomePrograma',$titulo);
			$this->db->select('tbl_programasParceiros.imagem AS imagemPrograma,tbl_parceiros.imagem AS imagemParceiro');
			$this->db->from('tbl_parceiros');
			$this->db->join('tbl_programasParceiros','tbl_programasParceiros.parceiros_id = tbl_parceiros.idParceiros');
			$dadosImagemParceiros =  $this->db->get()->result();
			if(count($dadosImagemParceiros) > 0){
				//echo IMAGEM_PROGRAMA.$dadosImagem[0]->imagem;
				if($dadosImagemParceiros[0]->imagemPrograma == '' || $dadosImagemParceiros[0]->imagemPrograma == null){
					return IMAGEM_PARCEIRO.$dadosImagemParceiros[0]->imagemParceiro;
				}else{
						return IMAGEM_PROGRAMA_PARCEIRO.$dadosImagemParceiros[0]->imagemPrograma;
				}

			}
		}
		return SEM_IMAGEM;

	}

	/*
	** Adicionar programacao
	*/
	function insertProgramacao($data){
		return $this->db->insert('programacao',$data);
	}

	/*
	** Gravar Alteração de Programação
	*/
	function updateProgramacao($data){
		$this->db->where('id',$data['id']);
		return $this->db->update('programacao',$data);
	}

	function updateIneditoTrue($id){
		$this->db->where('id',$id);
		$result =  $this->db->get('programacao')->result();
		$inedito = '';

		if($result[0]->inedito != ''){
			if($result[0]->inedito == 'S'){
				$inedito = 'N';
			}else if($result[0]->inedito == 'N'){
				$inedito = 'S';
			}
		}else{
			$inedito = 'S';
		}

		$data = array(
			'inedito' => $inedito
		);
		$this->db->where('id',$id);
		return $this->db->update('programacao',$data);
	}

	function updateDestaqueTrue($id){
		$this->db->where('id',$id);
		$result =  $this->db->get('programacao')->result();
		$destaque = '';

		if($result[0]->destaque != ''){
			if($result[0]->destaque == 'S'){
				$destaque = 'N';
			}else if($result[0]->destaque == 'N'){
				$destaque = 'S';
			}
		}else{
			$destaque = 'S';
		}
		

		$data = array(
			'destaque' => $destaque
		);
		$this->db->where('id',$id);
		return $this->db->update('programacao',$data);
	}

	/*
	** Select Programação por ID
	*/
	function selectProgramacaoById($id){
		$this->db->where('id',$id);
		return $this->db->get('programacao')->result();
	}

	/*
	** Excluir programacao
	*/
	function deleteProgramacao($id){
		$this->db->where('id',$id);
		return $this->db->delete('programacao');
	}

	function deleteProgramacaoPorPeriodo($dataInicial, $dataFinal){
		$this->db->where('dia BETWEEN "'.$dataInicial.'" AND "'.$dataFinal.'"', NULL,FALSE);
		return $this->db->delete('programacao');
	}

}

?>
