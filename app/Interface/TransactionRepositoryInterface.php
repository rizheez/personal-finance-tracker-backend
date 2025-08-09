<?php

namespace App\Interface;

interface TransactionRepositoryInterface
{
    public function index(array $filters = []);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getSummary(): array;
    public function getMonthlySummary(): array;
    public function getRecentTransactions(int $limit = 5): array;
    public function getCategoryBreakdown(): array;
}
