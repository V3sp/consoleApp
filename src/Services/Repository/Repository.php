<?php
declare(strict_types=1);

namespace Repository;

interface Repository
{

    public function makeRequest($repositoryName, $branch);
}
