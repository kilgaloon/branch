<?php 

namespace Branch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class User
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * Create user object
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
     * Create user
     *
     * @param array $attributes
     * @throws ClientException
     * @return object
     */
    public function create(array $attributes) : object
    {
        $response = $this->guzzle->post("profile", [
            'body' => json_encode(
                array_merge(
                [
                    'branch_key' => $this->key
                ],
                $attributes
                )
            )
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * Read user by identity
     *
     * @param string $identity
     * @throws ClientException
     * @return object
     */
    public function readByIdentity(string $identity) : object
    {
        $response = $this->guzzle->get("profile", [
            'query' => [
                'branch_key' => $this->key,
                'identity' => $identity
            ]
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

     /**
     * Read user by identity id
     *
     * @param int $identityId
     * @throws ClientException
     * @return object
     */
    public function readByIdentityId(int $identityId) : object
    {
        $response = $this->guzzle->get("profile", [
            'query' => [
                'branch_key' => $this->key,
                'identity_id' => $identityId
            ]
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }
}