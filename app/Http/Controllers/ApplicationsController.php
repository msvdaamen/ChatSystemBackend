<?php

namespace App\Http\Controllers;

use App\models\Application;
use Illuminate\Http\Response;

class ApplicationsController extends Controller
{
    public function index() {
        $applications = Application::all();
        return response($applications, Response::HTTP_OK);
    }
}
