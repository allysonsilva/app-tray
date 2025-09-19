<?php

declare(strict_types=1);

namespace Shared\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Throwable;

trait HasCode
{
    protected int $baseConvertFromBase = 10;

    protected int $baseConvertToBase = 30;

    public static function bootHasCode(): void
    {
        static::retrieved(function (self $model) {
            $model->appends = array_merge($model->appends, ['code']);
            $model->hidden = array_merge($model->hidden, ['id', 'updated_at', 'deleted_at']);
        });

        static::created(function (self $model) {
            $model->updateQuietly([ 'code' => $model->encodeKey($model->getKey()) ]);
        });
    }

    public function encodeKey(int $id): string
    {
        return strtoupper(rtrim($this->codePrefix(), '-').'-' . base_convert(
            (string) $id,
            $this->baseConvertFromBase,
            $this->baseConvertToBase
        ));
    }

    public static function encode(int $id): string
    {
        return app(static::class)->encodeKey($id);
    }

    public function decodeCode(string $code): int
    {
        $codeWithoutPrefix = preg_replace('/^' . preg_quote($this->codePrefix(), '/') . '/', '', $code);

        return (int) base_convert(strtolower($codeWithoutPrefix), $this->baseConvertToBase, $this->baseConvertFromBase);
    }

    public static function decode(string $code): int
    {
        return app(static::class)->decodeCode($code);
    }

    public static function isValidCode(string|int $code): bool
    {
        try {
            return ! is_int($code) && (static::encode(static::decode($code)) === $code);
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * $query->findByCode($code)
     */
    public function scopeFindByCode(Builder $query, string $code): Model
    {
        return $query->findOrFail($this->decodeCode($code));
    }

    /**
     * $query->whereCode($code)
     */
    public function scopeWhereCode(Builder $query, string $code): void
    {
        $query->where($query->qualifyColumn($this->getKeyName()), static::decode($code));
    }

    abstract protected function codePrefix(): string;
}
