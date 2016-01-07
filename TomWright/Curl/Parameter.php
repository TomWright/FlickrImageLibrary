<?php

namespace TomWright\Curl;

class Parameter
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|mixed
     */
    protected $value;


    public function __construct($name = null, $value = null)
    {
        $this->setName($name);
        $this->setValue($value);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @param mixed|string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}