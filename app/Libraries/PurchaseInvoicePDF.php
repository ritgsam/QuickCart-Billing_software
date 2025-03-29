<?php

namespace App\Libraries;

require_once base_path('vendor/setasign/fpdf/fpdf.php');

use FPDF;

class PurchaseInvoicePDF extends FPDF
{
    function Header()
    {
$this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 10, 'QuickCart', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, '', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function InvoiceDetails($invoice)
    {
        $this->SetFont('Arial', '', 10);
        $this->Cell(95, 8, "Invoice Number: " . $invoice->invoice_number, 0, 0, 'L');
        $this->Cell(95, 8, "Invoice Date: " . $invoice->invoice_date, 0, 1, 'R');
        $this->Cell(95, 8, "Supplier: " . $invoice->supplier->company_name, 0, 1, 'L');
        $this->Ln(5);
    }

    function TableHeader()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 200, 200);
        $this->Cell(60, 10, 'Product', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Qty', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Unit Price', 1, 0, 'C', true);
        $this->Cell(20, 10, 'GST (%)', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Discount (%)', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Total', 1, 1, 'C', true);
    }

    function TableBody($invoice)
    {
        $this->SetFont('Arial', '', 9);
        foreach ($invoice->items as $item) {
            $this->Cell(60, 8, $item->product->name, 1);
            $this->Cell(20, 8, $item->quantity, 1, 0, 'C');
            $this->Cell(30, 8, utf8_decode("₹") . number_format($item->unit_price, 2), 1, 0, 'R');
            $this->Cell(20, 8, $item->gst_rate . '%', 1, 0, 'C');
            $this->Cell(20, 8, $item->discount . '%', 1, 0, 'C');
            $this->Cell(30, 8, utf8_decode("₹") . number_format($item->total_price, 2), 1, 1, 'R');
        }
        $this->Ln(5);
    }

    function TotalAmount($invoice)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(150, 10, 'Total Amount:', 0, 0, 'R');
        $this->Cell(30, 10, utf8_decode("₹") . number_format($invoice->total_amount, 2), 0, 1, 'R');
    }
}


// namespace App\Libraries;

// require_once base_path('vendor/setasign/fpdf/fpdf.php');

// use FPDF;

// class PurchaseInvoicePDF extends FPDF
// {
//     function Header()
//     {
//         $this->SetFont('Arial', 'B', 16);
//         $this->Cell(0, 10, 'PURCHASE INVOICE', 0, 1, 'C');
//         $this->Ln(5);
//     }

//     function Footer()
//     {
//         $this->SetY(-15);
//         $this->SetFont('Arial', 'I', 8);
//         $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
//     }
// }
