<?php namespace App\Controllers;

class Authentication extends BaseController
{

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

                $data['statusCode'] = 200;
                $data['message'] = 'Successfull';
                return $this->response->setStatusCode(200)->setJson($data);

            }

        }

		return $this->response->setStatusCode(400)->setJson($data);
		
	}

	//--------------------------------------------------------------------

}
