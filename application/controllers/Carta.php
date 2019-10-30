<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
class Carta extends MY_Controller
{

    const GRUPO_CARTEIROS = 5;
    const GRUPO_REPRESENTANTE_COMUNIDADE = 3;
    const GRUPO_MOBILIZADORES = 6;

    const ACAO_AUTENTICACAO = 1;
    const ACAO_INCLUSAO = 2;
    const ACAO_ALTERACAO = 3;
    const ACAO_EXCLUSAO = 4;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Carta_model');
        $this->load->model('Usuario_model');
        $this->load->model('Instituicao_model');
        $this->load->model('Campanha_model');
        $this->load->model('Responsavel_model');
        $this->load->model('Beneficiado_model');
        $this->load->model('NatalSolidario_model');
    } 

    /*
     * Listing of cartas
     */
    function index()
    {
        $total_records = 0;
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['limite']                     = $this->input->get('limite');
        $data['carteiro_selecionado']       = $this->input->get('carteiro');
        $data['mobilizador_selecionado']    = $this->input->get('mobilizador');
        $data['regiao_administrativa']      = $this->input->get('regiao_administrativa');
        $data['numero']                     = $this->input->get('numero');
        $data['nome_crianca']               = $this->input->get('nome_crianca');
        $data['nome_responsavel']           = $this->input->get('nome_responsavel');
        $data['situacao']                   = $this->input->get('situacao');
        $data['campanha']                   = $this->input->get('campanha');
        $data['instituicao']                = $this->input->get('instituicao');
        $data['removida']                   = $this->input->get('removida');
        $data['ordem']                      = $this->input->get('ordem');
        $data['direcao']                    = $this->input->get('direcao');
        
        $data['isAdmin'] = $this->ion_auth_acl->has_permission('permite_acessar_campanha_geral');
        $data['isRepComu'] = $this->ion_auth_acl->has_permission('permite_acessar_campanha_local');

        if ($this->ion_auth_acl->has_permission('permite_acessar_campanha_local'))
        {
            $data['instituicao'] = $this->Instituicao_model->get_instituicao_by_usuario($this->user->id)['NU_TBP01'];
        }

        if (!array_key_exists('campanha', $this->input->get()))
            $data['campanha'] = $this->Campanha_model->get_campanha_atual()['AA_CAMPANHA'];
        if (!array_key_exists('removida', $this->input->get()))
            $data['removida'] = 0;
        
        if ($data['limite'] > 0)
            $limit_per_page = $data['limite'];

        $data['cartas'] = null;
        if ($data['carteiro_selecionado'] != null
            || strlen($data['numero']) > 0
            || strlen($data['nome_crianca']) > 0
            || strlen($data['nome_responsavel']) > 0
            || $data['regiao_administrativa'] != null
            || $data['mobilizador_selecionado'] != null
            || $data['situacao'] != null
            || $data['campanha'] != null
            || $data['instituicao'] != null
            || $data['removida'] != null)
        {
            $total_records = $this->Carta_model->contar_cartas_por_parametros($data['numero']
                , $data['carteiro_selecionado'], $data['regiao_administrativa'], $data['mobilizador_selecionado']
                , $data['nome_crianca'], $data['nome_responsavel'], $data['situacao'], $data['campanha'], $data['instituicao'], $data['removida']);
            
            $data['cartas'] = null;
            if ($total_records > 0)
            {
                $data['cartas'] = $this->Carta_model->get_cartas_por_parametros($limit_per_page, $start_index, $data['numero']
                                , $data['carteiro_selecionado'], $data['regiao_administrativa'], $data['mobilizador_selecionado']
                                , $data['nome_crianca'], $data['nome_responsavel'], $data['situacao'], $data['campanha']
                                , $data['instituicao'], $data['removida'], $data['ordem'], $data['direcao']);
            }
        }
        else
        {
            $total_records = $this->Carta_model->contar_todas_cartas();
            $data['cartas'] = null;
            if ($total_records > 0)
            {
                $data['cartas'] = $this->Carta_model->get_all_cartas($limit_per_page, $start_index, $data['ordem'], $data['direcao']);
            }
        }

        $data['total_registros'] = $total_records;
        
        $data['carteiros'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_CARTEIROS);

        $data['mobilizadores'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_MOBILIZADORES);
        
        $data['all_regioes'] = $this->NatalSolidario_model->get_all_regiao_administrativa();

        $data['all_campanhas'] = $this->Campanha_model->get_all();
        $data['all_instituicoes'] = $this->Instituicao_model->get_all_instituicoes();
        
        $config['enable_query_strings'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        
        $config['first_link'] = 'Primeiro';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link'] = 'Último';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        
        
        $config['base_url'] = base_url() . 'carta/index';
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        $config["uri_segment"] = 3;
        
        $this->pagination->initialize($config);
        
        $data["links"] = $this->pagination->create_links();
                
        $data['js_scripts'] = array('carta/index.js');
        $data['_view'] = 'carta/index';
        $this->load->view('layouts/main',$data);
    }

    function add()
    {
        redirect('carta/new');
    }  

    /*
     * Editing a carta_pedido
     */
    function edit($id)
    {   
        // check if the carta_pedido exists before trying to edit it
        $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
        
        if(isset($data['carta_pedido']['id']))
        {
            $this->form_validation->set_rules('documento_numero','CPF','required|callback_check_cpf_unique');
            $this->form_validation->set_rules('nome','Nome','required');
            $this->form_validation->set_rules('data_nascimento','Data de Nascimento','required');
            $this->form_validation->set_rules('endereco','Logradouro','required');
            $this->form_validation->set_rules('bairro','Bairro','required');
            $this->form_validation->set_rules('cidade','Cidade','required');
            $this->form_validation->set_rules('uf','UF','required|exact_length[2]|alpha');
            $this->form_validation->set_rules('responsavel_id','Responsável','required');
            $this->form_validation->set_rules('beneficiado_id','Beneficiado','required');
            $this->form_validation->set_rules('nome_beneficiado','Nome do Beneficiado','required');
            $this->form_validation->set_rules('data_nascimento_beneficiado','Data de Nascimento do Beneficiado','required');
            $this->form_validation->set_rules('sexo_beneficiado','Sexo do Beneficiado','required');
            $this->form_validation->set_rules('representante','Instituição','required');

            $data['campanha_atual'] = $this->Campanha_model->get_campanha_atual();

            if ($this->ion_auth_acl->has_permission('acesso_admin'))
            {
                $instituicao = $this->Instituicao_model->get_instituicao($this->input->post('representante'));
            }
            if ($this->ion_auth_acl->has_permission('permite_acessar_campanha_local'))
            {
                $instituicao = $this->Instituicao_model->get_instituicao_by_usuario($this->user->id);
            }
            else
            {
                $this->session->set_flashdata('message', 'Você não tem permissão para editar cartas no sistema.');
                redirect('carta/index');
            }

			if($this->form_validation->run())     
            {
                // Atualiza o Responsável
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
                $responsavel_id = $this->Responsavel_model->update_responsavel($this->input->post('responsavel_id'), $params_responsavel);

                // Atualiza dados da criança beneficiada
                $date2 = strtr($this->input->post('data_nascimento_beneficiado'), '/', '-');
                $params_beneficiado = array(
                    'responsavel' => $responsavel_id,
                    'nome' => mb_strtoupper($this->input->post('nome_beneficiado')),
                    'data_nascimento' => date('Y-m-d', strtotime($date2)),
                    'sexo' => $this->input->post('sexo_beneficiado'),
                );
                $beneficiado_id = $this->Beneficiado_model->update_beneficiado($this->input->post('beneficiado_id'), $params_beneficiado);

                $this->session->set_flashdata('message_ok', 'Alteração do pré-cadastro da carta realizada com sucesso.');
                redirect('carta/index');
            }
            else
            {
                $data['beneficiado'] = $this->Beneficiado_model->get_beneficiado($data['carta_pedido']['beneficiado']);
                $data['responsavel'] = $this->Responsavel_model->get_responsavel($data['beneficiado']['responsavel']);

                $data['instituicoes'] = $this->Campanha_model->get_instituicoes($data['campanha_atual']['NU_TBC01']);
                $data['instituicao'] = $this->Instituicao_model->get_instituicao_by_usuario($data['carta_pedido']['representante_comunidade']);

                $data['js_scripts'] = array('carta/edit.js');
                $data['_view'] = 'carta/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The carta_pedido you are trying to edit does not exist.');
    }
    
    function formulario($id)
    {
        // check if the carta_pedido exists before trying to edit it
        $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
        $data['carta_imagens'] = $this->Carta_model->get_galeria_by_carta($id);
        
        $data['instituicao'] = $this->Instituicao_model->get_instituicao_vinculo_campanha($data['carta_pedido']['NU_TBC02']);
        $data['beneficiado']  = $this->Beneficiado_model->get_beneficiado($data['carta_pedido']['beneficiado']);
        
        if ($data['beneficiado']['data_nascimento'] != null)
        {
            $data['beneficiado']['data_nascimento'] = date("d/m/Y", strtotime($data['beneficiado']['data_nascimento']));
        }
        
        $data['responsavel']  = $this->Responsavel_model->get_responsavel($data['beneficiado']['responsavel']);
        $data['responsavel']['telefone_whatsapp'] = ($data['responsavel']['telefone_whatsapp'] == "0" ? 0 : 1);
        if ($data['responsavel']['data_nascimento'] != null)
        {
            $data['responsavel']['data_nascimento'] = date("d/m/Y", strtotime($data['responsavel']['data_nascimento']));
        }

        $data['responsavel_adicional']  = null;
        if ($data['beneficiado']['responsavel_adicional'] != null)
        {
            $data['responsavel_adicional']  = $this->Responsavel_model->get_responsavel($data['beneficiado']['responsavel_adicional']);
            $data['responsavel_adicional']['telefone_whatsapp'] = ($data['responsavel_adicional']['telefone_whatsapp'] == "0" ? 0 : 1);
        }
        if ($data['responsavel_adicional']['data_nascimento'] != null)
        {
            $data['responsavel_adicional']['data_nascimento'] = date("d/m/Y", strtotime($data['responsavel_adicional']['data_nascimento']));
        }
        
        $this->load->model('Beneficiado_familia_model');
        $familiares = $this->Beneficiado_familia_model->get_familia_beneficiado($data['beneficiado']['id']);
        if (!empty($familiares))
        {
            $data['familiares'] = array_column($familiares, 'familiar');
        }
        
        $this->load->model('Brinquedo_classificacao_model');
        $data['brinquedo_classificacoes'] = $this->Brinquedo_classificacao_model->get_all_classificacao_brinquedo();
        
        $this->load->model('Carta_brinquedo_model');
        $data['brinquedos'] = $this->Carta_brinquedo_model->get_brinquedos_por_carta($id);
        
        $data['all_ufs'] = $this->NatalSolidario_model->get_all_uf();

        if(isset($data['carta_pedido']['id']))
        {
            // $this->form_validation->set_rules('regiao_administrativa','Beneficiado - Comunidade','required');
            $this->form_validation->set_rules('nome','Beneficiado - Nome','required');
            $this->form_validation->set_rules('dataNascimento','Beneficiado - Data de nascimento','required');
            $this->form_validation->set_rules('sexo','Beneficiado - Sexo','required');
            $this->form_validation->set_rules('escola','Beneficiado - Escola','required');
            $this->form_validation->set_rules('ano','Beneficiado - Escola','required');
            $this->form_validation->set_rules('cidade_escola','Beneficiado - Cidade Escola','required');
            $this->form_validation->set_rules('uf_escola','Beneficiado - UF Escola','required');
            
            $this->form_validation->set_rules('brinquedo1','1ª opção de brinquedo','required');
            $this->form_validation->set_rules('brinquedo1Tipo','Classificação da 1ª opção de brinquedo','required');
            
            $this->form_validation->set_rules('responsavel1Nome','Responsável 1 Nome','required');
            $this->form_validation->set_rules('responsavel1DataNascimento','Responsável 1 Data de Nascimento','required');
            $this->form_validation->set_rules('responsavel1NumeroDocumento','Responsável 1 CPF','required|callback_check_cpf_unique');
            $this->form_validation->set_rules('responsavel1Endereco','Responsável 1 Logradouro','required');
            $this->form_validation->set_rules('responsavel1Bairro','Responsável 1 Bairro','required');
            $this->form_validation->set_rules('responsavel1Cidade','Responsável 1 Cidade','required');
            $this->form_validation->set_rules('responsavel1UF','Responsável 1 UF','required|exact_length[2]|alpha');
            $this->form_validation->set_rules('responsavel1Telefone','Responsável 1 Telefone','required');
            $this->form_validation->set_rules('responsavel1TelefoneOperadora','Responsável 1 Operadora','required');
            $this->form_validation->set_rules('responsavel1TelefoneWhatsapp','Responsável 1 Whatsapp','required');

            if ($this->input->post('responsavel2_id') || $this->input->post('responsavel2NumeroDocumento') || ($this->input->post('responsavel2Nome') && $this->input->post('responsavel2DataNascimento')))
            {
                $this->form_validation->set_rules('responsavel2Nome','Responsável 2 Nome','required');
                $this->form_validation->set_rules('responsavel2DataNascimento','Responsável 2 Data de Nascimento','required');
                $this->form_validation->set_rules('responsavel2NumeroDocumento','Responsável 2 CPF','required|callback_check_cpf_unique');
                $this->form_validation->set_rules('responsavel2Endereco','Responsável 2 Logradouro','required');
                $this->form_validation->set_rules('responsavel2Bairro','Responsável 2 Bairro','required');
                $this->form_validation->set_rules('responsavel2Cidade','Responsável 2 Cidade','required');
                $this->form_validation->set_rules('responsavel2UF','Responsável 2 UF','required|exact_length[2]|alpha');
                $this->form_validation->set_rules('responsavel2Telefone','Responsável 2 Telefone','required');
                $this->form_validation->set_rules('responsavel2TelefoneOperadora','Responsável 2 Operadora','required');
                $this->form_validation->set_rules('responsavel2TelefoneWhatsapp','Responsável 2 Whatsapp','required');
            }

            if($this->form_validation->run())
            {                    
                $this->db->trans_start();
                //$this->db->trans_strict(FALSE);
                
                //ATUALIZACAO DOS BRINQUEDOS ===================================
                
                $params = array(
                    'carta' => $id,
                    'classificacao' => $this->input->post('brinquedo1Tipo'),
                    'descricao' => $this->input->post('brinquedo1'),
                    'prioridade' => 1,
                );
                
                if ($this->input->post('brinquedo1Id'))
                {
                    $this->Carta_brinquedo_model->update_carta_brinquedo($this->input->post('brinquedo1Id'), $params);
                }
                else
                {
                    $this->Carta_brinquedo_model->add_carta_brinquedo($params);
                }
                
                if ($this->input->post('brinquedo2') && $this->input->post('brinquedo2Tipo'))
                {
                    $params = array(
                        'carta' => $id,
                        'classificacao' => $this->input->post('brinquedo2Tipo'),
                        'descricao' => $this->input->post('brinquedo2'),
                        'prioridade' => 2,
                    );
                    
                    if ($this->input->post('brinquedo2Id'))
                    {
                        $this->Carta_brinquedo_model->update_carta_brinquedo($this->input->post('brinquedo2Id'), $params);
                    }
                    else
                    {
                        $this->Carta_brinquedo_model->add_carta_brinquedo($params);
                    }
                }
                
                if ($this->input->post('brinquedo3') && $this->input->post('brinquedo3Tipo'))
                {
                    $params = array(
                        'carta' => $id,
                        'classificacao' => $this->input->post('brinquedo3Tipo'),
                        'descricao' => $this->input->post('brinquedo3'),
                        'prioridade' => 3,
                    );
                    
                    if ($this->input->post('brinquedo3Id'))
                    {
                        $this->Carta_brinquedo_model->update_carta_brinquedo($this->input->post('brinquedo3Id'), $params);
                    }
                    else
                    {
                        $this->Carta_brinquedo_model->add_carta_brinquedo($params);
                    }
                }
                
                //ATUALIZACAO DO RESPONSAVEL ===================================
                
                $dataNascimentoResponsavel = strtr($this->input->post('responsavel1DataNascimento'), '/', '-');
                
                $params = array(
                    'nome' => $this->input->post('responsavel1Nome'),
                    'data_nascimento' => date('Y-m-d', strtotime($dataNascimentoResponsavel)),
                    'documento_numero' => $this->input->post('responsavel1NumeroDocumento'),
                    'documento_tipo' => 'CPF',
                    'email' => $this->input->post('responsavel1Email'),
                    'endereco' => $this->input->post('responsavel1Endereco'),
                    'numero' => $this->input->post('responsavel1Numero'),
                    'complemento' => $this->input->post('responsavel1Complemento'),
                    'bairro' => $this->input->post('responsavel1Bairro'),
                    'cidade' => $this->input->post('responsavel1Cidade'),
                    'uf' => $this->input->post('responsavel1UF'),
                    'cep' => preg_replace("/[^0-9]/", "", $this->input->post('responsavel1Cep')),
                    'telefone' => preg_replace("/[^0-9]/", "", $this->input->post('responsavel1Telefone')),
                    'telefone_operadora' => $this->input->post('responsavel1TelefoneOperadora'),
                    'telefone_whatsapp' => $this->input->post('responsavel1TelefoneWhatsapp'),
                    'ocupacao' => $this->input->post('responsavel1Ocupacao'),
                    'escolaridade' => $this->input->post('responsavel1Escolaridade'),
                );

                $this->Responsavel_model->update_responsavel($data['responsavel']['id'], $params);
                
                //ATUALIZACAO DO RESPONSAVEL ADICIONAL =========================
                
                $idResponsavelAdicional = null;
                if ($this->input->post('responsavel2NumeroDocumento') && $this->input->post('responsavel2Nome') && $this->input->post('responsavel2DataNascimento'))
                {
                    $dataNascimentoResponsavel = strtr($this->input->post('responsavel2DataNascimento'), '/', '-');
                    
                    $params = array(
                        'nome' => trim($this->input->post('responsavel2Nome')),
                        'data_nascimento' => date('Y-m-d', strtotime($dataNascimentoResponsavel)),
                        'documento_numero' => $this->input->post('responsavel2NumeroDocumento'),
                        'documento_tipo' => 'CPF',
                        'email' => $this->input->post('responsavel2Email'),
                        'endereco' => $this->input->post('responsavel2Endereco'),
                        'numero' => $this->input->post('responsavel2Numero'),
                        'complemento' => $this->input->post('responsavel2Complemento'),
                        'bairro' => $this->input->post('responsavel2Bairro'),
                        'cidade' => $this->input->post('responsavel2Cidade'),
                        'uf' => $this->input->post('responsavel2UF'),
                        'cep' => preg_replace("/[^0-9]/", "", $this->input->post('responsavel2Cep')),
                        'telefone' => preg_replace("/[^0-9,.]/", "", $this->input->post('responsavel2Telefone') ),
                        'telefone_operadora' => $this->input->post('responsavel2TelefoneOperadora'),
                        'telefone_whatsapp' => ($this->input->post('responsavel2TelefoneWhatsapp')) ? true : false,
                        'ocupacao' => $this->input->post('responsavel2Ocupacao'),
                        'escolaridade' => $this->input->post('responsavel2Escolaridade'),
                    );
                    
                    if ($data['responsavel_adicional']['id'])
                    {
                        $idResponsavelAdicional = $data['responsavel_adicional']['id'];
                        $this->Responsavel_model->update_responsavel($idResponsavelAdicional, $params);
                    }
                    else
                    {
                        // Checar se o responsável já existe na base de dados
                        // Buscar pelo CPF
                        $responsavel_adicional = $this->Responsavel_model->get_responsavel_by_cpf($params['documento_numero']);

                        if ($responsavel_adicional)
                        {
                            $idResponsavelAdicional = $responsavel_adicional['id'];
                            $this->Responsavel_model->update_responsavel($idResponsavelAdicional, $params);
                        }
                        else
                        {
                            // Buscar por nome e data de nascimento
                            $responsavel_adicional = $this->Responsavel_model->get_responsavel_by_nome_data_nascimento($params['nome'], $params['data_nascimento']);
                            if ($responsavel_adicional)
                            {
                                $idResponsavelAdicional = $responsavel_adicional['id'];
                                $this->Responsavel_model->update_responsavel($idResponsavelAdicional, $params);
                            }
                            else
                            {
                                $idResponsavelAdicional = $this->Responsavel_model->add_responsavel($params);
                            }
                        }
                    }
                }
                
                // ATUALIZACAO DO BENEFICIADO ===================================
                
                $dataNascimentoBeneficiado = strtr($this->input->post('dataNascimento'), '/', '-');
                
                $params = array(
                    'nome' => $this->input->post('nome'),
                    'data_nascimento' => date('Y-m-d', strtotime($dataNascimentoBeneficiado)),
                    'sexo' => $this->input->post('sexo'),
                    'responsavel_adicional' => $idResponsavelAdicional,
                    'pais_separados' => $this->input->post('paisSeparados')
                );
                $this->Beneficiado_model->update_beneficiado($data['beneficiado']['id'], $params);
                
                $this->Beneficiado_familia_model->delete_por_beneficiado($data['beneficiado']['id']);
                
                if ($this->input->post('familia'))
                {
                    foreach($this->input->post('familia') as $familiar)
                    {
                        $params = array(
                            'beneficiado' => $data['beneficiado']['id'],
                            'familiar' => $familiar,
                        );
                        $this->Beneficiado_familia_model->add_beneficiado_familia($params);
                    }
                }

                $params = array(
                    'atendimento_preferencial' => $this->input->post('preferencial'),
                    // 'regiao_administrativa' => $this->input->post('regiao_administrativa'),
                    'escola' => $this->input->post('escola'),
                    'ano' => $this->input->post('ano'),
                    'cidade_escola' => $this->input->post('cidade_escola'),
                    'uf_escola' => $this->input->post('uf_escola'),
                    'renda_familiar' => $this->input->post('renda'),
                    'moradia' => $this->input->post('moradia'),
                );
                
                if (is_uploaded_file($_FILES['imagem']['tmp_name']))
                {
                    $curYear = date('Y'); 
                    
                    if (!is_dir('uploads'))
                    {
                        mkdir('./uploads', 0777, true);
                    }
                    if (!is_dir('uploads/' . $curYear))
                    {
                        mkdir('./uploads/' . $curYear, 0777, true);
                    }
                    
                    $path = $_FILES['imagem']['name'];
                    
                    $newName = 'CARTA_NUMERO_' . $data['carta_pedido']['numero'] . '.' . pathinfo($path, PATHINFO_EXTENSION); 
                    
                    //CONFIGURACAO UPLOAD
                    $config['upload_path']      = './uploads/'.$curYear;
                    $config['allowed_types']    = 'gif|jpg|jpeg|png';
                    $config['file_name']        = $newName;
                    #$config['max_size']    	= '100';
                    #$config['max_width']       = '1024';
                    #$config['max_height']      = '768';
                    $this->load->library('upload', $config);
                    
                    $this->upload->do_upload('imagem');
                    $params['arquivo'] = $curYear . '/' . $newName;
                }
                //ATUALIZACAO DA CARTA =========================================

                $this->Carta_model->update_carta_pedido($id,$params);
                                
                $this->db->trans_complete(); # Completing transaction
                
                //Optional
                
                if ($this->db->trans_status() === FALSE)
                {
                    # Something went wrong.
                    $this->db->trans_rollback();
                }
                else
                {
                    # Everything is Perfect.
                    # Committing data to the database.
                    $this->db->trans_commit();
                }
                
                redirect('carta/index');
            }
            else
            {
                $data['all_beneficiados'] = $this->Beneficiado_model->get_all_beneficiados();
                
                $data['all_carteiros'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_CARTEIROS);
                
                $data['all_repr_comunidade'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_REPRESENTANTE_COMUNIDADE);
                //$data['all_usuarios'] = $this->Usuario_model->get_all_usuarios();
                
                //carrega as regioes administrativas
                $data['all_regioes'] = $this->NatalSolidario_model->get_all_regiao_administrativa();
                
                //carrega o checklist
                $this->load->model('Carta_checklist_model');
                $data['checklist'] = $this->Carta_checklist_model->get_carta_checklist($id);
                
                $data['js_scripts'] = array('carta/formulario.js');
                $data['_view'] = 'carta/formulario';
                $this->load->view('layouts/main',$data);
            }
        }
        else
        {
            show_error('The carta_pedido you are trying to edit does not exist.');
        }
    }
    
    function adotante($id)
    {
        if(isset($id))
        {
            $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
            
            $data['beneficiado'] = $this->Beneficiado_model->get_beneficiado($data['carta_pedido']['beneficiado']);
            
            $this->load->model('Adotante_model');
            $data['adotante'] = null;
            if ($data['carta_pedido']['adotante'])
            {
                $data['adotante'] = $this->Adotante_model->get_adotante_por_id($data['carta_pedido']['adotante']);
            }
            
            if($this->input->post('acao') === 'save')
            {
                $this->form_validation->set_rules('nome','Nome','required|max_length[300]');
                $this->form_validation->set_rules('celular','Celular','required');
                $this->form_validation->set_rules('email','E-mail pessoal','required|max_length[300]');
                
                if($this->form_validation->run())
                {
                    
                    $email = trim($this->input->post('email'));
                    $adotante = $this->Adotante_model->get_adotante_por_email($email);
                    
                    $params['nome'] = $this->input->post('nome');
                    $params['email'] = $this->input->post('email');
                    $params['telefone'] = preg_replace("/[^0-9,.]/", "", $this->input->post('celular'));
                    $params['local_trabalho'] = $this->input->post('local_trabalho');
                    $params['telefone_trabalho'] = preg_replace("/[^0-9,.]/", "", $this->input->post('telefone_trabalho'));
                    
                    $token = $data['carta_pedido']['token_acesso'];
                    
                    if ($adotante)
                    {
                        $this->Adotante_model->update_adotante($adotante['id'], $params);
                        $adotante_id = $adotante['id'];
                    }
                    else
                    {
                        $params['data_cadastro'] = date('Y-m-d H:i:s');
                        $params['mobilizador'] = $this->session->userdata('usuario_logado_id');
                        
                        $this->load->helper('random_helper');
                        $params['token_acesso'] =  gerarToken(20);
                        
                        $adotante_id = $this->Adotante_model->add_adotante($params);
                    }
                    
                    $params = array(
                        'adotante' => $adotante_id,
                    );
                    $this->Carta_model->update_carta_pedido($id,$params);
                    
                    redirect('carta/index');
                }
            }
            $data['_view'] = 'carta/adotante';
            $this->load->view('layouts/main',$data);
        }
        else
        {
            redirect('carta/index');
        }
    }
    
    function credenciar($id)
    {
        if(isset($id))
        {
            $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
            $params = array(
                'credenciado' => true,
                'data_credenciamento' => date('Y-m-d H:i:s'),
                'usuario_credenciamento' => $this->ion_auth->user()->row()->id,
            );
            $this->Carta_model->update_carta_pedido($id,$params);
        } 
        redirect('carta/index');
    }
    
    function atribuir_carteiro_mobilizador()
    {
        $cartas = $this->input->post('cartas');
        if (sizeof($cartas) > 0) 
        {
            foreach ($cartas as $carta)
            {
                $id = $carta['carta'];
                $carteiro = $carta['carteiro'];
                $mobilizador = $carta['mobilizador'];
                $carta_pedido = $this->Carta_model->get_carta_pedido($id);
                if ($carta_pedido['id'])
                {
                    $params = array();

                    if ($carteiro)
                        $params['carteiro_associado'] = $carteiro;
                    if ($mobilizador)
                        $params['mobilizador'] = $mobilizador;

                    $this->Carta_model->update_carta_pedido($id, $params);
                }
            }
            $this->session->set_flashdata('message_ok', 'Cartas atribuídas com sucesso.');
            return "ok";
        }
        return "erro";
    }

    function new()
    {
		$this->form_validation->set_rules('documento_numero','CPF','required|callback_check_cpf_unique');
        $this->form_validation->set_rules('nome','Nome','required');
        $this->form_validation->set_rules('data_nascimento','Data de Nascimento','required');
        $this->form_validation->set_rules('endereco','Logradouro','required');
        $this->form_validation->set_rules('bairro','Bairro','required');
        $this->form_validation->set_rules('cidade','Cidade','required');
        $this->form_validation->set_rules('uf','UF','required|exact_length[2]|alpha');
        $this->form_validation->set_rules('select_beneficiado','Beneficiado','required');
        $this->form_validation->set_rules('nome_beneficiado','Nome do Beneficiado','required');
        $this->form_validation->set_rules('data_nascimento_beneficiado','Data de Nascimento do Beneficiado','required');
        $this->form_validation->set_rules('sexo_beneficiado','Sexo do Beneficiado','required');
        $this->form_validation->set_rules('representante','Instituição','required');
        
        $data['campanha_atual'] = $this->Campanha_model->get_campanha_atual();

        if ($this->ion_auth_acl->has_permission('acesso_admin'))
        {
            $instituicao = $this->Instituicao_model->get_instituicao($this->input->post('representante'));
        }
        elseif ($this->ion_auth_acl->has_permission('permite_acessar_campanha_local'))
        {
            $instituicao = $this->Instituicao_model->get_instituicao_by_usuario($this->user->id);
        }
        else
        {
            $this->session->set_flashdata('message', 'Você não tem permissão para inclusão de cartas no sistema.');
            redirect('carta/index');
        }

		if($this->form_validation->run())     
        {
            /*
            O campo Método da Busca determina se o responsável foi localizado na base de dados
            0 = não localizado na base
            1 = pelo cpf
            2 = pelo nome e data de nascimento
            */
            
            // Adiciona ou atualiza o Responsável
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

            if (in_array($this->input->post('metodo_busca'), array("0", "2")))
            {
                $params_responsavel['documento_numero'] = $this->input->post('documento_numero');
            }

            $responsavel_id = $this->input->post('responsavel_id');
            if ($responsavel_id)
            {
                $responsavel_id = $this->Responsavel_model->update_responsavel($responsavel_id, $params_responsavel);
            }
            else
            {
                $params_responsavel['data_cadastro'] = date('Y-m-d H:i:s');
                $responsavel_id = $this->Responsavel_model->add_responsavel($params_responsavel);
            }

            // Adiciona ou atualiza a criança beneficiada
            $date2 = strtr($this->input->post('data_nascimento_beneficiado'), '/', '-');
            $params_beneficiado = array(
				'responsavel' => $responsavel_id,
                'nome' => mb_strtoupper($this->input->post('nome_beneficiado')),
                'data_nascimento' => date('Y-m-d', strtotime($date2)),
                'sexo' => $this->input->post('sexo_beneficiado'),
            );

            $beneficiado_id = $this->input->post('select_beneficiado');
            if ($beneficiado_id == 'outro')
            {
                $params_beneficiado['data_cadastro'] = date('Y-m-d H:i:s');
                $beneficiado_id = $this->Beneficiado_model->add_beneficiado($params_beneficiado);
            }
            elseif ($beneficiado_id > 0)
            {
                $beneficiado_id = $this->Beneficiado_model->update_beneficiado($beneficiado_id, $params_beneficiado);
            }

            // Adiciona a carta
            $ano = date('Y');
            $regiaoAdministrativa = str_pad($instituicao['ID_REGIAO_ADMINISTRATIVA'], 3, "0", STR_PAD_LEFT);
            $instituicao_id = str_pad($instituicao['NU_TBP01'], 3, "0", STR_PAD_LEFT);
            $total_cartas = $this->Carta_model->get_total_cartas_por_instituicao_campanha($instituicao['ABRANGENCIA_ID']);
            $sequencial_cartas = str_pad($total_cartas['total']+1, 4, "0", STR_PAD_LEFT);

            $params_carta = array(
				'data_cadastro' => date('Y-m-d H:i:s'),
				'beneficiado' => $beneficiado_id,
				'numero' => $ano . $regiaoAdministrativa . $instituicao_id . $sequencial_cartas,
				'representante_comunidade' => $instituicao['ID_USUARIO'],
                'regiao_administrativa' => $instituicao['ID_REGIAO_ADMINISTRATIVA'],
                'NU_TBC02' => $instituicao['ABRANGENCIA_ID'],
            );
            $carta_pedido_id = $this->Carta_model->add_carta_pedido($params_carta);

            $this->session->set_flashdata('message_ok', 'Pré-cadastro da carta realizado com sucesso.');
            redirect('carta/index');
        }
        else
        {
            $data['instituicoes'] = $this->Campanha_model->get_instituicoes($data['campanha_atual']['NU_TBC01']);
            $data['instituicao_usuario'] = $this->Instituicao_model->get_instituicao_by_usuario($this->user->id);

            $isAdmin = $this->ion_auth_acl->has_permission('acesso_admin');
            $isRepresentanteComunidade = $this->ion_auth_acl->has_permission('permite_acessar_campanha_local');
            if (($isRepresentanteComunidade && !$isAdmin) && !$this->Instituicao_model->checar_instituicao_vinculo_campanha_atual($data['instituicao_usuario']['NU_TBP01']))
            {
                $this->session->set_flashdata('message', 'A sua instituição não está habilitada à participar da campanha atual "' . $data['campanha_atual']['NO_CAMPANHA'] . '".');
                redirect('');
            }
            
            $data['js_scripts'] = array('carta/new.js');
            $data['_view'] = 'carta/new';
            $this->load->view('layouts/main',$data);
        }
    }

    function excluir($id)
    {
        if ($this->ion_auth_acl->has_permission('permite_excluir_carta'))
        {
            $this->Carta_model->delete_carta_pedido($id);
            $this->session->set_flashdata('message', 'A carta foi excluída com sucesso!');
            redirect('carta');
        }
    }

    function upload()
    {
        if(!empty($_FILES['imagens']['name']))
        {
            $campanha_atual = $this->Campanha_model->get_campanha_atual();
            $curYear = $campanha_atual['AA_CAMPANHA'];

            if (!is_dir('galeria/' . $curYear . '/' . $this->user->id))
            {
                mkdir('./galeria/' . $curYear . '/' . $this->user->id, 0777, true);
            }

            $qtdFiles = sizeof($_FILES['imagens']['name']);

            for ($i=0; $i < $qtdFiles; $i++)
            {
                $_FILES['imagem']['name'] = $_FILES['imagens']['name'][$i];
                $_FILES['imagem']['type'] = $_FILES['imagens']['type'][$i];
                $_FILES['imagem']['tmp_name'] = $_FILES['imagens']['tmp_name'][$i];
                $_FILES['imagem']['error'] = $_FILES['imagens']['error'][$i];
                $_FILES['imagem']['size'] = $_FILES['imagens']['size'][$i];

                // CONFIGURACAO UPLOAD
                $config['upload_path']      = './galeria/' . $curYear . '/' . $this->user->id;
                $config['allowed_types']    = 'gif|jpg|jpeg|png';
                $this->load->library('upload', $config);
                $this->upload->overwrite = true;
                $this->upload->initialize($config);
                
                // Upload file to server
                if ($this->upload->do_upload('imagem'))
                {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['nome_arquivo'] = $fileData['file_name'];
                    $uploadData[$i]['nome'] = trim($fileData['raw_name']);
                    $uploadData[$i]['caminho'] = './galeria/' . $curYear . '/' . $this->user->id;
                    $uploadData[$i]['enviado_em'] = date("Y-m-d H:i:s");
                    $uploadData[$i]['extensao'] = $fileData['file_ext'];
                    $uploadData[$i]['tipo'] = $fileData['file_type'];
                    $uploadData[$i]['tamanho'] = $fileData['file_size'];
                    $uploadData[$i]['enviado_por'] = $this->user->id;
                    $uploadData[$i]['status'] = '0';

                    if (substr($uploadData[$i]['nome'], 0, 4) >= 2019)
                    {
                        $numero_carta = substr($uploadData[$i]['nome'], 0, 14);
                    }
                    else {
                        if (strpos($uploadData[$i]['nome'], '_') === false)
                        {
                            $numero_carta = $uploadData[$i]['nome'];
                        }
                        else {
                            $teste = explode($uploadData[$i]['nome'], "_");
                            $numero_carta = $teste[0];
                        }
                    }

                    $carta = $this->Carta_model->get_carta_by_numeroCarta($numero_carta);
                    if ($carta['id'] && ($carta['carteiro_associado'] == $this->user->id || $this->ion_auth_acl->has_permission('acesso_admin')))
                    {
                        if (!is_dir('uploads/' . $curYear))
                        {
                            mkdir('./uploads/' . $curYear, 0777, true);
                        }
                        
                        $newName = 'CARTA_NUMERO_' . trim($fileData['raw_name']) . $fileData['file_ext'];
                        
                        $uploadData[$i]['carta_id'] = $carta['id'];

                        /*if (rename($uploadData[$i]['caminho'] . '/' . $fileData['file_name'], './uploads/'.$curYear .'/'. $newName))
                        {
                            // Atualizar a carta com o arquivo enviado
                            // $params = array(
                            //     'arquivo' => ($curYear .'/'. $newName)
                            // );
                            // $this->Carta_model->update_carta_pedido($carta['id'], $params);
                            // Remover o arquivo do array da galeria
                            // unset($uploadData[$i]);
                        }*/
                    }
                    else {
                        $uploadData[$i]['carta_id'] = NULL;
                    }
                }
            }

            // echo "<pre>";
            // print_r($uploadData);
            // exit();
            if (!empty($uploadData))
            {
                $insert = $this->Carta_model->inserir_galeria($uploadData);
                
                $statusMsg = $insert ? 'Arquivos enviados com sucesso.' : 'Algum problema ocorreu, por favor tente novamente.';
                $this->session->set_flashdata('message_ok', $statusMsg);
            }
        }

        $retorno = $this->Carta_model->get_galeria($this->user->id);
        $data['galeria'] = $retorno ? $retorno : array();

        $data['js_scripts'] = array('carta/upload.js');
        $data['_view'] = 'carta/upload';
        $this->load->view('layouts/main', $data);
    }
    
    function check_cpf_unique($cpf)
    {
        if ($this->input->post('responsavel_id') && ($this->input->post('documento_numero') == $cpf || $this->input->post('responsavel1NumeroDocumento') == $cpf))
            $id = $this->input->post('responsavel_id');
        elseif ($this->input->post('responsavel2_id') && $this->input->post('responsavel2NumeroDocumento') == $cpf)
            $id = $this->input->post('responsavel2_id');
        else
            $id = '';

        
        $cpf = preg_replace("/\D/", "", $cpf);
        $result = $this->Responsavel_model->check_unique_cpf($id, $cpf);
        // echo $id . " - " . $cpf . " - " . $result; exit();
        if ($result == 0)
        {
            $response = true;
            $result = $this->NatalSolidario_model->validar_cpf($cpf);
            if ($result == 1)
                $response = true;
            else
            {
                $this->form_validation->set_message('check_cpf_unique', 'CPF inválido.');
                $response = false;
            }
        }
        else
        {
            $this->form_validation->set_message('check_cpf_unique', 'CPF já existe na base de dados.');
            $response = false;
        }
        return $response;
    }
}