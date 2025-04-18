<?php

namespace App\Helpers;

use FPDF;

class MyFPDF extends FPDF
{
    // You can override these methods to customize the PDF globally

    function Header()
    {
        // Add a header to every page
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Purchase Invoice', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        // Add page number at the bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}
