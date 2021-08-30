<?php
/**
 * Created by v.taneev.
 */


namespace App\Services;


class TokenStorage
{
    protected static $instance;

    protected $userId;

    public static function getInstance() {
        return static::$instance ?? static::$instance = new static();
    }

    public function getToken() {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return null;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        list($type, $value) = explode(" ", $token);
        return $value;
    }

    /**
     * @return mixed
     */
    public function getUserId ()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return $this
     */
    public function setUserId ($userId)
    {
        $this->userId = $userId;
        return $this;
    }


}
