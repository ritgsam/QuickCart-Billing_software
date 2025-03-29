<?php

namespace App\Libraries;

require_once base_path('vendor/setasign/fpdf/fpdf.php');

use FPDF;

class MyFPDF extends FPDF
{
    function Header() {
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, 'QuickCart', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'SALE INVOICE', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}
