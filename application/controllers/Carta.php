<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Carta extends CI_Controller{

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
        $this->load->model('Instituicao_Model');
        $this->load->model('Campanha_model');
        $this->load->model('Responsavel_model');
         $this->load->model('Beneficiado_model');

        $this->load->add_package_path(APPPATH.'third_party/ion_auth/');
        $this->load->library('ion_auth');
        $this->load->library('pagination');

        if (!$this->ion_auth->logged_in())
        {
            $this->session->set_flashdata('message', 'You must be an admin to view this page');
            redirect('login');
        } else {
            $this->user = $this->ion_auth->user()->row();
            $user_groups = $this->ion_auth->get_users_groups()->result();

            $this->grupos = array();
            foreach ($user_groups as $grupo) {
                array_push($this->grupos, $grupo->name);
            }

            $this->session->set_userdata('usuario_logado', $this->user->email);
            $this->session->set_userdata('grupos_usuario', $this->grupos);
            $this->session->set_userdata('usuario_logado_id', $this->user->id);
        }

    } 

    /*
     * Listing of cartas
     */
    function index()
    {
        $total_records = 0;
        $limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['carteiro_selecionado']       = $this->input->get('carteiro');
        $data['mobilizador_selecionado']    = $this->input->get('mobilizador');
        $data['regiao_administrativa']      = $this->input->get('regiao_administrativa');
        $data['numero']                     = $this->input->get('numero');
        $data['nome_crianca']               = $this->input->get('nome_crianca');
        $data['nome_responsavel']           = $this->input->get('nome_responsavel');
        $data['situacao']                   = $this->input->get('situacao');
        
        //log_message('info',print_r('CARTEIRO_SELECIONADO:' . $data['carteiro_selecionado'], TRUE));
        //log_message('info',print_r('MOBILIZADOR_SELECIONADO:' . $data['mobilizador_selecionado'], TRUE));
        //log_message('info',print_r('REGIAO:' . $data['regiao_administrativa'], TRUE));
        //log_message('info',print_r('NUMERO:' . $data['numero'], TRUE));
        
        $data['cartas'] = null; 
        if ($data['carteiro_selecionado'] != null
            || strlen($data['numero']) > 0
            || strlen($data['nome_crianca']) > 0
            || strlen($data['nome_responsavel']) > 0
            || $data['regiao_administrativa'] != null
            || $data['mobilizador_selecionado'] != null
            || $data['situacao'] != null) {
            
            $total_records = $this->Carta_model->contar_cartas_por_parametros($data['numero']
                , $data['carteiro_selecionado'], $data['regiao_administrativa'], $data['mobilizador_selecionado']
                , $data['nome_crianca'], $data['nome_responsavel'], $data['situacao']);
            
            $data['cartas'] = null;
            if ($total_records > 0) {
                $data['cartas'] = $this->Carta_model->get_cartas_por_parametros($limit_per_page, $start_index, $data['numero']
                    , $data['carteiro_selecionado'], $data['regiao_administrativa'], $data['mobilizador_selecionado']
                    , $data['nome_crianca'], $data['nome_responsavel'], $data['situacao']);
            }
        } else {
            
            $total_records = $this->Carta_model->contar_todas_cartas();
            $data['cartas'] = null;
            if ($total_records > 0) {
                $data['cartas'] = $this->Carta_model->get_all_cartas($limit_per_page, $start_index);
            }
        }
        $data['total_registros'] = $total_records;
        
        $data['carteiros'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_CARTEIROS);

        $data['mobilizadores'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_MOBILIZADORES);
        
        $this->load->model('NatalSolidario_model');
        $data['all_regioes'] = $this->NatalSolidario_model->get_all_regiao_administrativa();
        
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
                
        $data['_view'] = 'carta/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new carta_pedido
     */
    function add()
    {
        $this->load->library('form_validation');

		$this->form_validation->set_rules('beneficiado','Beneficiado','required');
        $this->form_validation->set_rules('representante_comunidade','Representante Comunidade','required');
        //$this->form_validation->set_rules('carteiro_associado','Carteiro','required');
        $this->form_validation->set_rules('regiao_administrativa','Região Administrativa','required');
		
		if($this->form_validation->run())     
        {   
            
            $ano = date('Y');
            $regiaoAdministrativa = str_pad($this->input->post('regiao_administrativa'), 2, "0", STR_PAD_LEFT);
            $idBeneficiado = str_pad($this->input->post('beneficiado'), 5, "0", STR_PAD_LEFT);

            $params = array(
				'beneficiado' => $this->input->post('beneficiado'),
				'representante_comunidade' => $this->input->post('representante_comunidade'),
				'data_cadastro' => date('Y-m-d H:i:s'),
				'numero' => $ano . $regiaoAdministrativa . $idBeneficiado,
                'regiao_administrativa' => $this->input->post('regiao_administrativa')
            );

            if($this->input->post('carteiro_associado')) {
                $params['carteiro_associado'] = $this->input->post('carteiro_associado');
            }
            
            $carta_pedido_id = $this->Carta_model->add_carta_pedido($params);

            $this->load->model('Carta_checklist_model');

            $paramsChecklist = array(
                'carta' => $this->input->post('checklist_carta'),
                'formularo_social' => $this->input->post('checklist_form_social'),
                'doc_identidade_responsaveis' => $this->input->post('checklist_doc_id_responsaveis'),
                'certidao_nascimeno_crianca' => $this->input->post('checklist_cert_nasc_crianca'),
                'doc_bolsa_familia' => $this->input->post('checklist_doc_bolsa_familia'),
                'comprovante_escolar' => $this->input->post('checklist_comp_escolar'),
                'doc_pne' => $this->input->post('checklist_doc_pne'),
                'id_carta' => $carta_pedido_id
            );

            $this->Carta_checklist_model->add_carta_checklist($paramsChecklist);

            //auditoria
            $this->load->model('Registro_log_model');

            $paramsAudit = array(
                'data_cadastro' => date('Y-m-d H:i:s'),
                'usuario' => $this->ion_auth->user()->row()->id,
                'acao' => self::ACAO_INCLUSAO,
                'titulo' => "CARTA",
                'conteudo_anterior' => '',
                'conteudo_posterior' => http_build_query(array_merge($params, $paramsChecklist))

            );
            $this->Registro_log_model->add_registro_log($paramsAudit);

            //retorna o numero da carta criada
            $this->session->set_flashdata('numero_carta_criada', $ano . $regiaoAdministrativa . $idBeneficiado);

            redirect('carta/index');
        }
        else
        {
			$data['all_beneficiados'] = $this->Beneficiado_model->get_all_beneficiados();

            $data['all_carteiros'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_CARTEIROS);

            $data['all_repr_comunidade'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_REPRESENTANTE_COMUNIDADE);

			//$data['all_usuarios'] = $this->Usuario_model->get_all_usuarios();
			//$data['all_usuarios'] = $this->Usuario_model->get_all_usuarios();

            //carrega as regioes administrativas
            $this->load->model('NatalSolidario_model');
            $data['all_regioes'] = $this->NatalSolidario_model->get_all_regiao_administrativa();

            $data['_view'] = 'carta/add';
            $this->load->view('layouts/main',$data);
        }
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
            $this->load->library('form_validation');

			$this->form_validation->set_rules('beneficiado','Beneficiado','required');
            $this->form_validation->set_rules('representante_comunidade','Representante Comunidade','required');
            $this->form_validation->set_rules('carteiro_associado','Carteiro','required');
            $this->form_validation->set_rules('regiao_administrativa','Região Administrativa','required');
			//$this->form_validation->set_rules('data_cadastro','Data Cadastro','required');
			//$this->form_validation->set_rules('numero','Numero','required');
		
			if($this->form_validation->run())     
            {   
                //se o campo vem vazio envia null ao banco
                $varMobilizador = !empty($this->input->post('mobilizador')) ? $this->input->post('mobilizador') : NULL;

                $params = array(
					
					'beneficiado' => $this->input->post('beneficiado'),
					'representante_comunidade' => $this->input->post('representante_comunidade'),
					'carteiro_associado' => $this->input->post('carteiro_associado'),
                    'regiao_administrativa' => $this->input->post('regiao_administrativa'),
                    'mobilizador' => $varMobilizador
                );

                $this->load->model('Carta_checklist_model');
                $checklistAnterior = $this->Carta_checklist_model->get_carta_checklist($id);

                $paramsChecklist = array(
                    'carta' => $this->input->post('checklist_carta'),
                    'formularo_social' => $this->input->post('checklist_form_social'),
                    'doc_identidade_responsaveis' => $this->input->post('checklist_doc_id_responsaveis'),
                    'certidao_nascimeno_crianca' => $this->input->post('checklist_cert_nasc_crianca'),
                    'doc_bolsa_familia' => $this->input->post('checklist_doc_bolsa_familia'),
                    'comprovante_escolar' => $this->input->post('checklist_comp_escolar'),
                    'doc_pne' => $this->input->post('checklist_doc_pne')
                );
                $this->Carta_checklist_model->update_carta_checklist($id, $paramsChecklist);

                $this->Carta_model->update_carta_pedido($id,$params);


                //auditoria
                $this->load->model('Registro_log_model');

                $paramsAudit = array(
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'usuario' => $this->ion_auth->user()->row()->id,
                    'acao' => self::ACAO_ALTERACAO,
                    'titulo' => "CARTA",
                    'conteudo_anterior' => http_build_query(array_merge($data['carta_pedido'], $checklistAnterior)),
                    'conteudo_posterior' => http_build_query(array_merge($params, $paramsChecklist))

                );

                $this->Registro_log_model->add_registro_log($paramsAudit);

                redirect('carta/index');
            }
            else
            {
				$data['all_beneficiados'] = $this->Beneficiado_model->get_all_beneficiados();

                $data['all_carteiros'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_CARTEIROS);

                $data['all_repr_comunidade'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_REPRESENTANTE_COMUNIDADE);

                $data['all_mobilizadores'] = $this->Usuario_model->get_all_usuarios_by_perfil(self::GRUPO_MOBILIZADORES);
				//$data['all_usuarios'] = $this->Usuario_model->get_all_usuarios();

                //carrega as regioes administrativas
                $this->load->model('NatalSolidario_model');
                $data['all_regioes'] = $this->NatalSolidario_model->get_all_regiao_administrativa();

                //carrega o checklist
                $this->load->model('Carta_checklist_model');
                $data['checklist'] = $this->Carta_checklist_model->get_carta_checklist($id);

                $data['_view'] = 'carta/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The carta_pedido you are trying to edit does not exist.');
    }
    
    function formulario($id) {
        // check if the carta_pedido exists before trying to edit it
        $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
        
        $data['beneficiado']  = $this->Beneficiado_model->get_beneficiado($data['carta_pedido']['beneficiado']);
        
        if ($data['beneficiado']['data_nascimento'] != null) {
            $data['beneficiado']['data_nascimento'] = date("d-m-Y", strtotime($data['beneficiado']['data_nascimento']));
        }
        //log_message('info',print_r('PAIS_SEPARADOS:' . $data['beneficiado']['pais_separados'], TRUE));
        
        $data['responsavel']  = $this->Responsavel_model->get_responsavel($data['beneficiado']['responsavel']);
        if ($data['responsavel']['data_nascimento'] != null) {
            $data['responsavel']['data_nascimento'] = date("d-m-Y", strtotime($data['responsavel']['data_nascimento']));
        }
        
        $data['responsavel_adicional']  = null; 
        if ($data['beneficiado']['responsavel_adicional'] != null) {
            $data['responsavel_adicional']  = $this->Responsavel_model->get_responsavel($data['beneficiado']['responsavel_adicional']);
        }
        if ($data['responsavel_adicional']['data_nascimento'] != null) {
            $data['responsavel_adicional']['data_nascimento'] = date("d-m-Y", strtotime($data['responsavel_adicional']['data_nascimento']));
        }
        
        $this->load->model('Beneficiado_familia_model');
        $familiares = $this->Beneficiado_familia_model->get_familia_beneficiado($data['beneficiado']['id']);
        if (!empty($familiares)) {
            $data['familiares'] = array_column($familiares, 'familiar');
        }
        
        $this->load->model('Brinquedo_classificacao_model');
        $data['brinquedo_classificacoes'] = $this->Brinquedo_classificacao_model->get_all_classificacao_brinquedo();
        
        $this->load->model('Carta_brinquedo_model');
        $data['brinquedos'] = $this->Carta_brinquedo_model->get_brinquedos_por_carta($id);
        
        $this->load->model('Carta_programacao_model');
        $programacoes = $this->Carta_programacao_model->get_programacoes_por_carta($id);
        if (!empty($programacoes)) {
            $data['programacoes'] = array_column($programacoes, 'programacao');
        }
        
        if(isset($data['carta_pedido']['id'])) {
            
            //log_message('info',print_r('Validando', TRUE));
            
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('regiao_administrativa','Beneficiado - Comunidade','required');
            $this->form_validation->set_rules('nome','Beneficiado - Nome','required');
            $this->form_validation->set_rules('dataNascimento','Beneficiado - Data de nascimento','required');
            $this->form_validation->set_rules('sexo','Beneficiado - Sexo','required');
            $this->form_validation->set_rules('brinquedo1','1ª opção de brinquedo','required');
            $this->form_validation->set_rules('brinquedo1Tipo','Classificação da 1ª opção de brinquedo','required');
            
            if($this->form_validation->run()){
                
                $this->db->trans_start();
                //$this->db->trans_strict(FALSE);
                
                //ATUALIZACAO DOS BRINQUEDOS ===================================
                
                $params = array(
                    'carta' => $id,
                    'classificacao' => $this->input->post('brinquedo1Tipo'),
                    'descricao' => $this->input->post('brinquedo1'),
                    'prioridade' => 1,
                );
                
                if ($this->input->post('brinquedo1Id')) {
                    $this->Carta_brinquedo_model->update_carta_brinquedo($this->input->post('brinquedo1Id'), $params);
                } else {
                    $this->Carta_brinquedo_model->add_carta_brinquedo($params);
                }
                
                if ($this->input->post('brinquedo2') && $this->input->post('brinquedo2Tipo')) {
                    $params = array(
                        'carta' => $id,
                        'classificacao' => $this->input->post('brinquedo2Tipo'),
                        'descricao' => $this->input->post('brinquedo2'),
                        'prioridade' => 2,
                    );
                    
                    if ($this->input->post('brinquedo2Id')) {
                        $this->Carta_brinquedo_model->update_carta_brinquedo($this->input->post('brinquedo2Id'), $params);
                    } else {
                        $this->Carta_brinquedo_model->add_carta_brinquedo($params);
                    }
                }
                
                if ($this->input->post('brinquedo3') && $this->input->post('brinquedo3Tipo')) {
                    $params = array(
                        'carta' => $id,
                        'classificacao' => $this->input->post('brinquedo3Tipo'),
                        'descricao' => $this->input->post('brinquedo3'),
                        'prioridade' => 3,
                    );
                    
                    if ($this->input->post('brinquedo3Id')) {
                        $this->Carta_brinquedo_model->update_carta_brinquedo($this->input->post('brinquedo3Id'), $params);
                    } else {
                        $this->Carta_brinquedo_model->add_carta_brinquedo($params);
                    }
                }
                
                //ATUALIZACAO DO RESPONSAVEL ===================================
                
                $dataNascimentoResponsavel = strtr($this->input->post('responsavel1DataNascimento'), '/', '-');
                
                $params = array(
                    'nome' => $this->input->post('responsavel1Nome'),
                    'data_nascimento' => date('Y-m-d', strtotime($dataNascimentoResponsavel)),
                    'documento_numero' => $this->input->post('responsavel1NumeroDocumento'),
                    'documento_tipo' => $this->input->post('responsavel1Documento'),
                    'email' => $this->input->post('responsavel1Email'),
                    'endereco' => $this->input->post('responsavel1Endereco'),
                    'telefone' => preg_replace("/[^0-9,.]/", "", $this->input->post('responsavel1Telefone') ),
                    'telefone_operadora' => $this->input->post('responsavel1TelefoneOperadora'),
                    'telefone_whatsapp' => ($this->input->post('responsavel1TelefoneWhatsapp')) ? true : false,
                    'ocupacao' => $this->input->post('responsavel1Ocupacao'),
                    'escolaridade' => $this->input->post('responsavel1Escolaridade'),
                );
                
                $this->Responsavel_model->update_responsavel($data['responsavel']['id'],$params);
                
                //ATUALIZACAO DO RESPONSAVEL ADICIONAL =========================
                
                $idResponsavelAdicional = null;
                if ($this->input->post('responsavel2DataNascimento')
                    && $this->input->post('responsavel2Nome')) {
                
                    $dataNascimentoResponsavel = strtr($this->input->post('responsavel2DataNascimento'), '/', '-');
                    
                    $params = array(
                        'nome' => $this->input->post('responsavel2Nome'),
                        'data_nascimento' => date('Y-m-d', strtotime($dataNascimentoResponsavel)),
                        'documento_numero' => $this->input->post('responsavel2NumeroDocumento'),
                        'documento_tipo' => $this->input->post('responsavel2Documento'),
                        'email' => $this->input->post('responsavel2Email'),
                        'endereco' => $this->input->post('responsavel2Endereco'),
                        'telefone' => preg_replace("/[^0-9,.]/", "", $this->input->post('responsavel2Telefone') ),
                        'telefone_operadora' => $this->input->post('responsavel2TelefoneOperadora'),
                        'telefone_whatsapp' => ($this->input->post('responsavel2TelefoneWhatsapp')) ? true : false,
                        'ocupacao' => $this->input->post('responsavel2Ocupacao'),
                        'escolaridade' => $this->input->post('responsavel2Escolaridade'),
                    );
                    
                    if ($data['responsavel_adicional']['id']) {
                        $idResponsavelAdicional = $data['responsavel_adicional']['id'];
                        $this->Responsavel_model->update_responsavel($data['responsavel_adicional']['id'],$params);
                    } else {
                        $idResponsavelAdicional = $this->Responsavel_model->add_responsavel($params);
                    }
                }
                
                //ATUALIZACAO DO BENEFICIADO ===================================
                
                $dataNascimentoBeneficiado = strtr($this->input->post('dataNascimento'), '/', '-');
                
                //log_message('info',print_r('==========================================', TRUE));
                //log_message('info',print_r('pais separados:'.$this->input->post('paisSeparados'), TRUE));
                //log_message('info',print_r('==========================================', TRUE));
                
                $params = array(
                    'nome' => $this->input->post('nome'),
                    'data_nascimento' => date('Y-m-d', strtotime($dataNascimentoBeneficiado)),
                    'sexo' => $this->input->post('sexo'),
                    'responsavel_adicional' => $idResponsavelAdicional,
                    'pais_separados' => ($this->input->post('paisSeparados')) ? true : false,
                );
                $this->Beneficiado_model->update_beneficiado($data['beneficiado']['id'],$params);
                
                $this->Beneficiado_familia_model->delete_por_beneficiado($data['beneficiado']['id']);
                
                if ($this->input->post('familia')) {
                    //log_message('info',print_r($this->input->post('familia'), TRUE));
                    foreach($this->input->post('familia') as $familiar) {
                        $params = array(
                            'beneficiado' => $data['beneficiado']['id'],
                            'familiar' => $familiar,
                        );
                        $this->Beneficiado_familia_model->add_beneficiado_familia($params);
                    }
                }                
                
                //auditoria
                /*
                $this->load->model('Registro_log_model');
                
                $paramsAudit = array(
                    'data_cadastro' => date('Y-m-d H:i:s'),
                    'usuario' => $this->ion_auth->user()->row()->id,
                    'acao' => self::ACAO_ALTERACAO,
                    'titulo' => "CARTA",
                    'conteudo_anterior' => http_build_query(array_merge($data['carta_pedido'], $checklistAnterior)),
                    'conteudo_posterior' => http_build_query(array_merge($params, $paramsChecklist))
                    
                );
                $this->Registro_log_model->add_registro_log($paramsAudit);
                */
                
                //log_message('info',print_r('Validando', TRUE));
                $params = array(
                    'atendimento_preferencial' => $this->input->post('preferencial'),
                    'regiao_administrativa' => $this->input->post('regiao_administrativa'),
                    'escola' => $this->input->post('escola'),
                    'ano' => $this->input->post('ano'),
                    'renda_familiar' => $this->input->post('renda'),
                    'moradia' => $this->input->post('moradia'),
                );
                
                if(is_uploaded_file($_FILES['imagem']['tmp_name'])) {
                    
                    $curYear = date('Y'); 
                    
                    if (!is_dir('uploads')) {
                        mkdir('./uploads', 0777, true);
                        //log_message('info',print_r('Diretorio uploads criado', TRUE));
                    } else {
                        //log_message('info',print_r('Diretorio uploads ja existe', TRUE));
                    }
                    $dir_exist = true; // flag for checking the directory exist or not
                    if (!is_dir('uploads/' . $curYear)) {
                        mkdir('./uploads/' . $curYear, 0777, true);
                        //$dir_exist = false; // dir not exist
                    }
                    
                    
                    $path = $_FILES['imagem']['name'];
                    //log_message('info',print_r($data['carta_pedido'].['numero'], TRUE));
                    //log_message('info',print_r(pathinfo($path, PATHINFO_EXTENSION), TRUE));
                    
                    //$cartaNumero = $data['carta_pedido']['numero'];
                    //$extensao = pathinfo($path, PATHINFO_EXTENSION);
                    
                    //log_message('info',print_r('CARTA_NUMERO_' . $cartaNumero . '.' . $extensao, TRUE));
                    
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
                
                $this->Carta_programacao_model->delete_por_carta($id);
                
                if ($this->input->post('programacao')) {
                    foreach($this->input->post('programacao') as $programacao) {
                        $params = array(
                            'carta' => $id,
                            'programacao' => $programacao,
                        );
                        $this->Carta_programacao_model->add_carta_programacao($params);
                    }
                }
                
                
                $this->db->trans_complete(); # Completing transaction
                
                //Optional
                
                if ($this->db->trans_status() === FALSE) {
                    # Something went wrong.
                    $this->db->trans_rollback();
                }
                else {
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
                $this->load->model('NatalSolidario_model');
                $data['all_regioes'] = $this->NatalSolidario_model->get_all_regiao_administrativa();
                
                //carrega o checklist
                $this->load->model('Carta_checklist_model');
                $data['checklist'] = $this->Carta_checklist_model->get_carta_checklist($id);
                
                $data['_view'] = 'carta/formulario';
                $this->load->view('layouts/main',$data);
            }
        }
        else {
            show_error('The carta_pedido you are trying to edit does not exist.');
        }
    }
    
    function adotante($id) {
        if(isset($id)) {
            $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
            
            $data['beneficiado'] = $this->Beneficiado_model->get_beneficiado($data['carta_pedido']['beneficiado']);
            
            $this->load->model('Adotante_model');
            $data['adotante'] = null;
            if ($data['carta_pedido']['adotante']) {
                $data['adotante'] = $this->Adotante_model->get_adotante_por_id($data['carta_pedido']['adotante']);
            }
            
            if($this->input->post('acao') === 'save') {
                 
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('nome','Nome','required|max_length[300]');
                $this->form_validation->set_rules('celular','Celular','required');
                $this->form_validation->set_rules('email','E-mail pessoal','required|max_length[300]');
                
                if($this->form_validation->run()) {
                    
                    $email = trim($this->input->post('email'));
                    $adotante = $this->Adotante_model->get_adotante_por_email($email);
                    //log_message('info',print_r('ADOT ' . $adotante, TRUE));
                    
                    $params['nome'] = $this->input->post('nome');
                    $params['email'] = $this->input->post('email');
                    $params['telefone'] = preg_replace("/[^0-9,.]/", "", $this->input->post('celular'));
                    $params['local_trabalho'] = $this->input->post('local_trabalho');
                    $params['telefone_trabalho'] = preg_replace("/[^0-9,.]/", "", $this->input->post('telefone_trabalho'));
                    
                    $token = $data['carta_pedido']['token_acesso'];
                    
                    if ($adotante) {
                        $this->Adotante_model->update_adotante($adotante['id'], $params);
                        $adotante_id = $adotante['id'];
                    } else {
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
                    
                    //log_message('info',print_r('UPDATE CARTA', TRUE));
                    
                    redirect('carta/index');
                }
            }
            $data['_view'] = 'carta/adotante';
            $this->load->view('layouts/main',$data);
        } else {
            redirect('carta/index');
        }
    }
    
    function credenciar($id)
    {
        if(isset($id)) {
            $data['carta_pedido'] = $this->Carta_model->get_carta_pedido($id);
            $params = array(
                'credenciado' => true,
                'data_credenciamento' => date('Y-m-d H:i:s'),
                'usuario_credenciamento' => $this->ion_auth->user()->row()->id,
            );
            $this->Carta_model->atualizar_carta_credenciamento($id,$params);
        } 
        redirect('carta/index');
    }

    function new()
    {
        $this->load->library('form_validation');

		$this->form_validation->set_rules('documento_numero','CPF','required');
        $this->form_validation->set_rules('nome','Nome','required');
        $this->form_validation->set_rules('data_nascimento','Data de Nascimento','required');
        $this->form_validation->set_rules('endereco','Logradouro','required');
        $this->form_validation->set_rules('bairro','Bairro','required');
        $this->form_validation->set_rules('cidade','Cidade','required');
        $this->form_validation->set_rules('uf','UF','required');
        $this->form_validation->set_rules('select_beneficiado','Beneficiado','required');
        $this->form_validation->set_rules('nome_beneficiado','Nome do Beneficiado','required');
        $this->form_validation->set_rules('data_nascimento_beneficiado','Data de Nascimento do Beneficiado','required');
        $this->form_validation->set_rules('sexo_beneficiado','Sexo do Beneficiado','required');
        $this->form_validation->set_rules('representante','Instituição','required');
        
        $data['campanha_atual'] = $this->Campanha_model->get_campanha_atual();
		
		if($this->form_validation->run())     
        {
            $campanha_atual = $data['campanha_atual'];
            if (in_array('admin', $this->grupos, true)) {
                $instituicao = $this->Instituicao_Model->get_instituicao($this->input->post('representante'));
            }
            elseif (in_array("representante-comunidade", $grupos_usuario, true)) {
                $instituicao = $this->Instituicao_Model->get_instituicao_by_usuario($this->user->id);
            }
            else {
                $this->session->set_flashdata('message', 'Você não tem permissão para inclusão de cartas no sistema.');
                redirect('carta/index');
            }

            /*
            O campo Método da Busca determina se o responsável foi localizado na base de dados
            0 = não localizado na base
            1 = pelo cpf
            2 = pelo nome e data de nascimento
            */
            
            // echo "<pre>";
            // print_r($this->input->post());
            // print_r($campanha_atual);
            // print_r($instituicao);
            // exit();


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

            if (in_array($this->input->post('metodo_busca'), array("0", "2"))) {
                $params_responsavel['documento_numero'] = $this->input->post('documento_numero');
            }

            $responsavel_id = $this->input->post('responsavel_id');
            if ($responsavel_id) {
                $responsavel_id = $this->Responsavel_model->update_responsavel($responsavel_id, $params_responsavel);
            }
            else {
                $params_responsavel['data_cadastro'] = date('Y-m-d H:i:s');
                $responsavel_id = $this->Responsavel_model->add_responsavel($params_responsavel);
            }
            // print_r($params_responsavel);

            // Adiciona ou atualiza a criança beneficiada
            $date2 = strtr($this->input->post('data_nascimento_beneficiado'), '/', '-');
            $params_beneficiado = array(
				'responsavel' => $responsavel_id,
                'nome' => $this->input->post('nome_beneficiado'),
                'data_nascimento' => date('Y-m-d', strtotime($date2)),
                'sexo' => $this->input->post('sexo_beneficiado'),
            );

            $beneficiado_id = $this->input->post('select_beneficiado');
            if ($beneficiado_id == 'outro') {
                $params_beneficiado['data_cadastro'] = date('Y-m-d H:i:s');
                $beneficiado_id = $this->Beneficiado_model->add_beneficiado($params_beneficiado);
            }
            elseif ($beneficiado_id > 0) {
                $beneficiado_id = $this->Beneficiado_model->update_beneficiado($beneficiado_id, $params_beneficiado);
            }
            // print_r($params_beneficiado);


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
            // print_r($params_carta);

            // exit();

            redirect('carta/index');
        }
        else
        {
            $data['instituicoes'] = $this->Campanha_model->get_instituicoes($data['campanha_atual']['NU_TBC01']);
            $data['instituicao_usuario'] = $this->Instituicao_Model->get_instituicao_by_usuario($this->user->id);
            // echo "<pre>"; print_r($data['instituicoes']);print_r($data['instituicao_usuario']); exit();
            
            $data['js_scripts'] = array('carta/new.js');
            $data['_view'] = 'carta/new';
            $this->load->view('layouts/main',$data);
        }
    }
}
