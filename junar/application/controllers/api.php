<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');
/**
 * Main Controller
 * You could use at 
 * http://junar.youwebsite.com/index.php/api/FUNCTION_NAME
 * OR
 * http://youwebsite.com/junar/index.php/api/FUNCTION_NAME
 * (you could remove "index.php" using .htaccess)
 */
class Api extends REST_Controller {
    
    /**
     * Test function. ALWAYS use "_get" sufix in the function name definition
     * Read more about REST library at https://github.com/avdata99/codeigniter-restserver
     * 
     * Just define a query and send to resultToJunar function, then send the "response"
     * 
     * You could use "format" parameter as /format/json or /format/xml
     * For example
     * http://junar.youwebsite.com/api/miPrimeraFuncion/format/xml
     * http://junar.youwebsite.com/api/miPrimeraFuncion/format/json
     * (the url NEVER must include the"_get" sufix)
     */
    public function miPrimeraFuncion_get()
        {
        $q = "select * from anyTable";
        $res = $this->resultToJunar($q);
        $this->response($res);
        }
        
        
    /**
     * test whit params
     * Examples
     * http://junar.youwebsite.com/api/abotherFunction/table/productos
     * http://junar.youwebsite.com/api/abotherFunction/table/productos/order/id desc
     * http://junar.youwebsite.com/api/abotherFunction/table/productos/limit/6
     * http://junar.youwebsite.com/api/abotherFunction/table/productos/order/id/limit/10/format/xml
     * 
     * If you want to use parameters like ?param1=value1&param2=value2 enable "enable_query_strings"
     * on the config file (application/config/config.php)
     * If you need to allow more characters on the URL redefine the "permitted_uri_chars" configuration value
     */    
    public function anotherFunction_get()
        {
        $table = $this->get('table');
        $limit = ($this->get('limit')) ? " limit " . $this->get('limit'): "";
        $order = ($this->get('order')) ? " order by " . $this->get('order') : "";
        $q = "select * from $table $order $limit";
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