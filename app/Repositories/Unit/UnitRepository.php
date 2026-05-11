<?php

namespace App\Repositories\Unit;

use App\Models\Unit;

class UnitRepository
{
    public function getAll()
    {
        return Unit::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Unit::create($data);
    }

    public function findById($id)
    {
        return Unit::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $unit = Unit::findOrFail($id);

        $unit->update($data);

        return $unit;
    }

    public function delete($id)
    {
        $unit = Unit::findOrFail($id);

        return $unit->delete();
    }
}
