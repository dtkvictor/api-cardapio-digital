<?php

namespace App\Http\Repository;

class SaleRepository extends Repository 
{
    protected string $searchField = 'name';
    protected string $orderByField = 'price';           
    
    public function filterByUser(int $userId)
    {
        return $this->model->where('user', $userId);
    }

    protected function addSuportedFilters(): array
    {
        return [
            'user' => 'filterByUser'
        ];
    }
}