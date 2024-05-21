<?php

namespace Core\Domain\Entity\Traits;

trait MethodsMagicsTraits
{
    /**
     * @throws \Exception
     */
    public function  __get($name)
    {

        $method = 'get'.ucfirst($name);
        if(isset($this->{$name})){
            return $this->{$name};
        }

        throw new \Exception("Property {$method} not found in class ".get_class($this));
    }

    public function id():string
    {
        return (string) $this->id;
    }
}