<?php
/*ini_set('memory_limit','512M');
set_time_limit(0);
ini_set('max_input_time','15000M');*/
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// upload.php
// 'images' refers to your file input name attribute
//print_r($_FILES);

if (empty($_FILES['upload'])) {
    echo json_encode(['error'=>'Não há arquivos encontrados para upload.']);
    // or you can throw an exception
    return; // terminate
}

// get the files posted
$videos = $_FILES['upload'];
print_r($videos);
// get user id posted
//$userid = empty($_POST['userid']) ? '' : $_POST['userid'];

// get user name posted
//$username = empty($_POST['username']) ? '' : $_POST['username'];

// a flag to see if everything is ok
$success = null;

// file paths to store
$paths= array();

// get file names
$filenames = $videos['name'];

print_r($filenames);

// loop and process files
for($i=0; $i < count($filenames); $i++){
    $ext = explode('.', basename($filenames[$i]));
    //$target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
    $nomeId = md5(uniqid()) . "." . array_pop($ext);
    $target = $_SERVER['DOCUMENT_ROOT'] . 'uploadVideos/arquivos/' . $nomeId;
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/fundicaocamilo/upload/arquivos/'.basename($filenames[$i]);
	//$targetFile =  str_replace('//','/',$targetPath);
	$urlUpload = $_SERVER['DOCUMENT_ROOT'] . "uploadVideos/arquivos/" . $nomeId;


	echo 'target '  .$target . '<br>';
	echo 'basename '.basename($filenames[$i]). '<br>';
	echo 'DOCUMENT_ROOT: ' .$_SERVER['DOCUMENT_ROOT'] . '<br>';
	echo 'videos tmp name :'.$videos['tmp_name'][$i] . '<br>';
	//echo $targetFile . '<br>';

    if(move_uploaded_file($videos['tmp_name'][$i], $target)) {
        $success = true;
        $paths[] = $target;
		chmod ($target, 0777);
		$infoVideosEnviados[$i]=array("caption"=>$nomeId,"height"=>"120px","key"=>$nomeId);
	    //$VideosEnviados[$i]="<img  height='120px'  src='$urlUpload' class='file-preview-image'>";
    } else {
        $success = false;
        break;
    }


}

// check and process based on successful status
if ($success === true) {
    // call the function to save all data to database
    // code for the following function `save_data` is not
    // mentioned in this example
    //save_data($paths);

    // store a successful response (default at least an empty array). You
    // could return any additional response info you need to the plugin for
    // advanced implementations.
    //$output = array();
    // for example you can get the list of files uploaded this way
    //$output = ['uploaded' => $nomeId];
	$output = array("initialPreviewConfig"=>$infoVideosEnviados);

} elseif ($success === false) {
    $output = ['error'=>'Erro ao carregar os vídeos. Entre em contato com o administrador do sistema'];
    // delete any uploaded files
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $output = ['error'=>'Nenhum arquivo foi processado.'];
}

// return a json encoded response for plugin to process successfully
echo json_encode($output);





?>
