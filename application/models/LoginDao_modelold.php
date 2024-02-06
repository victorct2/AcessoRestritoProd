<?php 

Class LoginDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}


	function loginUser($idUsuario){		
		$this->db->where('usuarios.ativo','S');			
		$this->db->where("BINARY login='". $data['login']."'",NULL,FALSE);
		$this->db->where('senha',$data['senha']);
		$this->db->group_by('usuarios.id');
		$this->db->select('usuarios.id as idUsuario,usuarios.nome as nomeUsuario,email,cargo, usuarios.password_alterado, login,GROUP_CONCAT(usuarios_grupos.idGrupo) as grupos,avatar');	
		$this->db->from('usuarios');
		$this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id');
		return $this->db->get()->result();
	}
}

?>