<?php

namespace App\Utils;

use Exception;
use InvalidArgumentException;
use stdClass;

class ChromerClient {
    protected $sock = null;
    protected $seq;
    protected $acks = array();

    public function __construct($addr, $authKey = null) {
        $this->sock = @fsockopen($addr);
        if (!$this->sock) {
            throw new Exception("Unable to connect", 500);
        }
        // stream_set_timeout($this->sock, 999999);
        if ($authKey) {
            $res = $this->auth(array(
                'key' => $authKey,
            ));
        }
    }

    protected static function toObject($arg, $paramName) {
        if (is_array($arg)) {
            $arg = (object) $arg;
        }
        if (!is_object($arg)) {
            throw new InvalidArgumentException("Parameter '$paramName' should be an object or an array");
        }
        return $arg;
    }

    public function send($data) {
        $data = self::toObject($data, 'data');
        $data->seq = ++$this->seq;
        $sent = fwrite($this->sock, json_encode($data) . "\n");
        if (!$sent) {
            throw new Exception("Unable to send data");
        }
        return $data->seq;
    }

    public function recv() {
        $line = fgets($this->sock);
        if ($line === false || $line === "\n" || $line === '') {
            return null;
        }
        $data = json_decode($line);
        if (json_last_error()) {
            throw new Exception("Unable to decode response", 500);
        }
        $ackFired = false;
        if (is_object($data) && isset($data->seq)) {
            $ack = !isset($this->acks[$data->seq]) ? null : $this->acks[$data->seq];
            if ($ack) {
                unset($this->acks[$data->seq]);
                $ack($data);
                $ackFired = true;
            }
        }
        if (is_object($data) && !empty($data->err) && !$ackFired) {
            // echo "ERROR: {$data->err}\n";
            throw new Exception("Chromer error: {$data->err}", 400);
        }
        return $data;
    }

    public function query($data, $ack = null) {
        if ($ack !== null && !is_callable($ack)) {
            throw new InvalidArgumentException("Parameter 'ack' should be a callable or null");
        }
        $seq = $this->send($data);
        if ($ack) {
            $this->acks[$seq] = $ack;
            $this->recv();
            return $seq;
        }
        else {
            return $this->recv()->res ?? null;
        }
    }

    ////////////////////////////////////////////////////////////////////

    public function __call($name, $args) {
        $data = array_shift($args) ?: new stdClass();
        $data = self::toObject($data, 'data');
        $ack = array_shift($args);
        $data->cmd = $name;
        return $this->query($data, $ack);
    }
}
