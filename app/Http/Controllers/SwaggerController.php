<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'SSB HRD API',
    version: '1.0.0',
    description: 'API documentation for HRD modules in SSB Project',
    contact: new OA\Contact(email: 'admin@ssb.com')
)]
#[OA\Server(
    url: 'http://localhost:8088/others/ssb-project/public/api',
    description: 'SSB API Server'
)]
#[OA\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
class SwaggerController extends Controller
{
}
