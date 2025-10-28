<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\PurchaseInvoice;
use App\Models\Product;
use App\Models\SalePayment;
use App\Models\PurchasePayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $currentHour = Carbon::now()->timezone('Asia/Kolkata')->hour;

    if ($currentHour < 12) {
        $greeting = "Good Morning";
    } elseif ($currentHour < 18) {
        $greeting = "Good Afternoon";
    } else {
        $greeting = "Good Evening";
    }

    $salesData = DB::table('sale_invoices')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
        ->where('created_at', '>=', Carbon::now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();
    $sales_days = $salesData->pluck('date')->toArray();
    $sales_amounts = $salesData->pluck('total')->toArray();

    $total_sales_month = SaleInvoice::whereMonth('created_at', date('m'))->sum('total_amount');
    $total_sales_year = SaleInvoice::whereYear('created_at', date('Y'))->sum('total_amount');
    $total_sales = SaleInvoice::sum('total_amount');

    $total_purchases_month = PurchaseInvoice::whereMonth('created_at', date('m'))->sum('total_amount');
    $total_purchases_year = PurchaseInvoice::whereYear('created_at', date('Y'))->sum('total_amount');
    $total_purchases = PurchaseInvoice::sum('total_amount');

    $pending_customer_payments = SalePayment::where('status', 'Pending')->sum('balance_due');
    $pending_supplier_payments = PurchasePayment::where('status', 'Pending')->sum('balance_due');

    $low_stock_products = Product::where('stock_quantity', '<', 5)->get();

    return view('dashboard.index', compact(
'sales_days', 'sales_amounts',
        'greeting',
        'total_sales_month',
        'total_sales_year',
        'total_sales',
        'total_purchases_month',
        'total_purchases_year',
        'total_purchases',
        'pending_customer_payments',
        'pending_supplier_payments',
        'low_stock_products'
    ));
}
}

