<?php
/**
 * Created by v.taneev.
 */


namespace App\Clients;


use App\Exceptions\ServiceException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

abstract class AbstractRestClient
{
    /**
     * @var Client
     */
    protected $client;

    abstract protected function getBaseUrl();
    abstract protected function getTimeout();

    public static function getInstance() {
        return new static();
    }

    protected function getHttpClient() : Client {
        if ($this->client) {
            return $this->client;
        }

        $baseUrl = $this->getBaseUrl();
        $timeout = (int)$this->getTimeout();

        return $this->client ??
            $this->client = new Client(['base_uri' => $baseUrl, 'timeout' => $timeout]);
    }

    protected function get($url, $params = [], $token = null) {
        try {
            $queryParams = ['query' => $params];
            if ($token) {
                $queryParams['headers'] = [
                    'Authorization' => "Bearer {$token}"
                ];
            }
            $response = $this->getHttpClient()->get($url, $queryParams);
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $exception) {
            $this->adaptClientException($exception);
        }
    }

    protected function post($url, $params) {
        try {
            $response = $this->getHttpClient()->post($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $exception) {
            $this->adaptClientException($exception);
        }
    }

    protected function adaptClientException(ClientException $exception) {
        $code = $exception->getCode();
        $data = json_decode($exception->getResponse()->getBody()->getContents(), true);

        $message = isset($data['error']) && isset($data['error']['message']) ?
            $data['error']['message'] :
            null;

        if (!$message && isset($data['fields'])) {
            $ret = [];
            foreach ($data['fields'] as $field) {
                $ret[] = $field['error'];
            }
            $message = implode(" ", $ret);
        }

        if (!$message && isset($data['message'])) {
            $message = $data['message'];
        }

        throw new ServiceException($message, $code);
    }
}
