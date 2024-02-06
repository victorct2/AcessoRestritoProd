<?php 

Class UsuariosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarUsuarios($limit = null,$offset = null){
		$this->db->order_by('id','desc');
		$this->db->limit($limit,$offset);
		return $this->db->get('usuarios')->result();
	}

	function totalUsuarios($ativos = false, $inativos= false){
		if($ativos == true){
			$this->db->where('ativo','S');
		}
		if($inativos == true){
			$this->db->where('ativo','N');
		}
		return $this->db->get('usuarios')->num_rows();
	}

	function make_query(){
		$order_column = array("id","usuarios.nome","login", "grupos.nome", "email",null,null);
		$this->db->group_by('usuarios.id');
		$this->db->select('usuarios.id,usuarios.nome,login,GROUP_CONCAT(grupos.nome) AS nome_grupo, email,cargo,profissao,freelancer,ativo');
		$this->db->from('usuarios');
		//$this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id');
		//$this->db->join('grupos','usuarios_grupos.idGrupo = grupos.id');
        $this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id','LEFT');
		$this->db->join('grupos','usuarios_grupos.idGrupo = grupos.id','LEFT');

		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->where("usuarios.id", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("usuarios.nome", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->like("login", $_POST['columns'][3]["search"]["value"]);  	
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("usuarios.grupo", $_POST['columns'][4]["search"]["value"]);
		}
		if(!empty($_POST['columns'][5]["search"]["value"])){
			$this->db->like("email", $_POST['columns'][5]["search"]["value"]);
		}

		switch ($_POST['columns'][6]["search"]["value"]) {
			case 'ATIVO':
				$this->db->where("ativo", 'S');
				break;
			case 'INATIVO':
				$this->db->where("ativo", 'N');
				break;
			
			default:
				
				break;
			
		}

		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('usuarios.nome');
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
		$this->db->from('usuarios');  
		return $this->db->count_all_results();  
    }

	function selectUsuarioById($id){
		$this->db->where("id",$id);  
		return $this->db->get('usuarios')->result();  
	}

	function selectGruposUsuarioById($id){	
		$this->db->where("idUsuario",$id);  
		$this->db->select("idGrupo");  
		return $this->db->get('usuarios_grupos')->result();  
	}

	function selectProgramasUsuarioById($id){
		$this->db->where("idUsuario",$id);
		$this->db->select("idPrograma");
		return $this->db->get('tb_usuario_programa')->result();
	}

	function selectPasswordUser($idUsuario, $login){
		$this->db->where("BINARY login='". $login."'",NULL,FALSE);
		$this->db->where("id",$idUsuario);  
		$this->db->select('senha');
		return $this->db->get('usuarios')->result();
	}


	function usuariosAjustes(){
		$this->db->select("id,grupo");  
		return $this->db->get('usuarios')->result();  
	}

	function insertUsuariosGrupo($data){
		return $this->db->insert('usuarios_grupos',$data);
	}

	function login_disponivel($login) {
		$this->db->where('login',$login);	
		return $this->db->get('usuarios')->result();		
	}

	function insertUsuario($data,$grupos,$programas){
		//start the transaction
        $this->db->trans_begin();

		$this->db->insert('usuarios',$data);
		$idUsuario = $this->db->insert_id();
		foreach ($grupos as $value) {
			$grupo = array(
				'idUsuario' => $idUsuario,
				'idGrupo' => $value
			);
			$this->db->insert('usuarios_grupos',$grupo);
		}

		foreach ($programas as $prog) {
			$programa = array(
				'idUsuario' => $idUsuario,
				'idPrograma' => $prog
			);
			$this->db->insert('tb_usuario_programa',$programa);
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

	function updateUsuario($data,$grupos,$programas){
		//start the transaction
        $this->db->trans_begin();

		$this->db->where('id',$data['id']);
		$this->db->update('usuarios',$data);

		$this->db->where('idUsuario',$data['id']);
		$this->db->delete('usuarios_grupos');

		$this->db->where('idUsuario',$data['id']);
		$this->db->delete('tb_usuario_programa');

		foreach ($grupos as $value) {
			$grupo = array(
				'idUsuario' => $data['id'],
				'idGrupo' => $value
			);
			$this->db->insert('usuarios_grupos',$grupo);
		}

		foreach ($programas as $prog) {
			$programa = array(
				'idUsuario' => $data['id'],
				'idPrograma' => $prog
			);
			$this->db->insert('tb_usuario_programa',$programa);
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

	function updatePerfil($data){
		$this->db->where('id',$data['id']);	
		return $this->db->update('usuarios',$data);
	}

	function updateAvatar($id, $avatar){
		$data = array(			
			'avatar' => $avatar
		);
		$this->db->where('id',$id);	
		return $this->db->update('usuarios',$data);
	}


	/**
	 * Excluir Usuário
	 */
	function deleteUsuario($id){	

		//start the transaction
        $this->db->trans_begin();

		$this->db->where('id',$id);	
		$this->db->delete('usuarios');

		$this->db->where('idUsuario',$id);	
		$this->db->delete('usuarios_grupos');


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