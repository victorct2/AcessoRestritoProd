<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_filter2 extends CI_Controller {
 
 public function __construct()
 {
  parent::__construct();
   if(!$this->session->userdata('logged_in')){
            redirect(base_url() . 'Login', 'refresh');
        }
  $this->load->model('product_filter_model2');
 }

 function index()
 {
  $this->load->view('include/openDoc');
  $data['descricao_data'] = $this->product_filter_model2->fetch_filter_type('tipo_arquivo.descricao');
  #$data['ram_data'] = $this->product_filter_model2->fetch_filter_type('product_ram');
  #$data['product_storage'] = $this->product_filter_model2->fetch_filter_type('product_storage');
  $this->load->view('paginas/product/product_filter2', $data);
  
 }

 function fetch_data()
 {
  sleep(1);
  $descricao = $this->input->post('descricao');
  #$ativa = $this->input->post('ativa');
  #$id = $this->input->post('id');
  $this->load->library('pagination');
  $config = array();
  $config['base_url'] = '#';
  $config['total_rows'] = $this->product_filter_model2->count_all($descricao);
  $config['per_page'] = 8;
  $config['uri_segment'] = 3;
  $config['use_page_numbers'] = TRUE;
  $config['full_tag_open'] = '<ul class="pagination">';
  $config['full_tag_close'] = '</ul>';
  $config['first_tag_open'] = '<li>';
  $config['first_tag_close'] = '</li>';
  $config['last_tag_open'] = '<li>';
  $config['last_tag_close'] = '</li>';
  $config['next_link'] = '&gt;';
  $config['next_tag_open'] = '<li>';
  $config['next_tag_close'] = '</li>';
  $config['prev_link'] = '&lt;';
  $config['prev_tag_open'] = '<li>';
  $config['prev_tag_close'] = '</li>';
  $config['cur_tag_open'] = "<li class='active'><a href='#'>";
  $config['cur_tag_close'] = '</a></li>';
  $config['num_tag_open'] = '<li>';
  $config['num_tag_close'] = '</li>';
  $config['num_links'] = 3;
  $this->pagination->initialize($config);
  $page = $this->uri->segment(3);
  $start = ($page - 1) * $config['per_page'];
  $output = array(
   'pagination_link'  => $this->pagination->create_links(),
   'product_list'   => $this->product_filter_model2->fetch_data($config["per_page"], $start, $descricao)
  );
  echo json_encode($output);
 }
  
}

?>