<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [];

    public function __construct(Application $app, Encrypter $encrypter){
        parent::__construct($app, $encrypter);
        $prefix = getenv('APP_PREFIX') ? ((substr(getenv('APP_PREFIX'), 0, 1) == "/" ? substr(getenv('APP_PREFIX'), 1)."/" : getenv('APP_PREFIX')."/")) : '';
        $this->except = [
            $prefix.'solicitudes-discard*',
            $prefix.'solicitudes-register*',
            $prefix.'solicitudes-info*',
            $prefix.'solicitudes-detalle-tramite*',
            $prefix.'solicitudes-update*',
            $prefix.'solicitudes-filtrar*',
            $prefix.'save-divisas*',
            $prefix.'delete-divisas*',
            $prefix.'save-transaccion*',
            $prefix.'save-transaccion-motor*',
            $prefix.'solicitudes-guardar-carrito*',
            $prefix.'solicitudes-filtrar/count*',
            $prefix.'save-files*',
            $prefix.'edit-solicitudes-info*',
            $prefix.'registro-catastro',
            $prefix.'cancelar-transaccion*',
            $prefix.'add-folios-exp*'
        ];
    }
}
