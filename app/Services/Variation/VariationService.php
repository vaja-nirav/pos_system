<?php

namespace App\Services\Variation;

use App\Repositories\Variation\VariationRepository;

class VariationService
{
    protected $variationRepository;

    public function __construct(VariationRepository $variationRepository)
    {
        $this->variationRepository = $variationRepository;
    }

    public function getAll()
    {
        return $this->variationRepository->getAll();
    }

    public function findById($id)
    {
        return $this->variationRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        $data['values'] = array_map('trim', $data['values']);

        return $this->variationRepository->store($data);
    }

    public function update($request, $id)
    {
        $data = $request->validated();

        $data['values'] = array_map('trim', $data['values']);

        return $this->variationRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->variationRepository->delete($id);
    }
}
