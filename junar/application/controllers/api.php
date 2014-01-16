<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');
/**
 * Main Controller
 * You could use at 
 * http://junar.youwebsite.com/api/FUNCTION_NAME
 * OR
 * http://youwebsite.com/junar/api/FUNCTION_NAME
 */
class Api extends REST_Controller {
    
    /**
     * test function
     * http://api.youwebsite.com/api
     * http://portal.cormup.cl/wserv/index.php/api/catalogo/?token=jUnAr000TOKEN0099
     */    
    public function miPrimeraFuncion_get()
        {
        $q = "select * from anyTable";
        $res = $this->resultToJunar($q);
        $this->response($res);
        }    
       
    public function getDom_get()
        {
        $q = "select * from dominios limit 5";
        $res = $this->resultToJunar($q);
        $this->response($res);
        }
       
        
    /**
     * ---------DO NOT CHANGE-------------------
     * Make the result a junar-compatible result
     * 
     * ------ NO CAMBIAR --------------- 
     * Transformar el resultado de la base de datos en el objeto que Junar necesita
     * 
     * @param String $q the oracle Query
     */
    private function resultToJunar($q)
        {
        $res = new stdClass();
        $data = new stdClass();
        
        $this->load->database();
        $query = $this->db->query($q);
        if ($query)
            {
            $res->result="OK";
            $headers = array();
            $values = array();
            if ($query->num_rows() > 0)
                {
                foreach ($query->result_array() as $row)
                    {
                    if (count($headers) == 0) $headers = array_keys($row);
                    $values[] = str_replace(NULL, "",array_values($row));
                    }
                }
            $res->headers = $headers;
            $res->data = $values;    
            }   
        else 
            {
            $res->result="FAIL";
            $res->error = "Error en la consulta(".$this->db->_error_number()."): " . $this->db->_error_message();
            }
        
        $res->query = $q; // interesante para depurar
        return $res;
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */