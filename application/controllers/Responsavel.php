<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Responsavel extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Responsavel_model');

        $this->load->add_package_path(APPPATH.'third_party/ion_auth/');
        $this->load->library('ion_auth');

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('login');
        } else {
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
        
        $this->load->library('form_validation');

		$this->form_validation->set_rules('documento_numero','CPF','required');
		$this->form_validation->set_rules('nome','Nome','required');
		$this->form_validation->set_rules('data_nascimento','Data de Nascimento','required');
		$this->form_validation->set_rules('endereco','Endereço','required');
		$this->form_validation->set_rules('cidade','Cidade','required');
		$this->form_validation->set_rules('bairro','Bairro','required');
		$this->form_validation->set_rules('uf','Uf','required|max_length[2]|alpha');
		$this->form_validation->set_rules('cep','Cep','integer|exact_length[8]');
		
		if($this->form_validation->run())     
        {   
            $date1 = strtr($this->input->post('data_nascimento'), '/', '-');
            
            $params = array(
				//'removido' => $this->input->post('removido'),
				'documento_tipo' => 'CPF',
				'data_cadastro' => date('Y-m-d H:i:s'),
				'nome' => $this->input->post('nome'),
				'data_nascimento' => date('Y-m-d', strtotime($date1)),
				'endereco' => $this->input->post('endereco'),
				'cidade' => $this->input->post('cidade'),
				'uf' => $this->input->post('uf'),
				'cep' => $this->input->post('cep'),
            );
            
            $responsavel_id = $this->Responsavel_model->add_responsavel($params);
            redirect('responsavel/index');
        }
        else
        {   
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
            $this->load->library('form_validation');

			$this->form_validation->set_rules('data_cadastro','Data Cadastro','required');
			$this->form_validation->set_rules('nome','Nome','required');
			$this->form_validation->set_rules('data_nascimento','Data Nascimento','required');
			$this->form_validation->set_rules('endereco','Endereco','required');
			$this->form_validation->set_rules('cidade','Cidade','required');
			$this->form_validation->set_rules('uf','Uf','required|max_length[2]|alpha');
			$this->form_validation->set_rules('cep','Cep','integer|exact_length[8]');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'removido' => $this->input->post('removido'),
					'documento_tipo' => $this->input->post('documento_tipo'),
					'data_cadastro' => $this->input->post('data_cadastro'),
					'nome' => $this->input->post('nome'),
					'data_nascimento' => $this->input->post('data_nascimento'),
					'endereco' => $this->input->post('endereco'),
					'cidade' => $this->input->post('cidade'),
					'uf' => $this->input->post('uf'),
					'cep' => $this->input->post('cep'),
                );

                $this->Responsavel_model->update_responsavel($id,$params);            
                redirect('responsavel/index');
            }
            else
            {
                $data['_view'] = 'responsavel/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The responsavel you are trying to edit does not exist.');
    }
}
