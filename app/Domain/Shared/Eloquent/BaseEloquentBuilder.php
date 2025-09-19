<?php

declare(strict_types=1);

namespace Shared\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class BaseEloquentBuilder extends BaseBuilder
{
    // public function wherePublic(bool $isPublic = true)
    // {
    //     $this->where('is_public', $isPublic);

    //     return $this;
    // }

    // public function wherePrivate()
    // {
    //     $this->wherePublic(false);

    //     return $this;
    // }
}
