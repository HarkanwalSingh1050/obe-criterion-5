<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Domains\Academic\Models\Program;
use App\Domains\Academic\Models\AcademicYear;
use App\Domains\Faculty\Services\SfrCalculatorService;

class SfrCalculatorApiController extends Controller
{
    protected SfrCalculatorService $sfrService;

    public function __construct(SfrCalculatorService $sfrService)
    {
        $this->sfrService = $sfrService;
    }

    /**
     * Get SFR metrics for a program
     */
    public function getMetrics(Request $request): JsonResponse
    {
        $programId = $request->query('program_id');
        $program = $programId ? Program::find($programId) : Program::first();

        if (!$program) {
            return response()->json(['success' => false, 'message' => 'Program not found'], 404);
        }

        $result = $this->sfrService->calculate($program);

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }

    /**
     * Live Simulator for SFR based on user inputs
     */
    public function simulate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ugt1' => 'required|numeric|min:0',
            'ugt2' => 'required|numeric|min:0',
            'ugt3' => 'required|numeric|min:0',
            'ugt4' => 'nullable|numeric|min:0',
            'faculty_count' => 'required|numeric|min:1',
        ]);

        $totalStudents = $validated['ugt1'] + $validated['ugt2'] + $validated['ugt3'] + ($validated['ugt4'] ?? 0);
        $faculty = max(1, $validated['faculty_count']);
        $sfr = round($totalStudents / $faculty, 2);

        $claimedMarks = 0.0;
        $status = 'Standard';

        if ($sfr <= 15.0) {
            $claimedMarks = 20.0;
            $status = 'Optimal (<= 15:1) - Full 20 Marks';
        } elseif ($sfr <= 20.0) {
            $claimedMarks = round(20.0 * (15.0 / $sfr), 2);
            $status = 'Acceptable (15:1 to 20:1)';
        } elseif ($sfr <= 25.0) {
            $claimedMarks = round(15.0 * (15.0 / $sfr), 2);
            $status = 'Sub-optimal (20:1 to 25:1)';
        } else {
            $claimedMarks = 0.0;
            $status = 'Deficient (> 25:1) - Zero Marks';
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_students' => $totalStudents,
                'faculty_count' => $faculty,
                'simulated_sfr' => $sfr,
                'claimed_marks' => $claimedMarks,
                'max_marks' => 20.0,
                'status' => $status,
                'required_faculty_at_15' => ceil($totalStudents / 15),
                'required_faculty_at_20' => ceil($totalStudents / 20),
            ],
        ]);
    }
}
