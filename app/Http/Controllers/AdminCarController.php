<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarType;
use App\Models\CarModel;

class AdminCarController extends Controller
{
    public function index()
    {
        $types = CarType::with('models')->get();
        return view('admin.cars.index', compact('types'));
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        CarType::create($request->all());

        return back()->with('success', 'Car Company Added Successfully');
    }

    public function destroyType(CarType $type)
    {
        $type->delete();
        return back()->with('success', 'Car Company Deleted Successfully');
    }

    public function storeModel(Request $request)
    {
        $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'name' => 'required|string|max:255',
            'price_modifier' => 'required|numeric|min:0'
        ]);

        CarModel::create($request->all());

        return back()->with('success', 'Car Model Added Successfully');
    }

    public function destroyModel(CarModel $model)
    {
        $model->delete();
        return back()->with('success', 'Car Model Deleted Successfully');
    }
}
