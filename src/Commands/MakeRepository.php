<?php

namespace AleksandroDelPiero\Repository\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;


class MakeRepository extends GeneratorCommand
{
    protected $signature = 'make:repository {name} {--model=}';
    protected $description = 'Create a new repository class';
    protected $type = 'repository';
    protected $model;

    protected function getStub()
    {
        return __DIR__ . '/../Stubs/repository.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . config('repository.namespace');
    }

    public function handle()
    {
        if (!$this->getModelOption()) {
            while (empty($this->model)) {
                $this->model = $this->ask('Specify the name of the model');
            }

            if (!file_exists($file = $this->getModelFilePath())) {
                $this->error('File ' . $file . ' not found!');
                return 0;
            }
        }

        parent::handle();

        $this->updateRepositoryFile();
    }

    protected function updateRepositoryFile(): void
    {
        $this->model = $this->getModelClass($this->model ?? $this->getModelOption());

        $class = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($class);

        file_put_contents($path, $this->modifyContent(file_get_contents($path), $this->model));
    }

    /**
     * @return string
     */
    protected function getModelFilePath(): string
    {
        return base_path('app' . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . $this->cleanModelClass($this->model) . '.php');
    }

    protected function cleanModelClass(string $model)
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $model);
    }

    /**
     * @param string $model
     * @return string
     */
    protected function getModelClass(string $model): string
    {
        if (Str::contains($model, '\\')) {
            $model = array_reverse(explode('\\', $model))[0];
        }

        if (Str::contains($model, '/')) {
            $model = array_reverse(explode('/', $model))[0];
        }

        return Str::contains($model, '::') ? $model : $model . '::class';
    }

    /**
     * @param $content
     * @param $model
     * @return array|string|string[]
     */
    protected function modifyContent($content, $model)
    {
        $content = str_replace(['{{Model}}', '{{ Model }}'], $model, $content);
        return str_replace(['{{ModelNamespace}}', '{{ ModelNamespace }}'], $this->getModelNamespace($model), $content);
    }

    /**
     * @param string $model
     * @return string
     */
    protected function getModelNamespace(string $model): string
    {
        return Str::contains($model, '::') ? explode('::', $model)[0] : $model;
    }

    /**
     * @return string
     */
    protected function getModelOption()
    {
        return Str::studly($this->option('model'));
    }
}
