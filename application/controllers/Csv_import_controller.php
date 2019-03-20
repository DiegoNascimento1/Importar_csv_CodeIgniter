<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv_import_controller extends CI_Controller {
 
 public function __construct()
 {
  parent::__construct();
  $this->load->model('csv_import_model');
  $this->load->library('csvimport');
 }

public function index()
{
    $this->load->view('csv_import_view');
}

 public function carrega_dados()
 {
  $result = $this->csv_import_model->select();
  $output = '
   <h3 align="center"></h3>
        <div class="table-responsive">
         <table class="table table-bordered table-striped">
          <tr>
           <th>ID</th>
           <th>Data Vencimento</th>
           <th>Descrição</th>
           <th>Valor</th>
           <th>Categoria</th>
           <th>Forma de pagamento</th>
           <th>Data do pagamento</th>
           <th>Cliente/Fornecedor</th>
           <th>Centro de custo</th>
           <th>Custo de produção</th>
           <th>Custo do produto</th>
           <th>Observação</th>
           <th>Tipo de documento</th>
           <th>Documento</th>
           <th>Data da competência</th>
           <th>CNPJ/CPF</th>
           <th>Conta</th>
           <th>Tags</th>
          </tr>
  ';
  $count = 0;
  if($result->num_rows() > 0)
  {
   foreach($result->result() as $row)
   {
    $count = $count + 1;
    $output .= '
    <tr>
     <td>'.$count.'</td>
     <td>'.$row->data_vencimento.'</td>
     <td>'.$row->descricao.'</td>
     <td>'.$row->valor.'</td>
     <td>'.$row->categoria.'</td>
     <td>'.$row->forma_pagamento.'</td>
     <td>'.$row->data_pagamento.'</td>
     <td>'.$row->cliente_fornecedor.'</td>
     <td>'.$row->centro_custo.'</td>
     <td>'.$row->custo_producao.'</td>
     <td>'.$row->custo_produto.'</td>
     <td>'.$row->observacao.'</td>
     <td>'.$row->tipo_documento.'</td>
     <td>'.$row->documento.'</td>
     <td>'.$row->data_competencia.'</td>
     <td>'.$row->cnpj_cpf.'</td>
     <td>'.$row->conta.'</td>
     <td>'.$row->tags.'</td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
       <td colspan="17" align="center">Não há dados</td>
    </tr>
   ';
  }
  $output .= '</table></div>';
  echo $output;
 }

 function import()
 {
  $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
  foreach($file_data as $row)
  {
      //Preenchendo o array data com os dados do arquivo 
   $data[] = array(
        'data_vencimento' => $row["Data de vencimento"],
        'descricao'  => $row["Descricao"],
        'valor'   => $row["Valor"],
        'categoria'   => $row["Categoria"],
        'forma_pagamento'   => $row["Forma de pagamento"],
        'data_pagamento'   => $row["Data de pagamento"],
        'cliente_fornecedor'   => $row["Cliente/Fornecedor"],
        'centro_custo'   => $row["Centro de custo/lucro"],
        'custo_producao'   => $row["Custo n�vel de produ��o"],
        'custo_produto'   => $row["Custo apropria��o do produto"],
        'observacao'   => $row["Observa��o"],
        'tipo_documento'   => $row["Tipo de documento"],
        'documento'   => $row["Documento"],
        'data_competencia'   => $row["Data compet�ncia"],
        'cnpj_cpf'   => $row["Documento cliente/fornecedor"],
        'conta'   => $row["Conta"],
        'tags'   => $row["Tags"]
   );
  }
  //Salvando no banco
  $this->csv_import_model->insert($data);
 }
 
  
}