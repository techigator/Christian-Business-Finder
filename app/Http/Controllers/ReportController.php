<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('reportedBy', 'reportedTo')
            ->orderBy('created_at', 'DESC')
            ->latest()
            ->paginate(10);

        return view('reported.index', compact('reports'));
    }

    public function show($id): JsonResponse
    {
        $report = Report::find($id);
        $reportedByUser = $report->reportedBy()->first();
        $reportedToUser = $report->reportedTo()->first();

        $reportData = [
            $reportedByUser->name,
            $reportedToUser->name,
            $report->content
        ];

        $data = [
            'report' => $reportData,
            'reported_by_user' => $reportedByUser,
            'reported_to_user' => $reportedToUser
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function delete($id): JsonResponse
    {
        $report = Report::find($id);
        $report->delete();

        return response()->json([
            'message' => 'Report data deleted successfully'
        ]);
    }
}
