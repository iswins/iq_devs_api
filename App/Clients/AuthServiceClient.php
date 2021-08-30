<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;


class AuthServiceClient extends AbstractRestClient
{

    protected function getBaseUrl ()
    {
        return getenv('AUTH_SERVICE_URL');
    }

    protected function getTimeout ()
    {
        return getenv('AUTH_SERVICE_TIMEOUT');
    }

    public function register($email, $inn, $password) {
        $url = "/api/register";
        return $this->post($url, ['email' => $email, 'inn' => $inn, 'password' => $password]);
    }

    public function login($email, $password) {
        $url = "/api/login";
        return $this->post($url, ['email' => $email, 'password' => $password]);
    }

    public function refresh($token) {
        $url = "/api/refresh";
        return $this->get($url, [], $token);
    }

    public function check($token) {
        $url = "/api/check";
        return $this->get($url, [], $token);
    }

    public function logout($token) {
        $url = "/api/logout";
        return $this->get($url, [], $token);
    }

    public function user($userId, $token) {
        $url = "/api/user/{$userId}";
        return $this->get($url, [], $token);
    }
}
