<?php
/* 
 * João Paulo
 * jpaulocs@gmail.com
 */
 
class Envio_Email extends CI_Controller{
    function __construct()
    {
        parent::__construct();

        $this->load->add_package_path(APPPATH.'third_party/ion_auth/');
        $this->load->library('ion_auth');
        //Load email library
        $this->load->library('email');
        //$this->load->library('encrypt');

        $this->load->model('Adotante_model');
        $this->load->model('Beneficiado_model');

        if (!$this->ion_auth->in_group('admin'))
        {
            $this->session->set_flashdata('message', 'Você deve ser um administrador para acessar esta funcionalidade!');
            redirect(site_url());
        } else {
            $user = $this->ion_auth->user()->row();
            $this->session->set_userdata('usuario_logado', $user->email);
            
        }
    }

    public function index() {
    	$this->verificaEmailsEnviar();
    }

    private function verificaEmailsEnviar() {
    	// 0 = Email não enviado
    	$adotantesAEnviar = $this->Adotante_model->get_adotante_por_status_envio_email(0);

    	if(isset($adotantesAEnviar)) {
    		$data['qtdEmailsEnviar'] = count($adotantesAEnviar);
    	} else {
    		$data['qtdEmailsEnviar'] = 0;
    	}

    	$data['emailsOk'] = Array();
    	$data['emailsErro'] = Array();

    	foreach ($adotantesAEnviar as $adotante) {
    		$linkComToken = 'http://www.heroisdeverdade.org/app/natal-solidario/presente/index/';
    		$linkComToken .= $adotante['id'] . '/';
    		$linkComToken .= urlencode($adotante['token_acesso']);

    		$beneficiados = $this->Beneficiado_model->get_all_beneficiados_por_adotante($adotante['id']);

    		$infoEmail = Array(
    			'nomeAdotante' => $adotante['nome'],
    			'beneficiados' => $beneficiados,
    			'link' => $linkComToken
    		);
    		$body = $this->load->view('email/modelo_email_adotante.php',$infoEmail,TRUE);

    		$enviouEmail = $this->send_mail($body, $adotante['email']);

    		//Send mail
	        if($enviouEmail) {
	        	$params = array(
	        		'email_enviado' => '1'
	        	);
	        	$this->Adotante_model->update_adotante($adotante['id'], $params);
	        	array_push($data['emailsOk'], $adotante['email']);

	            log_message('info', 'E-mail enviado com sucesso: ' . $adotante['email']);
	        } else {
	        	array_push($data['emailsErro'], $adotante['email']);

	            log_message('info', 'Erro ao enviar e-mail: ' . $adotante['email']);
	        }

    	}

        $this->load->view('email/resumo_envio', $data);
    }

    private function send_mail($body, $emailTo) {
        $from_email = "";

        $config = Array(
		    'protocol' => 'mail',
		    'smtp_host' => '',
		    'smtp_port' => 587,
		    'smtp_user' => '',
		    'smtp_pass' => '',
		    'mailtype'  => 'html', 
		    'charset'   => 'utf-8',
            'smtp_crypto' => 'ssl'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
        $this->email->from($from_email, 'Heróis de Verdade');
        $this->email->to($emailTo);
        $this->email->subject('Natal Solidário - Informações sobre carta(s) adotada(s)');
        $this->email->message($body);

        //$this->email->send(FALSE);
        //return $this->email->print_debugger(array('headers'));
        return $this->email->send();
    }

}