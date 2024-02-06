<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/



// upload.php
// 'images' refers to your file input name attribute
if (empty($_FILES['arquivos'])) {
    echo json_encode(['error'=>'Não há arquivos encontrados para upload.']); 
    // or you can throw an exception 
    return; // terminate
}

// get the files posted
$images = $_FILES['arquivos'];

// get user id posted
//$userid = empty($_POST['userid']) ? '' : $_POST['userid'];

// get user name posted
//$username = empty($_POST['username']) ? '' : $_POST['username'];

// a flag to see if everything is ok
$success = null;

// file paths to store
$paths= array();

// get file names
$filenames = $images['name'];



// loop and process files
for($i=0; $i < count($filenames); $i++){
    $ext = explode('.', basename($filenames[$i]));
    //$target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
    $nomeId = md5(uniqid()) . "." . array_pop($ext);
    $target = $_SERVER['DOCUMENT_ROOT'] . '/uploadArquivos/arquivos/' . $nomeId;
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . '/fundicaocamilo/upload/arquivos/'.basename($filenames[$i]);
	//$targetFile =  str_replace('//','/',$targetPath);
	$urlUpload = $_SERVER['DOCUMENT_ROOT'] . "/uploadArquivos/arquivos/" . $nomeId;
	
	/*echo $target . '<br>';
	echo basename($filenames[$i]). '<br>';
	echo $_SERVER['DOCUMENT_ROOT'] . '<br>';
	echo $images['tmp_name'][$i] . '<br>';
	//echo $targetFile . '<br>';*/
	
    if(move_uploaded_file($images['tmp_name'][$i], $target)) {
        $success = true;
        $paths[] = $target;
		chmod ($target, 0777);
		$infoImagensSubidas[$i]=array("caption"=>$nomeId,"height"=>"120px","key"=>$nomeId);
	    $ImagensSubidas[$i]="<img  height='120px'  src='$urlUpload' class='file-preview-image'>";
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
	$output = array("initialPreviewConfig"=>$infoImagensSubidas);
    
} elseif ($success === false) {
    $output = ['error'=>'Erro ao carregar imagens. Entre em contato com o administrador do sistema'];
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