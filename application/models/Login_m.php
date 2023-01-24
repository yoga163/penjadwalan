<?php
class Login_m extends CI_Model
{
    public function Cek_login($user, $pasw)
    {
        $query = $this->db->get_where('admin', array('username' => $user, 'password' => $pasw), 1);
        return $query;
    }
}
