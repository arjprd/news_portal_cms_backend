<?php 

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;


class MailHashModel extends Model
{
    protected $table = 'email_verification';
    protected $DBGroup = 'temp';
    protected $allowedFields = ['email_id', 'hash'];

}