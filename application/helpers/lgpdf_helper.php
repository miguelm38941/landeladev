<?php

function generatePdf($contents)
{

    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('My Title');
    $pdf->SetHeaderMargin(30);
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');

    $pdf->AddPage();
    $pdf->writeHTML($contents['code'], true, false, true, false, '');
    //$pdf->Write(5, 'Some sample text');
        // set style for barcode
    $style = array(
        'border' => 2,
        'vpadding' => '2',
        'hpadding' => '2',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );
    $pathf = 'download/';
    // QRCODE,L : QR-CODE Low error correction
    $qr_string2d = $contents['id'].'|'.$contents['code'];
    $pdf->write2DBarcode($qr_string2d, 'QRCODE,H', 40, 40, 50, 50, $style, 'N');
    $pdf->Output('pvv_qrprint.pdf', 'I');		
    
}


?>
