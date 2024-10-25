<?php

namespace App\Http\Controllers;

use App\Models\ProductRating;
use App\Models\User;
use App\Exports\DataExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function usersExcel()
    {
        $model = User::class;
        $column = ['id', 'name', 'phone', 'email'];
        $conditions = ['role' => '1'];
        return $this->exportData($model, $column, $conditions, 'users');
    }

    public function ordersExcel()
    {
        $model = Order::class;
        $column = ['id', 'user_id', 'subtotal', 'shipping', 'coupon_code', 'discount', 'grand_total', 'payment_status', 'usd', 'payment_id', 'refund_id', 'status', 'first_name', 'last_name', 'email', 'country', 'address',  'apartment', 'city',  'state', 'pincode', 'mobile',  'notes', 'created_at', 'updated_at'];
        $conditions = [];
        return $this->exportData($model, $column, $conditions, 'orders');
    }

    public function ratingsExcel()
    {
        $model = ProductRating::class;
        $column = [
            'id',
            'product_id',
            'username',
            'email',
            'comment',
            'rating',
            'created_at',
            'updated_at'
        ];
        $conditions = [];
        return $this->exportData($model, $column, $conditions, 'ratings');
    }

    private function exportData($model, $columns, $conditions, $fileName)
    {
        $export = new DataExport($model, $columns, $conditions);

        return Excel::download($export, $fileName . '.xlsx');
    }
}
