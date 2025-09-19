<?php

declare(strict_types=1);

namespace Shared\Providers\Concerns;

use ReflectionClass;

trait ComponentPath
{
    /**
     * Recupera o caminho/path base do componente do contexto do domínio,
     * para que os recursos relacionados possam ser carregados/manipulados.
     *
     * @param string|null $directory
     *
     * @return string
     */
    protected function componentPath(?string $directory = null): string
    {
        $realPath = realpath(dirname((new ReflectionClass($this))->getFileName()) . '/../');

        // @codeCoverageIgnoreStart
        if (empty($directory)) {
            return $realPath;
        }
        // @codeCoverageIgnoreEnd

        return $realPath . DIRECTORY_SEPARATOR . $directory;
    }
}
