<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
**  CodeIgniter
**
**	FUNÇÕES DE TRATAMENTO E VALIDAÇÃO DE VARIÁVEIS
**
**	autor: Elom Waizmam
*/


function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';	
	$retorno = '';
	$caracteres = '';

	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}

function gerarDatasEntreDatas($d1,$d2){

	$arrayData = array();

	$timestamp1 = strtotime( $d1 );
	$timestamp2 = strtotime( $d2 );

	$cont = 1;
	while ( $timestamp1 <= $timestamp2 ){
		$arrayData[] = date('Y-m-d', $timestamp1);
		//echo $cont . ' - ' . date( 'd/m/Y', $timestamp1 ) . PHP_EOL;
		$timestamp1 += 86400;
		$cont++;
		}
	return $arrayData;
}


/*
**  Converte a Data Para ser inserida no Banco de Dados
*/
function converteDataBanco($data) {

	if(strpos($data, '-')){
		$d = explode("-", $data);
		return trim($d[2]).'-'.trim($d[1]).'-'.trim($d[0]);
	} else if(strpos($data, '/')) {
		$d = explode("/", $data);
		return trim($d[2]).'-'.trim($d[1]).'-'.trim($d[0]);
	}

}


/*
**  Validando a Data Para ser inserida no Banco de Dados
*/
function validaData($data){

	// fatia a string $data em pedaços, usando - como referência
	if(strpos($data, '-')){
		$data = explode("-",$data);
	} else if(strpos($data, '/')){
		$data = explode("/",$data);
	}
	$d = (int) $data[0];
	$m = (int) $data[1];
	$y = (int) $data[2];

	// verifica se a data é válida!
	// 1 = true (válida)
	// 0 = false (inválida)
	$res = checkdate($m,$d,$y);

	return $res;
}



function validaHora($hora){

	if (preg_match('/^[0-9]{2}:[0-9]{2}$/', $hora)) {

	   list($hour,$minute) = explode(':',$hora);

	   if ($hour > -1 && $hour < 24 && $minute > -1 && $minute < 60) {
	     	return true;
	   }
	   else{
	   	  	return false;
	   }

	} else {
		return false;
	}

}


function compararHora($hora){

	$horafixa = strtotime($hora);
	$horaatual = strtotime(date('H:i:s'));

	if($horaatual > $horafixa){
	    /*print("Agora a hora é maior\n");
	    print($horaatual);*/
	    return true;
	}else{
		return false;
	}

}

/*
**  Verificando se a 1ªdata é menor que a 2ª
*/
function datasCoerentes($data1, $data2) {

        $inicio = explode("/",$data1);
        $i = mktime(0,0,0,$inicio[1],$inicio[2],$inicio[0]);
		//$i = intval( $inicio[1]) + intval($inicio[2]) + intval($inicio[0]);

        $termino = explode("/",$data2);
        $t = mktime(0,0,0,$termino[1],$termino[2],$termino[0]);
		//$t = intval($termino[1]) + intval($termino[2]) + intval($termino[0]);


    if(($t - $i) < 0) {
        return false;
    }else if(($t - $i) == 0){
			return 2;
		}else{
      	return true;
		}
}


/*
**  Verificando se a 1ªdata é menor que a 2ª
*/
function CompararDatas($data1, $data2) {

    $data_inicial = implode(array_reverse(explode("/", $data1)));

		$data_final = implode(array_reverse(explode("/", $data2)));

		if($data_inicial > $data_final){
			return TRUE;
		}else{
			return FALSE;
		}
}


/*
**  Converte a Data Para ser mostrada nas views
*/
function converteDataInterface($dataInterface) {

	@$data = reset(explode(" ", trim($dataInterface)));
	@$hora = end(explode(" ", trim($dataInterface)));
	$dataFormatada = null;

	if($data === $hora){
		$hora = null;
	}

	if(strpos($data, '-')){
		$d = explode("-", $data);
		$dataFormatada = $d[2].'/'.$d[1].'/'.$d[0];
	} else if(strpos($data, '/')) {
		$d = explode("/", $data);
		$dataFormatada = $d[2].'/'.$d[1].'/'.$d[0];
	}


	if($hora != ''){
		return $dataFormatada . " " . $hora;
	}else{
		return $dataFormatada;
	}

}

