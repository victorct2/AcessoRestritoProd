<?php 

Class SlideShowDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function make_query(){

		$order_column = array(null,"nome","descricao","url","ativo", null);
		$this->db->select('*');
		$this->db->from('slideshow');


		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("nome", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->or_like("descricao", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->or_like("url", $_POST['columns'][3]["search"]["value"]);  	
		}

		switch ($_POST['columns'][4]["search"]["value"]) {
			case 'S':
				$this->db->where("ativo", 'S');
				break;
			case 'N':
				$this->db->where("ativo", 'N');
				break;
			default:
				
				break;
			
		}

		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('id', 'DESC');
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
		$this->db->from('slideshow');
		return $this->db->count_all_results();
    }

	/*
	** VERIFICANDO NO BANCO SE EXISTE O NOME A SER CADASTRADO
	*/
	function nome_disponivel($nome) {
		$this->db->where('nome',$nome);
		return $this->db->get('slideshow')->result();		
	}

	
	function slideShowById($id) {
		$this->db->where('id',$id);
		return $this->db->get('slideshow')->result();		
	}

	/*
	** Adicionar Slideshow
	*/
	function insertSlide($data){	
		return $this->db->insert('slideshow',$data);	
	}

	/*
	** Gravar Alteração de SlideShow
	*/
	function updateSlide($data){	
		$this->db->where('id',$data['id']);			
		return $this->db->update('slideshow',$data);
	}

	/*
	** Excluir Slideshow
	*/
	function deleteSlide($id){		
		$this->db->where('id',$id);	
		return $this->db->delete('slideshow');
	}

	

}

?>