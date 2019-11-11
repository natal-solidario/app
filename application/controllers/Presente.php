<?php (defined('BASEPATH')) OR exit('No direct script access allowed'); 
class Presente extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        
        $this->load->model('Carta_model');
        $this->load->model('Adotante_model');
        $this->load->model('Brinquedo_classificacao_model');
        $this->load->model('Presente_model');
        $this->load->model('Local_entrega_regiao_model');
        $this->load->model('Local_entrega_model');
        $this->load->model('Presente_historico_situacao_model');
        $this->load->model('NatalSolidario_model');
        
        $this->session->set_userdata('nomeAdotante', '');
        $this->session->set_userdata('cartasAdotante', []);
    }
    
    function carregarMenu($idAdotante = null, $token = null) {
        $token_decoded = urldecode($token);
        
        $adotante = $this->Adotante_model->get_adotante_por_id($idAdotante);
        if ($adotante) {
            if ($adotante['token_acesso'] == $token_decoded) {
                $pieces = explode(" ", $adotante['nome']);
                
                $this->session->set_userdata('nomeAdotante', $adotante['nome']);
                $this->session->set_userdata('cartasAdotante', $this->Carta_model->pesquisar_por_ano_adotante(date("Y"), $idAdotante));

            } else {
                $this->session->set_flashdata('message', 'O endereço acessado é inválido, verifique se ele está igual ao recebido por e-mail.');
            }
        } else {
            if(null !== $this->session->userdata('origem') && $this->session->userdata('origem') == 'recebimentoPresente'){
                $this->session->set_flashdata('message', '');
            } else {
                $this->session->set_flashdata('message', 'Não localizamos o seu cadastro.');
            }
            
        }
    }
    
    function index($idAdotante = null, $token = null)
    {
        $this->session->set_userdata('idAdotante', $idAdotante);
        $this->session->set_userdata('tokenAdotante', $token);
        
        $this->carregarMenu($idAdotante, $token);
        
        $data['_view'] = 'presente/index';
        $this->load->view('layouts/main_presente',$data);
    }
    
    function add($idCarta = null)
    {
        $this->form_validation->set_rules('descricaoBrinquedo','Brinquedo','required');
        $this->form_validation->set_rules('classificacaoBrinquedo','Classificação do brinquedo','required');

        $presente = $this->Presente_model->pesquisar_por_carta($idCarta);
        
        $data['origem'] = ($this->session->userdata('origem') != null) ? $this->session->userdata('origem') : $this->input->post('hdnOrigem');
        
        if($this->form_validation->run())
        {
            $valorBrinquedo = $this->input->post('valorBrinquedo');
            if ($valorBrinquedo) {
                $valorBrinquedo = str_replace(".","",$valorBrinquedo);
                $valorBrinquedo = str_replace(",",".",$valorBrinquedo);
            }
            
            $params = array(
                'situacao' => 1 /*NOVO*/,
                'carta' => $idCarta,
                'brinquedo_descricao' => $this->input->post('descricaoBrinquedo'),
                'brinquedo_classificacao' => $this->input->post('classificacaoBrinquedo'),
                'valor' => $valorBrinquedo
            );
            
            if ($presente) {
                $this->Presente_model->update($presente['id'], $params);
            } else {
                $params['data_cadastro'] = date('Y-m-d H:i:s');
                $this->Presente_model->add($params);
            }
            
            if($data['origem'] == 'recebimentoPresente')
            {
                $carta = $this->Carta_model->get_carta_pedido($idCarta);
                redirect('presente/receberPresente/'.$carta['numero']);
            }
            else
            {
                redirect('presente/index/'.$this->session->userdata('idAdotante').'/'.$this->session->userdata('tokenAdotante'), 'location');
            }
        }
        else
        {
            $this->carregarMenu($this->session->userdata('idAdotante'), $this->session->userdata('tokenAdotante'));
            
            $data['descricaoPresente'] = ($presente) ? $presente['brinquedo_descricao'] : '';
            $data['valorBrinquedo'] = ($presente) ? $presente['valor'] : '';
            $data['classificacaoBrinquedo'] = ($presente) ? $presente['brinquedo_classificacao'] : '';
            $data['situacao'] = ($presente) ? $presente['situacao'] : '1';
            
            $data['brinquedo_classificacoes'] = $this->Brinquedo_classificacao_model->get_all_classificacao_brinquedo();
            
            if(isset($idCarta)) {
                $data['cartaSelecionada'] = $this->Carta_model->get_dados_complementares_carta_por_id($idCarta);
            }

            $data['idade'] = date("Y") - date("Y", strtotime($data['cartaSelecionada']['data_nascimento']));
            
            $data['locais_entrega'] = $this->Local_entrega_regiao_model->get_local_entrega_por_regiao($data['cartaSelecionada']['regiao_administrativa'], date('Y/m/d'));
            if (!$data['locais_entrega']) {
                $data['locais_entrega'] = [];
            }
            
            $data['local_entrega_familia'] = $this->Local_entrega_regiao_model->get_local_entrega_familias_por_regiao($data['cartaSelecionada']['regiao_administrativa']);
            if (!$data['local_entrega_familia']) {
                $data['local_entrega_familia'] = '';
            }
            $dadosPresente = $this->Presente_model->get_dados_presente($this->input->post('numeroCarta'));
            $data['nomeLocalEntrega'] = urlencode($dadosPresente['nomeLocalEntrega']);
            $data['numeroSalaEntrega'] = $dadosPresente['numeroSalaEntrega'];
            

            // echo "<pre>";
            // print_r($data);
            // print_r($this->session->userdata());
            // exit();

            $data['_view'] = 'presente/add';
            if($data['origem'] == 'recebimentoPresente')
            {
                $this->load->view('layouts/main',$data);
            }
            else
            {
                $this->load->view('layouts/main_presente',$data);    
            }
            
        }
    }

    function gerarEtiqueta() {
        $data = Array(
            'numeroCarta' => urldecode($this->uri->segment(3)),
            'nomeResponsavel' => urldecode($this->uri->segment(4)),
            'nomeCrianca' => urldecode($this->uri->segment(5)),
            'localEntrega' => urldecode($this->uri->segment(6)) . "<br /> Data Limite: " . urldecode($this->uri->segment(7)),
            'localEvento' => urldecode($this->uri->segment(8)) . "<br /> Sala: " . urldecode($this->uri->segment(9)),
            'urlQrcode' => urlencode(site_url().'presente/receberPresente/'.$this->uri->segment(3))
        );

        //load the view and saved it into $html variable
        $this->load->view('presente/template_etiqueta', $data);
    }

    function receberPresente($numeroCarta = null) {
        if ($this->input->post('numeroCarta') || isset($numeroCarta)) {
            $numeroCarta = isset($numeroCarta) ? $numeroCarta : $this->input->post('numeroCarta');

            $usuario = $this->user;

            $carta = $this->Carta_model->get_carta_by_numeroCarta($numeroCarta);
            $data['idCarta'] = $carta['id'];
            
            $dadosPresente = $this->Presente_model->get_dados_presente($numeroCarta);
            
            if(is_null($dadosPresente['idPresente']))
            {
                $this->session->set_flashdata('message', 'Não existe presente cadastrado para a carta número ' . $numeroCarta);
            }

            $data['allLocaisArmazenamento'] = $this->Local_entrega_model->get_locais_armazenamento();
            $data['allSituacoesPresente'] = $this->Presente_model->get_all_situacoes_presente();
            $data['allLocaisEntrega'] = $this->Local_entrega_regiao_model->get_local_entrega_familias();

            if($this->input->post('local_armazenamento')) {
                $params = array(
                    'local_armazenamento' => $this->input->post('local_armazenamento')
                );
                $this->Presente_model->update($dadosPresente['idPresente'], $params);
            }

            if($this->input->post('situacao_presente')) {
                $params = array(
                    'situacao' => $this->input->post('situacao_presente'),
                    'local_entrega' => $this->input->post('local_entrega'),
                );
                $this->Presente_model->update($dadosPresente['idPresente'], $params);
                $this->session->set_flashdata('message', 'O presente foi atualizado com sucesso.');
                $paramsSituacao = array(
                    'presente' => $dadosPresente['idPresente'],
                    'situacao' => $this->input->post('situacao_presente'),
                    'usuario' => $user->id,
                    'data_situacao' => date('Y-m-d H:i:s')
                );
                $this->Presente_historico_situacao_model->add($paramsSituacao);
            }

            $dadosPresenteAposAtualizacao = $this->Presente_model->get_dados_presente($numeroCarta);
            $dados = array(
                'idPresente' => $dadosPresenteAposAtualizacao['idPresente'],
                'numeroCarta' => $dadosPresenteAposAtualizacao['numeroCarta'],
                'nomeAdotante' => $dadosPresenteAposAtualizacao['adotante_nome'],
                'numeroSalaEntrega' => $dadosPresenteAposAtualizacao['numeroSalaEntrega'],
                'nomeLocalEntrega' => $dadosPresenteAposAtualizacao['nomeLocalEntrega'],
                'responsavel_nome' => $dadosPresenteAposAtualizacao['responsavel_nome'],
                'beneficiado_nome' => $dadosPresenteAposAtualizacao['beneficiado_nome'],
                'localArmazenamentoPresente' => $dadosPresenteAposAtualizacao['localArmazenamentoPresente'],
                'situacaoPresente' => $dadosPresenteAposAtualizacao['situacaoPresente'],
                'presente_local_entrega' => $dadosPresenteAposAtualizacao['presente_local_entrega'],
            );

            $data['_view'] = 'presente/receber-presente';
            $data['dados'] = $dados;

            $this->load->view('layouts/main',$data);
        }
        else
        {
            $data['_view'] = 'presente/receber-presente';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function entrega($idPresente = null) {
        $data['imagem_entrega'] = null;
        
        if($this->input->post('numeroCarta')) {
            $numeroCarta = $this->input->post('numeroCarta');
            $dadosPresente = $this->Presente_model->get_dados_presente($numeroCarta);
            
            if ($dadosPresente['situacaoPresente'] == 5) {
                $data['imagem_entrega'] = $dadosPresente['imagem_entrega'];
            }
            $data['dadosPresente'] = $dadosPresente;
        }
        
        if (isset($idPresente)) {
            
            if(isset($_FILES['imagem']) && is_uploaded_file($_FILES['imagem']['tmp_name'])) {
                
                $curYear = date('Y');
                
                if (!is_dir('uploads')) {
                    mkdir('./uploads', 0777, true);
                }
                
                if (!is_dir('uploads/entrega')) {
                    mkdir('./uploads/entrega', 0777, true);
                }
                
                if (!is_dir('uploads/entrega/' . $curYear)) {
                    mkdir('./uploads/entrega/' . $curYear, 0777, true);
                }
                
                
                $path = $_FILES['imagem']['name'];
                
                $newName = 'CARTA_NUMERO_' . $this->input->post('numeroCarta') . '.' . pathinfo($path, PATHINFO_EXTENSION);
                
                //CONFIGURACAO UPLOAD
                $config['upload_path']      = './uploads/entrega/'.$curYear;
                $config['allowed_types']    = 'gif|jpg|jpeg|png';
                $config['file_name']        = $newName;
                #$config['max_size']    	= '100';
                #$config['max_width']       = '1024';
                #$config['max_height']      = '768';
                $this->load->library('upload', $config);
                
                $this->upload->do_upload('imagem');
                $params['imagem_entrega'] = 'entrega/' . $curYear . '/' . $newName;
                $params['situacao'] = 5;/*ENTREGUE*/
                
                $this->Presente_model->update($idPresente, $params);
                
                $data['imagem_entrega'] = $params['imagem_entrega'];
                
                $infoEmail['nomeAdotante'] = $dadosPresente['adotante_nome'];
                $infoEmail['beneficiado_sexo'] = $dadosPresente['beneficiado_sexo'];
                $infoEmail['beneficiado'] = $dadosPresente['beneficiado_nome'];
                $infoEmail['imagem_entrega'] = $params['imagem_entrega'];
                
                $body = $this->load->view('email/modelo_email_entrega_presente.php', $infoEmail, TRUE);
                
                if ($dadosPresente['adotante_email']) {
                    $params2['email_entrega_enviado'] = $this->send_mail($body, $dadosPresente['adotante_email']);
                    $this->Presente_model->update($idPresente, $params2);
                }
            }
        }
        $data['_view'] = 'presente/entrega';
        $this->load->view('layouts/main',$data);
    }

    public function send_teste() {
        $this->send_mail("Mensagem de corpo do e-mail", "dyegoav@gmail.com");
    }

    private function send_mail($body, $emailTo)
    {
        $sysconfig = $this->NatalSolidario_model->get_all_config();

        if ($sysconfig['smtp_host'] && $sysconfig['smtp_user'] && $sysconfig['smtp_pass'])
        {
            $config = Array(
                'protocol' => 'smtp', // 'mail', 'sendmail', 'smtp'
                'smtp_host' => $sysconfig['smtp_host'],
                'smtp_port' => (isset($sysconfig['smtp_port']) ? $sysconfig['smtp_port'] : 587),
                'smtp_user' => $sysconfig['smtp_user'],
                'smtp_pass' => $sysconfig['smtp_pass'],
                'mailtype'  => 'html', // 'text', 'html'
                'charset'   => 'utf-8',
                'smtp_crypto' => 'ssl', // 'ssl', 'tls'
                'validate' => TRUE,
                'newline' => "\r\n"
                );
            
            $this->email->initialize($config);
        }
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($sysconfig['email_from'], $sysconfig['nome_from']);
        $this->email->to($emailTo);
        $this->email->subject('Natal Solidário - Entrega do presente');
        $this->email->message($body);
        
        //$this->email->send(FALSE);
        //return $this->email->print_debugger(array('headers'));
        return $this->email->send();
    }
    
    function conferencia() {
        
        $totalCartasRecebidasPorRegiao = $this->Carta_model->get_total_cartas_por_regiao();
        
        $totalPresentesConferidosPorRegiao = $this->Presente_model->get_presentes_por_local_entrega();
        
        $locaisEntrega = $this->Local_entrega_regiao_model->get_local_entrega_familias();
        $data['locaisEntrega'] = $locaisEntrega;
        
        $data['totalCartasRecebidasPorRegiao'] = array();
        $i = 0;
        foreach($totalCartasRecebidasPorRegiao as $regiao) {
            $regiao['conferidosPorRegiao'] = array();

            foreach($locaisEntrega as $local) {
                
                $encontrado = false;
                foreach($totalPresentesConferidosPorRegiao as $item) {
                
                    if ($regiao['id'] === $item['carta_destino']) {
                    
                        if ($local['nomeLocalEntrega'] === $item['presente_nome_local_entrega']) {
                            $regiao['conferidosPorRegiao'][$item['presente_nome_local_entrega']] = $item['total'];
                            $encontrado = true;
                            break;
                        } 
                    }
                }
                if (!$encontrado) {
                    $regiao['conferidosPorRegiao'][$local['nomeLocalEntrega']] = 0;
                }
            }
            $data['totalCartasRecebidasPorRegiao'][$i++] = $regiao;
        }
        $data['_view'] = 'presente/conferencia';
        $this->load->view('layouts/main',$data);
    }
}