/*
**  Dia da Semana - Agendamento
*/
function diasemana($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

	switch($diasemana) {
		case"0": $diasemana = "Domingo";       break;
		case"1": $diasemana = "Segunda-Feira"; break;
		case"2": $diasemana = "Terça-Feira";   break;
		case"3": $diasemana = "Quarta-Feira";  break;
		case"4": $diasemana = "Quinta-Feira";  break;
		case"5": $diasemana = "Sexta-Feira";   break;
		case"6": $diasemana = "Sábado";        break;
	}

	return "$diasemana";
}


/*
**  Trata o campos dos formulários
*/
function sql_inject($campo){
	$campo = get_magic_quotes_gpc() == 0 ? addslashes($campo) : $campo;
	$campo = strip_tags($campo);
	$campo = trim($campo);
	return preg_replace("@(--|\#|\*|;|=)@s", "", $campo);
}



/*
**  Ajustando o CEP - tirando os ("." e "-")
*/
function tratarCEP($cep) {

	$array_cep = explode("-", $cep);
	$cep_tratado = $array_cep[0] . $array_cep[1];

	return $cep_tratado;

}


/*
** Ajustando o Telefone - tirando os ("()" e "-")
*/
function tratarTelefone($telefone) {

	$array_telefone = explode("(", $telefone);
	$telefone1 = $array_telefone[0] . $array_telefone[1];

	$array_telefone2 = explode(")", $telefone1);
	$telefone2 = $array_telefone2[0] . $array_telefone2[1];

	$array_telefone = explode("-", $telefone2);
	$telefone_tratado = $array_telefone[0] . $array_telefone[1] ;

	return $telefone_tratado;

}


/*
** Validando Email
*/
function validarEmail ($email) {
        $email=trim (strtolower($email));
        if (strlen($email)<6) return false;
        if (!preg_match('/^[a-z0-9]+([\._-][a-z0-9]+)*@[a-z0-9_-]+(\.[a-z0-9]+){0,4}\.[a-z0-9]{1,4}$/',$email)) return false;
        $dominio=end (explode ('@',$email));
        //if (!gethostbynamel ($dominio)) return false;
        return true;
}





/* /*
**  Ajustando o CNPJ - tirando os ("." e "-")
*/
function tratarCNPJ($cnpj) {

	$array_cnpj = explode("-", $cnpj);
	$cnpj1 = @$array_cnpj[0] . @$array_cnpj[1];

	$array_cnpj2 = explode("/", $cnpj1);
	$cnpj2 = @$array_cnpj2[0] . @$array_cnpj2[1]. @$array_cnpj2[2];

	$array_cnpj3 = explode(".", $cnpj2);
	$cnpj_tratado = @$array_cnpj3[0] . @$array_cnpj3[1]. @$array_cnpj3[2];

	return $cnpj_tratado;

}

/*
**  Ajustando o CPF - tirando os ("." e "-")
*/
function tratarCPF($cpf) {

	$array_cpf = explode("-", $cpf);
	$cpf1 = @$array_cpf[0] . @$array_cpf[1];

	$array_cpf2 = explode(".", $cpf1);
	$cpf_tratado = @$array_cpf2[0] . @$array_cpf2[1]. @$array_cpf2[2];

	return $cpf_tratado;

}



/*
**  Validando o CPF
*/
function validar_cpf($cpf) {

    // Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 ||
        $cpf == '00000000000' ||
        $cpf == '11111111111' ||
        $cpf == '22222222222' ||
        $cpf == '33333333333' ||
        $cpf == '44444444444' ||
        $cpf == '55555555555' ||
        $cpf == '66666666666' ||
        $cpf == '77777777777' ||
        $cpf == '88888888888' ||
        $cpf == '99999999999') {
        return FALSE;
    } else {
        // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return FALSE;
            }
        }
        return TRUE;
    }
}



/*
** Validando o CNPJ
*/
function validaCNPJ($cnpj) {
    if (strlen($cnpj) <> 18) return 0;
    $soma1 = ($cnpj[0] * 5) +

    ($cnpj[1] * 4) +
    ($cnpj[3] * 3) +
    ($cnpj[4] * 2) +
    ($cnpj[5] * 9) +
    ($cnpj[7] * 8) +
    ($cnpj[8] * 7) +
    ($cnpj[9] * 6) +
    ($cnpj[11] * 5) +
    ($cnpj[12] * 4) +
    ($cnpj[13] * 3) +
    ($cnpj[14] * 2);
    $resto = $soma1 % 11;
    $digito1 = $resto < 2 ? 0 : 11 - $resto;
    $soma2 = ($cnpj[0] * 6) +

    ($cnpj[1] * 5) +
    ($cnpj[3] * 4) +
    ($cnpj[4] * 3) +
    ($cnpj[5] * 2) +
    ($cnpj[7] * 9) +
    ($cnpj[8] * 8) +
    ($cnpj[9] * 7) +
    ($cnpj[11] * 6) +
    ($cnpj[12] * 5) +
    ($cnpj[13] * 4) +
    ($cnpj[14] * 3) +
    ($cnpj[16] * 2);
    $resto = $soma2 % 11;
    $digito2 = $resto < 2 ? 0 : 11 - $resto;
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
}


