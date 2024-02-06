<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RevisaoCatalogacaoController extends CI_Controller {

    function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}
        $grupos = $this->session->userdata('grupos');
        if(in_array("1", $grupos) || in_array("17", $grupos) || in_array("20", $grupos) || in_array("15", $grupos) || in_array("16", $grupos)
		|| in_array("17", $grupos) || in_array("19", $grupos) || in_array("21", $grupos) || in_array("22", $grupos) || in_array("23", $grupos)
		|| in_array("24", $grupos) || in_array("28", $grupos)){             
        }else{
            redirect(base_url() . 'Home', 'refresh');
        }	
		$this->load->model('parceirosDao_model','parceirosDao');	
		$this->load->model('ingestDao_model','ingestDao');
		$this->load->model('revisaoDao_model','revisaoDao');
		$this->load->model('fichaConclusaoDao_model','fichaConclusaoDao');
		$this->load->model('catalogacaoDao_model','catalogacaoDao');
		$this->load->model('RevisaoCatalogacaoDao_model','revisaoCatalogacaoDao');
		$this->load->model('usuariosDao_model','usuariosDao');
	}

	function cadastrarRevisao(){
		
		
		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;				
		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;		
		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
        $idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;
		
		$idCatalogacao = $this->input->post('idCatalogacao');
		
		$claquetes = is_array($this->input->post('claquete'))? $this->input->post('claquete'):null;
		$obs_claquete = is_array($this->input->post('obs_claquete'))? $this->input->post('obs_claquete'):null;
		$blocos = is_array($this->input->post('bloco'))? $this->input->post('bloco'):null;
		$obs_bloco = is_array($this->input->post('obs_bloco'))? $this->input->post('obs_bloco'):null;
		$materias = is_array($this->input->post('materia'))? $this->input->post('materia'): null ;
		$obs_materia = is_array($this->input->post('obs_materia'))? $this->input->post('obs_materia'):null;
		$materiasRedacao = is_array($this->input->post('materiaRedacao'))? $this->input->post('materiaRedacao'): null ;
		$obs_materiaRedacao = is_array($this->input->post('obs_materiaRedacao'))? $this->input->post('obs_materiaRedacao'):null;
		$chamadas = is_array($this->input->post('chamada'))? $this->input->post('chamada'): null ;
		$obs_chamada = is_array($this->input->post('obs_chamada'))? $this->input->post('obs_chamada'):null;
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');
		
		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){			
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisarExcluir/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisarExcluir/brutas';
				}  
				break;
			case 'CH':							
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisarExcluir';		 
				break;
			case 'CHP':							
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/revisarExcluir';		 
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoExclusao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisarExcluir';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisarExcluir';
				break;
			
			default:
				
				break;
		}
		
		$mensagem = array();
		$status = "";
		
		$data['ingest'] = $this->ingestDao->selectIngest($idIngest);
		
		if(count($claquetes) < $data['ingest'][0]->claquetes){
			$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da(s) Claquete(s)";
		}
		
		if(count($blocos) < $data['ingest'][0]->blocos){
			$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO do(s) Bloco(s)";
		}
		
		if($tipoIngest == 'C'){
			$data['materias'] = $this->dao_midiascasa_model->materiasDaPauta($data['ingest'][0]->pauta_id);
			if( $idPrograma != 39  & $idPrograma != 2 & $idPrograma != 15 & $idPrograma != 32){
				if(count($materias) < count($data['materias'])){
					$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da(s) Matéria(s)";
				}
			}
			$data['materiasRedacao'] = $this->dao_midiascasa_model->materiasRedacaoDaPauta($data['ingest'][0]->pauta_id);
			if( $idPrograma != 39  & $idPrograma != 2 & $idPrograma != 15 & $idPrograma != 32){
				if(count($materiasRedacao) < count($data['materiasRedacao'])){
					$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da(s) Matéria(s) de Redação";
				}
			}
		}
		
		if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
			$data['chamada'] = $this->dao_chamadas_model->chamadaFluxo($idIngest);
			if( $idPrograma != 39  & $idPrograma != 2 & $idPrograma != 15 & $idPrograma != 32){
				if(count($chamadas) < count($data['chamada'])){
					$mensagem[] = "Por favor, entre com as informações APROVADO/REPROVADO da Chamada";
				}
			}
		}
		
		if(count($claquetes)>0){
			foreach ($claquetes as $key => $c) {
				
				if($c[0] == 'REPROVADO' && trim($obs_claquete[$key][0]) == ''){
					$mensagem[] = "Por favor, entre com a observação da Claquete Reprovada";
				}else if($c[0] == 'REPROVADO' && trim($obs_claquete[$key][0]) != ''){
					$status = "R";
				}
				
			}
		}
		
		//echo 'Blocos:<br><br>';
		
		if(count($blocos)>0){
			foreach ($blocos as $key => $b) {
				
				if($b[0] == 'REPROVADO' && trim($obs_bloco[$key][0]) == ''){
					$mensagem[] = "Por favor, entre com a observação do Bloco Reprovado";
				}else if($b[0] == 'REPROVADO' && trim($obs_bloco[$key][0]) != ''){
					$status = "R";
				}
				
			}
		}
		
		///echo 'Materias:<br><br>';
		if($tipoIngest == 'C'){
			if(count($materias)>0){
				foreach ($materias as $key => $m) {					
					if($m[0] == 'REPROVADO' && trim($obs_materia[$key][0]) == ''){
						$mensagem[] = "Por favor, entre com a observação da Matéria Reprovada";
					}else if($m[0] == 'REPROVADO' && trim($obs_materia[$key][0]) != ''){
						$status = "R";
					}					
				}
			}

			if(count($materiasRedacao)>0){
				foreach ($materiasRedacao as $key => $mr) {					
					if($mr[0] == 'REPROVADO' && trim($obs_materiaRedacao[$key][0]) == ''){
						$mensagem[] = "Por favor, entre com a observação da Matéria de Redação Reprovada";
					}else if($mr[0] == 'REPROVADO' && trim($obs_materiaRedacao[$key][0]) != ''){
						$status = "R";
					}					
				}
			}
		}
		
		if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
			if(count($chamadas)>0){
				foreach ($chamadas as $key => $ch) {					
					if($ch[0] == 'REPROVADO' && trim($obs_chamada[$key][0]) == ''){
						$mensagem[] = "Por favor, entre com a observação da Chamada Reprovada";
					}else if($ch[0] == 'REPROVADO' && trim($obs_chamada[$key][0]) != ''){
						$status = "R";
					}					
				}
			}
		}			
		
		
		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{			
						
			$revisao['idRevisaoCatalogacao'] = null;			
			$revisao['usuario_id_revCatalog'] = $this->session->userdata('idUsuario');			 
			$revisao['catalogacao_id'] = $idCatalogacao;
			$revisao['ingest_id'] = $idIngest;
			$revisao['statusRevCatalog'] = ($status == '')? 'A':$status;

			$dadosEmail['idUsuario'] = $this->session->userdata('idUsuario');
			$dadosEmail['idPauta'] = $idPauta;
			$dadosEmail['statusRevisao'] = ($status == '')? 'A':$status;
			$dadosEmail['dataRevisao'] = Date("Y-m-d H:i:s");
			
			if($this->revisaoCatalogacaoDao->insertRevisao($revisao,$idIngest,$idCatalogacao,$claquetes,$obs_claquete,$blocos,$obs_bloco,$chamadas,$obs_chamada,$materias,$obs_materia,$materiasRedacao,$obs_materiaRedacao,$tipoIngest)){				
				$this->session->set_flashdata('resultado_ok','Revisão de Catalogação cadastrada com sucesso!');											
				redirect(base_url() . $url,'refresh');
			}else{				
				$this->session->set_flashdata('resultado_error','Erro ao revisar Catalogação!');			
				redirect(base_url() . $url,'refresh');
			}
			
			
		}
		
		
	}



	function revisaoCorrecao(){
		
		
		$idRevisaoCatalogacao = $this->input->post('idRevisaoCatalogacao');
		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;
        $idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
        $idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;
		
		$idInterProgramas = ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
		$idIngestInterPrograma = ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;
		
		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
        $idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;
		
		$claquetes = is_array($this->input->post('claquete'))? $this->input->post('claquete'):null;
		$obs_claquete = is_array($this->input->post('obs_claquete'))? $this->input->post('obs_claquete'):null;
		$blocos = is_array($this->input->post('bloco'))? $this->input->post('bloco'):null;
		$obs_bloco = is_array($this->input->post('obs_bloco'))? $this->input->post('obs_bloco'):null;
		$materias = is_array($this->input->post('materia'))? $this->input->post('materia'): null ;
		$obs_materia = is_array($this->input->post('obs_materia'))? $this->input->post('obs_materia'):null;
		$materiasRedacao = is_array($this->input->post('materiaRedacao'))? $this->input->post('materiaRedacao'): null ;
		$obs_materiaRedacao = is_array($this->input->post('obs_materiaRedacao'))? $this->input->post('obs_materiaRedacao'):null;
		
		$chamadas = is_array($this->input->post('chamada'))? $this->input->post('chamada'): null ;
		$obs_chamada = is_array($this->input->post('obs_chamada'))? $this->input->post('obs_chamada'):null;
		
		$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');
		
		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){			
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisarExcluir/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/revisarExcluir/brutas';
				}  
				break;
			case 'CH':							
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/revisarExcluir';		 
				break;
			case 'CHP':							
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/revisarExcluir';		 
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/revisaoExclusao';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/revisarExcluir';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/revisarExcluir';
				break;
			
			default:
				
				break;
		}
		
		$mensagem = array();
		$status = "";
			
		
		if(count($claquetes)>0){
			foreach ($claquetes as $key => $c) {
				/*echo 'claquetes ' .$key .': '. $c[0] . '<br>';
				echo 'Observação matéria ' .$key .': '. $obs_claquete[$key][0] . '<br>';*/
				
				if($c[0] == 'REPROVADO' && trim($obs_claquete[$key][0]) == ''){
					$mensagem[] = "Por favor, entre com a observação da Claquete Reprovada";
				}else if($c[0] == 'REPROVADO' && trim($obs_claquete[$key][0]) != ''){
					$status = "R";
				}
				
			}
		}
		
		//echo 'Blocos:<br><br>';
		
		if(count($blocos)>0){
			foreach ($blocos as $key => $b) {				
				if($b[0] == 'REPROVADO' && trim($obs_bloco[$key][0]) == ''){
					$mensagem[] = "Por favor, entre com a observação do Bloco Reprovado";
				}else if($b[0] == 'REPROVADO' && trim($obs_bloco[$key][0]) != ''){
					$status = "R";
				}
				
			}
		}
		
		//echo 'Materias:<br><br>';
		if($tipoIngest == 'C'){
			if(count($materias)>0){
				foreach ($materias as $key => $m) {					
					if($m[0] == 'REPROVADO' && trim($obs_materia[$key][0]) == ''){
						$mensagem[] = "Por favor, entre com a observação da Matéria Reprovada";
					}else if($m[0] == 'REPROVADO' && trim($obs_materia[$key][0]) != ''){
						$status = "R";
					}					
				}
			}

			if(count($materiasRedacao)>0){
				foreach ($materiasRedacao as $key => $mr) {					
					if($mr[0] == 'REPROVADO' && trim($obs_materiaRedacao[$key][0]) == ''){
						$mensagem[] = "Por favor, entre com a observação da Matéria de Redação Reprovada";
					}else if($mr[0] == 'REPROVADO' && trim($obs_materiaRedacao[$key][0]) != ''){
						$status = "R";
					}					
				}
			}
		}

		if($tipoIngest == 'CH' || $tipoIngest == 'CHP'){
			if(count($chamadas)>0){
				foreach ($chamadas as $key => $ch) {					
					if($ch[0] == 'REPROVADO' && trim($obs_chamada[$key][0]) == ''){
						$mensagem[] = "Por favor, entre com a observação da Chamada Reprovada";
					}else if($ch[0] == 'REPROVADO' && trim($obs_chamada[$key][0]) != ''){
						$status = "R";
					}					
				}
			}
		}
		
		
				
		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{
			
			$revisao['idRevisaoCatalogacao'] = $idRevisaoCatalogacao;			
			$revisao['usuario_id_revCatalog'] = $this->session->userdata('idUsuario');
			$revisao['ingest_id'] = $idIngest;
			$revisao['statusRevCatalog'] = ($status == '')? 'A':$status;

			$dadosEmail['idUsuario'] = $this->session->userdata('idUsuario');
			$dadosEmail['idPauta'] = $idPauta;
			$dadosEmail['statusRevisao'] = ($status == '')? 'A':$status;
			$dadosEmail['dataRevisaoCorrecao'] = Date("Y-m-d H:i:s");
			
					
			if($this->revisaoCatalogacaoDao->updateRevisaoCorrecao($revisao,$idIngest,$claquetes,$obs_claquete,$blocos,$obs_bloco,$materias,$obs_materia,$materiasRedacao,$obs_materiaRedacao,$chamadas,$obs_chamada,$tipoIngest)){				
				$this->session->set_flashdata('resultado_ok','Revisão da correção de Catalogação efetuada com sucesso!');							
				redirect(base_url() . $url,'refresh');
			}else{				
				$this->session->set_flashdata('resultado_error','Erro ao Revisar a Correção da Catalogação!');			
				redirect(base_url() . $url,'refresh');
			}
			
			
		}
		
	}

	function deleteRevisaoCatalogacao(){
		$idIngest = $this->input->post('idIngest');
		$idRevisaoCatalogacao = $this->input->post('idRevisaoCatalogacao');

		/*$this->db->where('id_ingest',$idIngest);
		$this->db->where('tipoRevisao','C');
		$this->db->from('tbl_revisao_problema');
		$this->db->join('tbl_problema','tbl_problema.idProblema = tbl_revisao_problema.problema_id');	
		$dados = $this->db->get()->result();
		echo '<pre>';
		print_r($dados);
		echo '</pre>';*/
		
		if( $this->revisaoCatalogacaoDao->deleteRevisaoCatalogacaoParceiro($idIngest,$idRevisaoCatalogacao)){
		    echo true;
		}else{
			echo false; 
		}
	}
}