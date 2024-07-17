<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function get(): JsonResponse
    {
        return response()->json()->setStatusCode(200);
    }
}
