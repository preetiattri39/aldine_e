<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\{Payment, Role, User,Post};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * functionName : index
     * createdDate  : 29-05-2024
     * purpose      : Get the dashboard detail for the admin
     */
    public function index() {
        $role = Role::where('name', config('constants.ROLES.USER'))->first();
        $user = User::whereNull('deleted_at')->where('role_id', $role->id);

        // Get monthly post counts for last 6 months
        $months = collect();
        $postCounts = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M Y'); // e.g., "Jul 2025"
            $months->push($month);
            $postCounts->put($month, 0); // Default to 0
        }

        // Step 2: Get post counts grouped by month
        $monthlyPosts = Post::select(
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
            DB::raw("COUNT(*) as count")
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
        ->groupBy('month')
        ->pluck('count', 'month');

        // Step 3: Merge real counts into $postCounts
        foreach ($monthlyPosts as $month => $count) {
            $postCounts->put($month, $count);
        }
       
        $responseData = [
            'total_registered_user' => $user->clone()->count(),
            'total_active_user'     => $user->clone()->where('status', 1)->count(),
            'total_inactive_user'   => $user->clone()->where('status', 0)->count(),
            'total_active_post'     => Post::count(),
            'months'                => $months,
            'post_counts' => $months->map(fn($m) => $postCounts[$m])->values()->all(),

        ];

        return view("admin.dashboard", compact('responseData'));
    }
    /**End method index**/
}
