<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Url;

/**
 * Routeur personnalisé — motifs simples avec paramètres {id}.
 * Aucun redirect codé en dur : tous passent par Url::to() (sous-dossier compatible).
 */
final class Router
{
    /** @var array<int, array{method:string, pattern:string, handler:mixed}> */
    private array $routes = [];

    public function get(string $pattern, mixed $handler): void
    {
        $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, mixed $handler): void
    {
        $this->add('POST', $pattern, $handler);
    }

    public function any(string $pattern, mixed $handler): void
    {
        foreach (['GET', 'POST'] as $m) {
            $this->add($m, $pattern, $handler);
        }
    }

    private function add(string $method, string $pattern, mixed $handler): void
    {
        $this->routes[] = ['method' => $method, 'pattern' => '/' . trim($pattern, '/'), 'handler' => $handler];
    }

    /** Exécute la route correspondant à la requête courante. */
    public function dispatch(string $method, string $uri): void
    {
        // Chemin relatif sans le préfixe d'installation (sous-dossier local).
        $base = Url::basePath();
        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . trim(parse_url($uri, PHP_URL_PATH) ?: '/', '/');
        if ($uri === '/index.php') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            $regex = '#^' . preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $route['pattern']) . '$#';
            if (preg_match($regex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];

                if (is_callable($handler)) {
                    echo $handler(...array_values($params)) ?? '';
                    return;
                }
                if (is_array($handler) && count($handler) === 2) {
                    [$class, $action] = $handler;
                    $controller = new $class();
                    echo $controller->{$action}(...array_values($params)) ?? '';
                    return;
                }
            }
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        $view = dirname(__DIR__) . '/Views/errors/404.php';
        if (is_file($view)) {
            require $view;
        } else {
            echo '<h1>404 — Page introuvable</h1>';
        }
    }
}
