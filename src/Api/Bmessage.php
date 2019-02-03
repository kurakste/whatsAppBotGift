<?php

namespace Viber\Api;

/**
 * Broadcast message object
 *
 * @author Stepan Kurakin <kurakste@gmail.com>
 */
class Bmessage extends Entity
{
    /**
     * Viber user id
     *
     * @var integer
     */
    protected $broadcast_list;

    /**
     * Message type
     *
     * @var string
     */
    protected $type;

    /**
     * Sender information
     *
     * @var \Viber\Api\Sender
     */
    protected $sender;

    /**
     * API version required by clients
     *
     * @var integer
     */
    protected $min_api_version = 1;

    /**
     * Custom keyboard for message
     *
     * @var \Viber\Api\Keyboard
     */
    protected $keyboard;

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
            'broadcast_list' => $this->getBroadcastList(),
            'type' => $this->getType(),
            'sender' => $this->getSender(),
            'min_api_version' => $this->getMinApiVersion(),
            'keyboard' => $this->getKeyboard(),
        ];
    }

    /**
     * Get the array of value of Viber user
     *
     * @return array
     */
    public function getBroadcastList()
    {
        return $this->broadcast_list;
    }

    /**
     * Set the value of Viber user
     *
     * @param array broadcastlist
     *
     * @return static
     */
    public function setBroadcastList($broadcast_list)
    {
        $this->broadcast_list = $broadcast_list;

        return $this;
    }

    /**
     * Get the value of Message type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of Sender information
     *
     * @return \Viber\Api\Sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set the value of Sender information
     *
     * @param \Viber\Api\Sender sender
     *
     * @return static
     */
    public function setSender(\Viber\Api\Sender $sender)
    {
        $this->sender = $sender;

        return $this;
    }


    /**
     * Get the value of API version required by clients
     *
     * @return integer
     */
    public function getMinApiVersion()
    {
        return $this->min_api_version;
    }

    /**
     * Set the value of API version required by clients
     *
     * @param integer min_api_version
     *
     * @return static
     */
    public function setMinApiVersion($min_api_version)
    {
        $this->min_api_version = $min_api_version;

        return $this;
    }

    /**
     * Get the value of Custom keyboard for message
     *
     * @return \Viber\Api\Keyboard
     */
    public function getKeyboard()
    {
        return $this->keyboard;
    }

    /**
     * Set the value of Custom keyboard for message
     *
     * @param \Viber\Api\Keyboard keyboard
     *
     * @return static
     */
    public function setKeyboard(\Viber\Api\Keyboard $keyboard)
    {
        $this->keyboard = $keyboard;

        return $this;
    }
}
