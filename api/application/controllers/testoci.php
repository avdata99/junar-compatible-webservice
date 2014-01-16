<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testoci extends CI_Controller {
    
    public function index()
        {
        $data = new stdClass();
        $data->server = array("status"=>"OK", "URL"=>BASEPATH);
        $data->environment = ENVIRONMENT;
        
        $data->loadDB = $this->load->database();
        $this->output->set_header("Content-Type:application/json");
        $this->output->set_output(json_encode($data));
        }
          
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */