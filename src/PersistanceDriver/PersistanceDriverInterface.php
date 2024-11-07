<?php

namespace App\PersistanceDriver;

interface PersistanceDriverInterface
{
    public function save(): void;
}
