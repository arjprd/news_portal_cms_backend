<?php 

class UserAccountModel extends CI_Model
{

    public function __construct()
    {
            $this->db = $this->load->database('default', true);
    }

    public function isEmailIn( $email ){

        $this->db->where('email_id', $email);
        $query = $this->db->get('user_account');

        if( count( $query->result_array() ) )
            return true;
        
        return false;
 
    }

    public function isMobileIn( $mobile ){

        $this->db->where('mobile', $mobile);
        $query = $this->db->get('user_account');
        
        if( count( $query->result_array() ) )
            return true;
        
        return false;

    }

    public function add($data){

        $data["mobile_verified"] = "0";
        
        unset($data['lastupdated']);
        
        if($this->db->insert("user_account", $data)){
            return true;
        }

        return false;
    }

}