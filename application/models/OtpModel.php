<?php 
class OtpModel extends CI_Model
{
    public function __construct()
    {
            $this->db = $this->load->database('temp', true);
    }

    public function add( $mobile, $otp, $lastupdated ){

        return $this->db->insert( 'mobile_verification', [
            "mobile"      =>  $mobile,
            "otp"          =>  $otp,
            "lastupdated"   =>  $lastupdated 
        ] );

    }

    public function delete( $mobile ){

        $this->db->where('mobile', $mobile);

        if( $this->db->delete('mobile_verification') )
            return true;

        return false;

    }

}