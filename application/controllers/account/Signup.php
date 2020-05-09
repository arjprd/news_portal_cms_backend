<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;
class Signup extends CI_Controller
{

    public function __construct(){

        parent::__construct();
        $this->load->model('SignupModel');
        $this->load->model('UserAccountModel');
        $this->load->helper('url');

        access_token_check();

    }

	public function index()
	{

		$data = [
			'statusCode' => 405,
			'message' => 'Method Not Allowed'
        ];

        $required = [

            "email" => "email id not provided!",
            "password" => "password not provided",
            "mobile" => "mobile number not provided",
            "pin" => "pin code not provided",
            "city" => "city not provided",
            "state" => "state not provided",
            "country" => "country not provided",
            "street" => "street not provided",
            "name" => "name not provided"

        ];

        $parameters = [ "email", "password", "mobile", "pin", "city", "state", "country", "street", "name"];

        
        if( $this->request_data = isMethod('PUT') ){

            $request = [];
            
            foreach( $parameters as $key ){

                if( !empty($this->request_data[$key]) ){

                    $request[$key] = $this->request_data[$key];

                }else if( !empty($required[$key]) ){

                    if( empty($data['error']) )

                        $data['error'] = [];

                    $data['error'][$key] = $required[$key];

                }

            }

            $request['lastupdated'] = time();
            $request['password'] = hash_password($request['password']);

            if( !empty($data['error']) ){

                $data['statusCode'] = 4121;
                $data['message'] = 'Required data missing';
                return $this->output
                    ->set_status_header(412)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

            }else{

                if( $this->UserAccountModel->isMobileIn($request['mobile']) ){
                    
                    $data['statusCode'] = 4122;
                    $data['message'] = 'Mobile number already in use';
                    return $this->output
                                ->set_status_header(412)
                                ->set_content_type('application/json')
                                ->set_output(json_encode($data));

                }else if( $this->SignupModel->isMobileIn($request['mobile']) ){
                    
                    $data['statusCode'] = 4122;
                    $data['message'] = 'Mobile number already in use, verify email';
                    return $this->output
                                ->set_status_header(412)
                                ->set_content_type('application/json')
                                ->set_output(json_encode($data));

                }else if( $this->UserAccountModel->isEmailIn($request['email']) ){

                    $data['statusCode'] = 4122;
                    $data['message'] = 'Email already in use, sign in';
                    return $this->output
                                ->set_status_header(412)
                                ->set_content_type('application/json')
                                ->set_output(json_encode($data));

                }else if( $this->SignupModel->isEmailIn($request['email']) ){

                    $data['statusCode'] = 4122;
                    $data['message'] = 'Email already in use, verify email';
                    return $this->output
                                ->set_status_header(412)
                                ->set_content_type('application/json')
                                ->set_output(json_encode($data));

                }else{

                    $otp = generateNumericOTP();
                    $mail_hash = sha1("$request[email]$otp".time());

                    $confirm_mail_url = SIGNUP_VERIFY_URL_BASE."?email=$request[email]&verification_key=$mail_hash";

                    if($this->SignupModel->add( $request, $otp, $mail_hash )){

                        confirm_mail( $request['email'], $confirm_mail_url );
                        send_otp( $request['mobile'], $otp );

                        $data['statusCode'] = 200;
                        $data['message'] = 'Successful';
                        return $this->output
                                    ->set_status_header(200)
                                    ->set_content_type('application/json')
                                    ->set_output(json_encode($data));

                    }else{

                        $data['statusCode'] = 5031;
                        $data['message'] = 'Signup Failed';
                        return $this->output
                                    ->set_status_header(503)
                                    ->set_content_type('application/json')
                                    ->set_output(json_encode($data));

                    }

                }

            }

        }

        return $this->output
                    ->set_status_header(405)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
		
	}


}
