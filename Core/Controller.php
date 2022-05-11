<?php declare(strict_types=1);

namespace Core;

abstract class Controller
{
    public function __construct(protected array $routeParams) {}

    public function __call($method, $params)
    {
        $method = $method . 'Action';

        if (method_exists($this, $method)) {
            if (false !== $this->before()) {
                call_user_func_array([$this, $method], $params);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    protected function before() {}

    protected function after() {}
}
