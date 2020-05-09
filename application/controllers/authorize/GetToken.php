<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class GetToken extends CI_Controller
{

    public function __construct(){

        parent::__construct();

    }

    public function index(){

        $timeStamp = time();

        $payload = array(
            "User-Agent" => $_SERVER['HTTP_USER_AGENT'],
            "Last-Request-Time" => $_SERVER['REQUEST_TIME'],
            "Content-Type" => $_SERVER['CONTENT_TYPE'],
            "Request-IP" => $_SERVER['REMOTE_ADDR'],
            "Request-PORT" => $_SERVER['REMOTE_PORT'],
            "iss" => BASE_URL,
            "iat" => $timeStamp,
            "nbf" => $timeStamp + 5,
            "exp" => $timeStamp + 15 * 60
        );

        if( $token = jwt_helper::get_token( $payload ) ){

            $data = [
                'statusCode' => 200,
                'message' => 'Success',
                'token' =>  $token
            ];

            return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

        }else{

            $data = [
                'statusCode' => 401,
                'message' => 'Could Not Get Token'
            ];

            return $this->output
                    ->set_status_header(401)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

        }

    }

    public function renew(){

        print_r(jwt_helper::verify_token($_SERVER['HTTP_ACCESS_TOKEN']));

        exit();


        $payload = array(
            "User-Agent" => $_SERVER['HTTP_USER_AGENT'],
            "Last-Request-Time" => $_SERVER['REQUEST_TIME'],
            "Content-Type" => $_SERVER['CONTENT_TYPE'],
            "Last-Response-Time" => time()
        );

        if( $token = jwt_helper::get_token( $payload ) ){

            $data = [
                'statusCode' => 200,
                'message' => 'Success',
                'token' =>  $token
            ];

            return $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

        }else{

            $data = [
                'statusCode' => 401,
                'message' => 'Could Not Get Token'
            ];

            return $this->output
                    ->set_status_header(401)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

        }

    }


}
