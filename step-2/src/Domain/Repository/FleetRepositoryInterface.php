<?php
namespace Domain\Repository;

use Domain\Model\Fleet;

interface FleetRepositoryInterface {
    public function save(Fleet $fleet);
    public function findById($id): ?Fleet;
}
