<?php 

Class FigurinoDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

    function listarFigurino($limit = null,$offset = null){
		$this->db->order_by('idFigurino','desc');
		$this->db->limit($limit,$offset);
		return $this->db->get('tb_figurino')->result();
	}

	function listarTipo(){
		return $this->db->get('tb_tipoFigurino')->result();
	}

	function selectTipoById($idTipoFigurino){
		$this->db->where('idTipoFigurino', $idTipoFigurino);
		return $this->db->get('tb_tipoFigurino')->result();		
	}

	function listarSituacao(){
		return $this->db->get('tb_situacaoFigurino')->result();
	}

	/*
	** Adicionar Figurino
	*/
	function insertFigurino($data){	
		return $this->db->insert('tb_figurino',$data);	
	}

	function updateFigurino($data){	
		$this->db->where('idFigurino',$data['idFigurino']);			
		return $this->db->update('tb_figurino',$data);
	}

	/*
	** Completar cadastro Figurino
	*/
	function completar_cadastro($codigo,$foto_banco,$idFigurino){	
		$this->db->where('idFigurino',$idFigurino);	
		$this->db->set('codigo', $codigo);
		$this->db->set('foto', $foto_banco);
		return $query = $this->db->update('tb_figurino');		
	}

	function selectFigurinoById($idFigurino){
		$this->db->where('idFigurino',$idFigurino);	
		return $this->db->get('tb_figurino')->result();
	}

	function selectFigurino($idFigurino){
		$this->db->where('idFigurino',$idFigurino);	
		$this->db->select('idFigurino,codigo,descricao,foto,sexo,tipo,situacao,situacaoFigurino_id');
		$this->db->from('tb_figurino');
		$this->db->join('tb_situacaoFigurino','tb_situacaoFigurino.idSituacaoFigurino = tb_figurino.situacaoFigurino_id');
		$this->db->join('tb_tipoFigurino','tb_tipoFigurino.idTipoFigurino = tb_figurino.idTipoFigurino');
		return $this->db->get()->result();
	}


	function insertServico($data,$idFigurino){
		//start the transaction
        $this->db->trans_begin();

			$this->db->insert('tb_historicoServFigurino',$data);

			$situacao = array(
			'situacaoFigurino_id'=> 3
			);
			$this->db->where('idFigurino',$idFigurino);
			$this->db->update('tb_figurino',$situacao);


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

	function listarServico($idFigurino,$tipo){
		$this->db->where('figurino_id',$idFigurino);	
		$this->db->where('tipoServico',$tipo);	
		return $this->db->get('tb_historicoServFigurino')->result();
	}

	function totalServico($idFigurino, $tipo){
		$this->db->where('figurino_id',$idFigurino);	
		$this->db->where('tipoServico',$tipo);	
		return $this->db->get('tb_historicoServFigurino')->num_rows();
	}

	function insertDevolucao($data,$idServico,$idFigurino){
		//start the transaction
        $this->db->trans_begin();
			
			$this->db->where('idHistoricoServico',$idServico);
			$this->db->update('tb_historicoServFigurino',$data);

			$situacao = array(
			'situacaoFigurino_id'=> 1
			);
			$this->db->where('idFigurino',$idFigurino);
			$this->db->update('tb_figurino',$situacao);


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

	/*
	** Excluir Figurino
	*/
	function deleteFigurino($idFigurino){		
		$this->db->where('idFigurino',$idFigurino);	
		return $this->db->delete('tb_figurino');
	}

	/* ======================= Sql de search ===========================*/
	
	/*
	** Busca de figurino
	*/
	function buscarFigurino($data,$limite,$offset){
		
			$descricao = $data['descricao'];
			$tipo =	$data['idTipofigurino']	;
			$sexo =	$data['sexo'];
			
			if($descricao != '' & $tipo == '' & $sexo == ''){
				$this->db->like('descricao',$descricao);
			}		
			if($descricao != '' & $tipo != '' & $sexo == ''){
				$this->db->like('descricao',$descricao);	
				$this->db->where('tb_figurino.idTipoFigurino',$tipo);
			}
			if($descricao != '' & $tipo == '' & $sexo != ''){
				$this->db->like('descricao',$descricao);
				$this->db->where('sexo',$sexo);
			}
			if($descricao != '' & $tipo != '' & $sexo != ''){
				$this->db->like('descricao',$descricao);
				$this->db->where('tb_figurino.idTipoFigurino',$tipo);
				$this->db->where('sexo',$sexo);
			}
			
			
			if($descricao == '' & $tipo != '' & $sexo == ''){
				$this->db->where('tb_figurino.idTipoFigurino',$tipo);
			}
			if($descricao == '' & $tipo != '' & $sexo != ''){
				$this->db->where('tb_figurino.idTipoFigurino',$tipo);
				$this->db->where('sexo',$sexo);
			}
			
			
			if($descricao == '' & $tipo == '' & $sexo != ''){
				$this->db->where('sexo',$sexo);
			}		
			
			
			$this->db->select('*');
			$this->db->order_by('idFigurino','desc');	
			$this->db->from('tb_figurino');
			$this->db->join('tb_tipoFigurino','tb_tipoFigurino.idTipoFigurino = tb_figurino.idTipoFigurino');
			$this->db->limit($limite, $offset);		
			$query = $this->db->get();		
			return $query->result();		
			
		
		}
		
		
		/*
		** Número de linhas da Busca de figurino
		*/
		function get_rows($data){	
				
			$descricao = $data['descricao'];
			$tipo =	$data['idTipofigurino']	;
			$sexo =	$data['sexo'];
			
			if($descricao != '' & $tipo == '' & $sexo == ''){
				$this->db->like('descricao',$descricao);
			}		
			if($descricao != '' & $tipo != '' & $sexo == ''){
				$this->db->like('descricao',$descricao);	
				$this->db->where('idTipoFigurino',$tipo);
			}
			if($descricao != '' & $tipo == '' & $sexo != ''){
				$this->db->like('descricao',$descricao);
				$this->db->where('sexo',$sexo);
			}
			if($descricao != '' & $tipo != '' & $sexo != ''){
				$this->db->like('descricao',$descricao);
				$this->db->where('idTipoFigurino',$tipo);
				$this->db->where('sexo',$sexo);
			}
			
			
			if($descricao == '' & $tipo != '' & $sexo == ''){
				$this->db->where('idTipoFigurino',$tipo);
			}
			if($descricao == '' & $tipo != '' & $sexo != ''){
				$this->db->where('idTipoFigurino',$tipo);
				$this->db->where('sexo',$sexo);
			}
			
			
			if($descricao == '' & $tipo == '' & $sexo != ''){
				$this->db->where('sexo',$sexo);
			}		
					
			$query = $this->db->order_by('idFigurino','desc');		
			$num_rows = $this->db->count_all_results('tb_figurino');		
			
			return $num_rows; 	
		
		}

	


}

?>