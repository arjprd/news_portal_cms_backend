<?php

use \Firebase\JWT\JWT;

class jwt_helper{
    
    public static function get_token( $data ){

        $key = JWT_API_KEY;
        $jwt = JWT::encode($data, $key);

        return $jwt;

    }

    public static function verify_token( $jwt ){

        try{

            $key = JWT_API_KEY;
            $data = JWT::decode($jwt, $key, array('HS256'));

            return $data;

        }catch(Exception $e){

        }

        return false;

    }

}