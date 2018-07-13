<?php 

namespace Branch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Event
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * Create event object
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
        $response = $this->guzzle->post("event", [
            'body' => json_encode(
                array_merge(
                [
                    "branch_key" => $this->key
                ],
                $attributes
                )
            )
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }
}