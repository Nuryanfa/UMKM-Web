    <?php

    use Illuminate\Foundation\Application;
    use Illuminate\Foundation\Configuration\Exceptions;
    use Illuminate\Foundation\Configuration\Middleware;

    return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
            web: __DIR__.'/../routes/web.php',
            commands: __DIR__.'/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
            $middleware->web(append: [
                \App\Http\Middleware\HandleInertiaRequests::class,
            ]);

            $middleware->validateCsrfTokens(except: [
                'pembayaran/callback',
            ]);

            // Daftarkan middleware alias di sini
            $middleware->alias([
                'role' => \App\Http\Middleware\CekRole::class,
            ]);
        })
        ->withExceptions(function (Exceptions $exceptions) {
            $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response) {
                if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
                    return \Inertia\Inertia::render('Error', ['status' => $response->getStatusCode()])
                        ->toResponse(request())
                        ->setStatusCode($response->getStatusCode());
                } elseif ($response->getStatusCode() === 404 || $response->getStatusCode() === 403) {
                     // Always render nice error for 404/403 even in local for testing the "cute" page
                     return \Inertia\Inertia::render('Error', ['status' => $response->getStatusCode()])
                        ->toResponse(request())
                        ->setStatusCode($response->getStatusCode());
                }
                return $response;
            });
        })
        ->create();
    