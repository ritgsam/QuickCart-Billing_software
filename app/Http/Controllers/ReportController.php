<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceItem;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\SalePayment;
use App\Models\PurchasePayment;
use Carbon\Carbon;
use DB;

class ReportController extends Controller
{


    public function index()
    {
        return view('reports.index');
    }

    public function salesReport(Request $request)
    {
        $start_date = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        $sales = SaleInvoice::whereBetween('invoice_date', [$start_date, $end_date])->get();
        return view('reports.sales', compact('sales', 'start_date', 'end_date'));
    }

    public function purchaseReport(Request $request)
{
    $start_date = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
    $end_date = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

    $purchases = PurchaseInvoice::whereBetween('invoice_date', [$start_date, $end_date])->get();

    return view('reports.purchases', compact('purchases', 'start_date', 'end_date'));
}


    public function stockReport()
    {
        $low_stock_products = Product::where('stock', '<=', 10)->get();
        return view('reports.stock', compact('low_stock_products'));
    }

    public function financialReport()
    {
        $total_sales = SaleInvoice::sum('total_amount');
        $total_purchases = PurchaseInvoice::sum('total_amount');
        $profit = $total_sales - $total_purchases;

        return view('reports.financial', compact('total_sales', 'total_purchases', 'profit'));
    }
}
