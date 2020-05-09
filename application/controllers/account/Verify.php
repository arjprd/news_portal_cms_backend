<?php

class Verify extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model('SignupModel');
        $this->load->model('UserAccountModel');

        access_token_check();

    }

    public function signup(){

        $data = [
			'statusCode' => 405,
			'message' => 'Method Not allowed'
        ];

        $parameters = [ "email", "verification_key" ];

        $required = [

            "email" => "email id not provided!",
            "verification_key" => "verification key not provided"
    
        ];

        if( isMethod('POST') ){

            $request = [];
            
            foreach( $parameters as $key ){
               
                if( !empty($_POST[$key]) ){

                    $request[$key] = $_POST[$key];

                }else if( !empty($required[$key]) ){

                    if( empty($data['error']) )

                        $data['error'] = [];

                    $data['error'][$key] = $required[$key];

                }

            }

            if( !empty($data['error']) ){

                $data['statusCode'] = 4121;
                $data['message'] = 'Required data missing';
                return $this->output
                    ->set_status_header(412)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

            }

            if ( $this->MailHashModel->isUserPresent( $request['email'], $request['verification_key'] ) ) {

                 
                if ( $result = $this->SignupModel->getByEmail( $request['email'] ) ) {

                    if ( $this->UserAccountModel->add( $result ) ) {

                        $this->MailHashModel->remove( $request['email'] );
                        $this->SignupModel->remove( $request['email'] );

                        $data['statusCode'] = 200;
                        $data['message'] = 'Successful';
                        return $this->output
                                    ->set_status_header( 200 )
                                    ->set_content_type( 'application/json' )
                                    ->set_output( json_encode( $data ) );

                    }else{

                        $data['statusCode'] = 5031;
                        $data['message'] = 'Signup Failed';
                        return $this->output
                                    ->set_status_header(503)
                                    ->set_content_type('application/json')
                                    ->set_output(json_encode($data));

                    }

                }else{

                    $data['statusCode'] = 4123;
                    $data['message'] = 'No signup record found';
                    return $this->output
                                ->set_status_header( 412 )
                                ->set_content_type( 'application/json' )
                                ->set_output( json_encode( $data ) );

                }

            } else {

                $data['statusCode'] = 4123;
                $data['message'] = 'Invalid verification request';
                return $this->output
                            ->set_status_header( 412 )
                            ->set_content_type( 'application/json' )
                            ->set_output( json_encode( $data ) );

            }

        }

        return $this->output
                    ->set_status_header(405)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

    }

}