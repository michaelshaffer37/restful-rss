<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;

abstract class Action
{
    /**
     * The validation rules to apply to this request.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * A method that validates the request for this action.
     *
     * @param Request $request
     */
    protected function validate(Request $request)
    {
        $validator = validator($request->all(), $this->rules);

        if ($validator->fails()) {
            abort(422);
        }
    }

    /**
     * The handler for the given request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    abstract protected function handle(Request $request);

    /**
     * Get a route param by name
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function getRouteParam(Request $request, string $param)
    {
        return array_get(last($request->route()), $param);
    }

    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $this->validate($request);
        return $this->handle($request);
    }
}
