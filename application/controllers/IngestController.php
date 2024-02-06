<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IngestController extends CI_Controller {

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
		$this->load->model('revisaoClosedCaptionDao_model','revisaoClosedCaptionDao');
		$this->load->model('fichaConclusaoDao_model','fichaConclusaoDao');
		$this->load->model('catalogacaoDao_model','catalogacaoDao');
		$this->load->model('RevisaoCatalogacaoDao_model','revisaoCatalogacaoDao');
		$this->load->model('usuariosDao_model','usuariosDao');
	}

	public function inserirProgramaParceiro(){

		$idParceiros = $this->input->post('idParceiros');
		$idProgramasParceiros = $this->input->post('programaParceiro');
        $tituloPrograma = $this->input->post('tituloPrograma');
        $numeroPGM = $this->input->post('numeroPGM');
		$observacao = $this->input->post('observacao');
		$recebido = $this->input->post('recebido');
		$statusIngest = $this->input->post('statusIngest');

		$url = 'MidiasParceirosController/viewInsertProgramasParceiros/'.$idParceiros;

		$mensagem = array();

        if(empty($idProgramasParceiros)){
			$mensagem[] = "Por favor, informe o Programa Parceiro";
		}

		if(empty($tituloPrograma)){
			$mensagem[] = "Por favor, informe o Título do Programa";
		}

        if(empty($numeroPGM)){
			$mensagem[] = "Por favor, informe o Número do Programa";
		}else if(!$this->ingestDao->verificarNumeroProgramaLiberado($idProgramasParceiros,$numeroPGM,'P')){
			$mensagem[] = "Número de Programa já cadastrado!";
		}



		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{


			$ingest['idIngest'] = null;
		    $ingest['tipoFluxo'] = 'M';
		    $ingest['tipoIngest'] = 'P';

            $ingestParceiro['idIngestParceiro'] = null;
            $ingestParceiro['idPrograma'] = $idProgramasParceiros;
			$ingestParceiro['tituloPrograma'] = $tituloPrograma;
			$ingestParceiro['numeroPGM'] = $numeroPGM;
			$ingestParceiro['parceiro_id'] = $idParceiros;
			$ingestParceiro['observacao'] = $observacao;
			$ingestParceiro['recebido'] = $recebido;
			$ingestParceiro['statusIngest'] = $statusIngest;

			if($this->ingestDao->insertProgramaParceiro($ingest,$ingestParceiro)){
				$this->session->set_flashdata('resultado_ok','Programa cadastrado com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Programa!');
				redirect(base_url() . $url,'refresh');
			}


		}
	}

	function alterarInfoParceiro(){


        $idIngest = $this->input->post('idIngest');
        $idIngestParceiro = $this->input->post('idIngestParceiro');
	    $idParceiros = $this->input->post('idParceiros');
		$idProgramasParceiros = $this->input->post('programaParceiro');
        $tituloPrograma = $this->input->post('tituloPrograma');
        $numeroPGM = $this->input->post('numeroPGM');
		$observacao = $this->input->post('observacao');
		$recebido = $this->input->post('recebido');
		$statusIngest = $this->input->post('statusIngest');

		$url = 'MidiasParceirosController/viewInsertProgramasParceiros/'.$idParceiros;

		$ingestParceiroAtual = $this->ingestDao->selectIngestParceiro($idIngest);

		$mensagem = array();

        if(empty($idProgramasParceiros)){
			$mensagem[] = "Por favor, informe o Programa Parceiro";
		}

        if(empty($tituloPrograma)){
			$mensagem[] = "Por favor, informe o Título do Programa";
		}

		if($statusIngest != 'CANCELADO'){
			if(empty($numeroPGM)){
				$mensagem[] = "Por favor, informe o Número do Programa";
			}else if($ingestParceiroAtual[0]->numeroPGM != $numeroPGM){
				if(!$this->ingestDao->verificarNumeroProgramaLiberado($idProgramasParceiros,$numeroPGM,'P')){
					$mensagem[] = "Número de Programa já cadastrado!";
				}
			}
		}else{
			$numeroPGM = null;
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

            $ingestParceiro['idIngestParceiro'] = $idIngestParceiro;
            $ingestParceiro['idPrograma'] = $idProgramasParceiros;
			$ingestParceiro['tituloPrograma'] = $tituloPrograma;
			$ingestParceiro['numeroPGM'] = $numeroPGM;
			$ingestParceiro['parceiro_id'] = $idParceiros;
			$ingestParceiro['observacao'] = $observacao;
			$ingestParceiro['recebido'] = $recebido;
			$ingestParceiro['statusIngest'] = $statusIngest;
			$ingest = [];
			if($statusIngest == 'CANCELADO'){
				$ingest['idIngest'] = $idIngest;
				$ingest['dataInicio'] = null;
				$ingest['dataFim'] = null;
				$ingest['usuario_id'] = null;
				$ingest['claquetes'] = null;
				$ingest['blocos'] = null;
				$ingest['versao'] = null;
			}

			if($this->ingestDao->updateInfoParceiro($ingestParceiro,$ingest)){
				$this->session->set_flashdata('resultado_ok','Programa Alterado com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao alterar o Programa!');
				redirect(base_url() . $url,'refresh');
			}


		}


	}

	public function ingestarParceiro(){

		$idParceiros = $this->input->post('idParceiros');
		$idProgramasParceiros = $this->input->post('programaParceiro');
        $tituloPrograma = $this->input->post('tituloPrograma');
        $numeroPGM = $this->input->post('numeroPGM');
		$claquetes = $this->input->post('claquetes');
		$blocos = $this->input->post('blocos');
		$observacao = $this->input->post('observacao');
		//$materias = $this->input->post('materias');

		$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/ingest';

		$mensagem = array();

        if(empty($idProgramasParceiros)){
			$mensagem[] = "Por favor, informe o Programa Parceiro";
		}

		if(empty($tituloPrograma)){
			$mensagem[] = "Por favor, informe o Título do Programa";
		}

        if(empty($numeroPGM)){
			$mensagem[] = "Por favor, informe o Número do Programa";
		}else if(!$this->ingestDao->verificarNumeroProgramaLiberado($idProgramasParceiros,$numeroPGM,'P')){
			$mensagem[] = "Número de Programa já cadastrado!";
		}

		if(empty($claquetes)){
			$mensagem[] = "Por favor, informe o valor da Claquete";
		}

		if(empty($blocos)){
			$mensagem[] = "Por favor, informe o valor dos Blocos";
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{


			$ingest['idIngest'] = null;
            $ingest['dataInicio'] = Date("Y-m-d H:i:s");
            $ingest['dataFim'] = Date("Y-m-d H:i:s");
            $ingest['usuario_id'] = $this->session->userdata('idUsuario');
            $ingest['claquetes'] = $claquetes;
            $ingest['blocos'] = $blocos;
           //$ingest['materiaFluxo'] = $materias;
			$ingest['versao'] = 'A';
		    $ingest['tipoFluxo'] = 'M';
		    $ingest['tipoIngest'] = 'P';

            $ingestParceiro['idIngestParceiro'] = null;
            $ingestParceiro['idPrograma'] = $idProgramasParceiros;
			$ingestParceiro['tituloPrograma'] = $tituloPrograma;
			$ingestParceiro['numeroPGM'] = $numeroPGM;
			$ingestParceiro['parceiro_id'] = $idParceiros;
			$ingestParceiro['observacao'] = $observacao;


			if($this->ingestDao->insertIngestParceiro($ingest,$ingestParceiro)){
				$this->session->set_flashdata('resultado_ok','Ingest cadastrado com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao cadastrar o Ingest!');
				redirect(base_url() . $url,'refresh');
			}


		}
	}

	function corrigirIngest(){


		$claquetes = is_array($this->input->post('claquete'))? $this->input->post('claquete'):null;
		$blocos = is_array($this->input->post('bloco'))? $this->input->post('bloco'):null;
		$materias = is_array($this->input->post('materia'))? $this->input->post('materia'): null ;
		$materiasRedacao = is_array($this->input->post('materiaRedacao'))? $this->input->post('materiaRedacao'): null ;
		$chamadas = is_array($this->input->post('chamada'))? $this->input->post('chamada'): null ;
		$versaoAtual = $this->input->post('versaoAtual');

		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;

    	$idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
    	$idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

    	$idInterProgramas =  ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
    	$idIngestInterPrograma =  ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
    	$idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

    	$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$problemaClaquete = is_array($this->input->post('claqueteProblema'))? $this->input->post('claqueteProblema') : null;
		$blocoProblema = is_array($this->input->post('blocoProblema') )? $this->input->post('blocoProblema') : null;
		$materiaProblema = is_array($this->input->post('materiaProblema') )? $this->input->post('materiaProblema') : null;
		$materiaRedacaoProblema = is_array($this->input->post('materiaRedacaoProblema') )? $this->input->post('materiaRedacaoProblema') : null;
		$chamadaProblema = is_array($this->input->post('chamadaProblema') )? $this->input->post('chamadaProblema') : null;

		$respostaClaqueteProblema = is_array($this->input->post('respostaClaqueteProblema') )? $this->input->post('respostaClaqueteProblema') : null;
		$respostaBlocoProblema = is_array($this->input->post('respostaBlocoProblema') )? $this->input->post('respostaBlocoProblema') : null;
		//print_r($respostaBlocoProblema);
		//exit();
		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/ingest/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/ingest/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/ingest';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/ingest';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/ingest';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/ingest';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/ingest';
				break;

			default:

				break;
		}

		$mensagem = array();
		$novaVersao = proximaVersao($versaoAtual);

		if(count($claquetes) >0){
			foreach ($claquetes as $key => $c) {
				if($c[0] == ''){
					$mensagem[] = "Por favor, informe a Correção da(s) Claquete(s).";
				}
			}
		}

		if(count($blocos) >0){
			foreach ($blocos as $key => $b) {
				if($b[0] == ''){
					$mensagem[] = "Por favor, informe a Correção do(s) Bloco(s).";
				}
			}
		}

		if(count($materias) >0){
			foreach ($materias as $key => $m) {
				if($m[0] == ''){
					$mensagem[] = "Por favor, informe a Correção da(s) Materia(s).";
				}

			}
		}

		if(count($chamadas) >0){
			foreach ($chamadas as $key => $ch) {
				if($ch[0] == ''){
					$mensagem[] = "Por favor, informe a Correção da(s) Chamada(s).";
				}

			}
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{


			$data['dataFim'] = Date("Y-m-d H:i:s");
			$data['versao'] = $novaVersao;

			$dadosEmail['idIngest'] = $idIngest;
			$dadosEmail['usuario_id'] = $this->session->userdata('idUsuario');
			$dadosEmail['pauta_id'] = $idPauta;
			$dadosEmail['tipoIngest'] = $tipoIngest;
			$dadosEmail['dataFim'] = Date("Y-m-d H:i:s");
			$dadosEmail['claquetes'] = $claquetes;
			$dadosEmail['blocos'] = $blocos;
			$dadosEmail['versao'] = $novaVersao;

			//if($this->ingestDao->updateCorrecaoIngest($data,$idIngest,$materias,$materiasRedacao,$claquetes,$chamadas,$blocos,$tipoIngest,$problemaClaquete,$blocoProblema,$materiaProblema,$materiaRedacaoProblema,$chamadaProblema)){
			if($this->ingestDao->updateCorrecaoIngest($data,$idIngest,$materias,$materiasRedacao,$claquetes,$chamadas,$blocos,$tipoIngest,
			$problemaClaquete,$blocoProblema,$materiaProblema,$materiaRedacaoProblema,$chamadaProblema,$respostaBlocoProblema,$respostaClaqueteProblema)){

				$this->revisaoDao->atualizaRevisaoCorrigido($idIngest);
				$this->session->set_flashdata('resultado_ok','Ingest corrigido com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao corrigir Ingest!');
				redirect(base_url() . $url,'refresh');
			}


		}
	}


	function alterarIngestParceiro(){


        $idIngest = $this->input->post('idIngest');
        $idIngestParceiro = $this->input->post('idIngestParceiro');
	    $idParceiros = $this->input->post('idParceiros');
		$idProgramasParceiros = $this->input->post('programaParceiro');
		$tituloPrograma = $this->input->post('tituloPrograma');
        $numeroPGM = $this->input->post('numeroPGM');
		$claquetes = $this->input->post('claquetes');
		$blocos = $this->input->post('blocos');
		$observacao = $this->input->post('observacao');
		$closedCaption = $this->input->post('closedCaption');
		//$materias = $this->input->post('materias');

		$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/ingest';

		$ingestParceiroAtual = $this->ingestDao->selectIngestParceiro($idIngest);

		$mensagem = array();

        if(empty($idProgramasParceiros)){
			$mensagem[] = "Por favor, informe o Programa Parceiro";
		}

        if(empty($tituloPrograma)){
			$mensagem[] = "Por favor, informe o Título do Programa";
		}

        if(empty($numeroPGM)){
			$mensagem[] = "Por favor, informe o Número do Programa";
		}else if($ingestParceiroAtual[0]->numeroPGM != $numeroPGM){
			if(!$this->ingestDao->verificarNumeroProgramaLiberado($idProgramasParceiros,$numeroPGM,'P')){
				$mensagem[] = "Número de Programa já cadastrado!";
			}
		}

		if(empty($claquetes)){
			$mensagem[] = "Por favor, informe o valor da Claquete";
		}

		if(empty($blocos)){
			$mensagem[] = "Por favor, informe o valor dos Blocos";
		}

		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{


			$ingest['idIngest'] = $idIngest;
            $ingest['dataInicio'] = Date("Y-m-d H:i:s");
            $ingest['dataFim'] = Date("Y-m-d H:i:s");
            $ingest['usuario_id'] = $this->session->userdata('idUsuario');
            $ingest['claquetes'] = $claquetes;
            $ingest['blocos'] = $blocos;
            //$ingest['materiaFluxo'] = $materias;
			$ingest['versao'] = 'A';
		    $ingest['tipoFluxo'] = 'M';
		    $ingest['tipoIngest'] = 'P';

            $ingestParceiro['idIngestParceiro'] = $idIngestParceiro;
            $ingestParceiro['idPrograma'] = $idProgramasParceiros;
            $ingestParceiro['tituloPrograma'] = $tituloPrograma;
			$ingestParceiro['numeroPGM'] = $numeroPGM;
            $ingestParceiro['parceiro_id'] = $idParceiros;
			$ingestParceiro['ingest_id'] = $idIngest;
			$ingestParceiro['observacao'] = $observacao;
			//$ingestParceiro['closedCaption'] = $closedCaption;

			if($this->ingestDao->updateIngestParceiro($ingest,$ingestParceiro)){
				$this->session->set_flashdata('resultado_ok','Ingest Alterado com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao alterar o Ingest!');
				redirect(base_url() . $url,'refresh');
			}


		}


	}

	/* ============================ ClosedCaption =====================================*/

	function ingestClosedCaption(){
		$idIngest = $this->input->post('idIngest');
		$catalogacao = $this->catalogacaoDao->selectCatalogacaoByIdIngest($idIngest);
		$data['idIngestClosedCaption'] = null;
		$data['usuario_id_ingest_closedCaption'] = $this->session->userdata('idUsuario');
		$data['ingest_id'] = $idIngest;
		$data['ingestPosterior'] = (count($catalogacao) > 0 )? 'S':'N';
		//$data['ingestPosterior'] =  'S';
		if( $this->ingestDao->insertIngestClosedCaption($data)){
		    echo true;
		}else{
			echo false;
		}
	}

	function semIngestClosedCaption(){
		$idIngest = $this->input->post('idIngest');
		if( $this->ingestDao->insertSemIngestClosedCaption($idIngest)){
		    echo true;
		}else{
			echo false;
		}
	}

	function desfazerClosedCaption(){
		$idIngest = $this->input->post('idIngest');
		if( $this->ingestDao->desfazerClosedCaption($idIngest)){
		    echo true;
		}else{
			echo false;
		}
	}

	function corrigirIngestClosedCaption(){

		$idIngest = $this->input->post('idIngest');
		$idPauta = $this->input->post('idPauta');
		$idPrograma =  ($this->input->post('idPrograma') != null)? $this->input->post('idPrograma') : null;

    	$idParceiros =  ($this->input->post('idParceiros') != null)? $this->input->post('idParceiros') : null;
    	$idIngestParceiro =  ($this->input->post('idIngestParceiro') != null)? $this->input->post('idIngestParceiro') : null;

    	$idInterProgramas =  ($this->input->post('idInterProgramas') != null)? $this->input->post('idInterProgramas') : null;
    	$idIngestInterPrograma =  ($this->input->post('idIngestInterPrograma') != null)? $this->input->post('idIngestInterPrograma') : null;

		$idInterProgramaCasa =  ($this->input->post('idInterProgramaCasa') != null)? $this->input->post('idInterProgramaCasa') : null;
    	$idIngestInterCasa =  ($this->input->post('idIngestInterCasa') != null)? $this->input->post('idIngestInterCasa') : null;

    	$tipoFluxo =  $this->input->post('tipoFluxo');
		$tipoIngest =  $this->input->post('tipoIngest');

		$closedCaption = $this->input->post('closedCaption');
		$idRevisaoClosedCaptionProblema = $this->input->post('idRevisaoClosedCaptionProblema');
		$resposta = $this->input->post('resposta');

		$url = "";
		switch ($tipoIngest) {
			case 'C':
				if($tipoFluxo=='M'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/ingestClosedCaption/midias';
				}elseif($tipoFluxo=='B'){
					$url = 'controlMidiasProgramaCasa/fluxo/'.$idPrograma.'/ingestClosedCaption/brutas';
				}
				break;
			case 'CH':
				$url = 'controlMidiasChamadas/fluxo/'.$idPrograma.'/ingestClosedCaption';
				break;
			case 'CHP':
				$url = 'controlMidiasChamadasParceiros/fluxo/'.$idParceiros.'/ingestClosedCaption';
				break;
			case 'P':
				$url = 'MidiasParceirosController/viewfluxoParceiros/'.$idParceiros.'/ingestClosedCaption';
				break;
			case 'IP':
				$url = 'controlMidiasInterParceiros/fluxo/'.$idInterProgramas.'/ingestClosedCaption';
				break;
			case 'IC':
				$url = 'controlMidiasInterCasa/fluxo/'.$idInterProgramaCasa.'/ingestClosedCaption';
				break;

			default:

				break;
		}

		$mensagem = array();


		if($closedCaption == ''){
			$mensagem[] = "Por favor, informe a Correção do <b>Closed Caption</>.";
		}


		if(count($mensagem)>0){
			 $this->session->set_flashdata('mensagem',$mensagem);
			 redirect(base_url() . $url,'refresh');
		}else{

			$data['dt_atualiza'] = Date("Y-m-d H:i:s");
			$data['usuario_atualiza'] = $this->session->userdata('idUsuario');

			if($this->ingestDao->updateCorrecaoIngestClosedCaption($data,$idIngest,$idRevisaoClosedCaptionProblema,$resposta)){

				$this->revisaoClosedCaptionDao->atualizaRevisaoCorrigido($idIngest);
				$this->session->set_flashdata('resultado_ok','Ingest de <b>Closed Caption</b> corrigido com sucesso!');
				redirect(base_url() . $url,'refresh');
			}else{
				$this->session->set_flashdata('resultado_error','Erro ao corrigir Ingest de <b>Closed Caption</b>!');
				redirect(base_url() . $url,'refresh');
			}


		}
	}








	function deleteAutorizacao(){
		$idIngest = $this->input->post('idIngest');
		$idAutorizacao = $this->input->post('idAutorizacao');
		if( $this->parceirosDao->deleteAutorizacao($idIngest,$idAutorizacao)){
		    echo true;
		}else{
			echo false;
		}
	}




	function deleteIngestParceiro(){
		$idIngest = $this->input->post('idIngest');
		if($this->ingestDao->deleteIngestParceiro($idIngest)){
		    echo true;
		}else{
			echo false;
		}
	}

}
