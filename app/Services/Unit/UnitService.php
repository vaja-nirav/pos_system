<?php

namespace App\Services\Unit;

use App\Repositories\Unit\UnitRepository;

class UnitService
{
    protected $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function getAll()
    {
        return $this->unitRepository->getAll();
    }

    public function findById($id)
    {
        return $this->unitRepository->findById($id);
    }

    public function store($request)
    {
        $data = $request->validated();

        return $this->unitRepository->store($data);
    }

    public function update($request, $id)
    {
        $data = $request->validated();

        return $this->unitRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->unitRepository->delete($id);
    }
}
