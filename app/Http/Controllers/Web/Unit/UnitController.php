<?php

namespace App\Http\Controllers\Web\Unit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Services\Unit\UnitService;

class UnitController extends Controller
{
    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index()
    {
        $units = $this->unitService->getAll();

        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(StoreUnitRequest $request)
    {
        $this->unitService->store($request);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit Created Successfully');
    }

    public function edit($id)
    {
        $unit = $this->unitService->findById($id);

        return view('units.edit', compact('unit'));
    }

    public function update(UpdateUnitRequest $request, $id)
    {
        $this->unitService->update($request, $id);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit Updated Successfully');
    }

    public function destroy($id)
    {
        $this->unitService->delete($id);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit Deleted Successfully');
    }
}
