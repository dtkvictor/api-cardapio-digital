<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{       
    public function index()
    {
        $controller = new UserController();
        return $controller->show(auth()->id());
    }

    public function update(Request $request)
    {
        $controller = new UserController();
        return $controller->update($request, auth()->id());
    }

    public function destroy()
    {
        $controller = new UserController();
        return $controller->destroy(auth()->id());
    }

    public function detailsStore(Request $request) 
    {
        $controller = new UserDetailController();
        return $controller->store($request, auth()->id());
    }

    public function detailsUpdate(Request $request) 
    {
        $controller = new UserDetailController();
        return $controller->update($request, auth()->id());
    }


    public function address() 
    {
        $controller = new AddressController();
        return $controller->showByUserId(auth()->id());
    }

    public function addressShow(int $addressId) 
    {
        $controller = new AddressController();
        return $controller->showByUserAndAddressId(auth()->id(), $addressId);
    }

    public function addressStore(Request $request) 
    {
        $controller = new AddressController();
        return $controller->store($request, auth()->id());
    }

    public function addressUpdate(Request $request, int $addressId) 
    {
        $controller = new AddressController();
        return $controller->update($request, auth()->id(), $addressId);
    }

    public function addressDelete(int $addressId)
    {
        $controller = new AddressController();
        return $controller->destroy(auth()->id(), $addressId);
    }


    public function shopping() 
    {
        $controller = new SaleController();
        return $controller->showByUserId(auth()->id());
    }

    public function shoppingShow(int $saleId) 
    {
        $controller = new SaleController();
        return $controller->showByUserAndSaleId(auth()->id(), $saleId);
    }

    public function shoppingStore(Request $request) 
    {
        $controller = new SaleController();
        return $controller->store($request);
    }

    public function shoppingDelete(int $saleId)
    {
        $controller = new SaleController();
        return $controller->hidden(auth()->id(), $saleId);
    }

}
