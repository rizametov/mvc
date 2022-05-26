<?php declare(strict_types=1);

namespace Core;

class View
{
    public static function render(string $view, array $params = [], string $layout = 'main'): void
    {
        $viewFile = dirname(__DIR__) . "/App/Views/$view.php";

        if (is_readable($viewFile)) {
            extract($params, EXTR_SKIP);
            ob_start();
            require $viewFile;
            $content = ob_get_clean();
            require dirname(__DIR__) . "/App/Views/layout/$layout.php";
        } else {
            throw new \Exception("Page not found");
        }
    }
}
