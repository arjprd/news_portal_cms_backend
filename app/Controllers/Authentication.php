<?php 

namespace App\Controllers;

use App\Models\SignupModel;
use App\Models\UserAccountModel;

class Authentication extends BaseController
{

    private function generateNumericOTP($n) { 
      
        $generator = "1357902468"; 
      
        $result = ""; 
      
        for ($i = 1; $i <= $n; $i++) { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
      
        return $result; 
    } 

	public function signup()
	{

		$data = [
			'statusCode' => 400,
			'message' => 'Bad Request'
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

        
        if( $this->isMethod('PUT') ){

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

            
            
            if( !empty($data['error']) ){

                $data['statusCode'] = 401;
                $data['message'] = 'Required data missing';
                return $this->response->setStatusCode(401)->setJson($data);

            }else{

                $model = new SignupModel();
                $user_model = new UserAccountModel();

                if( count($user_model->where('mobile', $request['mobile'])->findAll()) ){
                    
                    $data['statusCode'] = 405;
                    $data['message'] = 'Mobile number already in use';
                    return $this->response->setStatusCode(405)->setJson($data);

                }else if( count($model->where('mobile', $request['mobile'])->findAll()) ){
                    
                    $data['statusCode'] = 404;
                    $data['message'] = 'Mobile number already in use, verify email';
                    return $this->response->setStatusCode(404)->setJson($data);

                }else if($user_model->find($request['email'])){

                    $data['statusCode'] = 403;
                    $data['message'] = 'Email already in use, sign in';
                    return $this->response->setStatusCode(403)->setJson($data);

                }else if($model->find($request['email'])){

                    $data['statusCode'] = 402;
                    $data['message'] = 'Email already in use, verify email';
                    return $this->response->setStatusCode(402)->setJson($data);

                }else{

                    $otp = $this->generateNumericOTP(6);
                    $mail_hash = sha1("$request[email]$otp".time());

                    if($model->add( $request, $otp, $mail_hash )){

                        //send email and otp

                        $data['statusCode'] = 200;
                        $data['message'] = 'Successful';
                        return $this->response->setStatusCode(200)->setJson($data);

                    }else{

                        $data['statusCode'] = 406;
                        $data['message'] = 'Signup Failed';
                        return $this->response->setStatusCode(406)->setJson($data);

                    }

                }

            }

        }

		return $this->response->setStatusCode(400)->setJson($data);
		
	}

	//--------------------------------------------------------------------

}
