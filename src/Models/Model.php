<?php
namespace TelcoLAB\Freshdesk\SDK\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Laravie\Codex\Contracts\Response as ResponseContract;
use TelcoLAB\Freshdesk\SDK\Exceptions\JsonEncodingException;

abstract class Model implements Arrayable, Jsonable
{
    protected $attributes;

    protected $original;

    public function __construct(array $data = null)
    {
        $this->original = static::make($data);
    }

    public static function responseCollection(ResponseContract $response)
    {
        return static::collection(static::getContent($response));
    }

    public static function response(ResponseContract $response)
    {
        return static::hydrate(static::getContent($response));
    }

    protected static function getContent(ResponseContract $response)
    {
        return $response->getContent();
    }

    public static function hydrate(array $data = null)
    {
        if (!$data) {
            return null;
        }

        return (new static($data))->fill();
    }

    public static function collection(array $items = null)
    {
        return Collection::make($items)->map(function ($item) {
            return (new static($item))->fill();
        });
    }

    protected function fill()
    {
        $this->attributes = $this->map($this->original);

        return $this;
    }

    public static function make(array $data = null)
    {
        if (!$data) {
            return null;
        }

        return (new static())->fillAttributes($data);
    }

    protected function fillAttributes(array $data)
    {
        $this->attributes = [];

        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }

        return $this;
    }

    public function attribute($key, $default = null)
    {
        return $this->__isset($key) ? $this->attributes[$key] : $default;
    }

    abstract protected function map(array $item);

    public function toArray()
    {
        return $this->attributes;
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->toArray(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonEncodingException('Failed to encode resource. Message : ' . json_last_error_msg());
        }

        return $json;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name];
    }

    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    public function __toString()
    {
        return $this->toJson();
    }
}
