<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;


class OrderServiceClient extends AbstractRestClient
{

    protected function getBaseUrl ()
    {
        return getenv('ORDER_SERVICE_URL');
    }

    protected function getTimeout ()
    {
        return getenv('ORDER_SERVICE_TIMEOUT');
    }

    public function newOrder($userId, $amount, $term) {
        $url = "/api/new/{$userId}/";
        return $this->post($url, ['amount' => $amount, 'term' => $term]);
    }

    public function list($userId) {
        $url = "/api/list/{$userId}/";
        return $this->get($url);
    }

    public function schedule($userId, $requestId) {
        $url = "/api/payments/{$userId}/{$requestId}/";
        return $this->get($url);
    }
}
