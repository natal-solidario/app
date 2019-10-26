<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Instituicao extends MY_Controller
{
    const GRUPO_REPRESENTANTE_COMUNIDADE = 3;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Instituicao_Model');
        $this->load->model('Regiao_administrativa_model');
        $this->load->model('Usuario_model');
        $this->load->model('Campanha_model');
        $this->load->model('NatalSolidario_model');
        
		if (!$this->ion_auth_acl->has_permission('permite_acessar_campanha'))
		{
            $this->session->set_flashdata('message', 'Você não tem permissão para acessar esta funcionalidade!');
            redirect(site_url());
        }
    } 

    /*
     * lista instituições cadastradas
     */
    function index()
    {
        $data['instituicoes'] = $this->Instituicao_Model->get_all_instituicoes();

        $data['_view'] = 'instituicao/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adiciona uma nova instituição
     */
    function add()
    {
        $this->form_validation->set_rules('NU_CNPJ','CNPJ','required|callback_check_cnpj_unique');
        $this->form_validation->set_rules('NO_INSTITUICAO','Nome','required');
        $this->form_validation->set_rules('NO_LOGRADOURO','Logradouro','required');
        $this->form_validation->set_rules('NO_BAIRRO','Bairro','required');
        $this->form_validation->set_rules('NO_CIDADE','Cidade','required');
        $this->form_validation->set_rules('SG_UF','UF','required');
        $this->form_validation->set_rules('ID_REGIAO_ADMINISTRATIVA','Região Administrativa','required');
        $this->form_validation->set_rules('ID_USUARIO','Usuário Responsável','required');

        if($this->form_validation->run())     
        {
            // Adicionar primeiro o endereço
            $params_endereco = array(
                'NU_CEP' => preg_replace("/\D/", "", $this->input->post('NU_CEP')),
                'NO_LOGRADOURO' => $this->input->post('NO_LOGRADOURO'),
                'NU_ENDERECO' => $this->input->post('NU_ENDERECO'),
                'DE_COMPLEMENTO' => $this->input->post('DE_COMPLEMENTO'),
                'NO_BAIRRO' => $this->input->post('NO_BAIRRO'),
                'NO_CIDADE' => $this->input->post('NO_CIDADE'),
                'SG_UF' => $this->input->post('SG_UF'),
            );
            $endereco_id = $this->Instituicao_Model->add_endereco($params_endereco);
            
            // Adicionar o telefone            
            $telefone = preg_replace("/\D/", "", $this->input->post('DE_TELEFONE'));
            $params_telefone = array(
                'NU_DDD' => substr($telefone, 0, 2),
                'NU_TELEFONE' => substr($telefone, 2),
            );
            if ($telefone > 0)
                $telefone_id = $this->Instituicao_Model->add_telefone($params_telefone);

            // Adicionar a Instituição
            $params_instituicao = array(
                'NO_INSTITUICAO' => $this->input->post('NO_INSTITUICAO'),
                'NU_CNPJ' => preg_replace("/\D/", "", $this->input->post('NU_CNPJ')),
                'ID_REGIAO_ADMINISTRATIVA' => $this->input->post('ID_REGIAO_ADMINISTRATIVA'),
                'NU_TBH01' => $endereco_id,
                'NU_TBH02' => $telefone_id
            );
            $instituicao_id = $this->Instituicao_Model->add_instituicao($params_instituicao);

            // Vincular responsável com a instituição
            $params_vinculo_instituicao_usuario = array(
                'NU_TBP01' => $instituicao_id,
                'ID_USUARIO' => $this->input->post('ID_USUARIO'),
            );
            $vinculo_responsavel_id = $this->Instituicao_Model->add_vinculo_instituicao_usuario($params_vinculo_instituicao_usuario);

            // Vincular instituição com a campanha atual
            if ($this->input->post('vinculo-campanha-atual') == 1) {
                $campanha_atual = $this->Campanha_model->get_campanha_atual();
                $params_vinculo_instituicao_campanha = array(
                    'NU_TBC01' => $campanha_atual['NU_TBC01'],
                    'NU_TBP01' => $instituicao_id,
                );
                $vinculo_campanha_id = $this->Instituicao_Model->add_abrangencia_instituicao($params_vinculo_instituicao_campanha);
            }

            redirect('instituicao/index');
        }
        else
        {            
            $data['ras'] = $this->Regiao_administrativa_model->get_all();
            $data['usuarios'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_REPRESENTANTE_COMUNIDADE);

            $data['js_scripts'] = array('instituicao/add.js');
            $data['_view'] = 'instituicao/add';
            $this->load->view('layouts/main', $data);
        }
    }

    /*
     * Edita uma instituição
     */
    function edit($id)
    {   
        // verifica se a instituição já existe antes de atualizar
        $data['instituicao'] = $this->Instituicao_Model->get_instituicao($id);

       if(isset($data['instituicao']['NU_TBP01']))
        {
            $this->form_validation->set_rules('NU_CNPJ','CNPJ','required|callback_check_cnpj_unique');
            $this->form_validation->set_rules('NO_INSTITUICAO','Nome','required');
            $this->form_validation->set_rules('NO_LOGRADOURO','Logradouro','required');
            $this->form_validation->set_rules('NO_BAIRRO','Bairro','required');
            $this->form_validation->set_rules('NO_CIDADE','Cidade','required');
            $this->form_validation->set_rules('SG_UF','UF','required');
            $this->form_validation->set_rules('ID_REGIAO_ADMINISTRATIVA','Região Administrativa','required');
            $this->form_validation->set_rules('ID_USUARIO','Usuário Responsável','required');
                
            if($this->form_validation->run())     
            {
                // Adicionar primeiro o endereço
                $params_endereco = array(
                    'NU_CEP' => preg_replace("/\D/", "", $this->input->post('NU_CEP')),
                    'NO_LOGRADOURO' => $this->input->post('NO_LOGRADOURO'),
                    'NU_ENDERECO' => $this->input->post('NU_ENDERECO'),
                    'DE_COMPLEMENTO' => $this->input->post('DE_COMPLEMENTO'),
                    'NO_BAIRRO' => $this->input->post('NO_BAIRRO'),
                    'NO_CIDADE' => $this->input->post('NO_CIDADE'),
                    'SG_UF' => $this->input->post('SG_UF'),
                );

                $endereco_id = $this->Instituicao_Model->update_endereco($data['instituicao']['NU_TBH01'], $params_endereco);

                // Adicionar o telefone            
                $telefone = preg_replace("/\D/", "", $this->input->post('DE_TELEFONE'));

                $params_telefone = array(
                    'NU_DDD' => substr($telefone, 0, 2),
                    'NU_TELEFONE' => substr($telefone, 2),
                );

                if ($data['instituicao']['NU_TBH02'] == 0 && $telefone > 0) {
                    $telefone_id = $this->Instituicao_Model->add_telefone($params_telefone);
                }
                else {
                    $telefone_id = $this->Instituicao_Model->update_telefone($data['instituicao']['NU_TBH02'], $params_telefone);
                }

                // Adicionar a Instituição
                $params_instituicao = array(
                    'NO_INSTITUICAO' => $this->input->post('NO_INSTITUICAO'),
                    'NU_CNPJ' => preg_replace("/\D/", "", $this->input->post('NU_CNPJ')),
                    'ID_REGIAO_ADMINISTRATIVA' => $this->input->post('ID_REGIAO_ADMINISTRATIVA'),
                    'NU_TBH01' => $endereco_id,
                    'NU_TBH02' => $telefone_id,
                );
                $instituicao_id = $this->Instituicao_Model->update_instituicao($data['instituicao']['NU_TBP01'], $params_instituicao);

                $params_vinculo_instituicao_usuario = array(
                    'NU_TBP01' => $instituicao_id,
                    'ID_USUARIO' => $this->input->post('ID_USUARIO'),
                );
                $vinculo_responsavel_id = $this->Instituicao_Model->update_vinculo_instituicao_usuario($data['instituicao']['NU_TBP01'], $params_vinculo_instituicao_usuario);

                // Vincular instituição com a campanha atual
                if ($this->input->post('vinculo-campanha-atual') == 1) 
                {
                    if ($this->input->post('NU_TBC02') == "" || $this->input->post('NU_TBC02') == 0) {
                        $campanha_atual = $this->Campanha_model->get_campanha_atual();
                        $params_vinculo_instituicao_campanha = array(
                            'NU_TBC01' => $campanha_atual['NU_TBC01'],
                            'NU_TBP01' => $instituicao_id,
                        );
                        $vinculo_campanha_id = $this->Instituicao_Model->add_abrangencia_instituicao($params_vinculo_instituicao_campanha);
                    }
                }
                else {
                    $vinculo_campanha_id = $this->Instituicao_Model->delete_abrangencia_instituicao($instituicao_id);
                }
                redirect('instituicao/index');
            }
            else
            {
                $data['ras'] = $this->Regiao_administrativa_model->get_all();
                $data['usuarios'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_REPRESENTANTE_COMUNIDADE);

                $data['instituicao']['vinculo_campanha_atual'] = $this->Instituicao_Model->checar_instituicao_vinculo_campanha_atual($id);

                $data['js_scripts'] = array('instituicao/edit.js');
                $data['_view'] = 'instituicao/edit';
                $this->load->view('layouts/main', $data);
            }
        }
        else
        {
            show_error('A instituição que você está tentando editar não existe.');
        }
    }

    function check_cnpj_unique($cnpj) {
        $cnpj = preg_replace("/\D/", "", $cnpj);
        if($this->input->post('NU_TBP01'))
            $id = $this->input->post('NU_TBP01');
        else
            $id = '';
        $result = $this->Instituicao_Model->check_unique_cnpj($id, $cnpj);
        if($result == 0) {
            $response = true;
            $result = $this->NatalSolidario_model->validar_cnpj($cnpj);
            if ($result == 1)
                $response = true;
            else {
                $this->form_validation->set_message('check_cnpj_unique', 'CNPJ inválido.');
                $response = false;
            }
        }
        else {
            $this->form_validation->set_message('check_cnpj_unique', 'CNPJ já existe na base de dados.');
            $response = false;
        }
        return $response;
    }
}
