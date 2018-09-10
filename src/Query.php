<?php
namespace TelcoLAB\Freshdesk\SDK;

class Query
{
    protected $page;

    protected $perPage;

    protected $includes = [];

    protected $customs = [];

    protected function includes($includes)
    {
        $includes = is_array($includes) ? $includes : func_get_args();

        $this->includes = $includes;

        return $this;
    }

    protected function with(string $name, $value)
    {
        $this->customs[$name] = $value;

        return $this;
    }

    protected function forPage(int $page = null)
    {
        $this->page = $page;

        return $this;
    }

    protected function take(int $perPage = null)
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function toArray(): array
    {
        return $this->build(function ($data, $customs) {
            return array_merge($customs, $data);
        });
    }

    public function build(callable $callback): array
    {
        $data = [];

        if (!empty($this->includes)) {
            $data['include'] = implode(',', $this->includes);
        }

        if (is_int($this->page) && $this->page > 0) {
            $data['page'] = $this->page;

            if (is_int($this->perPage) && $this->perPage > 5) {
                $data['per_page'] = $this->perPage;
            }
        }

        return call_user_func($callback, $data, $this->customs);
    }

    public function __call(string $method, array $parameters)
    {
        return $this->$method(...$parameters);
    }

    public static function __callStatic(string $method, array $parameters)
    {
        return (new static())->$method(...$parameters);
    }
}
