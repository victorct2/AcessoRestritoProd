<?php 

Class LoginDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}


	function loginUser($data){		
		$this->db->where('usuarios.ativo','S');			
		$this->db->where("BINARY login='". $data['login']."'",NULL,FALSE);
		$this->db->where('senha',$data['senha']);
		$this->db->group_by('usuarios.id');
		$this->db->select('usuarios.id as idUsuario,usuarios.nome as nomeUsuario,email,cargo, usuarios.password_alterado, login,GROUP_CONCAT(usuarios_grupos.idGrupo) as grupos,avatar');	
		$this->db->from('usuarios');
		$this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id');
		return $this->db->get()->result();
	}

	function loginUserAlterar($data){		
		$this->db->where('usuarios.ativo','S');			
		$this->db->where("BINARY login='". $data['login']."'",NULL,FALSE);
		$this->db->where('senha',$data['senha']);
		$this->db->group_by('usuarios.id');
		$this->db->select('usuarios.id as idUsuario,usuarios.nome as nomeUsuario, usuarios.login as login, email,cargo, usuarios.password_alterado as newP, login,GROUP_CONCAT(usuarios_grupos.idGrupo) as grupos,avatar');	
		$this->db->from('usuarios');
		$this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id');
		return $this->db->get()->result();
	}

	function updateUsuario($data){
		//start the transaction
        $this->db->trans_begin();

		$this->db->where('id',$data['id']);
		$this->db->update('usuarios',$data);
		

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