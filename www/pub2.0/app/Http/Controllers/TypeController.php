<?php

namespace App\Http\Controllers;

use App\Services\TypeService;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    private $typeService;
    public function __construct(TypeService $typeService)
    {
        $this->typeService=$typeService;
    }

    public function deleteType($typeId){
        $this->typeService->delete($typeId);
        return url('dashboard/type');
    }
    public function addType(Request $request){
        $this->typeService->create([
            'name'=>$request->name
        ]);
        return url('dashboard/type');
    }
}
