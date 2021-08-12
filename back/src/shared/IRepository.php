<?php

declare(strict_types=1);

namespace Src\shared;

interface IRepository
{
    public function BeginTransaction(): void;
    public function RollbackTransaction(): void;
    public function CommitTransacction(): void;
}
