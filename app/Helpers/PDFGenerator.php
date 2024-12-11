<?php

namespace App\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class PDFGenerator {
    public static function generate($htmlContent, $fileName, $forceDownload = false) {
        try {
            if (empty($htmlContent)) {
                throw new Exception("El contenido HTML no puede estar vacío.");
            }

            if (empty($fileName)) {
                throw new Exception("El nombre del archivo PDF no puede estar vacío.");
            }

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $attachmentOption = $forceDownload ? 1 : 0;
            $dompdf->stream($fileName, ["Attachment" => $attachmentOption]);

        } catch (Exception $e) {
            error_log("Error al generar el PDF: " . $e->getMessage());
            echo "Hubo un error al generar el PDF. Por favor, intente más tarde.";
        }
    }
}
