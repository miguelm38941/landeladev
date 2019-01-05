<?php

function generatePdf($contents)
{

    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetTitle('My Title');
    $pdf->SetHeaderMargin(0);
    $pdf->SetTopMargin(5);
    $pdf->setFooterMargin(0);
    $pdf->SetAutoPageBreak(false);
    $pdf->SetAuthor('Author');
    $pdf->SetDisplayMode('real', 'default');
    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage('L', 'A7');
    $pdf->Cell(0, 0, $contents['code'], 'L,T,R,B', 1, 'C', 0);
    //$pdf->Write(5, 'Some sample text');
        // set style for barcode
    $style = array(
        'border' => 0,
        'vpadding' => '1',
        'hpadding' => '1',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );
    $pathf = 'download/';
    // QRCODE,L : QR-CODE Low error correction
    $qr_string2d = $contents['id'].'|'.$contents['code'];
    $pdf->write2DBarcode($qr_string2d, 'QRCODE,H', 30, 16, 45, 45, $style, 'N');
    $pdf->Output('pvv_qrprint.pdf', 'I');		
    
}


?>
