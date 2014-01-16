<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Welcome extends CI_Controller {

    public function index()
        {
        $this->load->view('api_home');
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */