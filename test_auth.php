<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/api/login', 'POST', [
    'email' => 'test@example.com',
    'password' => 'secret123'
]);
$request->headers->set('Accept', 'application/json');

$response = $kernel->handle($request);
file_put_contents(__DIR__.'/test_output.json', $response->getContent());
