<?php

class MailHashModel extends CI_Model
 {
    public function __construct()
 {
        $this->db = $this->load->database( 'temp', true );
    }

    public function add( $email, $hash, $lastupdated ) {

        return $this->db->insert( 'email_verification', [
            'email_id'      =>  $email,
            'hash'          =>  $hash,
            'lastupdated'   =>  $lastupdated
        ] );

    }

    public function isUserPresent( $email, $v_key ) {

        $isPresent = ['email_id' => $email, 'hash' => $v_key];

        $this->db->where( $isPresent );
        $query = $this->db->get( 'email_verification' );

        if ( count( $query->result_array() ) )
        return true;

        return false;
    }

    public function remove( $email ) {

        $this->db->where( 'email_id', $email );

        return $this->db->delete( 'email_verification' );

    }

}