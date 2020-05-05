<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{

		$data = [
			'statusCode' => 400,
			'message' => 'Bad Request'
		];
		return $this->response->setStatusCode(400)->setJson($data);
		
	}

	//--------------------------------------------------------------------

}
