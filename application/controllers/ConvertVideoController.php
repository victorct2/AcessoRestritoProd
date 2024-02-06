<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConvertVideoController extends CI_Controller {

   

    public function convertVideoFffmpeg720(){
        $nomeVideo   = $this->input->post('videoName');        
        $qualidade   = $this->input->post('qualidade');  
        $caminhoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/arquivos/';
        $destinoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/videos/720/';
        $arrayNomeVideo = explode('.',$nomeVideo);
        $nomeVideoSemEXT = $arrayNomeVideo[0];
        //$exec_string = 'ffmpeg -i '.$caminhoVideo.$nomeVideo.' -strict -2  '.$destinoVideo.$nomeVideo.' 1> '.$caminhoVideo.$nomeVideoSemEXT.'_720.txt  2>&1;  > '.$caminhoVideo.$nomeVideoSemEXT.'_240.txt ';
        if($qualidade == 'HD'){
        	$exec_string = 'ffmpeg -i '.$caminhoVideo.$nomeVideo.' -acodec libfdk_aac -aq 100 -vcodec libx264 -preset slow -crf 22 -b 4000 -ab 32 -s 1280x720 -pix_fmt yuv420p  '.$destinoVideo.$nomeVideoSemEXT.'.mp4  1> '.$caminhoVideo.$nomeVideoSemEXT.'_720.txt  2>&1';
        }else{
        	$exec_string = 'ffmpeg -i '.$caminhoVideo.$nomeVideo.' -acodec libfdk_aac -aq 100 -vcodec libx264 -preset slow -crf 22 -b 2000 -ab 32 -s 720x480 -pix_fmt yuv420p  '.$destinoVideo.$nomeVideoSemEXT.'.mp4  1> '.$caminhoVideo.$nomeVideoSemEXT.'_720.txt  2>&1';
        }

        exec($exec_string, $output, $value);                      

        $result = array(
            'value' => $value,
            'output' => $output
        );

        echo json_encode($result);
    }

    public function convertVideoFffmpeg240(){
        $nomeVideo   = $this->input->post('videoName');
        $qualidade   = $this->input->post('qualidade');  
        $caminhoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/arquivos/';
        $destinoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/videos/240/';
        $arrayNomeVideo = explode('.',$nomeVideo);
        $nomeVideoSemEXT = $arrayNomeVideo[0];

        if($qualidade == 'HD'){
        	$exec_string = 'ffmpeg -i '.$caminhoVideo.$nomeVideo.' -acodec libfdk_aac -aq 100 -vcodec libx264 -preset slow -crf 22 -b 800 -ab 6 -s 854x480 -pix_fmt yuv420p  '.$destinoVideo.$nomeVideoSemEXT.'.mp4  1> '.$caminhoVideo.$nomeVideoSemEXT.'_240.txt  2>&1';
        }else{	
        	$exec_string = 'ffmpeg -i '.$caminhoVideo.$nomeVideo.' -acodec libfdk_aac -aq 100 -vcodec libx264 -preset slow -crf 22 -b 300 -ab 6 -s 480x360 -pix_fmt yuv420p  '.$destinoVideo.$nomeVideoSemEXT.'.mp4  1> '.$caminhoVideo.$nomeVideoSemEXT.'_240.txt  2>&1';
        }

        exec($exec_string, $output, $value);                      

        $result = array(
            'value' => $value,
            'output' => $output
        );

        echo json_encode($result);
    }

    public function zipVideo(){
        $nomeVideo   = $this->input->post('videoName');
        $caminhoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/videos/720/';
        $destinoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/videos/zip/';
        $arrayNomeVideo = explode('.',$nomeVideo);
        $nomeVideoSemEXT = $arrayNomeVideo[0];
        $exec_string = 'cd '.$caminhoVideo.'; zip -r '.$destinoVideo.$nomeVideoSemEXT.'.zip  '.$nomeVideoSemEXT.'.mp4';
        exec($exec_string, $output, $value);                      

        $result = array(
            'value' => $value,
            'output' => $output
        );
        echo json_encode($result);
    }

    public function imagensVideo(){
        $nomeVideo   = $this->input->post('videoName');
        $qualidade   = $this->input->post('qualidade'); 
        $caminhoVideo = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/arquivos/';
        $destinoImagem = $_SERVER['DOCUMENT_ROOT'] . '/uploadVideos/videos/img/';
        $arrayNomeVideo = explode('.',$nomeVideo);
        $nomeVideoSemEXT = $arrayNomeVideo[0];
        $total_segundos = shell_exec("ffprobe -v quiet -of csv=p=0 -show_entries format=duration ". $caminhoVideo.$nomeVideo);
        $frame_antigo = null;
        $erro = null;
        $imgLog = null;
        $imagens = null;
        for ($i = 1; $i <= 3; ) {
            // Gera um número de 200 a o número total de quadros.
			//echo 'i = ' . $i .'<br>';
            if($total_segundos > 30){
                $frame = mt_rand(30,intval($total_segundos));       
            }else if($total_segundos < 30){
                $frame = mt_rand(1,intval($total_segundos));   
            }
            
			//echo 'frame = ' . $frame .'<br>';
            if( $frame_antigo != $frame ){		
                //$exec_string_img = "ffmpeg -i ".$caminhoVideo.$nomeVideo." -an -s 480x360 -ss ".$frame." -vframes 1 -r 1 ".$destinoImagem.$i."-".$nomeVideoSemEXT.".jpg   2>&1";
                $exec_string_img = "ffmpeg -i ".$caminhoVideo.$nomeVideo." -an -s 1280x720 -ss ".$frame." -vframes 1 -r 1 ".$destinoImagem.$i."-".$nomeVideoSemEXT.".jpg   2>&1";         
                //Executando o Script com exec(), retornando o valor para verificação de erro
                exec($exec_string_img, $output, $value);                
                $result_img = var_export($value, true);               
                if($result_img > 0){
                    $imgLog[] =  $result_img;
                    $erro[] = 'Erro ao criar a imagem nº:'.$i.'!';  
					//echo '<pre>';
					//print_r($erro);
					//print_r($imgLog);
					//echo '</pre>';
                }else{
                    $imagens[] = $i."-".$nomeVideoSemEXT.".jpg";
                }
                $frame_antigo = $frame;
                $i++;
            }            
        }    
        $result = array(
            "resultImagem" => $imgLog, 
            "Segundos" => $total_segundos,
            "Erro" => $erro,
            "String" => $exec_string_img,
            'imagens' => $imagens 
        );

        echo json_encode($result);
    }
    
}