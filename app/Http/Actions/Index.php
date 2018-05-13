<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;

/**
 * Class Index
 *
 * @package App\Http\Actions
 */
class Index extends Action
{
    /**
     * Generate a Simple Health Check
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handle(Request $request)
    {
        return response()->json(['version' => app()->version()], 200);
    }
}
