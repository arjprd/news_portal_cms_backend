<?php 

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;


class OtpModel extends Model
{
    protected $table = 'mobile_verification';
    protected $DBGroup = 'temp';
    protected $allowedFields = ['mobile', 'otp'];

}