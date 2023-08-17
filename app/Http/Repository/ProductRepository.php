<?php

namespace App\Http\Repository;

class ProductRepository extends Repository
{        
    protected string $searchField = 'name';
    protected string $orderByField = 'price';

    public function filterByCategory(int $category) 
    {        
        return $this->model->where('category', $category);
    }             

    public function filterByMinPrice(float $min)
    {   
        return $this->model->where('price', '>=', $min);
    }

    public function filterByMaxPrice(float $max)
    {   
        return $this->model->where('price', '<=', $max);
    }       
    
    protected function addSuportedFilters(): array
    {
        return [
            'category' => "filterByCategory",
            'minPrice' => "filterByMinPrice",
            'maxPrice' => "filterByMaxPrice",
        ];
    }
}