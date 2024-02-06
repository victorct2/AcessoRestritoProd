<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjustesVideos extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		
	}


	function ajustesVideos($admin='',$senha=''){
		
		if($admin == 'webc4n4l' && $senha=="c4n4ldvod"){

			$this->load->model('videosDao_model');
			$this->load->model('programasDao_model');
			
			
			$videos = $this->videosDao_model->allVideos();

			$count = 1;
					
			foreach ($videos as $v) {

				if($v->id_programa != 50 ){


						if($v->numeroPgm == ''){

							$dados = explode('#', $v->nome);                

							if(count($dados) > 1){
								$valor = explode(' ', $dados[1]);	
								
								if(count($valor) == 2){						

									$numeroPgm = $valor[1];
									
								}else if(count($valor) == 4){
									

									$numeroPgm = $valor[3];
									
								}else{
									$numeroPgm = $valor[2];

								}
								

								if($this->videosDao_model->updateAllVideosDados($v->id, $numeroPgm, $v->id_programa)){
									echo '<br>' . $count .' - Vídeo '.$v->id.' e numeroPgm = ' . $numeroPgm . ' e idPrograma = '. $v->id_programa . ' Ajustado com sucesso <br><br>';
									$count ++;
								}else{
									$programa = $this->programasDao_model->selectProgramaById($v->id_programa);
									echo 'Vídeo numeroPgm = ' . $numeroPgm . ' e Programa = <b>'.$v->id_programa.'  - '. $programa[0]->titulo . '</b>  -- teve um problema e não foi reajustado <br>';
									
								}

							}else{
								$programa = $this->programasDao_model->selectProgramaById($v->id_programa);
								echo  '  >>>>>>>>>Vídeo <b>'. $v->nome.'</b> sem número de PGM - <b>'.$programa[0]->titulo.'</b> <<<<<<<<<<<<<<<<<<br>';	
								
							}
				
										
						}else{
						
							if($this->videosDao_model->updateAllVideosDados($v->id, $v->numeroPgm, $v->id_programa)){
								echo '<br>' . $count .' - Vídeo '.$v->id.' e numeroPgm = ' . $v->numeroPgm . ' e idPrograma = '. $v->id_programa . ' Ajustado com sucesso <br><br>';
								$count ++;
							}else{
								$programa = $this->programasDao_model->selectProgramaById($v->id_programa);
								echo 'Vídeo numeroPgm = ' . $v->numeroPgm . ' e Programa = <b>'.$v->id_programa.'  - '. $programa[0]->titulo . '</b>  -- teve um problema e não foi reajustado <br>';
								
							}
						}
				
				}
				
			}	 
			echo '<br> <br><b>Ajustes Finalizados! </b>';
			

		}else{
			$this->index ();

		}

		
	}
	
	


}
