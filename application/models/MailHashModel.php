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

}