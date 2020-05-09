<?php

    function generateNumericOTP($n = 6) { 
      
        $generator = "1357902468"; 
      
        $result = ""; 
      
        for ($i = 1; $i <= $n; $i++) { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
      
        return $result; 
    } 

    function hash_password( $plain_password ){
       
        return password_hash($plain_password, PASSWORD_DEFAULT);
        
    }

    function verify_password( $plain_password, $hashed_password ){
       
        return password_verify($plain_password, $hashed_password);
        
    }

    function confirm_mail( $email, $url ){

        $data = post_request(CONFIRM_MAIL_API_URL, [
            'url' => $url,
            'email' => $email
        ]);

        return true;

    }

    function send_otp( $mobile, $otp ){

      $data = post_request(OTP_API_URL, [
          'otp' => $otp,
          'mobile' => $mobile
      ]);

      return true;

  }

    function post_request($url, array $params) {

		$query_content = http_build_query($params);
		$fp = fopen($url, 'r', FALSE, // do not use_include_path
		  stream_context_create([
		  'http' => [
			'header'  => [ // header array does not need '\r\n'
			  'Content-type: application/x-www-form-urlencoded',
			  'Content-Length: ' . strlen($query_content)
			],
			'method'  => 'POST',
			'content' => $query_content
		  ]
		]));
		if ($fp === FALSE) {
		  return json_encode(['error' => 'Failed to get contents...']);
		}
		$result = stream_get_contents($fp); // no maxlength/offset
		fclose($fp);
		return $result;
		
  }
  
  function isMethod( $type ){

		if( $_SERVER['REQUEST_METHOD'] == $type ){

      $request_data;

      parse_str(file_get_contents("php://input"), $request_data);

			return count($request_data) > 0? $request_data: true;

		}

		return false;

  }
  
  function access_token_check(){

    $data = [
			'statusCode' => 4010,
			'message' => 'Not authorized to use this API'
    ];

    if( empty($_SERVER['HTTP_ACCESS_TOKEN']) ){

      http_response_code ( 401 );
      header("Content-Type: application/json");
      echo json_encode($data);
      exit();

    }

    $access_token = jwt_helper::verify_token( $_SERVER['HTTP_ACCESS_TOKEN'] );

    if( !$access_token ){

      http_response_code ( 401 );
      header("Content-Type: application/json");
      $data['statusCode'] = 4011;
      $data['message'] = "Invalid Token";
      echo json_encode($data);
      exit();

    }

  }