<?php 

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

use App\Models\OtpModel;
use App\Models\MailHashModel;

class SignupModel extends Model
{

    protected $table = 'signup';
    protected $DBGroup = 'temp';
    protected $primaryKey = 'email_id';

    protected $allowedFields = ['name', 'email_id', 'password', 'mobile', 'pin', 'street', 'city', 'state', 'country'];

    public function add( $data, $otp, $mail_hash ){

        $data['email_id'] = $data['email'];

        if($this->save($data)){

            $otp_model = new OtpModel();

            if($otp_model->save([
                "mobile"    =>  $data['mobile'],
                "otp"       =>  $otp
            ])){

                $mail = new MailHashModel();

                if($mail->save([
                    "email_id"  =>  $data['email'],
                    "hash"      =>  $mail_hash
                ])){

                   return true;
                    
                }else{

                    $mail->delete($data['email']);

                }

            }else{

                $otp->delete($data['mobile']);

            }

        }

        return false;

    }

}