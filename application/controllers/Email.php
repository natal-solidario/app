<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //load the  library
        $this->load->library('email');
    }

    function send_mail()
    {
        $this->email->from('dyegoav@gmail.com', 'DyegoAV');
        $this->email->to('dyegoav@gmail.com');

        $this->email->subject('mail send demonstration');
        $this->email->message('this is testing');

        $this->email->send();

        echo $this->email->print_debugger();
    }
}