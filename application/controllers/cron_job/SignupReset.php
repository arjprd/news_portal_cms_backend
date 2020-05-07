<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class SignupReset extends CI_Controller
{

    public function __construct(){

        Parent::__construct();
        $this->load->model('SignupModel');

    }

    
    public function index(){

        $compare_time = time() - 3600;
        
        if( $deleted = $this->SignupModel->deleteBefore($compare_time) )
            foreach( $deleted as $value ){

                echo "$value[0],$value[1]\n";

            }

    }    

}