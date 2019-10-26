<?php
class Usuario_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->userTbl = 'users';
    }
    
    /*
     * Get usuario by id
     */
    function get_usuario($id)
    {
        return $this->db->get_where('usuario',array('id'=>$id))->row_array();
    }
        
    /*
     * Get all usuarios
     */
    function get_all_usuarios()
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get('usuario')->result_array();
    }

    /*
     * Get all usuarios
     */
    function get_all_usuarios_by_perfil($idPerfil)
    {
        $this->db->select('usuario.*');
        $this->db->from('usuario');
        $this->db->join('usuario_perfil', 'usuario_perfil.user_id = usuario.id and usuario_perfil.group_id = '.$idPerfil);
        $this->db->order_by('usuario.first_name', 'asc');
        
        return $this->db->get()->result_array();
    }
        
    /*
     * function to add new usuario
     */
    function add_usuario($params)
    {
        $this->db->insert('usuario',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update usuario
     */
    function update_usuario($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('usuario',$params);
    }
    
    /*
     * function to delete usuario
     */
    function delete_usuario($id)
    {
        return $this->db->delete('usuario',array('id'=>$id));
    }

    /*
     * get rows from the users table
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->userTbl);
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            $query = $this->db->get();
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $query->num_rows();
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $result = ($query->num_rows() > 0)?$query->row_array():FALSE;
            }else{
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }

        //return fetched data
        return $result;
    }
    
    /*
     * Insert user information
     */
    public function insert($data = array()) {
        //add created and modified data if not included
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        
        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);
        
        //return the status
        if($insert){
            return $this->db->insert_id();;
        }else{
            return false;
        }
    }
}
