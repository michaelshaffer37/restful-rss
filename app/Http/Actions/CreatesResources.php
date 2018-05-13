<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

/**
 * Class CreatesResources
 *
 * @package App\Http\Actions
 */
abstract class CreatesResources extends Action
{
    /**
     * A Uuid Namespace for the application resources.
     *
     * @var Uuid
     */
    protected $namespace;

    /**
     * Build the Application namespace from the
     *
     */
    protected function buildNamespace()
    {
        $this->namespace = app_namespace();
    }

    /**
     * Build a namespace (v5) uuid from the given string.
     *
     * @param string $value
     *
     * @return string
     */
    protected function buildUuid(string $name): string
    {
        return (string)Uuid::uuid5($this->namespace, $name);
    }

    /**
     * Builds the Namespace before handling the request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $this->buildNamespace();
        return parent::__invoke($request);
    }
}
