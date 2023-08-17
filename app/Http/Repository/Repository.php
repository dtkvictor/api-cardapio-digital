<?php

namespace App\Http\Repository;

abstract class Repository
{    
    protected $model;    
    protected string $orderByField;
    protected string $searchField;

    private array $supported = [
        'search' => 'filterBySearch',
        'orderBy' => "orderBy",
    ];    

    public function __construct($model)
    {
        $this->model = $model;
        $this->supported = array_merge(
            $this->supported, 
            $this->addSuportedFilters()
        );
    }    

    protected function addSuportedFilters(): array
    {
        return [];
    }

    public function filterBy(array $filters) 
    {                        
        foreach($this->supported as $key => $filter) {
            if(!isset($filters[$key])) continue;
            $this->model = call_user_func([$this, $filter], $filters[$key]);            
        }
        return $this->model;
    }
    
    public function filterBySearch(string $search) 
    {            
        $searches = explode(" ", $search);                
        $model = $this->model->where($this->searchField, 'like', "%$search%");                    
        foreach($searches as $search) {            
            $model->orWhere($this->searchField, 'like', "%$search%");
        }                
        return $model;        
    }    

    public function orderBy(string $order) 
    {
        return $this->model->orderBy($this->orderByField, $order);
    }
}