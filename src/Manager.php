<?php 

namespace Branch;

use GuzzleHttp\Client;

class Manager
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Referral
     */
    protected $referral;
    /**
     * @var Event
     */
    protected $event;
    /**
     * @var GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * Create manager object
     *
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->guzzle = new Client([
            'base_uri' => "https://api.branch.io/v1/"
        ]);

        $this->user = new User($this->guzzle, $settings);
        $this->referral = new Referral($this->guzzle, $settings);
        $this->event = new Event($this->guzzle, $settings);
        $this->link = new Link($this->guzzle, $settings);

        $this->key = $settings["key"];
        $this->secret = $settings["secret"];
    }
    
    /**
     * @return User
     */
    public function user() : User
    {
        return $this->user;
    }

    /**
     * @return Referral
     */
    public function referral() : Referral
    {
        return $this->referral;
    }

    /**
     * @return Referral
     */
    public function event() : Event
    {
        return $this->event;
    }

    /**
     * @return Link
     */
    public function link() : Link
    {
        return $this->link;
    }
}