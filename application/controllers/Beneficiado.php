<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Beneficiado extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Beneficiado_model');
        $this->load->model('Responsavel_model');
    } 

    /*
     * Listing of beneficiados
     */
    function index()
    {
        $data['beneficiados'] = $this->Beneficiado_model->get_all_beneficiados();
        
        $data['js_scripts'] = array('beneficiado/index.js');
        $data['_view'] = 'beneficiado/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new beneficiado
     */
    function add()
    {
		$this->form_validation->set_rules('responsavel','Responsavel','required');
		$this->form_validation->set_rules('nome','Nome','required');
		$this->form_validation->set_rules('data_nascimento','Data Nascimento','required');
		$this->form_validation->set_rules('sexo','Sexo','required');
		
		if($this->form_validation->run())     
        {
            $date1 = strtr($this->input->post('data_nascimento'), '/', '-');
            $params = array(
				'responsavel' => $this->input->post('responsavel'),
                'nome' => $this->input->post('nome'),
                'sexo' => $this->input->post('sexo'),
                'data_nascimento' => date('Y-m-d', strtotime($date1)),
				'data_cadastro' => date('Y-m-d H:i:s'),
            );
            
            $beneficiado_id = $this->Beneficiado_model->add_beneficiado($params);
            $this->session->set_flashdata('message_ok', 'Beneficiado incluído com sucesso!');
            redirect('beneficiado/index');
        }
        else
        {
			$data['all_responsaveis'] = $this->Responsavel_model->get_all_responsaveis();
            
            $data['js_scripts'] = array('beneficiado/add.js');
            $data['_view'] = 'beneficiado/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a beneficiado
     */
    function edit($id)
    {   
        // check if the beneficiado exists before trying to edit it
        $data['beneficiado'] = $this->Beneficiado_model->get_beneficiado($id);
        
        if(isset($data['beneficiado']['id']))
        {
			$this->form_validation->set_rules('responsavel','Responsavel','required');
			$this->form_validation->set_rules('nome','Nome','required');
			$this->form_validation->set_rules('data_nascimento','Data Nascimento','required');
			$this->form_validation->set_rules('sexo','Sexo','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'responsavel' => $this->input->post('responsavel'),
					'nome' => $this->input->post('nome'),
					'sexo' => $this->input->post('sexo'),
					'data_nascimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('data_nascimento')))),
                );

                $this->Beneficiado_model->update_beneficiado($id, $params);
                redirect('beneficiado/index');
            }
            else
            {
				$data['all_responsaveis'] = $this->Responsavel_model->get_all_responsaveis();

                $data['_view'] = 'beneficiado/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The beneficiado you are trying to edit does not exist.');
    }

    function get_beneficiados()
    {
        $idResponsavel = $this->input->post('responsavel');
        echo json_encode($this->Beneficiado_model->get_all_beneficiados_por_responsavel($idResponsavel));
    } 
}
