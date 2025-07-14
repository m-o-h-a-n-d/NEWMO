<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


class AdminDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:home');
    }
    public function __invoke()
    {

        $chart_options = [
            'chart_title' => 'Posts by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Post',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 30, // show only last 30 day

        ];
        $chart1 = new LaravelChart($chart_options);

        $User_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 365, // show only last 30 day
        ];
        $chart2 = new LaravelChart($User_options);




        return  view('admin.index', compact('chart1', 'chart2'));
    }
}
