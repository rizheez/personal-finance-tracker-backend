<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Interface\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    protected $transactionRepository;
    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve filters from the request
        $filters = $request->all();
        $filters['user_id'] = auth()->id(); // Assuming user_id is required for filtering

        // Get transactions using the repository
        $transactions = $this->transactionRepository->index($filters);

        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'message' => 'Transactions retrieved successfully.',
            'status' => 'success',
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        // Create a new transaction using the repository
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id(); // Assuming user_id
            $transaction = $this->transactionRepository->create($data);
            DB::commit();
            return response()->json([
                'data' => new TransactionResource($transaction),
                'message' => 'Transaction created successfully.',
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create transaction: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve a transaction using the repository
        $transaction = $this->transactionRepository->find($id);
        if (!$transaction) {
            return response()->json([
                'message' => 'Transaction not found.',
                'status' => 'error',
            ], 404);
        }
        return response()->json([
            'data' => new TransactionResource($transaction),
            'message' => 'Transaction retrieved successfully.',
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, string $id)
    {
        // Update a transaction using the repository
        DB::beginTransaction();
        try {
            $transaction = $this->transactionRepository->update($id, $request->validated());
            DB::commit();
            return response()->json([
                'data' => new TransactionResource($transaction),
                'message' => 'Transaction updated successfully.',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update transaction: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete a transaction using the repository
        $deleted = $this->transactionRepository->delete($id);
        if (!$deleted) {
            return response()->json([
                'message' => 'Transaction not found or could not be deleted.',
                'status' => 'error',
            ], 404);
        }
        return response()->json([
            'message' => 'Transaction deleted successfully.',
            'status' => 'success',
        ], 200);
    }
}
