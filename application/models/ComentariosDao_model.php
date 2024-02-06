<?php

Class ComentariosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    

	function totalComentarios($ativos = false, $inativos= false,$liberar= false){
		if($ativos == true){
			$this->db->where('ativo','S');
		}
		if($inativos == true){
			$this->db->where('ativo','N');
		}
		if($liberar == true){
			$this->db->where('ativo','AC');
		}
		return $this->db->get('videos_comentarios')->num_rows();
	}

	function make_query(){
		$order_column = array("idComentario","nomeUsuario",null, null, "videos_comentarios.data_cadastro",null,null,null);
		//$this->db->group_by('usuarios.id');
		$this->db->select('id_comentario as idComentario,usuarios.nome as nomeUsuario,usuarios.id as idUsuario,tb_video.nome as nomeVideo, tb_video.id as idVideo,tb_video.friendly_url, comentario, videos_comentarios.data_cadastro, videos_comentarios.ativo');
		$this->db->from('videos_comentarios');
		$this->db->join('usuarios','usuarios.id = videos_comentarios.id_usuario');
		$this->db->join('tb_video','tb_video.id = videos_comentarios.id_video');


		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->where("nomeUsuario", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("nomeVideo", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->like("comentario", $_POST['columns'][3]["search"]["value"]);  	
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("videos_comentarios.data_cadastro", $_POST['columns'][4]["search"]["value"]);
		}

		switch ($_POST['columns'][6]["search"]["value"]) {
			case 'S':
				$this->db->where("videos_comentarios.ativo", 'S');
				break;
			case 'N':
				$this->db->where("videos_comentarios.ativo", 'N');
				break;
			case 'AC':
				$this->db->where("videos_comentarios.ativo", 'AC');
				break;
			default:
				
				break;
			
		}

		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('idComentario DESC', 'videos_comentarios.data_cadastro DESC');
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
		$this->db->from('videos_comentarios');
		return $this->db->count_all_results();
    }

	function liberarComentarioBD($idComentario){
		$arrayComentario = array(
			'ativo' => 'S'
		);
		$this->db->where('id_comentario',$idComentario);
		return $this->db->update('videos_comentarios',$arrayComentario);
	}

	function negarComentarioBD($idComentario){
		$arrayComentario = array(
			'ativo' => 'N'
		);
		$this->db->where('id_comentario',$idComentario);
		return $this->db->update('videos_comentarios',$arrayComentario);
	}

}

?>
