<?php 

class MailHashModel extends CI_Model
{
    public function __construct()
    {
            $this->db = $this->load->database('temp', true);
    }

    public function add( $email, $hash, $lastupdated ){

        return $this->db->insert( 'email_verification', [
            "email_id"      =>  $email,
            "hash"          =>  $hash,
            "lastupdated"   =>  $lastupdated 
        ] );

    }

    public function isUserPresent($email, $v_key){
        $this->db->where('email_id', $email);
        $query = $this->db->get('email_verification');

        if( count( $query->result_array() ) ){
            $d = $query->result_array()[0];

            $k = $d['hash'];

            if($k === $v_key)
                return true;
        }   
            
        
        return false;
    }

    public function remove($email){
        
        $this->db->where("email_id", $email);
        
        return $this->db->delete("email_verification");
    
    }

}