<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Interface\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get a list of transactions with optional filters.
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(array $filters = [])
    {
        $query = Transaction::query();
        if (!empty($filters['with'])) {
            $query->with($filters['with']);
        }
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }
        if (!empty($filters['order'])) {
            $query->orderBy($filters['order']['column'], $filters['order']['direction']);
        }

        $query->filter($filters);

        return $query->paginate($filters['per_page'] ?? 20)
            ->withQueryString();
    }

    /**
     * Find a transaction by its ID.
     *
     * @param int $id
     * @return \App\Models\Transaction|null
     */
    public function find($id)
    {
        // Implementation for finding a transaction by ID
        return Transaction::find($id);
    }

    /**
     * Create a new transaction.
     *
     * @param array $data
     * @return \App\Models\Transaction
     */
    public function create(array $data)
    {
        // Implementation for creating a new transaction
        return Transaction::create($data);
    }

    /**
     * Update an existing transaction.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Transaction|null
     */
    public function update($id, array $data)
    {
        // Implementation for updating a transaction by ID
        $transaction = Transaction::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    /**
     * Delete a transaction by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        // Implementation for deleting a transaction by ID
        $transaction = Transaction::find($id);
        if ($transaction) {
            return $transaction->delete();
        }
    }

    public function getSummary(): array
    {
        $totalIncome = Transaction::where('type', 'income')->sum('amount');
        $totalExpense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        $monthlyIncome = Transaction::whereMonth('date', date('m'))->whereYear('date', date('Y'))->where('type', 'income')->sum('amount');
        $monthlyExpense = Transaction::whereMonth('date', date('m'))->whereYear('date', date('Y'))->where('type', 'expense')->sum('amount');
        $total_transaction = Transaction::count();
        return [
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'balance' => $balance,
            'monthly_income' => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'total_transaction' => $total_transaction
        ];
    }

    public function getMonthlySummary(): array
    {
        return Transaction::select(
            DB::raw("TO_CHAR(date, 'Mon YYYY') as month"),
            DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) as income"),
            DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as expense")
        )
            ->groupBy(DB::raw("TO_CHAR(date, 'Mon YYYY')"))
            ->orderByRaw("MIN(date) ASC")
            ->get()
            ->toArray();
    }

    public function getRecentTransactions(int $limit = 5): array
    {
        return Transaction::with('category')->latest('date')->limit($limit)->get()->toArray();
    }

    public function getCategoryBreakdown(): array
    {
        $data = Transaction::with('category')->select('category_id', DB::raw("SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END ) as income"), DB::raw("SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END ) AS expense"))->groupBy('category_id')->get();
        $result = [];
        foreach ($data as $item) {
            $result[$item->category_id] = [
                'name' => $item->category->name,
                'income' => $item->income,
                'expense' => $item->expense,
                'net' => $item->income - $item->expense,
                'color' => $item->category->color
            ];
        }
        return $result;
    }
}
