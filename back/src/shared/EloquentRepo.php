<?php

declare(strict_types=1);

namespace Src\shared;

use Illuminate\Support\Facades\DB;

abstract class EloquentRepo implements IRepository
{
    public function BeginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function RollbackTransaction(): void
    {
        DB::rollback();
    }

    public function CommitTransacction(): void
    {
        DB::commit();
    }
}
