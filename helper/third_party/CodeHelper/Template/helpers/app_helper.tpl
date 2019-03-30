<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 生成密码
 * 
 * @param string $password 密码
 * @param string $salt 密钥
 * @return string 加密后的密码
 */
function generate_passwrod($password, $salt = '')
{
    return md5($salt . md5($password) . $salt);
}