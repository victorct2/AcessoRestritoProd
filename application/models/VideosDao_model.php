<?php

Class VideosDao_model extends CI_Model {

	public function __construct() {
		parent:: __construct();
	}

	function allVideos(){
		$this->db->order_by('id','desc');
		return $this->db->get('tb_video')->result();
	}

	function updateAllVideosDados($id, $numeroPgm, $id_programa){

		$numeroPgm = trim($numeroPgm);
		$id_programa = trim($id_programa);

		$this->db->where('numero_pgm',$numeroPgm);
		$this->db->where('idPrograma',$id_programa);
		$this->db->select('apresentadores,diretor,produtor,reporter,convidados,tags,sinopse,entrevistados');
		$this->db->from('ficha_conclusao');
		$this->db->join('ingest','ingest.id = ficha_conclusao.ingest_id');
		$dados  = $this->db->get()->result();


		if(count($dados) > 0){
			$data = array(
			'apresentador' => ($dados[0]->apresentadores == '' || $dados[0]->apresentadores == null)? null : $dados[0]->apresentadores,
			'diretor' => ($dados[0]->diretor == '' || $dados[0]->diretor == null)? null : $dados[0]->diretor,
			'produtor' => ($dados[0]->produtor == '' || $dados[0]->produtor == null)? null : $dados[0]->produtor,
			'reporter' => ($dados[0]->reporter == '' || $dados[0]->reporter == null)? null : $dados[0]->reporter,
			'convidados' => ($dados[0]->convidados == '' || $dados[0]->convidados == null)? null : $dados[0]->convidados,
			'entrevistados' => ($dados[0]->entrevistados == '' || $dados[0]->entrevistados == null)? null : $dados[0]->entrevistados,
			'tags' => ($dados[0]->tags == '' || $dados[0]->tags == null)? null : $dados[0]->tags,
			'sinopse' => ($dados[0]->sinopse == '' || $dados[0]->sinopse == null)? null : $dados[0]->sinopse,

		);

		$this->db->where('id',$id);
		return $this->db->update('tb_video',$data);
		}else{

			return false;
		}


	}

	function updateFriendlyUrl($novaUrl,$idVideo){
		$data = array(
			'friendly_url' => $novaUrl
		);
		$this->db->where('id',$idVideo);
		return $this->db->update('tb_video',$data);
	}

	function totalVideos($destaque = false, $incompletos= false, $inativos=false){
		if($destaque == true){
			$this->db->where('destaque','S');
		}
		if($inativos == true){
			$this->db->where('situacao','INATIVO');
		}
		if($incompletos == true){
			$this->db->where('situacao','INCOMPLETO');
		}
		return $this->db->get('tb_video')->num_rows();
	}

	function make_query(){
		$order_column = array(null,"nome","tb_video.descricao","titulo","data_video", null, null);
		$this->db->select('tb_video.id, nome, tb_video.descricao, tb_video.imagem, data_video,situacao,destaque, titulo,tb_video.friendly_url');
		$this->db->from('tb_video');
		$this->db->join('tb_programa','tb_programa.id = tb_video.id_programa');

		if(!empty($_POST['columns'][1]["search"]["value"])){
			$this->db->like("nome", $_POST['columns'][1]["search"]["value"]);
		}
		if(!empty($_POST['columns'][2]["search"]["value"])){
			$this->db->or_like("tb_video.descricao", $_POST['columns'][2]["search"]["value"]);
		}
		if(!empty($_POST['columns'][4]["search"]["value"])){
			$this->db->where("data_video", $_POST['columns'][4]["search"]["value"]);
		}
		if(!empty($_POST['columns'][3]["search"]["value"])){
			$this->db->where("tb_video.id_programa", $_POST['columns'][3]["search"]["value"]);
		}

		switch ($_POST['columns'][5]["search"]["value"]) {
			case 'ATIVO':
				$this->db->where("situacao", $_POST['columns'][5]["search"]["value"]);
				break;
			case 'INCOMPLETO':
				$this->db->where("situacao", $_POST['columns'][5]["search"]["value"]);
				break;
			case 'INATIVO':
				$this->db->where("situacao", $_POST['columns'][5]["search"]["value"]);
				break;
			case 'DESTAQUE':
				$this->db->where("destaque", 'S');
				break;
			case 'SEMDESTAQUE':
				$this->db->where("destaque", 'N');
				break;
			default:

				break;

		}

		if(isset($_POST["order"])){
			$this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else{
			$this->db->order_by('tb_video.id', 'DESC');
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
		$this->db->from('tb_video');
		return $this->db->count_all_results();
	}

	function nome_disponivel($nome) {
		$this->db->where('nome',$nome);
		return $this->db->get('tb_video')->result();
	}

	function selectVideoById($idVideo){
		$this->db->where('id',$idVideo);
		return $this->db->get('tb_video')->result();
	}

	function selectArquivoByIdVideo($idVideo){
		$this->db->where('id_video',$idVideo);
		$this->db->select('id_arquivo, tb_arquivo.nome, id_video, tb_arquivo.id_formato, tb_formato.nome as formato, tb_arquivo.id_taxa, resolucao');
		$this->db->from('tb_arquivo');
		$this->db->join('tb_formato','tb_formato.id_formato = tb_arquivo.id_formato');
		$this->db->join('tb_taxa_transmissao','tb_taxa_transmissao.id_taxa = tb_arquivo.id_taxa');
		return $this->db->get()->result();
	}

	function sequenciaPrograma($idPrograma){
		$this->db->where('id',$idPrograma);
		$this->db->select('sequencia,prefixo');
		return $this->db->get('tb_programa')->result();
	}

	function updateSequencia($sequencia,$id_programa){
		$this->db->where('id',$id_programa);
		$this->db->set('sequencia',$sequencia);
		return $this->db->update('tb_programa');
	}

	function arquivoVideo($idVideo){
		$this->db->where('id_formato',3);
		$this->db->where('id_video',$idVideo);
		$this->db->select('nome,id_taxa');
		return $this->db->get('tb_arquivo')->result();
	}


	function gerarSequencia($idPrograma){

		//echo 'idPrograma: '.$idPrograma. '<br>';

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);
		$sequencia = $programa[0]->sequencia;

		$livre = false;
		while ($livre == false):
			$sequencia = $sequencia +1;
			//echo 'sequencia: ' .$sequencia. '<br>';
			$this->db->where('sequencia_programa',$sequencia);
			$this->db->where('id_programa',$idPrograma);
			$result = $this->db->get('tb_video')->result();
			//echo 'result: '.count($result). '<br>';
			if(count($result)==0){
				//echo 'true<br>';
				$livre = true;
				return $sequencia;
				break;
			}
		endwhile;

	}

	function insertVideo($data,$arquivoVideo,$nomeImagem){

		//start the transaction
		$this->db->trans_begin();

			$this->db->insert('tb_video',$data);
			$idVideo = $this->db->insert_id();
			//echo $idVideo;

			$arrayArquivo= explode('.',$arquivoVideo);
        	$videoArquivo = $arrayArquivo[0].'.mp4';

			$this->videosDao_model->insertArquivo720($videoArquivo,$idVideo,$data['id_programa'],$data['sequencia_programa']);
			$this->videosDao_model->insertArquivo240($videoArquivo,$idVideo,$data['id_programa'],$data['sequencia_programa']);
			$this->videosDao_model->insertArquivoZIP($videoArquivo,$idVideo,$data['id_programa'],$data['sequencia_programa']);

			chmod('uploadVideos/videos/img/'.$nomeImagem, 0777);
			copy('uploadVideos/videos/img/'.$nomeImagem, 'assets/img/videos/'.$nomeImagem);
			unlink('uploadVideos/videos/img/'.$nomeImagem);

			$this->videosDao_model->updateSequencia($data['sequencia_programa'],$data['id_programa']);

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



	function insertArquivo720($arquivoVideo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_2000kbps.mp4';

		//$tamanho_Kb = number_format(filesize('uploadVideos/videos/720/'.$arquivoVideo) / 1024,1,".","");
		//$tamanho_Mb = number_format(filesize('uploadVideos/videos/720/'.$arquivoVideo) / 1048576,1);
		rename('uploadVideos/videos/720/'.$arquivoVideo,'uploadVideos/videos/720/'.$nomeVideo);

		$arquivo['id_arquivo'] = null ;
		$arquivo['nome'] = $nomeVideo;
		//$arquivo['tamanho_kb'] = $tamanho_Kb;
		//$arquivo['tamanho_mb'] = $tamanho_Mb;
		$arquivo['id_video'] = $idVideo;
		$arquivo['id_formato'] = 3;
		$arquivo['id_taxa'] = 5 ;

		if($this->db->insert('tb_arquivo',$arquivo)){
			copy('uploadVideos/videos/720/'.$nomeVideo,'streaming/'.$nomeVideo);
			unlink('uploadVideos/videos/720/'.$nomeVideo);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function insertArquivo240($arquivoVideo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_256kbps.mp4';

		//$tamanho_Kb = number_format(filesize('uploadVideos/videos/240/'.$arquivoVideo) / 1024,1,".","");
		//$tamanho_Mb = number_format(filesize('uploadVideos/videos/240/'.$arquivoVideo) / 1048576,1);
		rename('uploadVideos/videos/240/'.$arquivoVideo,'uploadVideos/videos/240/'.$nomeVideo);

		$arquivo['id_arquivo'] = null ;
		$arquivo['nome'] = $nomeVideo;
		//$arquivo['tamanho_kb'] = $tamanho_Kb;
		//$arquivo['tamanho_mb'] = $tamanho_Mb;
		$arquivo['id_video'] = $idVideo;
		$arquivo['id_formato'] = 3;
		$arquivo['id_taxa'] = 2 ;

		if($this->db->insert('tb_arquivo',$arquivo)){
			copy('uploadVideos/videos/240/'.$nomeVideo,'streaming/'.$nomeVideo);
			unlink('uploadVideos/videos/240/'.$nomeVideo);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function insertArquivoZIP($arquivoVideo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		$arquivoZip = explode('.',$arquivoVideo);
		$nomeVideoZip = $programa[0]->prefixo . '_'. $sequencia . '_2000kbps.zip';

		//$tamanho_Kb = number_format(filesize('uploadVideos/videos/zip/'.$arquivoVideo) / 1024,1,".","");
		//$tamanho_Mb = number_format(filesize('uploadVideos/videos/zip/'.$arquivoVideo) / 1048576,1);
		rename('uploadVideos/videos/zip/'.$arquivoZip[0].'.zip','uploadVideos/videos/zip/'.$nomeVideoZip);

		$arquivo['id_arquivo'] = null ;
		$arquivo['nome'] = $nomeVideoZip;
		//$arquivo['tamanho_kb'] = $tamanho_Kb;
		//$arquivo['tamanho_mb'] = $tamanho_Mb;
		$arquivo['id_video'] = $idVideo;
		$arquivo['id_formato'] = 2;
		$arquivo['id_taxa'] = 5;

		if($this->db->insert('tb_arquivo',$arquivo)){
			copy('uploadVideos/videos/zip/'.$nomeVideoZip,'download/'.$nomeVideoZip);
			unlink('uploadVideos/videos/zip/'.$nomeVideoZip);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function updateVideo($data,$arquivoVideo,$nomeImagem,$dadosAtuais,$atualizarImagem){

		//start the transaction
		$this->db->trans_begin();

			$this->db->where('id',$data['id']);
			$this->db->update('tb_video',$data);

			if($arquivoVideo != ''){
				$arrayArquivos = $this->videosDao_model->selectArquivoByIdVideo($data['id']);

				foreach ($arrayArquivos as $arquivo) {
					if($arquivo->resolucao == '240p'){
						unlink('streaming/'.$arquivo->nome);
					}elseif($arquivo->resolucao == '240p'){
						unlink('streaming/'.$arquivo->nome);
					}elseif($arquivo->formato == 'ZIP'){
						unlink('download/'.$arquivo->nome);
					}
				}

				$arrayArquivo= explode('.',$arquivoVideo);
        		$videoArquivo = $arrayArquivo[0].'.mp4';

				$this->videosDao_model->updateArquivo720($videoArquivo,$data['id'],$data['id_programa'],$data['sequencia_programa']);
				$this->videosDao_model->updateArquivo240($videoArquivo,$data['id'],$data['id_programa'],$data['sequencia_programa']);
				$this->videosDao_model->updateArquivoZIP($videoArquivo,$data['id'],$data['id_programa'],$data['sequencia_programa']);
			}
			else{

				if($dadosAtuais[0]->id_programa != $data['id_programa']){
					$arquivosArray = $this->videosDao_model->selectArquivoByIdVideo($data['id']);
					foreach($arquivosArray as $a){
						$this->videosDao_model->updateArquivoByIdPrograma($a,$data['id'],$data['id_programa'],$data['sequencia_programa']);
					}
				}
			}

			if($atualizarImagem){
				chmod('uploadVideos/arquivos/'.$nomeImagem, 0777);
				copy('uploadImagens/arquivos/'.$nomeImagem, 'assets/img/videos/'.$nomeImagem);
				unlink('uploadImagens/arquivos/'.$nomeImagem);
			}else{
				@rename('assets/img/videos/'.$imagem_atual, 'assets/img/videos/'.$nomeImagem);
			}

			if($dadosAtuais[0]->id_programa != $data['id_programa']){
				$this->videosDao_model->updateSequencia($data['sequencia_programa'],$data['id_programa']);
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

	function updateArquivo720($arquivoVideo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_2000kbps.mp4';

		rename('uploadVideos/videos/720/'.$arquivoVideo,'uploadVideos/videos/720/'.$nomeVideo);

		$arquivo['nome'] = $nomeVideo;

		$this->db->where('id_video',$idVideo);
		$this->db->where('id_formato',3);
		$this->db->where('id_taxa',5);
		if($this->db->update('tb_arquivo',$arquivo)){
			copy('uploadVideos/videos/720/'.$nomeVideo,'streaming/'.$nomeVideo);
			unlink('uploadVideos/videos/720/'.$nomeVideo);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function updateArquivo240($arquivoVideo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_256kbps.mp4';

		rename('uploadVideos/videos/240/'.$arquivoVideo,'uploadVideos/videos/240/'.$nomeVideo);

		$arquivo['nome'] = $nomeVideo;

		$this->db->where('id_video',$idVideo);
		$this->db->where('id_formato',3);
		$this->db->where('id_taxa',2);
		if($this->db->update('tb_arquivo',$arquivo)){
			copy('uploadVideos/videos/240/'.$nomeVideo,'streaming/'.$nomeVideo);
			unlink('uploadVideos/videos/240/'.$nomeVideo);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function updateArquivoZIP($arquivoVideo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		$arquivoZip = explode('.',$arquivoVideo);
		$nomeVideoZip = $programa[0]->prefixo . '_'. $sequencia . '_2000kbps.zip';

		rename('uploadVideos/videos/zip/'.$arquivoZip[0].'.zip','uploadVideos/videos/zip/'.$nomeVideoZip);

		$arquivo['nome'] = $nomeVideoZip;

		$this->db->where('id_video',$idVideo);
		$this->db->where('id_formato',2);
		$this->db->where('id_taxa',5);
		if($this->db->update('tb_arquivo',$arquivo)){
			copy('uploadVideos/videos/zip/'.$nomeVideoZip,'download/'.$nomeVideoZip);
			unlink('uploadVideos/videos/zip/'.$nomeVideoZip);
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function updateArquivoByIdPrograma($arquivo,$idVideo,$idPrograma,$sequencia){

		$programa = $this->videosDao_model->sequenciaPrograma($idPrograma);

		if($arquivo->resolucao == '720p' & $arquivo->formato == 'MP4'){
			$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_2000kbps.mp4';
			rename('streaming/'.$arquivo->nome,'streaming/'.$nomeVideo);
		}
		else if($arquivo->resolucao == '240p' & $arquivo->formato == 'MP4'){
			$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_256kbps.mp4';
			rename('streaming/'.$arquivo->nome,'streaming/'.$nomeVideo);
		}
		else if($arquivo->formato == 'ZIP'){
			$nomeVideo = $programa[0]->prefixo . '_'. $sequencia . '_2000kbps.zip';
			rename('download/'.$arquivo->nome,'download/'.$nomeVideo);
		}

		$arquivoUpdate['nome'] = $nomeVideo;

		$this->db->where('id_arquivo',$arquivo->id_arquivo);
		$this->db->where('id_video',$idVideo);
		if($this->db->update('tb_arquivo',$arquivoUpdate)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function deleteVideo($idVideo){

		//start the transaction
		$this->db->trans_begin();


		$this->db->where('id_video',$idVideo);
		$this->db->delete('tb_arquivo');

		$this->db->where('id',$idVideo);
		$this->db->delete('tb_video');

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


	function insertClosedCaption($data){
		return $this->db->insert('tbl_closed_caption',$data);
	}

	function updateClosedCaption($data){
		$this->db->where('id',$data['id']);
		return $this->db->update('tbl_closed_caption',$data);
	}

	function selectClosedCaptionByIdVideo($idVideo){
		$this->db->where('video_id',$idVideo);
		return $this->db->get('tbl_closed_caption')->result();
	}

	function selectClosedCaptionById($id){
		$this->db->where('id',$id);
		return $this->db->get('tbl_closed_caption')->result();
	}

	function deleteClosedCaption($id){
		$this->db->where('id',$id);
		return $this->db->delete('tbl_closed_caption');
	}

}

?>
