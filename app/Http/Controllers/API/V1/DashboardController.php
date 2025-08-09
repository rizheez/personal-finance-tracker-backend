<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $transaction;
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transaction = $transactionRepository;
    }

    public function summary()
    {
        $summary = $this->transaction->getSummary();
        return response()->json($summary);
    }

    public function getMonthlySummary()
    {
        $monthly = $this->transaction->getMonthlySummary();
        return response()->json($monthly);
    }

    public function recentTransactions()
    {
        $limit = request()->query('limit', 5);
        $transactions = $this->transaction->getRecentTransactions($limit);
        return response()->json($transactions);
    }

    public function categoryBreakdown()
    {
        $categories = $this->transaction->getCategoryBreakdown();
        return response()->json($categories);
    }
}
