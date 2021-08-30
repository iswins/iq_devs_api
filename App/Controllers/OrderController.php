<?php
/**
 * Created by v.taneev.
 */


namespace App\Controllers;


use App\Clients\OrderServiceClient;
use App\Services\TokenStorage;
use GuzzleHttp\Exception\ConnectException;
use Luracast\Restler\RestException;
use Exception;

class OrderController
{
    /**
     * @url POST new/
     * @protected
     *
     * @param $amount
     * @param $term
     * @return mixed
     * @throws RestException
     */
    public function newOrder($amount, $term) {
        try {
            return OrderServiceClient::getInstance()
                ->newOrder(TokenStorage::getInstance()->getUserId(), $amount, $term);
        } catch (ConnectException $exception) {
            throw new RestException(500, "Order service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }

    /**
     * @url GET list/
     * @protected
     *
     * @return mixed
     * @throws RestException
     */
    public function listOrders() {
        try {
            return OrderServiceClient::getInstance()
                ->list(TokenStorage::getInstance()->getUserId());
        } catch (ConnectException $exception) {
            throw new RestException(500, "Order service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }

    /**
     * @url GET details/{requestId}/
     * @protected
     *
     * @param $requestId
     * @return mixed
     * @throws RestException
     */
    public function listSchedules($requestId) {
        try {
            return OrderServiceClient::getInstance()
                ->schedule(TokenStorage::getInstance()->getUserId(), $requestId);
        } catch (ConnectException $exception) {
            throw new RestException(500, "Order service is unavailable");
        } catch (Exception $exception) {
            throw new RestException(400, $exception->getMessage());
        }
    }
}
