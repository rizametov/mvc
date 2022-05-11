<?php declare(strict_types=1);

namespace Core;

class View
{
    public static function render(string $view, array $params = []): void
    {
        extract($params, EXTR_SKIP);

        $file = "../App/Views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }
}
