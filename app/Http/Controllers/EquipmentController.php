<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function fetchEquipment()
    {
        $equipments = Equipment::query()->get([
            'id',
            'name',
            'price',
            'description',
        ]);
        return response()->json(['data' => $equipments]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeEquipment(StoreEquipmentRequest $request)
    {
        Equipment::create($request->validated());
        return response()->json(['message' => 'Thêm dụng cụ thành công']);
    }

    public function show($id)
    {
        $equipment = Equipment::find($id);
        if (!$equipment) {
            return response()->json(['message' => 'Không tìm thấy dụng cụ']);
        }
        return response()->json(['data' => $equipment]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateEquipment(Request $request, $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json(['message' => 'Không tìm thấy dụng cụ']);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
        $equipment->update($validated);

        return response()->json(['message' => 'Cập nhật dụng cụ thành công']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyEquipment(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            abort(404);
        }

        $equipment->delete();

        return redirect()->back()->with('message', 'Xóa dụng cụ thành công');
    }
}

