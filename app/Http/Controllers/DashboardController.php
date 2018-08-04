<?php

namespace App\Http\Controllers;

use App\models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $applications = Dashboard::where('user_id', $request->user()->id)->with('application')->get();
        return response($applications, Response::HTTP_OK);
    }

    public function add(Request $request) {
        $dashboard = new Dashboard;
        $dashboard->user_id = $request->user()->id;
        $dashboard->application_id = $request->application_id;
        $dashboard->shortcut_id = $request->shortcut_id;

        $order = Dashboard::where('user_id', $request->user()->id)->count();
        $dashboard->order = $order++;
        $dashboard->save();

        $newDashboard = Dashboard::where('id', $dashboard->id)->with('application')->first();

        return response($newDashboard, Response::HTTP_OK);
    }

    public function remove($id, Request $request) {
        $dashboard = Dashboard::where('id', $id)->where('user_id', $request->user()->id)->delete();

        return response($dashboard, Response::HTTP_OK);
    }
}
