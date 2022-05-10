<?php declare(strict_types=1);

class Router
{
    private array $routes = [];

    private array $params = [];

    public function add(string $route, array $params = []): void
    {
        $route = preg_replace_callback_array(
            [
                '/\//' => fn ($matches) => "\/",
                '/\{([a-z-]+)\}/' => fn ($matches) => "(?P<$matches[1]>[a-z-]+)",
                '/\{(\\\d\+)\}$/' => fn ($matches) => "(?P<id>$matches[1])",
            ],
            $route
        );

        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    public function match(string $path): bool
    {
        foreach ($this->routes as $route => $params) {
            if (1 === preg_match($route, $path, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;

                return true;
            }
        }

        return false;
    }

    public function dispatch(string $path): void
    {
        if (true === $this->match($path)) {
            $controller = $this->convertToCamelCase($this->params['controller']);
            if (class_exists($controller)) {
                $controllerObject = new $controller();
                $action = lcfirst($this->convertToCamelCase($this->params['action']));
                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    echo sprintf('action %s cannot be called', $action);
                }
            } else {
                echo sprintf('class %s not found', $controller);
            }
        } else {
            echo sprintf('route %s is incorrect, 404', $path);
        }
    }

    private function convertToCamelCase(string $text): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $text)));
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
