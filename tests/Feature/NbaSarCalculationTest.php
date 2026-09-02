<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\NbaSarDatabaseSeeder;
use App\Domains\Academic\Models\Program;
use App\Domains\Academic\Models\AcademicYear;
use App\Domains\Faculty\Services\SfrCalculatorService;
use App\Domains\Faculty\Services\FqiCalculatorService;
use App\Domains\Faculty\Services\CadreRatioCalculatorService;
use App\Domains\Attainment\Services\AttainmentEngine;
use App\Domains\SAR\Models\SarReport;
use App\Domains\SAR\StateMachine\SarStateMachine;

class NbaSarCalculationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NbaSarDatabaseSeeder::class);
    }

    public function test_sfr_calculator_engine_computes_accurate_ratio_and_marks(): void
    {
        $program = Program::first();
        $service = new SfrCalculatorService();
        $result = $service->calculate($program);

        $this->assertNotNull($result);
        $this->assertGreaterThan(0, $result['avg_students_N']);
        $this->assertGreaterThan(0, $result['avg_faculty_F']);
        $this->assertGreaterThan(0, $result['avg_sfr']);
        $this->assertLessThanOrEqual(20.0, $result['claimed_marks']);
    }

    public function test_fqi_calculator_engine_computes_qualification_index(): void
    {
        $program = Program::first();
        $service = new FqiCalculatorService();
        $result = $service->calculate($program);

        $this->assertNotNull($result);
        $this->assertGreaterThan(0, $result['avg_fqi']);
        $this->assertLessThanOrEqual(25.0, $result['claimed_marks']);
    }

    public function test_cadre_ratio_calculator_engine_evaluates_cadre_proportions(): void
    {
        $program = Program::first();
        $service = new CadreRatioCalculatorService();
        $result = $service->calculate($program);

        $this->assertNotNull($result);
        $this->assertGreaterThan(0, $result['claimed_marks']);
        $this->assertLessThanOrEqual(25.0, $result['claimed_marks']);
    }

    public function test_attainment_engine_combines_direct_and_indirect_scores(): void
    {
        $program = Program::first();
        $engine = new AttainmentEngine();
        $result = $engine->computeFinalProgramAttainment($program);

        $this->assertNotEmpty($result['po_attainments']);
        $this->assertGreaterThan(0, $result['overall_po_average']);
        $this->assertLessThanOrEqual(3.0, $result['overall_po_average']);

        // Check PO1 combined formula: 0.8 * Direct + 0.2 * Indirect
        $po1 = $result['po_attainments']['PO1'];
        $expected = round((0.80 * $po1['direct_attainment']) + (0.20 * $po1['indirect_attainment']), 2);
        $this->assertEquals($expected, $po1['final_attainment']);
    }

    public function test_sar_state_machine_transition_and_audit_logging(): void
    {
        $report = SarReport::first();
        $report->current_state = SarStateMachine::STATE_DRAFT;
        $report->save();

        $stateMachine = new SarStateMachine();
        $updated = $stateMachine->transition(
            $report,
            SarStateMachine::STATE_DEPARTMENT,
            'Dr. Arvind Mehra',
            'HOD',
            'Department verification complete'
        );

        $this->assertEquals(SarStateMachine::STATE_DEPARTMENT, $updated->current_state);
        $this->assertDatabaseHas('sar_audit_logs', [
            'sar_report_id' => $report->id,
            'action' => 'STATE_TRANSITION',
            'user_role' => 'HOD',
        ]);
    }

    public function test_dashboard_api_returns_success_json_with_all_criteria(): void
    {
        $response = $this->getJson('/api/v1/nba/dashboard');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'report_id',
                'report_title',
                'total_claimed_marks',
                'total_max_marks',
                'total_percentage',
                'criteria',
                'live_engines' => [
                    'sfr',
                    'fqi',
                    'cadre',
                    'attainment',
                    'success_rate',
                    'placement',
                    'budget',
                ],
            ],
        ]);
    }

    public function test_sfr_simulator_api_endpoint(): void
    {
        $response = $this->postJson('/api/v1/nba/sfr-simulate', [
            'ugt1' => 120,
            'ugt2' => 120,
            'ugt3' => 120,
            'ugt4' => 120,
            'faculty_count' => 32,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'total_students' => 480,
                'faculty_count' => 32,
                'simulated_sfr' => 15.0,
                'claimed_marks' => 20.0,
            ],
        ]);
    }

    public function test_fqi_simulator_api_endpoint(): void
    {
        $response = $this->postJson('/api/v1/nba/fqi-simulate', [
            'phd_faculty_x' => 10,
            'mtech_faculty_y' => 15,
            'total_students' => 500,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'phd_faculty_x',
                'mtech_faculty_y',
                'total_students',
                'required_faculty_rf',
                'raw_fqi',
                'claimed_score',
            ],
        ]);
    }
}
