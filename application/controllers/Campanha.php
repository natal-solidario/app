<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Campanha extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Campanha_model');
        $this->load->model('Instituicao_model');

		if (!$this->ion_auth_acl->has_permission('permite_acessar_campanha'))
		{
            $this->session->set_flashdata('message', 'Você não tem permissão para acessar esta funcionalidade!');
            redirect(site_url());
        }
    }

    function index()
    {
        $data['campanhas'] = $this->Campanha_model->get_all();
        
        $data['_view'] = 'campanha/index';
        $this->load->view('layouts/main', $data);
    }

    function instituicoes($id)
    {
        $data['campanha'] = $this->Campanha_model->get($id);
        $data['instituicoes'] = $this->Campanha_model->get_instituicoes($id);
        $data['select_instituicoes'] = $this->Instituicao_model->get_all_instituicoes();

        foreach ($data['select_instituicoes'] as $ks => $si) 
        {
            foreach ($data['instituicoes'] as $k => $i)
            {
                if ($si["NU_TBP01"] == $i["NU_TBP01"])
                {
                    unset($data['select_instituicoes'][$ks]);
                }
            }
        }

        $data['campanha_id'] = $id;
        
        $data['js_scripts'] = array('campanha/instituicoes.js');
        $data['_view'] = 'campanha/instituicoes';
        $this->load->view('layouts/main', $data);
    }

    
    function add_instituicao($campanha, $instituicao)
    {
        $params = array(
            "NU_TBC01" => $campanha,
            'NU_TBP01' => $instituicao
        );
        $this->Campanha_model->add_instituicao($params);
        $this->session->set_flashdata('message_ok', 'Instituição incluída com sucesso!');
        redirect('campanha/instituicoes/' . $campanha);
    }

    function del_instituicao($campanha, $instituicao)
    {
        $this->Campanha_model->del_instituicao($instituicao);
        $this->session->set_flashdata('message_ok', 'Instituição removida com sucesso!');
        redirect('campanha/instituicoes/' . $campanha);
    }

    function add()
    {
        $this->form_validation->set_rules('NO_CAMPANHA','Nome da Campanha','required|is_unique[TBC01_CAMPANHA.NO_CAMPANHA]');
        $this->form_validation->set_rules('AA_CAMPANHA','Ano da Campanha','required|integer|exact_length[4]|is_unique[TBC01_CAMPANHA.AA_CAMPANHA]');

        if($this->form_validation->run())     
        {
            $params = array(
                'NO_CAMPANHA' => $this->input->post('NO_CAMPANHA'),
                'AA_CAMPANHA' => $this->input->post('AA_CAMPANHA')
            );

            $this->Campanha_model->add($params);
            $this->session->set_flashdata('message_ok', 'Campanha incluída com sucesso!');
            redirect('campanha/index');
        }
        else
        {
            $data['_view'] = 'campanha/add';
            $this->load->view('layouts/main', $data);
        }
    }  

    function edit($id)
    {
        $data['campanha'] = $this->Campanha_model->get($id);

        if(isset($data['campanha']->NU_TBC01))
        {
            $this->form_validation->set_rules('NO_CAMPANHA','Nome da Campanha','required|is_unique[TBC01_CAMPANHA.NO_CAMPANHA]');
            $this->form_validation->set_rules('AA_CAMPANHA','Ano da Campanha','required|integer|exact_length[4]|is_unique[TBC01_CAMPANHA.AA_CAMPANHA]');
            
            if($this->form_validation->run())     
            {  
                $params = array(
                    'NO_CAMPANHA' => $this->input->post('NO_CAMPANHA'),
                    'AA_CAMPANHA' => $this->input->post('AA_CAMPANHA')
                );

                $this->Campanha_model->update($data['campanha']->NU_TBC01, $params);
                $this->session->set_flashdata('message_ok', 'Campanha alterada com sucesso!');
                redirect('campanha/index');
            }
            else
            {
                $data['_view'] = 'campanha/edit';
                $this->load->view('layouts/main', $data);
            }
        }
        else {
            show_error('A campanha que está tentando editar não existe!');
        }
    }

}