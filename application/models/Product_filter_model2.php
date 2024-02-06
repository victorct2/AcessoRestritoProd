<?php

class Product_filter_model2 extends CI_Model
{
 function fetch_filter_type($type)
 {
  $this->db->distinct();
  $this->db->select($type);
  $this->db->from('tipo_arquivo');
  $this->db->where('ativa', 'S');
  return $this->db->get();
 }

 function make_query($descricao)
 {
  $query = "
  SELECT tipo_arquivo.descricao,tipo_arquivo.id,nome_arquivo, arquivo, ativa, Data_cadastro FROM tipo_arquivo 
  inner join arquivo_upload on arquivo_upload.tipo_arquivo = tipo_arquivo.id
  inner join cooperado_arquivo on cooperado_arquivo.id_arquivo = arquivo_upload.id
  inner join usuarios on cooperado_arquivo.id_user = usuarios.id
  WHERE ativa = 'S'    and cooperado_arquivo.id_user= '".$this->session->userdata("idUsuario")."'
  ";

  

  if(isset($descricao))
  { 
   $descricao_filter = implode("','", $descricao);
   $query .= "
   
    AND tipo_arquivo.descricao in('".$descricao_filter."')
   ";
  }

  
  return $query;
 }

 
 function count_all($descricao )
 {
  $query = $this->make_query($descricao);
  $data = $this->db->query($query);
  return $data->num_rows();
 }

 function fetch_data($limit, $start, $descricao)
 {
  $query = $this->make_query($descricao );

  $query .= ' LIMIT '.$start.', ' . $limit;

  $data = $this->db->query($query);

  $output = '';
  if($data->num_rows() > 0)
  {
   foreach($data->result_array() as $row)
   {
    $output .= '
    <div class="col-sm-4 col-lg-3 col-md-3">
     <div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
            <p align="center"><strong><a href="#">'. $row['descricao'] .'</a></strong></p>
            Tipo de Arquivo : '. $row['descricao'] .' <br />      
      Nome do Arquivo : '. $row['nome_arquivo'] .' </p>
     <a target=_blank href="'.base_url().RESTRITO_UPLOAD.$row['arquivo'].'">Download</a></strong></p>
      Cadastro : '. $row['Data_cadastro'] .' </p>
      </div>
    </div>
    ';
   }
  }
  else
  {
   $output = '<h3>No Data Found</h3>';
  }
  return $output;
 }
}

?>
