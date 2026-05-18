<?php

namespace App\Repositories\Variation;

use App\Models\Variation;

class VariationRepository
{
    public function getAll()
    {
        return Variation::latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Variation::create($data);
    }

    public function findById($id)
    {
        return Variation::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $variation = Variation::findOrFail($id);
        $variation->update($data);

        return $variation;
    }

    public function delete($id)
    {
        $variation = Variation::findOrFail($id);

        return $variation->delete();
    }
}
