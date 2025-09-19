<?php

declare(strict_types=1);

namespace Shared\Providers\Concerns;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

trait LoadCommands
{
    /**
     * Recupera e registra (`$this->commands()`) os Commands Artisan do contexto do domínio.
     *
     * @return void
     */
    protected function loadCommands(): void
    {
        $path = $this->componentPath('Console' . DIRECTORY_SEPARATOR . 'Commands');

        if (! file_exists($path)) {
            return;
        }

        $commands = [];

        foreach ((Finder::create()->files()->name('*.php')->in($path)->exclude('Off')) as $splFileInfo) {
            $class = $this->getClassFromFile($splFileInfo->getRealPath());

            if (! is_null($class) && is_subclass_of($class, Command::class)) {
                $commands[] = $class;
            }
        }

        $this->commands($commands);
    }

    protected function getClassFromFile(string $file): ?string
    {
        $content = file_get_contents($file);

        if (preg_match('/namespace\s+(.+?);/', $content, $namespace) &&
            preg_match('/class\s+(\w+)/', $content, $class)) {
            return $namespace[1] . '\\' . $class[1];
        }

        return null;
    }
}
