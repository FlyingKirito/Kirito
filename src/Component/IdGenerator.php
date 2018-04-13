<?php

namespace Kirito\Component;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class IdGenerator
{
    private $factory;

    public function __construct()
    {
        $this->factory = new UuidFactory();
        $codec = new OrderedTimeCodec($this->factory->getUuidBuilder());
        $this->factory->setCodec($codec);
    }

    public function generate($encode = true)
    {
        if ($encode) {
            return $this->factory->uuid1()->getBytes();
        }

        return $this->factory->uuid1()->toString();
    }
}