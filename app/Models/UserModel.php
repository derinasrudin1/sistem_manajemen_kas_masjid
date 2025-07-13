<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username', 'password', 'nama', 'role', 'id_masjid', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = md5($data['data']['password']);
        }
        return $data;
    }

    public function verifyCredentials($username, $password)
    {
        return $this->where('username', $username)
            ->where('password', md5($password))
            ->first();
    }
}