<?php 
namespace App\Http\Repository;

class AddressRepository extends Repository
{    
    protected string $orderByField = 'name';
    protected string $searchField = 'name';

    public function filterByZipcode(int $zipcode) 
    {
        return $this->model->where('zipcode', $zipcode);
    }

    public function filterByCity(string $city)
    {
        return $this->model->where('city', $city);
    }        

    public function addSuportedFilters(): array
    {
        return [
            'cep' => 'filterByZipcode',
            'city' => 'filterByCity'
        ];
    }
}