/*
** Formatar
*/
function formatar($string, $tipo = "")
{
    $string = preg_replace("[^0-9]", "", $string);

   /* if (!$tipo)
    {
        switch (strlen($string))
        {
            case 10:    $tipo = 'fone';     break;
            case 8:     $tipo = 'cep';      break;
            case 11:    $tipo = 'cpf';      break;
            case 14:    $tipo = 'cnpj';     break;
        }

    }*/

    switch ($tipo)

    {	
		case 'cel':
			$string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 5) . '-' . substr($string, 7);
		break;

        case 'fone':
            $string = '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . '-' . substr($string, 6);
        break;

        case 'cep':
            $string = substr($string, 0, 5) . '-' . substr($string, 5, 3);
        break;

        case 'cpf':
            $string = substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
        break;

        case 'cnpj':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2);
        break;

        case 'rg':
            $string = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3);
        break;
    }

    return $string;

	/*
	UTILIZAÇÃO
	echo formatar ('3135399000', 'fone');
	// (31) 3539-9000
	*/

}



/*
 *  Separar Data e hora de campos TIMESTAMP
 */

function separaDataHora($dataHora){

	$array = explode(' ', $dataHora);

	$data = $array[0];
	$hora = $array[1];

	$array_data = explode("-", $data);

	$ano = $array_data[0];
	$mes = $array_data[1];
	$dia = $array_data[2];

	$res = checkdate($mes,$dia,$ano);

	if ($res == 1){
		$data_valida = $dia .'/' .$mes .'/'. $ano;
		return $data_valida;
	}

}

function formatarDataHora($dataHora){

	$array = explode(' ', $dataHora);

	$data = $array[0];
	$hora = $array[1];

	$array_data = explode("-", $data);

	$ano = $array_data[0];
	$mes = $array_data[1];
	$dia = $array_data[2];

	$res = checkdate($mes,$dia,$ano);

	if ($res == 1){
		$data_valida = $dia .'/' .$mes .'/'. $ano;
		return $data_valida.' - '. $hora ;
	}

}


function convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }
    else {
        return $data;
    }
}

function arrayToObject($array) {
    if (!is_array($array)) {
        return $array;
    }

    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
        foreach ($array as $name=>$value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = arrayToObject($value);
            }
        }
        return $object;
    }
    else {
        return FALSE;
    }
}

function retornaDataEstilizada($dataHora,$rcs = 0){

	$array = explode(' ', $dataHora);

	$hora = $array[1];
	$tm = strtotime($dataHora);

	$cur_tm = time();
	$dif = $cur_tm-$tm;
    $pds = array('segundo','minuto','hora','dia','semana','mes','ano','decada');
    $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
    for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

    $no = floor($no);

    if($no <> 1){
    	if ( $v == 5 )
    		$pds[$v] .='es atrás';
    	else
    		$pds[$v] .='s atrás';
    }else{
    	$pds[$v] .= ' atrás';
    }

    $x=sprintf("%d %s",$no,$pds[$v]);
    if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
    return $x;

}


function formatarDuracaoVideo($duracao){

		$array = explode(':',$duracao);

		$hora = ($array[0] == '00')? '': intval($array[0]);
		$min = intval($array[1]);
		$seg = $array[2];


		if($min < 10  && $hora!=''){
				$min = '0'.$min;
		}

		$time = '';

		if($hora != ''){
				$duration = $hora.':'.$min.':'.$seg;
		}else{
			$duration = $min.':'.$seg;
		}

		return $duration;

}

/*
** URL Amigável (Friendly_url)
*/
function getRawUrl($url) {
	$string = convert_accented_characters($url);
	$b =  url_title($string,"dash",TRUE);
	return strtolower($b);
}


function proximaVersao($versaoAtual){
	
	$letras = range($versaoAtual, 'Z');
	
	for ($i=1; $i < count($letras); $i++) { 
		return $letras[$i];
	}
	
}