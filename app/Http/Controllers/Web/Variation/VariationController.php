<?php

namespace App\Http\Controllers\Web\Variation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Variation\StoreVariationRequest;
use App\Http\Requests\Variation\UpdateVariationRequest;
use App\Services\Variation\VariationService;

class VariationController extends Controller
{
    protected $variationService;

    public function __construct(VariationService $variationService)
    {
        $this->variationService = $variationService;
    }

    public function index()
    {
        $variations = $this->variationService->getAll();
        return view('variations.index', compact('variations'));
    }

    public function store(StoreVariationRequest $request)
    {
        $this->variationService->store($request);

        return redirect()
            ->route('variations.index')
            ->with('success', 'Variation Created Successfully');
    }

    public function update(UpdateVariationRequest $request, $id)
    {
        $this->variationService->update($request, $id);

        return redirect()
            ->route('variations.index')
            ->with('success', 'Variation Updated Successfully');
    }

    public function destroy($id)
    {
        $this->variationService->delete($id);

        return redirect()
            ->route('variations.index')
            ->with('success', 'Variation Deleted Successfully');
    }
}
