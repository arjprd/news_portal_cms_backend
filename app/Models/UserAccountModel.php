<?php 

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class UserAccountModel extends Model
{

    protected $table = 'user_account';
    protected $allowedFields = ['name', 'email_id', 'password', 'mobile', 'pin', 'street', 'city', 'state', 'country', 'status', 'mobile_verified'];

    public function add( $data, $otp, $mail_hash ){

        $data['email_id'] = $data['email'];

        if($this->save($data)){

            

        }

        return false;

    }

}