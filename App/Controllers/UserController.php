<?php
/**
 * Created by v.taneev.
 */


namespace App\Controllers;


use App\Clients\AuthServiceClient;
use App\Services\TokenStorage;
use GuzzleHttp\Exception\ConnectException;
use Exception;
use Luracast\Restler\RestException;

class UserController
{
    /**
     * @url POST login/
     *
     * @param $email
     * @param $password
     */
    public function login($email, $password) {
        try {
            return AuthServiceClient::getInstance()->login($email, $password);
        } catch (ConnectException $exception) {
            throw new RestException(500, "Auth service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }


    /**
     * @url POST register/
     *
     * @param $email
     * @param $inn
     * @param $password
     */
    public function register($email, $inn, $password) {
        try {
            return AuthServiceClient::getInstance()->register($email, $inn, $password);
        } catch (ConnectException $exception) {
            throw new RestException(500, "Auth service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }

    /**
     * @url GET detail/{userId}/
     * @protected
     *
     * @param $userId
     * @return array
     */
    public function user($userId) {
        try {
            if ($userId != TokenStorage::getInstance()->getUserId()) {
                throw new Exception("You don't have enough rights");
            }
            return AuthServiceClient::getInstance()->user($userId, TokenStorage::getInstance()->getToken());
        } catch (ConnectException $exception) {
            throw new RestException(500, "Auth service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }

    /**
     * @url GET logout/
     * @protected
     *
     * @return array
     */
    public function logout() {
        try {
            return AuthServiceClient::getInstance()->logout(TokenStorage::getInstance()->getToken());
        } catch (ConnectException $exception) {
            throw new RestException(500, "Auth service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }

    /**
     * @url GET refresh_token/
     *
     * @return mixed
     * @throws RestException
     */
    public function refreshToken() {
        try {
            return AuthServiceClient::getInstance()->refresh(TokenStorage::getInstance()->getToken());
        } catch (ConnectException $exception) {
            throw new RestException(500, "Auth service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }
}
