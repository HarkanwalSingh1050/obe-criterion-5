<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\NbaDashboardApiController;
use App\Http\Controllers\Api\V1\SfrCalculatorApiController;
use App\Http\Controllers\Api\V1\FqiCalculatorApiController;
use App\Http\Controllers\Api\V1\ArticulationMatrixApiController;
use App\Http\Controllers\Api\V1\AttainmentApiController;
use App\Http\Controllers\Api\V1\SarWorkflowApiController;
use App\Http\Controllers\Api\V1\SarReportExportApiController;

Route::prefix('v1/nba')->group(function () {
    // Executive Dashboard & Overview
    Route::get('/dashboard', [NbaDashboardApiController::class, 'index']);

    // Criterion 5: Faculty Engines (SFR, FQI, Cadre)
    Route::get('/sfr-metrics', [SfrCalculatorApiController::class, 'getMetrics']);
    Route::post('/sfr-simulate', [SfrCalculatorApiController::class, 'simulate']);
    Route::get('/fqi-metrics', [FqiCalculatorApiController::class, 'getMetrics']);
    Route::post('/fqi-simulate', [FqiCalculatorApiController::class, 'simulate']);

    // Criterion 2 & 3: Curriculum & Articulation Matrix
    Route::get('/course-matrix/{courseId}', [ArticulationMatrixApiController::class, 'getCourseMatrix']);
    Route::get('/program-matrix', [ArticulationMatrixApiController::class, 'getProgramMatrix']);
    Route::post('/update-mapping', [ArticulationMatrixApiController::class, 'updateMapping']);

    // Criterion 3: Attainment (Direct, Indirect, Final PO Attainment)
    Route::get('/attainment/final', [AttainmentApiController::class, 'getFinalAttainment']);
    Route::get('/attainment/course/{courseId}', [AttainmentApiController::class, 'getCourseDirectAttainment']);
    Route::get('/attainment/indirect', [AttainmentApiController::class, 'getIndirectAttainment']);

    // SAR Workflow State Engine & Audit Logs
    Route::get('/workflow/{reportId}', [SarWorkflowApiController::class, 'getStatus']);
    Route::post('/workflow/{reportId}/transition', [SarWorkflowApiController::class, 'transition']);

    // Export Full SAR Report
    Route::get('/export/{reportId}', [SarReportExportApiController::class, 'getFullDocument']);
});
