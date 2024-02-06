<?php 

Class RelatoriosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}


	function totalVideos(){		
		return $this->db->get('tb_video')->num_rows();
	}

/*=================== Acessos e Downloads ===============================*/

	function make_queryAcessos(){  
		
		$order_column = array("tb_video.nome","tb_programa.titulo","tb_video.numeroPgm","total_acesso");  

		$this->db->where('videos_acessos.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);
		$this->db->where('videos_acessos.tipo_acesso','A');
		$this->db->group_by(array("tb_video.id", "tb_video.duracao","tb_video.imagem","tb_programa.titulo"));
		$this->db->having('total_acesso > ',  0);		
		$this->db->distinct('tb_video.id');
		$this->db->select('count(*) as total_acesso, tb_video.id as id,tb_video.numeroPgm, tb_video.nome, tb_programa.titulo');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa','inner');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id','inner');

		if(isset($_POST["search"]["value"]) & $_POST["search"]["value"] != ''){  
			$this->db->like("tb_video.nome", $_POST["search"]["value"]);  
			$this->db->or_like("tb_programa.titulo", $_POST["search"]["value"]);
			$this->db->or_like("tb_video.numeroPgm", $_POST["search"]["value"]); 
		}  
		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('total_acesso', 'DESC');  
		}  
	}

	function make_datatablesAcessos(){  
		$this->make_queryAcessos();  
		if($_POST["length"] != -1){  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}  		
		$query = $this->db->get();  
		return $query->result();  
    } 

	function get_filtered_dataAcessos(){  
		$this->make_queryAcessos();  
		$query = $this->db->get();  
		return $query->num_rows();  
    }

	function get_all_dataAcessos(){  
		$this->db->select("*");  
		$this->db->from('tb_video');  
		return $this->db->count_all_results();  
    }


	function make_queryDownloads(){  
		
		$order_column = array("tb_video.nome","tb_programa.titulo","tb_video.numeroPgm","total_download");  

		$this->db->where('videos_acessos.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);		
		$this->db->where('videos_acessos.tipo_acesso','D');
		$this->db->group_by(array("tb_video.id", "tb_video.duracao","tb_video.imagem","tb_programa.titulo"));
		$this->db->having('total_download > ',  0);		
		$this->db->distinct('tb_video.id');
		$this->db->select('count(*) as total_download, tb_video.id as id,tb_video.numeroPgm, tb_video.nome, tb_programa.titulo');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa','inner');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id','inner');

		if(isset($_POST["search"]["value"]) & $_POST["search"]["value"] != ''){  
			$this->db->like("tb_video.nome", $_POST["search"]["value"]);  
			$this->db->or_like("tb_programa.titulo", $_POST["search"]["value"]);
			$this->db->or_like("tb_video.numeroPgm", $_POST["search"]["value"]); 
		}  
		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('total_download', 'DESC');  
		}  
	}

	function make_datatablesDownloads(){  
		$this->make_queryDownloads();  
		if($_POST["length"] != -1){  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}  
		$query = $this->db->get();  
		return $query->result();  
  } 

	function get_filtered_dataDownloads(){  
		$this->make_queryDownloads();  
		$query = $this->db->get();  
		return $query->num_rows();  
  }

	function get_all_dataDownloads(){  
		$this->db->select("*");  
		$this->db->from('tb_video');  
		return $this->db->count_all_results();  
	}
		

	
	function make_queryStreaming(){  
		
		$order_column = array("titulo","programa","total_streaming");  

		$this->db->where('data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);	
		if(@$_SESSION['horaInicial'] !=  @$_SESSION['horaFinal'] ){
			$this->db->where('hora_acesso BETWEEN "'. $_SESSION['horaInicial'] .'" AND "'.$_SESSION['horaFinal'].'"',NULL,FALSE);
		}		
		$this->db->group_by(array("titulo", "programa"));
		$this->db->having('total_streaming > ',  0);		
		$this->db->distinct('titulo');
		$this->db->select('count(*) as total_streaming, titulo,programa');
		$this->db->from('tbl_acessoLiveStreaming');

		if(isset($_POST["search"]["value"]) & $_POST["search"]["value"] != ''){  
			$this->db->like("titulo", $_POST["search"]["value"]);  
			$this->db->or_like("programa", $_POST["search"]["value"]);
		}  
		if(isset($_POST["order"])){  
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
		}  
		else{  
			$this->db->order_by('total_streaming', 'DESC');  
		}  
	}

	function make_datatablesStreaming(){  
		$this->make_queryStreaming();  
		if($_POST["length"] != -1){  
			$this->db->limit($_POST['length'], $_POST['start']);  
		}  
		$query = $this->db->get();  
		return $query->result();  
    } 

	function get_filtered_dataStreaming(){  
		$this->make_queryStreaming();  
		$query = $this->db->get();  
		return $query->num_rows();  
    }

	function get_all_dataStreaming(){  
		$this->db->select("*");  
		$this->db->from('tbl_acessoLiveStreaming');  
		return $this->db->count_all_results();  
    }


/* ===== Totais de Acesso ==========================*/

	function totalAcessos(){
		$this->db->where('videos_acessos.tipo_acesso','A');			
		$this->db->select('count(*) as total_acesso');
		$this->db->from('tb_video');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id');	
		$resultado = $this->db->get()->result();		
		return $resultado[0]->total_acesso;
	}

	function totalDownloads(){
		$this->db->where('videos_acessos.tipo_acesso','D');				
		$this->db->select('count(*) as total_downloads');
		$this->db->from('tb_video');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id');	
		$resultado = $this->db->get()->result();		
		return $resultado[0]->total_downloads;	
	}

	/*function totalAcessos(){
		$this->db->where('videos_acessos.tipo_acesso','A');			
		$this->db->select('count(id_video) as total_acesso');
		$this->db->from('videos_acessos');	
		$resultado = $this->db->get()->result();		
		return $resultado[0]->total_acesso;
	}

	function totalDownloads(){
		$this->db->where('videos_acessos.tipo_acesso','D');				
		$this->db->select('count(id_video) as total_downloads');
		$this->db->from('videos_acessos');	
		$resultado = $this->db->get()->result();		
		return $resultado[0]->total_downloads;	
	}*/

	

	function totalAcessosOnDemand(){
		$data_inicio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
		$data_fim = date("Y-m-t");		
		$this->db->where('videos_acessos.tipo_acesso','A');		
		$this->db->where('videos_acessos.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);		
		$this->db->select('count(*) as total_acesso');
		$this->db->from('tb_video');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id');	
		$resultado = $this->db->get()->result();		
		return $resultado[0]->total_acesso;
	}

	function totalDownloadsOnDemand(){
		$data_inicio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
		$data_fim = date("Y-m-t");
		$this->db->where('videos_acessos.tipo_acesso','D');		
		$this->db->where('videos_acessos.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);		
		$this->db->select('count(*) as total_downloads');
		$this->db->from('tb_video');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id');	
		$resultado = $this->db->get()->result();		
		return $resultado[0]->total_downloads;	
	}

	function totalStreaming(){
		$data_inicio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
		$data_fim = date("Y-m-t");
		$this->db->where('tbl_acessoLiveStreaming.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);		
		if($_SESSION['horaInicial'] !=  $_SESSION['horaFinal'] ){
			$this->db->where('hora_acesso BETWEEN "'. $_SESSION['horaInicial'] .'" AND "'.$_SESSION['horaFinal'].'"',NULL,FALSE);
		}	
		$this->db->select('count(*) as total_streaming');		
		$resultado = $this->db->get('tbl_acessoLiveStreaming')->result();		
		return $resultado[0]->total_streaming;	
	}



	function topFiveMaisAcessados(){
		$data_inicio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
		$data_fim = date("Y-m-t");
		$this->db->limit(5,0);
		$this->db->where('videos_acessos.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);
		$this->db->where('videos_acessos.tipo_acesso','A');
		$this->db->group_by(array("tb_video.id", "tb_video.duracao","tb_video.imagem","tb_programa.titulo"));
		$this->db->having('total_acesso >',  0);
		$this->db->order_by('total_acesso',	'desc');		
		$this->db->distinct('tb_video.id');
		$this->db->select(' count(*) as total_acesso, tb_video.id as id, tb_video.nome as nome_video, tb_programa.titulo as nome_programa');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa','inner');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id','inner');
		return $this->db->get()->result();
	}

	function topFiveMaisBaixados(){
		$data_inicio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
		$data_fim = date("Y-m-t");
		$this->db->limit(5,0);
		$this->db->where('videos_acessos.data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);
		$this->db->where('videos_acessos.tipo_acesso','D');
		$this->db->group_by(array("tb_video.id", "tb_video.duracao","tb_video.imagem","tb_programa.titulo"));
		$this->db->having('total_downloads >',  0);
		$this->db->order_by('total_downloads',	'desc');		
		$this->db->distinct('tb_video.id');
		$this->db->select(' count(*) as total_downloads, tb_video.id as id, tb_video.nome as nome_video, tb_programa.titulo as nome_programa');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa','inner');
		$this->db->join('videos_acessos','videos_acessos.id_video = tb_video.id','inner');
		return $this->db->get()->result();
	}

	function topFiveStreaming(){
		$data_inicio = date('Y-m-d', mktime(0, 0, 0, date('m') , 1 , date('Y')));
		$data_fim = date("Y-m-t");
		$this->db->limit(5,0);
		$this->db->where('data_acesso BETWEEN "'. $_SESSION['startDate'] .'" AND "'.$_SESSION['endDate'].'"',NULL,FALSE);		
		if($_SESSION['horaInicial'] !=  $_SESSION['horaFinal'] ){
			$this->db->where('hora_acesso BETWEEN "'. $_SESSION['horaInicial'] .'" AND "'.$_SESSION['horaFinal'].'"',NULL,FALSE);
		}	
		$this->db->group_by(array("titulo", "programa"));
		$this->db->having('total_streaming >',  0);
		$this->db->order_by('total_streaming',	'desc');		
		$this->db->distinct('titulo');
		$this->db->select('count(*) as total_streaming, titulo, programa');		
		return $this->db->get('tbl_acessoLiveStreaming')->result();
	}

}

?>
