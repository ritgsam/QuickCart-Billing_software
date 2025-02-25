<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\PurchaseInvoice;
use App\Models\Products;

class DashboardController extends Controller
{
    public function index()
    {
        $low_stock_products = Products::where('stock_quantity', '<', 5)->get();
        Log::info('DashboardController@index is being executed');


        $total_sales_month = SaleInvoice::whereMonth('created_at', date('m'))->sum('total_amount');
        $total_sales_year = SaleInvoice::whereYear('created_at', date('Y'))->sum('total_amount');

        $purchaseTotal = PurchaseInvoice::whereMonth('created_at', '02')->sum('total_amount');

        $total_purchases_month = PurchaseInvoice::whereMonth('created_at', date('m'))->sum('total_amount');
        $total_purchases_year = PurchaseInvoice::whereYear('created_at', date('Y'))->sum('total_amount');


        $pending_customer_payments = SaleInvoice::where('payment_status', 'Unpaid')->sum('total_amount');
        $pending_supplier_payments = PurchaseInvoice::where('payment_status', 'Unpaid')->sum('total_amount');


        $low_stock_products = Products::where('stock', '<', 5)->get();

        $recent_sales = SaleInvoice::latest()->take(5)->get();
        $recent_purchases = PurchaseInvoice::latest()->take(5)->get();

        return view('dashboard.index', compact('low_stock_products',
            'total_sales_month', 'total_sales_year',
            'total_purchases_month', 'total_purchases_year',
            'pending_customer_payments', 'pending_supplier_payments',
            'low_stock_products', 'recent_sales', 'recent_purchases'
        ));

    }
}
