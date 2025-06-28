<?php

class GraficosHelper
{
    public static function formatearParaGraficoSexo($datos, $label = 'Sexo', $valor = 'Cantidad') {
        $formato = [[$label, $valor]];
        foreach ($datos as $fila) {
            $formato[] = [$fila['sexo'], (int)$fila['cantidad']];
        }
        return json_encode($formato);
    }

    public static function formatearParaGraficoEdad($datos, $label = 'Grupo etario', $valor = 'Cantidad') {
        $formato = [[$label, $valor]];
        foreach ($datos as $fila) {
            $formato[] = [$fila['grupo_edad'], (int)$fila['cantidad']];
        }
        return json_encode($formato);
    }

    public static function formatearParaGraficoRespuestas($datos, $label = 'Tipo de respuesta', $valor = 'Cantidad') {
        $formato = [[$label, $valor]];
        foreach ($datos as $fila) {
            $formato[] = [$fila['tipo_respuesta'], (int)$fila['cantidad']];
        }
        return json_encode($formato);
    }

    public static function formatearParaGraficoPreguntas($datos): array
    {
        $formateados = [];

        // Formato para preguntas por categoría
        $formatoCategoria = [['Categoría', 'Cantidad']];
        foreach ($datos['por_categoria'] as $fila) {
            $formatoCategoria[] = [$fila['categoria'], (int)$fila['cantidad']];
        }
        $formateados['por_categoria'] = json_encode($formatoCategoria);

        // Formato para preguntas por dificultad
        $formatoDificultad = [['Dificultad', 'Cantidad']];
        foreach ($datos['por_dificultad'] as $fila) {
            $formatoDificultad[] = [$fila['dificultad'], (int)$fila['cantidad']];
        }
        $formateados['por_dificultad'] = json_encode($formatoDificultad);

        return $formateados;
    }

}