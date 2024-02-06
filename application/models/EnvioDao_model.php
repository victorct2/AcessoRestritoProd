<?php 

Class EnvioDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	 function listarGrupos(){
		$this->db->order_by('nome','asc');		
		$this->db->where('id','49');
        return $this->db->get('grupos')->result();
	}

    function listarCooperado($limit = null,$offset = null){
		
$this->db->select('usuarios.id,usuarios.nome');
$this->db->from('usuarios');
$this->db->join('usuarios_grupos','usuarios.id = usuarios_grupos.idUsuario');
$this->db->where('usuarios_grupos.idGrupo','49');
$this->db->where('usuarios.ativo','S');
return $this->db->get()->result();
	}

	function listarSituacao(){
		$this->db->order_by('descricao');
		$this->db->where('ativa','S');
		return $this->db->get('tipo_arquivo')->result();
	}

	function selectUsuarioById($id){
		$this->db->where('id', $id);
		return $this->db->get('usuarios')->result();	
    }

    function selectArquivoById($id){
		$this->db->where('id', $id);
		return $this->db->get('usuarios')->result();	
    }
	/*
	** Adicionar Figurino
    */

    /*function insertArquivo($data){	
		return $this->db->insert('arquivo_upload',$data);	
	}*/
	
	function insertArquivo($data){	
		return $this->db->insert('arquivo_upload_usuario',$data);	
	}

	/*function insertRestrito($data2){	
		return $this->db->insert('cooperado_arquivo',$data2);	
	}*/
	
	function insertRestrito($data2){	
		return $this->db->insert('cooperado_arquivo_envio',$data2);	
	}

	function insertTipoArquivo($data){	
		return $this->db->insert('tipo_arquivo',$data);	
	}

	
	/*function completar_cadastro($nome_arquivo,$arquivo,$id){	
		$this->db->where('id',$id);	
		$this->db->set('nome_arquivo', $nome_arquivo);
		$this->db->set('arquivo', $arquivo);
		return $query = $this->db->update('arquivo_upload');		
	}*/
	
	function completar_cadastro($nome_arquivo,$arquivo,$id){	
		$this->db->where('id',$id);	
		$this->db->set('nome_arquivo', $nome_arquivo);
		$this->db->set('arquivo', $arquivo);
		return $query = $this->db->update('arquivo_upload_usuario');		
	}

	 function listarUsuarios($limit = null,$offset = null){
		$this->db->order_by('idUsuario','desc');
		$this->db->where('idGrupo','49');
		$this->db->limit($limit,$offset);
		return $this->db->get('usuarios_grupos')->result();
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

		$gruposArray = $this->session->userdata('grupos');
		if(in_array("50",$gruposArray))
		{
		$order_column = array("id","usuarios.nome","login", "email");
		$this->db->group_by('usuarios.id');
		$this->db->select('usuarios.id,usuarios.nome,login, email');
		$this->db->from('usuarios');
		$this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id');
		$this->db->join('grupos','usuarios_grupos.idGrupo = grupos.id');
        $this->db->where('usuarios_grupos.idGrupo','49');
        }else{
        $order_column = array("id","usuarios.nome","login", "email");
		$this->db->group_by('usuarios.id');
		$this->db->select('usuarios.id,usuarios.nome,login, email');
		$this->db->from('usuarios');
		$this->db->join('usuarios_grupos','usuarios_grupos.idUsuario = usuarios.id');
		$this->db->join('grupos','usuarios_grupos.idGrupo = grupos.id');
        $this->db->where('usuarios_grupos.idGrupo','49');
        $this->db->where('usuarios.id',$this->session->userdata("idUsuario"));
    }		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->where("usuarios.id", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("usuarios.nome", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->like("login", $_POST['columns'][3]["search"]["value"]);  	
		}
		
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->like("email", $_POST['columns'][4]["search"]["value"]);
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
		$this->db->from('usuarios');  
		return $this->db->count_all_results();  
    }
    function selectArquivoUsuario($id=0){
		$order_column = array("nome as descr","arquivo_upload_usuario.nome_arquivo","arquivo_upload_usuario.arquivo","arquivo_upload_usuario.Data_cadastro");
		$this->db->select('nome, login, id_user,id_arquivo,nome_arquivo, arquivo, arquivo_upload_usuario.Descricao, Data_cadastro, tipo_arquivo.descricao as descr, tipo_arquivo.id as  id');
		$this->db->from('cooperado_arquivo_envio');
		$this->db->order_by('Data_cadastro','desc');
		$this->db->join('usuarios','cooperado_arquivo_envio.id_user = usuarios.id');
		$this->db->join('arquivo_upload_usuario','cooperado_arquivo_envio.id_arquivo = arquivo_upload_usuario.id');
		$this->db->join('tipo_arquivo','arquivo_upload_usuario.tipo_arquivo = tipo_arquivo.id','left');
		$gruposArray = $this->session->userdata('grupos');
		if(!in_array("50",$gruposArray)){
			$id_user = $this->session->userdata('idUsuario');
			$this->db->where('usuarios.id',$id_user);
		}else{			$this->db->where('cooperado_arquivo_envio.id_user',$id);
		}
		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("nome", $_POST['columns'][1]["search"]["value"]);  
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->like("nome_arquivo", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->like("arquivo", $_POST['columns'][3]["search"]["value"]);  	
		}
		
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->like("Data_cadastro", $_POST['columns'][4]["search"]["value"]);
		}
		
		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}

		else{
			$this->db->order_by('Data_cadastro', 'DESC');
		}
				
			
		}

    function make_datatables2($id){  
		$this->selectArquivoUsuario($id);  
		if($_POST["length"] != -1){  
			$this->db->limit($_POST['length'], $_POST['start']); 
			

		}  
		$query = $this->db->get();  
		return $query->result();  
    } 

    
    function get_filtered_data2($id){  
		$this->selectArquivoUsuario($id);  
		$query = $this->db->get();  
		return $query->num_rows();  
    }

	

    function get_all_files($id){  
		$this->selectArquivoUsuario($id);  
		$query = $this->db->get();  
		return $this->db->count_all_results();  
    }

	function make_queryTipoArquivo(){  
		$order_column = array("id","descricao","ativa");  
		$this->db->select('*');  
		$this->db->from('tipo_arquivo');
		
		if(isset($_POST["search"]["value"])){  
			$this->db->like("id", $_POST["search"]["value"]);		
			$this->db->or_like("descricao", $_POST["search"]["value"]); 
			$this->db->or_like("ativa", $_POST["search"]["value"]);
			
		}  
		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('id', 'ASC');  
		}  
	}
