<?php

namespace App\Http\Controllers\Web\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Services\Brand\BrandService;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $brands = $this->brandService->getAll();

        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $this->brandService->store($request);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand Created Successfully');
    }

    public function edit($id)
    {
        $brand = $this->brandService->findById($id);

        return view('brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        $this->brandService->update($request, $id);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand Updated Successfully');
    }

    public function destroy($id)
    {
        $this->brandService->delete($id);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand Deleted Successfully');
    }
}
