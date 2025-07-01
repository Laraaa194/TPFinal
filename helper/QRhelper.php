<?php

class QRhelper
{

    public static function generarQRCode($texto, $archivo = false, $nivel = 'L', $tamanio = 4)
    {
        require_once __DIR__ . '/../vendor/phpqrcode/qrlib.php';

        // Mapear nivel a constante (L, M, Q, H)
        $niveles = [
            'L' => QR_ECLEVEL_L,
            'M' => QR_ECLEVEL_M,
            'Q' => QR_ECLEVEL_Q,
            'H' => QR_ECLEVEL_H,
        ];

        $nivel_const = $niveles[$nivel] ?? QR_ECLEVEL_L;

        QRcode::png($texto, $archivo ?: false, $nivel_const, $tamanio);
    }
}