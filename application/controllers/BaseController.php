<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	protected $request_data = null;

	protected function isMethod( $type ){

		if( $_SERVER['REQUEST_METHOD'] == $type ){

			parse_str(file_get_contents("php://input"), $this->request_data);
			return true;

		}

		return false;

	}
	
}