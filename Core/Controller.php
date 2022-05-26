<?php declare(strict_types=1);

namespace Core;

use Core\View;
use App\Auth;
use App\Flash;

abstract class Controller
{
    protected string $layout = 'main';

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

    protected function redirect(string $url): void
    {
        header(
            'Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $url,
            true, 
            303
        );
        
        exit;
    }

    protected function requireLogin(): void
    {
        if (null === Auth::getUser()) {

            Flash::add('Please login to access the page', Flash::DANGER);

            Auth::rememberRequestedPage();

            $this->redirect('/login/index');
        }
    }

    protected function render(string $view, array $params = []): void
    {
        View::render($view, $params, $this->layout);
    }

    protected function before() {}

    protected function after() {}
}
