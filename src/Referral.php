<?php 

namespace Branch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Referral
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * Create referral object
     *
     * @param Client $client
     * @param array $settings
     */
    public function __construct(Client $client, array $settings)
    {
        $this->guzzle = $client;
        $this->key = $settings["key"];
        $this->secret = $settings["secret"];
    }

    /**
     * Add credits
     *
     * @param string $identity
     * @param int $amount
     * @param string $bucket default
     * @throws ClientException
     * @return object
     */
    public function reward(string $identity, int $amount, string $bucket = 'default') : object
    {
        $response = $this->guzzle->post("credits", [
            'body' => json_encode([
                'branch_key' => $this->key,
                'branch_secret' => $this->secret,
                'identity' => $identity,
                'amount' => $amount,
                'bucket' => $bucket
            ])
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * Get credits
     *
     * @param string $identity
     * @param string $bucket default
     * @throws ClientException
     * @return int
     */
    public function read(string $identity, string $bucket = 'default') : int
    {
        $response = $this->guzzle->get("credits", [
            'query' => [
                'branch_key' => $this->key,
                'identity' => $identity
            ]
        ]);

        $body = $response->getBody()->__toString();   
        $bodyJson = json_decode($body);
        
        if (isset($bodyJson->$bucket)) {
            return $bodyJson->$bucket;
        } else {
            return 0;
        }
    }

    /**
     * Redeem credits
     *
     * @param string $identity
     * @param int $amount
     * @param string $bucket default
     * @throws ClientException
     * @return object
     */
    public function redeem(string $identity, int $amount, string $bucket = 'default') : object
    {
        $response = $this->guzzle->post("redeem", [
            'body' => json_encode([
                'branch_key' => $this->key,
                'branch_secret' => $this->secret,
                'identity' => $identity,
                'amount' => $amount,
                'bucket' => $bucket
            ])
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * History
     *
     * @param string $identity
     * @throws ClientException
     * @return array
     */
    public function history(string $identity) : array
    {
        $response = $this->guzzle->get("credithistory", [
            'query' => [
                'branch_key' => $this->key,
                'identity' => $identity
            ]
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * Reconcile
     *
     * @param string $identity
     * @param int $amount
     * @param string $bucket default
     * @throws ClientException
     * @return object
     */
    public function reconcile(string $identity, int $amount, string $bucket = 'default') : object
    {
        $response = $this->guzzle->post("reconcile", [
            'body' => json_encode([
                'branch_key' => $this->key,
                'branch_secret' => $this->secret,
                'identity' => $identity,
                'amount' => $amount,
                'bucket' => $bucket
            ])
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * Reconcile
     *
     * @param array $attributes
     * @throws ClientException
     * @return object
     */
    public function createRule(array $attributes) : object
    {
        $response = $this->guzzle->post("eventresponse", [
            'body' => json_encode(
                array_merge(
                [
                    'branch_key' => $this->key,
                    'branch_secret' => $this->secret
                ],
                $attributes
                )
            )
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }
}