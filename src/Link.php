<?php 

namespace Branch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Link
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * Create link object
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
     * Create referral link 
     *
     * @param array $attributes
     * @throws RequestException
     * @return object
     */
    public function create(array $attributes)
    {
        $response = $this->guzzle->post("url", [
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
     * Create referral link bulk
     *
     * @param array $attributes
     * @throws RequestException
     * @return object
     */
    public function bulk(array $attributes)
    {
        $response = $this->guzzle->post("url/bulk/" . $this->key, [
            'body' => json_encode($attributes)
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * Read link
     *
     * @param array $attributes
     * @throws RequestException
     * @return object
     */
    public function read(string $url)
    {
        $response = $this->guzzle->get("url", [
            'query' => [
                'url' => $url,
                'branch_key' => $this->key
            ]
        ]);

        $body = $response->getBody()->__toString();   
        return json_decode($body);
    }

    /**
     * Update link
     *
     * @param string $url
     * @param array $attributes
     * @throws RequestException
     * @return object
     */
    public function update(string $url, array $attributes)
    {
        try {
            $response = $this->guzzle->get("url?url=$url", [
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
        } catch(RequestException $e) {
            throw new HttpException(406, $e->getResponse());
        }
    }
}