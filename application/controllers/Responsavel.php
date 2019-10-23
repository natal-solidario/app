<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Responsavel extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Responsavel_model');
        $this->load->model('Beneficiado_model');
        $this->load->model('NatalSolidario_model');

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('login');
        }
        else
        {
            $user = $this->ion_auth->user()->row();
            $this->session->set_userdata('usuario_logado', $user->email);
        }
    } 

    /*
     * Listing of responsaveis
     */
    function index()
    {
        $data['responsaveis'] = $this->Responsavel_model->get_all_responsaveis();
        
        $data['js_scripts'] = array('responsavel/index.js');
        $data['_view'] = 'responsavel/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new responsavel
     */
    function add()
    {
		$this->form_validation->set_rules('documento_numero','CPF','required|callback_check_cpf_unique');
		$this->form_validation->set_rules('nome','Nome','required');
		$this->form_validation->set_rules('data_nascimento','Data de Nascimento','required');
		$this->form_validation->set_rules('endereco','Logradouro','required');
		$this->form_validation->set_rules('bairro','Bairro','required');
		$this->form_validation->set_rules('cidade','Cidade','required');
		$this->form_validation->set_rules('uf','UF','required|exact_length[2]|alpha');
		
		if($this->form_validation->run())     
        {
            $date1 = strtr($this->input->post('data_nascimento'), '/', '-');

            $params_responsavel = array(
				'documento_tipo' => 'CPF',
				'nome' => mb_strtoupper(trim($this->input->post('nome'))),
				'data_nascimento' => date('Y-m-d', strtotime($date1)),
				'endereco' => $this->input->post('endereco'),
				'numero' => $this->input->post('numero'),
				'complemento' => $this->input->post('complemento'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'uf' => $this->input->post('uf'),
                'cep' => str_replace('-', '', $this->input->post('cep'))
            );

            if (in_array($this->input->post('metodo_busca'), array("0", "2"))) {
                $params_responsavel['documento_numero'] = $this->input->post('documento_numero');
            }

            $responsavel_id = $this->input->post('responsavel_id');
            if ($responsavel_id) {
                $responsavel_id = $this->Responsavel_model->update_responsavel($responsavel_id, $params_responsavel);
                $this->session->set_flashdata('message_ok', 'Responsável atualizado com sucesso.');
            }
            else {
                $params_responsavel['data_cadastro'] = date('Y-m-d H:i:s');
                $responsavel_id = $this->Responsavel_model->add_responsavel($params_responsavel);
                $this->session->set_flashdata('message_ok', 'Responsável incluído com sucesso.');
            }
            
            redirect('responsavel/index');
        }
        else
        {   
            $data['js_scripts'] = array("responsavel/add.js");
            $data['_view'] = 'responsavel/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a responsavel
     */
    function edit($id)
    {   
        // check if the responsavel exists before trying to edit it
        $data['responsavel'] = $this->Responsavel_model->get_responsavel($id);
        
        if(isset($data['responsavel']['id']))
        {
            $this->form_validation->set_rules('documento_numero','CPF','required|callback_check_cpf_unique');
            $this->form_validation->set_rules('nome','Nome','required');
            $this->form_validation->set_rules('data_nascimento','Data de Nascimento','required');
            $this->form_validation->set_rules('endereco','Logradouro','required');
            $this->form_validation->set_rules('bairro','Bairro','required');
            $this->form_validation->set_rules('cidade','Cidade','required');
            $this->form_validation->set_rules('uf','UF','required|exact_length[2]|alpha');
            
			if($this->form_validation->run())     
            {
                $date1 = strtr($this->input->post('data_nascimento'), '/', '-');

                $params_responsavel = array(
                    'documento_tipo' => 'CPF',
                    'documento_numero' => $this->input->post('documento_numero'),
                    'nome' => mb_strtoupper(trim($this->input->post('nome'))),
                    'data_nascimento' => date('Y-m-d', strtotime($date1)),
                    'endereco' => $this->input->post('endereco'),
                    'numero' => $this->input->post('numero'),
                    'complemento' => $this->input->post('complemento'),
                    'bairro' => $this->input->post('bairro'),
                    'cidade' => $this->input->post('cidade'),
                    'uf' => $this->input->post('uf'),
                    'cep' => str_replace('-', '', $this->input->post('cep'))
                );
                $this->Responsavel_model->update_responsavel($id, $params_responsavel);            
                redirect('responsavel/index');
            }
            else
            {
                $data['js_scripts'] = array("responsavel/edit.js");
                $data['_view'] = 'responsavel/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('O responsável que você está tentando editar não existe.');
    }

    function get_responsavel()
    {
        $etapa = $this->input->post('etapa');
        $cpf = $this->input->post('cpf');

        $nome = trim($this->input->post('nome'));
        $data_nascimento = $this->input->post('data_nascimento');

        $date1 = strtr($this->input->post('data_nascimento'), '/', '-');

        $data_nascimento = date('Y-m-d', strtotime($date1));
        
        if ($etapa == 1)
        {
            $teste = $this->NatalSolidario_model->validar_cpf($cpf);

            if ($teste) {
                $retorno = $this->Responsavel_model->get_responsavel_by_cpf($cpf);
            }
            else {
                $retorno = array('status' => 'error', 'message' => 'CPF inválido.');
            }
        }
        elseif ($etapa == 2)
        {
            $retorno = $this->Responsavel_model->get_responsavel_by_nome_data_nascimento($nome, $data_nascimento);
        }
        else
        {
            $retorno = null;
        }
        
        echo json_encode($retorno);
    }
    
    function check_cpf_unique($cpf) {
        $cpf = preg_replace("/\D/", "", $cpf);
        if($this->input->post('responsavel_id'))
            $id = $this->input->post('responsavel_id');
        else
            $id = '';
        $result = $this->Responsavel_model->check_unique_cpf($id, $cpf);
        if($result == 0) {
            $response = true;
            $result = $this->NatalSolidario_model->validar_cpf($cpf);
            if ($result == 1)
                $response = true;
            else {
                $this->form_validation->set_message('check_cpf_unique', 'CPF inválido.');
                $response = false;
            }
        }
        else {
            $this->form_validation->set_message('check_cpf_unique', 'CPF já existe na base de dados.');
            $response = false;
        }
        return $response;
    }
}
