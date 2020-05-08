<?php

class SignupModel extends CI_Model {

    public function __construct()
 {

        $this->db = $this->load->database( 'temp', true );
        $this->load->model( 'MailHashModel' );
        $this->load->model( 'OtpModel' );

    }

    public function get() {

        $query = $this->db->get( 'signup' );
        return $query->result_array();

    }

    public function isEmailIn( $email ) {

        $this->db->where( 'email_id', $email );
        $query = $this->db->get( 'signup' );

        if ( count( $query->result_array() ) )
        return true;

        return false;

    }

    public function isMobileIn( $mobile ) {

        $this->db->where( 'mobile', $mobile );
        $query = $this->db->get( 'signup' );

        if ( count( $query->result_array() ) )
        return true;

        return false;

    }

    public function add( $data, $otp, $mail_hash ) {

        $data['email_id'] = $data['email'];
        unset( $data['email'] );

        if ( $this->db->insert( 'signup', $data ) ) {

            if ( $this->MailHashModel->add( $data['email_id'], $mail_hash, $data['lastupdated'] ) ) {

                if ( $this->OtpModel->add( $data['mobile'], $otp, $data['lastupdated'] ) ) {

                    return true;

                }

            }

        }

        return false;

    }

    public function getUser( $email ) {

        $this->db->where( 'email_id', $email );
        $query = $this->db->get( 'signup' );

        $result = $query->result_array();

        if ( count( $result ) )
        return $result[0];

        return false;
    }

    public function removeUser( $email ) {

        $this->db->where( 'email_id', $email );

        return $this->db->delete( 'signup' );
    }

}