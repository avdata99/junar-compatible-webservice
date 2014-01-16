<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/REST_Controller.php');

class Api extends REST_Controller {
    
    /**
     * lista de todas las tables del sistema (que no sean del tipo SYNONYM)
     * http://portal.cormup.cl/wserv/index.php/api/catalogo/?token=jUnAr000TOKEN0099
     */    
    public function catalogo_get()
        {
        $q = "select * from cat";
        $res = $this->resultToJunar($q);
        $this->response($res);
        }    
        
    /**
     * Consulta generica a la base de datos definiendo la tabla y cantidad de registros
     * Formato tal como lo requiere junar (path-to-headers = "headers", path-to-data = "data")
     * @param string $table table name
     * @param int $limit records
     * EJEMPLO
     * http://portal.cormup.cl/wserv/index.php/api/generic2/BOLETASHON/20/?token=jUnAr000TOKEN0099
     */    
    public function generic2_get($table, $limit = 1000)
        {
        $q = "select * from $table where rownum < $limit";
        $res = $this->resultToJunar($q);
        $this->response($res);
        }
        
    /**
     * Ejemplo de consulta especifica con dos filtros incluidos
     * @param type $neto_desde
     * @param type $neto_hasta
     * EJEMPLO
     * http://portal.cormup.cl/wserv/index.php/api/boletashon/2000/3000/NETO/1/5?token=jUnAr000TOKEN0099
     */    
    public function boletashon_get($neto_desde = "0", $neto_hasta = "0")
        {
        $q = "select * from BOLETASHON ";
        
        if ($neto_desde > 0) {$filtros[] = "NETO >= $neto_desde";}
        if ($neto_hasta > 0) {$filtros[] = "NETO <= $neto_hasta";}
        
        if (count($filtros > 0)) {$q .= " where ". implode(" AND ", $filtros);}
        
        $q .= " order by NETO ";
        
        $res = $this->resultToJunar($q);
        $this->response($res);
        }    
       
    /**
     * Ejemplo de consulta especifica (compleja) expuesta al API con filtros, orden y paginado 
     * @param type $neto_desde
     * @param type $neto_hasta
     * @param type $order
     * @param type $limit
     * EJEMPLO: http://portal.cormup.cl/wserv/index.php/api/boletashonpaginado/2600/4800/NETO/2/30?token=jUnAr000TOKEN0099
     */
    public function boletashonpaginado_get($neto_desde = "0", $neto_hasta = "0", $order="NROBOLETA", $page = 1, $pageSize = 1000)
        {
        $q = "select NETO, RUT, NROBOLETA, CONTRATO_ID, row_number() over (order by $order) rn from BOLETASHON ";
        
        if ($neto_desde > 0) {$filtros[] = "NETO >= $neto_desde";}
        if ($neto_hasta > 0) {$filtros[] = "NETO <= $neto_hasta";}
        
        if (count($filtros > 0)) {$q .= " where ". implode(" AND ", $filtros);}
        
        //$q .= " ORDER BY $order ";
        
        $registroDesde = ((INT)$page - 1) * (INT)$pageSize;
        $registroHasta = $registroDesde + (INT)$pageSize;
        
        //asi se limitan las consultas en oracle viejo
        $q2 = "SELECT * FROM ($q) WHERE ";
        if ($registroDesde > 0) {$q2 .= "  rn >= $registroDesde AND ";}
        $q2 .= " rn < $registroHasta"; 
        
        /* esto funciona en Oracle 12, no en nuestra version mas vieja
        if ($registroDesde > 0) $q .= " OFFSET $registroDesde ROWS FETCH NEXT $pageSize ROWS ONLY;";
        else $q .= " FETCH FIRST $pageSize ROWS ONLY ";
        */
        
        $res = $this->resultToJunar($q2);
        $this->response($res);
        }    
        
    /**
     * Transformar el resultado de la base de datos en el objeto que Junar necesita
     * ------ NO CAMBIAR ---------------
     * @param String $q the oracle Query
     */
    private function resultToJunar($q)
        {
        $res = new stdClass();
        $data->loadDB = $this->load->database();
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