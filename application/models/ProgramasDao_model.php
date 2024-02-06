<?php 

Class ProgramasDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarProgramas(){
		$this->db->order_by('titulo','asc');
		return $this->db->get('tb_programa')->result();
	}

	function make_query(){  
		$order_column = array(null,"titulo","sigla","descricao", null, null);  
		$this->db->select('*');  
		$this->db->from('tb_programa');

		if(!empty($_POST['columns'][1]["search"]["value"])){
			if($_POST['columns'][1]["search"]["value"] == "Ciência & Letras"){
				$titulo = "Ciência e Letras";
			}else{
				$titulo = $_POST['columns'][1]["search"]["value"];
			}
			$this->db->like("titulo", $titulo);
		}

		if(!empty($_POST['columns'][2]["search"]["value"])){

			$this->db->where("sigla", $_POST['columns'][2]["search"]["value"]);
		}

		if(!empty($_POST['columns'][3]["search"]["value"])){

			//$this->db->where("descricao", $_POST['columns'][3]["search"]["value"]);
			$this->db->like("descricao", $_POST['columns'][3]["search"]["value"]);
		}

		

		switch ($_POST['columns'][4]["search"]["value"]) {
			case 'ATIVO':
				$this->db->where("ativo", 'S');
				break;
			case 'INATIVO':
				$this->db->where("ativo", 'N');
				break;
			case 'NOSITE':
				$this->db->where("site_novo", 'S');
				break;
			case 'FORASITE':
				$this->db->where("site_novo", 'N');
				break;
			default:				
				break;
			
		}


		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('id', 'ASC');  
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
		$this->db->from('tb_programa');  
		return $this->db->count_all_results();  
    }

	function selectProgramaById($idPrograma){
        $this->db->where('id',$idPrograma);
		return $this->db->get('tb_programa')->result();
	}

	/*
	** VERIFICANDO NO BANCO SE EXISTE O TÍTULO A SER CADASTRADO
	*/
	function titulo_disponivel($titulo) {
		$this->db->where('titulo',$titulo);
		return $this->db->get('tb_programa')->result();		
	}

	/*
	** Adicionar Programa
	*/
	function insertPrograma($data){	
	 	return $this->db->insert('tb_programa',$data);	
	}

	/*
	** Gravar Alteração de Programa
	*/
	function updatePrograma($data){	
		$this->db->where('id',$data['id']);			
		return $this->db->update('tb_programa',$data);
	}

	/*
	** Excluir Programa
	*/
	function deletePrograma($idPrograma){		
		$this->db->where('id',$idPrograma);	
		return $this->db->delete('tb_programa');
	}



}

?>