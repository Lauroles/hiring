<?php
namespace Infra\Repository;

use Domain\Model\Fleet;
use Domain\Repository\FleetRepositoryInterface;

class InMemoryFleetRepository implements FleetRepositoryInterface {
    private $fleets = [];

    public function save(Fleet $fleet) {
        $this->fleets[$fleet->getId()] = $fleet;
    }

    public function findById($id): ?Fleet {
        return $this->fleets[$id] ?? null;
    }
}
