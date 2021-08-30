<?php
/**
 * Created by v.taneev.
 */


namespace App\AuthGuard;

use App\Clients\AuthServiceClient;
use App\Services\TokenStorage;
use \Luracast\Restler\iAuthenticate;
use \Luracast\Restler\Resources;
use \Luracast\Restler\Defaults;
use Exception;

class RestlerGuard implements iAuthenticate
{

    public function __getWWWAuthenticateString ()
    {
        return null;
    }

    public function __isAllowed ()
    {
        $token = TokenStorage::getInstance()->getToken();
        if (!$token) {
            return false;
        }

        try {
            $response = AuthServiceClient::getInstance()->check($token);
            TokenStorage::getInstance()->setUserId($response['id']);
            return true;
        } catch (Exception $exception) {
            return false;
        }
    }
}
