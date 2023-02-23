<?php

// use UserService;
namespace App\Http\DashboardService;

use App\Http\Controllers\ApiController;



 class DashboardService
 {
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function dashboard_graph_data($fromDate,$toDate,$officeId,$isAdmin)
    {
        $dashboardData=ApiController::DEFDashBoardGraphData($fromDate,$toDate,$officeId,$isAdmin);
        return $dashboardData;
    }
}