function make_datatablesTipoArquivo(){  
		$this->make_queryTipoArquivo();  
		if($_POST["length"] != -1){  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}  
		$query = $this->db->get();  
		return $query->result();  
    } 

    function get_filtered_dataLista(){  
		$this->make_queryTipoArquivo();  
		$query = $this->db->get();  
		return $query->num_rows();  
    }

	function get_all_dataLista(){  
		$this->db->select("*");  
		$this->db->from('tipo_arquivo');  
		return $this->db->count_all_results();  
    }
	

	function selectTipoArquivoById($id){
		$this->db->where('id', $id);		
		return $this->db->get('tipo_arquivo')->result();
	}

		function deleteTipoArquivo($id){		
		$this->db->where('id',$id);	
		return $this->db->delete('tipo_arquivo');
	}		function deleteArquivo($id_arquivo){				$this->db->where('id',$id_arquivo);			return $this->db->delete('arquivo_upload_usuario');	}	

	function updateTipoArquivo($data){	
		$this->db->where('id',$data['id']);			
		return $this->db->update('tipo_arquivo',$data);
	}
	
	
	 function fetch_filter_type($type)
 {
  $this->db->distinct();
  $this->db->select($type);
  $this->db->from('tipo_arquivo');
  $this->db->join('arquivo_upload_usuario','arquivo_upload_usuario.tipo_arquivo = tipo_arquivo.id');
  $this->db->join('cooperado_arquivo_envio','cooperado_arquivo_envio.id_arquivo = arquivo_upload_usuario.id');
 $this->db->join('usuarios','cooperado_arquivo_envio.id_user = usuarios.id');
  $this->db->where('tipo_arquivo.ativa', 'S');
  return $this->db->get();
 }

 function make_query_descr($descricao,$id_user)
 {
	 $gruposArray = $this->session->userdata('grupos');
	
		
		if(!in_array("50",$gruposArray)){
			
		
  $query = "
   SELECT tipo_arquivo.descricao,tipo_arquivo.id,nome_arquivo, arquivo, ativa, DATE_FORMAT(Data_cadastro,'%d/%m/%Y') as Data_cadastro, id_user FROM tipo_arquivo 
  inner join arquivo_upload_usuario on arquivo_upload_usuario.tipo_arquivo = tipo_arquivo.id
  inner join cooperado_arquivo_envio on cooperado_arquivo_envio.id_arquivo = arquivo_upload_usuario.id
  left join usuarios on cooperado_arquivo_envio.id_user = usuarios.id
  WHERE ativa = 'S'    and cooperado_arquivo_envio.id_user in('".$this->session->userdata("idUsuario")."', 0  )
  
  ";

		}
		
	else{
		
	$query = "
  SELECT tipo_arquivo.descricao,tipo_arquivo.id,nome_arquivo, arquivo, ativa, DATE_FORMAT(Data_cadastro,'%d/%m/%Y') as Data_cadastro, id_user FROM tipo_arquivo 
  inner join arquivo_upload_usuario on arquivo_upload_usuario.tipo_arquivo = tipo_arquivo.id
  inner join cooperado_arquivo_envio on cooperado_arquivo_envio.id_arquivo = arquivo_upload_usuario.id
  left join usuarios on cooperado_arquivo_envio.id_user = usuarios.id
  WHERE ativa = 'S'    and cooperado_arquivo_envio.id_user in ('".$id_user."',0)  ";
		
		
	}

  if(isset($descricao))
  { 
   $descricao_filter = implode("','", $descricao);
   $query .= "
   
    AND tipo_arquivo.descricao in('".$descricao_filter."')
	ORDER BY cooperado_arquivo_envio.id desc
	
	
   ";
  }

  
  return $query;
 }

 
 function count_all($descricao,$id_user )
 {
  $query = $this->make_query_descr($descricao,$id_user);
  $data = $this->db->query($query);
  return $data->num_rows();
 }

 function fetch_data($limit, $start, $descricao,$id_user)
 {
  $query = $this->make_query_descr($descricao,$id_user );

  $query .= ' LIMIT '.$start.', ' . $limit;

  $data = $this->db->query($query);

  $output = '';
  if($data->num_rows() > 0)
  {
   foreach($data->result_array() as $row)
   {
    $output .= '
    <div class="col-sm-4 col-lg-3 col-md-3">
     <div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
            <p align="center"><strong><a href="#"><b>'. $row['descricao'] .'</b></a></strong></p>
            Tipo de Arquivo : <b>'. $row['descricao'] .' </b><br />      
      Nome do Arquivo : <b>'. $row['nome_arquivo'] .' </b></p>
     <a target=_blank href="'.base_url().RESTRITO_UPLOAD.$row['arquivo'].'">Download</a></strong></p>
      Cadastro : <b>'. $row['Data_cadastro'] .' </b></p>
	  Cadastro : <b>'. $row['id_user'] .' </b></p>
      </div>
    </div>
    ';
   }
  }
  else
  {
   $output = '<h3>Tipo de arquivo não encontrado</h3>';
  }
  return $output;
 }

}

?>