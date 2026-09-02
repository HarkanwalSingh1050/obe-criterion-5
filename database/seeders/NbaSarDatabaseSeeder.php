<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Academic\Models\Institution;
use App\Domains\Academic\Models\Department;
use App\Domains\Academic\Models\AcademicYear;
use App\Domains\Academic\Models\Program;
use App\Domains\Academic\Models\AcademicIntake;
use App\Domains\Faculty\Models\FacultyProfile;
use App\Domains\Faculty\Models\FacultyAcademicYear;
use App\Domains\Faculty\Models\FacultyFdp;
use App\Domains\Faculty\Models\FacultyPublication;
use App\Domains\Curriculum\Models\Course;
use App\Domains\Curriculum\Models\ProgramOutcome;
use App\Domains\Curriculum\Models\ProgramSpecificOutcome;
use App\Domains\Curriculum\Models\CourseOutcome;
use App\Domains\Curriculum\Models\CoPoMapping;
use App\Domains\Attainment\Models\StudentAssessment;
use App\Domains\Attainment\Models\IndirectAssessment;
use App\Domains\Attainment\Models\AttainmentResult;
use App\Domains\Student\Models\StudentCohort;
use App\Domains\Student\Models\StudentPlacement;
use App\Domains\Finance\Models\FinancialBudget;
use App\Domains\Finance\Models\BudgetItem;
use App\Domains\SAR\Models\SarReport;
use App\Domains\SAR\Models\SarCriterion;
use App\Domains\SAR\Models\SarAuditLog;

class NbaSarDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Institution & Department
        $inst = Institution::create([
            'name' => 'National Institute of Engineering & Technology',
            'code' => 'NIET-098',
            'head_of_institution' => 'Dr. R. K. Sharma (Principal / Director)',
            'address' => 'Knowledge Park Tech Zone, Phase II',
            'website' => 'https://niet-tech.edu.in',
        ]);

        $dept = Department::create([
            'institution_id' => $inst->id,
            'name' => 'Department of Computer Science and Engineering',
            'code' => 'CSE',
            'hod_name' => 'Dr. Arvind Mehra, Ph.D.',
            'hod_email' => 'hod.cse@niet-tech.edu.in',
        ]);

        // 2. Academic Years (CAY, CAYm1, CAYm2, CAYm3)
        $cay = AcademicYear::create(['name' => '2024-25', 'type' => 'CAY', 'start_year' => 2024, 'end_year' => 2025, 'is_current' => true]);
        $caym1 = AcademicYear::create(['name' => '2023-24', 'type' => 'CAYm1', 'start_year' => 2023, 'end_year' => 2024, 'is_current' => false]);
        $caym2 = AcademicYear::create(['name' => '2022-23', 'type' => 'CAYm2', 'start_year' => 2022, 'end_year' => 2023, 'is_current' => false]);
        $caym3 = AcademicYear::create(['name' => '2021-22', 'type' => 'CAYm3', 'start_year' => 2021, 'end_year' => 2022, 'is_current' => false]);

        // 3. Program
        $prog = Program::create([
            'institution_id' => $inst->id,
            'department_id' => $dept->id,
            'name' => 'B.Tech in Computer Science and Engineering',
            'code' => 'BTECH-CSE',
            'degree_level' => 'UG',
            'sanctioned_intake' => 120,
            'year_of_start' => 2008,
            'nba_tier' => 'Tier-II',
            'coordinator_name' => 'Dr. S. Narayan (NBA Coordinator)',
        ]);

        // 4. Academic Intake data (UGT1 + UGT2 + UGT3 + UGT4)
        AcademicIntake::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'ug_1st_year' => 120, 'ug_2nd_year' => 128, 'ug_3rd_year' => 125, 'ug_4th_year' => 122, 'lateral_entry' => 12]);
        AcademicIntake::create(['program_id' => $prog->id, 'academic_year_id' => $caym1->id, 'ug_1st_year' => 120, 'ug_2nd_year' => 126, 'ug_3rd_year' => 124, 'ug_4th_year' => 120, 'lateral_entry' => 12]);
        AcademicIntake::create(['program_id' => $prog->id, 'academic_year_id' => $caym2->id, 'ug_1st_year' => 120, 'ug_2nd_year' => 124, 'ug_3rd_year' => 120, 'ug_4th_year' => 118, 'lateral_entry' => 10]);

        // 5. Faculty Profiles (Professors, Assoc Profs, Asst Profs)
        $facultyData = [
            ['name' => 'Dr. Arvind Mehra', 'faculty_id' => 'FAC-CSE-001', 'degree' => 'Ph.D. Computer Science', 'cadre' => 'Professor', 'exp' => 18, 'joining' => '2012-07-01'],
            ['name' => 'Dr. Sunita Varma', 'faculty_id' => 'FAC-CSE-002', 'degree' => 'Ph.D. AI & Deep Learning', 'cadre' => 'Professor', 'exp' => 16, 'joining' => '2014-06-15'],
            ['name' => 'Dr. Rajesh Deshmukh', 'faculty_id' => 'FAC-CSE-003', 'degree' => 'Ph.D. Cloud Computing', 'cadre' => 'Professor', 'exp' => 15, 'joining' => '2015-08-01'],
            ['name' => 'Dr. Priya Nambiar', 'faculty_id' => 'FAC-CSE-004', 'degree' => 'Ph.D. Cybersecurity', 'cadre' => 'Associate Professor', 'exp' => 12, 'joining' => '2017-07-10'],
            ['name' => 'Dr. Ankit Gupta', 'faculty_id' => 'FAC-CSE-005', 'degree' => 'Ph.D. Data Science', 'cadre' => 'Associate Professor', 'exp' => 11, 'joining' => '2018-01-05'],
            ['name' => 'Dr. Sneha Roy', 'faculty_id' => 'FAC-CSE-006', 'degree' => 'Ph.D. Computer Vision', 'cadre' => 'Associate Professor', 'exp' => 10, 'joining' => '2018-07-15'],
            ['name' => 'Dr. Vikas Patel', 'faculty_id' => 'FAC-CSE-007', 'degree' => 'Ph.D. IoT Systems', 'cadre' => 'Associate Professor', 'exp' => 9, 'joining' => '2019-06-01'],
            ['name' => 'Prof. Rohit Kulkarni', 'faculty_id' => 'FAC-CSE-008', 'degree' => 'M.Tech Software Engineering', 'cadre' => 'Associate Professor', 'exp' => 12, 'joining' => '2016-08-10'],
            ['name' => 'Prof. Neha Sen', 'faculty_id' => 'FAC-CSE-009', 'degree' => 'M.Tech Computer Networks', 'cadre' => 'Assistant Professor', 'exp' => 7, 'joining' => '2020-01-10'],
            ['name' => 'Prof. Amitava Ghosh', 'faculty_id' => 'FAC-CSE-010', 'degree' => 'M.Tech Machine Learning', 'cadre' => 'Assistant Professor', 'exp' => 6, 'joining' => '2020-07-01'],
            ['name' => 'Prof. Pooja Hegde', 'faculty_id' => 'FAC-CSE-011', 'degree' => 'M.Tech Distributed Systems', 'cadre' => 'Assistant Professor', 'exp' => 6, 'joining' => '2020-08-15'],
            ['name' => 'Prof. Manoj Iyer', 'faculty_id' => 'FAC-CSE-012', 'degree' => 'M.Tech Information Security', 'cadre' => 'Assistant Professor', 'exp' => 5, 'joining' => '2021-06-01'],
            ['name' => 'Prof. Shweta Joshi', 'faculty_id' => 'FAC-CSE-013', 'degree' => 'M.Tech Web Technologies', 'cadre' => 'Assistant Professor', 'exp' => 5, 'joining' => '2021-07-10'],
            ['name' => 'Prof. Deepali Rathi', 'faculty_id' => 'FAC-CSE-014', 'degree' => 'M.Tech Embedded Systems', 'cadre' => 'Assistant Professor', 'exp' => 4, 'joining' => '2022-01-15'],
            ['name' => 'Prof. Saurabh Mishra', 'faculty_id' => 'FAC-CSE-015', 'degree' => 'M.Tech Cloud Architecture', 'cadre' => 'Assistant Professor', 'exp' => 4, 'joining' => '2022-06-20'],
            ['name' => 'Prof. Kavita Rao', 'faculty_id' => 'FAC-CSE-016', 'degree' => 'M.Tech Database Systems', 'cadre' => 'Assistant Professor', 'exp' => 4, 'joining' => '2022-07-01'],
            ['name' => 'Prof. Tanmay Bhatia', 'faculty_id' => 'FAC-CSE-017', 'degree' => 'M.Tech Algorithm Design', 'cadre' => 'Assistant Professor', 'exp' => 3, 'joining' => '2023-01-05'],
            ['name' => 'Prof. Divya Nair', 'faculty_id' => 'FAC-CSE-018', 'degree' => 'M.Tech Big Data Analytics', 'cadre' => 'Assistant Professor', 'exp' => 3, 'joining' => '2023-06-15'],
            ['name' => 'Prof. Rahul Saxena', 'faculty_id' => 'FAC-CSE-019', 'degree' => 'M.Tech Computer Engineering', 'cadre' => 'Assistant Professor', 'exp' => 2, 'joining' => '2023-07-01'],
            ['name' => 'Prof. Meenakshi S.', 'faculty_id' => 'FAC-CSE-020', 'degree' => 'M.Tech AI & Robotics', 'cadre' => 'Assistant Professor', 'exp' => 2, 'joining' => '2024-01-10'],
            ['name' => 'Prof. Nitin Chawla', 'faculty_id' => 'FAC-CSE-021', 'degree' => 'M.Tech Blockchain Technologies', 'cadre' => 'Assistant Professor', 'exp' => 2, 'joining' => '2024-06-01'],
            ['name' => 'Prof. Ananya Mukherjee', 'faculty_id' => 'FAC-CSE-022', 'degree' => 'M.Tech Human Computer Interaction', 'cadre' => 'Assistant Professor', 'exp' => 1, 'joining' => '2024-07-01'],
        ];

        $createdProfiles = [];
        foreach ($facultyData as $f) {
            $prof = FacultyProfile::create([
                'department_id' => $dept->id,
                'faculty_id' => $f['faculty_id'],
                'name' => $f['name'],
                'pan' => 'ABCDE' . rand(1000, 9999) . 'Z',
                'apaar_id' => 'APAAR-' . rand(10000000, 99999999),
                'email' => strtolower(str_replace(['Dr. ', 'Prof. ', ' '], ['', '', '.'], $f['name'])) . '@niet-tech.edu.in',
                'mobile' => '+91 98' . rand(10000000, 99999999),
                'joining_date' => $f['joining'],
                'highest_degree' => $f['degree'],
                'degree_specialization' => $f['degree'],
                'teaching_experience_years' => $f['exp'],
                'is_active' => true,
            ]);
            $createdProfiles[] = ['profile' => $prof, 'cadre' => $f['cadre']];

            // Assign to CAY, CAYm1, CAYm2
            foreach ([$cay, $caym1, $caym2] as $y) {
                FacultyAcademicYear::create([
                    'faculty_profile_id' => $prof->id,
                    'academic_year_id' => $y->id,
                    'program_id' => $prog->id,
                    'designation' => $f['cadre'],
                    'cadre' => $f['cadre'],
                    'pay_scale' => str_contains($f['cadre'], 'Professor') ? '7th CPC Level 14' : (str_contains($f['cadre'], 'Associate') ? '7th CPC Level 13A' : '7th CPC Level 10'),
                    'association_type' => 'Regular',
                    'is_exclusive_to_program' => true,
                ]);
            }

            // Faculty FDP
            FacultyFdp::create([
                'faculty_profile_id' => $prof->id,
                'academic_year_id' => $cay->id,
                'title' => 'Advanced Pedagogical Training & Outcome Based Education Implementation',
                'duration_days' => 5,
                'organizer' => 'AICTE - ATAL Academy',
                'start_date' => '2024-09-10',
                'end_date' => '2024-09-15',
            ]);

            // Publication
            if (str_contains($f['degree'], 'Ph.D')) {
                FacultyPublication::create([
                    'faculty_profile_id' => $prof->id,
                    'academic_year_id' => $cay->id,
                    'title' => 'Scalable Distributed Architectures for High-Throughput Stream Processing',
                    'journal_conference_name' => 'IEEE Transactions on Computers',
                    'publication_type' => 'Journal',
                    'indexing' => 'SCI',
                    'impact_factor' => 3.85,
                    'published_date' => '2024-11-20',
                ]);
            }
        }

        // 6. Program Outcomes (PO1 to PO12)
        $nbaPos = [
            ['code' => 'PO1', 'title' => 'Engineering Knowledge', 'desc' => 'Apply knowledge of mathematics, science, engineering fundamentals, and computer engineering specialization.'],
            ['code' => 'PO2', 'title' => 'Problem Analysis', 'desc' => 'Identify, formulate, review research literature, and analyze complex engineering problems reaching substantiated conclusions.'],
            ['code' => 'PO3', 'title' => 'Design/Development of Solutions', 'desc' => 'Design solutions for complex engineering problems and design system components or processes that meet specified needs.'],
            ['code' => 'PO4', 'title' => 'Conduct Investigations of Complex Problems', 'desc' => 'Use research-based knowledge and research methods including design of experiments, analysis and interpretation of data.'],
            ['code' => 'PO5', 'title' => 'Modern Tool Usage', 'desc' => 'Create, select, and apply appropriate techniques, resources, and modern engineering and IT tools.'],
            ['code' => 'PO6', 'title' => 'The Engineer and Society', 'desc' => 'Apply reasoning informed by contextual knowledge to assess societal, health, safety, legal and cultural issues.'],
            ['code' => 'PO7', 'title' => 'Environment and Sustainability', 'desc' => 'Understand the impact of professional engineering solutions in societal and environmental contexts.'],
            ['code' => 'PO8', 'title' => 'Ethics', 'desc' => 'Apply ethical principles and commit to professional ethics and responsibilities and norms of engineering practice.'],
            ['code' => 'PO9', 'title' => 'Individual and Team Work', 'desc' => 'Function effectively as an individual, and as a member or leader in diverse teams, and in multidisciplinary settings.'],
            ['code' => 'PO10', 'title' => 'Communication', 'desc' => 'Communicate effectively on complex engineering activities with the engineering community and with society at large.'],
            ['code' => 'PO11', 'title' => 'Project Management and Finance', 'desc' => 'Demonstrate knowledge and understanding of engineering and management principles and apply these to one’s own work.'],
            ['code' => 'PO12', 'title' => 'Life-long Learning', 'desc' => 'Recognize the need for, and have the preparation and ability to engage in independent and life-long learning.'],
        ];

        $createdPos = [];
        foreach ($nbaPos as $p) {
            $createdPos[$p['code']] = ProgramOutcome::create([
                'program_id' => $prog->id,
                'po_code' => $p['code'],
                'title' => $p['title'],
                'description' => $p['desc'],
            ]);
        }

        // Program Specific Outcomes (PSOs)
        $nbaPsos = [
            ['code' => 'PSO1', 'title' => 'Software Systems Architecture', 'desc' => 'Design, build, and deploy robust, secure, and full-stack software applications using contemporary frameworks.'],
            ['code' => 'PSO2', 'title' => 'Intelligent Computing & Data Science', 'desc' => 'Develop predictive and generative AI models, analytics pipelines, and cloud computing solutions.'],
        ];

        $createdPsos = [];
        foreach ($nbaPsos as $p) {
            $createdPsos[$p['code']] = ProgramSpecificOutcome::create([
                'program_id' => $prog->id,
                'pso_code' => $p['code'],
                'title' => $p['title'],
                'description' => $p['desc'],
            ]);
        }

        // 7. Courses & Articulation Matrix
        $coursesData = [
            ['code' => 'CS301', 'name' => 'Data Structures and Algorithms', 'sem' => 3, 'credits' => 4.0],
            ['code' => 'CS401', 'name' => 'Database Management Systems', 'sem' => 4, 'credits' => 4.0],
            ['code' => 'CS501', 'name' => 'Operating Systems & Concurrency', 'sem' => 5, 'credits' => 3.5],
            ['code' => 'CS502', 'name' => 'Computer Networks & Protocols', 'sem' => 5, 'credits' => 3.5],
            ['code' => 'CS601', 'name' => 'Artificial Intelligence & Machine Learning', 'sem' => 6, 'credits' => 4.0],
            ['code' => 'CS602', 'name' => 'Software Engineering & Agile Methodologies', 'sem' => 6, 'credits' => 3.0],
            ['code' => 'CS701', 'name' => 'Cloud Computing & Distributed Systems', 'sem' => 7, 'credits' => 3.5],
            ['code' => 'CS801', 'name' => 'Cybersecurity & Cryptographic Protocols', 'sem' => 8, 'credits' => 3.0],
        ];

        foreach ($coursesData as $c) {
            $course = Course::create([
                'program_id' => $prog->id,
                'academic_year_id' => $cay->id,
                'course_code' => $c['code'],
                'course_name' => $c['name'],
                'semester' => $c['sem'],
                'credits' => $c['credits'],
                'lecture_hours' => 3,
                'tutorial_hours' => 0,
                'practical_hours' => 2,
                'course_type' => 'Core',
            ]);

            // Create 5 Course Outcomes per course
            for ($i = 1; $i <= 5; $i++) {
                $co = CourseOutcome::create([
                    'course_id' => $course->id,
                    'co_code' => "CO{$i}",
                    'description' => "Demonstrate proficiency in {$c['name']} objective {$i} with algorithmic design and practical implementation.",
                    'target_percentage' => 65.0,
                    'target_level' => 2.5,
                    'bloom_level' => $i <= 2 ? 'Understand' : ($i <= 4 ? 'Apply' : 'Analyze'),
                ]);

                // Map CO to POs (Correlation levels 1, 2, 3)
                $mapPos = ['PO1' => 3, 'PO2' => 3, 'PO3' => 2, 'PO5' => 3, 'PO9' => 2, 'PO12' => 2];
                foreach ($mapPos as $poKey => $lvl) {
                    if (isset($createdPos[$poKey])) {
                        CoPoMapping::create([
                            'course_outcome_id' => $co->id,
                            'target_type' => 'PO',
                            'target_id' => $createdPos[$poKey]->id,
                            'correlation_level' => max(1, ($lvl + ($i % 2) - 1)),
                            'justification' => "Course outcome directly enhances competence in {$poKey}.",
                        ]);
                    }
                }

                // Map CO to PSOs
                foreach ($createdPsos as $psoKey => $psoModel) {
                    CoPoMapping::create([
                        'course_outcome_id' => $co->id,
                        'target_type' => 'PSO',
                        'target_id' => $psoModel->id,
                        'correlation_level' => 2,
                        'justification' => "Maps to {$psoKey} industry competencies.",
                    ]);
                }

                // Create Student Assessments for CIE and SEE
                StudentAssessment::create([
                    'course_id' => $course->id,
                    'course_outcome_id' => $co->id,
                    'academic_year_id' => $cay->id,
                    'assessment_type' => 'Internal_Test_1',
                    'total_students_attempted' => 125,
                    'students_meeting_target' => 98,
                    'percentage_achieved' => 78.4,
                    'attainment_level' => 2.8,
                ]);

                StudentAssessment::create([
                    'course_id' => $course->id,
                    'course_outcome_id' => $co->id,
                    'academic_year_id' => $cay->id,
                    'assessment_type' => 'End_Sem',
                    'total_students_attempted' => 125,
                    'students_meeting_target' => 92,
                    'percentage_achieved' => 73.6,
                    'attainment_level' => 2.6,
                ]);

                // Attainment Result
                AttainmentResult::create([
                    'course_outcome_id' => $co->id,
                    'academic_year_id' => $cay->id,
                    'direct_cie_score' => 2.8,
                    'direct_see_score' => 2.6,
                    'direct_attainment' => 2.64,
                    'indirect_attainment' => 2.55,
                    'final_score' => 2.62,
                ]);
            }
        }

        // 8. Indirect Assessments (Surveys)
        foreach ($createdPos as $poCode => $poModel) {
            IndirectAssessment::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'survey_type' => 'Graduate_Exit_Survey', 'target_type' => 'PO', 'target_id' => $poModel->id, 'average_rating' => 2.65, 'total_respondents' => 110]);
            IndirectAssessment::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'survey_type' => 'Alumni_Survey', 'target_type' => 'PO', 'target_id' => $poModel->id, 'average_rating' => 2.50, 'total_respondents' => 75]);
            IndirectAssessment::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'survey_type' => 'Employer_Survey', 'target_type' => 'PO', 'target_id' => $poModel->id, 'average_rating' => 2.70, 'total_respondents' => 30]);
        }

        foreach ($createdPsos as $psoCode => $psoModel) {
            IndirectAssessment::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'survey_type' => 'Graduate_Exit_Survey', 'target_type' => 'PSO', 'target_id' => $psoModel->id, 'average_rating' => 2.70, 'total_respondents' => 110]);
            IndirectAssessment::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'survey_type' => 'Alumni_Survey', 'target_type' => 'PSO', 'target_id' => $psoModel->id, 'average_rating' => 2.55, 'total_respondents' => 75]);
            IndirectAssessment::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'survey_type' => 'Employer_Survey', 'target_type' => 'PSO', 'target_id' => $psoModel->id, 'average_rating' => 2.75, 'total_respondents' => 30]);
        }

        // 9. Student Cohorts (Criterion 4)
        StudentCohort::create(['program_id' => $prog->id, 'batch_name' => '2020-2024 (CAYm1)', 'entry_year' => 2020, 'graduation_year' => 2024, 'cohort_type' => 'CAYm1', 'sanctioned_intake' => 120, 'admitted_first_year' => 120, 'lateral_admitted_second_year' => 12, 'graduated_without_backlog' => 102, 'graduated_in_stipulated_time' => 122]);
        StudentCohort::create(['program_id' => $prog->id, 'batch_name' => '2019-2023 (CAYm2)', 'entry_year' => 2019, 'graduation_year' => 2023, 'cohort_type' => 'CAYm2', 'sanctioned_intake' => 120, 'admitted_first_year' => 118, 'lateral_admitted_second_year' => 10, 'graduated_without_backlog' => 96, 'graduated_in_stipulated_time' => 116]);
        StudentCohort::create(['program_id' => $prog->id, 'batch_name' => '2018-2022 (CAYm3)', 'entry_year' => 2018, 'graduation_year' => 2022, 'cohort_type' => 'CAYm3', 'sanctioned_intake' => 120, 'admitted_first_year' => 120, 'lateral_admitted_second_year' => 12, 'graduated_without_backlog' => 94, 'graduated_in_stipulated_time' => 114]);

        // Placements (Criterion 4.5)
        StudentPlacement::create(['program_id' => $prog->id, 'academic_year_id' => $cay->id, 'final_year_students' => 122, 'placed_students' => 96, 'higher_studies_students' => 14, 'entrepreneurs_count' => 3, 'median_salary_lpa' => 7.8]);
        StudentPlacement::create(['program_id' => $prog->id, 'academic_year_id' => $caym1->id, 'final_year_students' => 120, 'placed_students' => 92, 'higher_studies_students' => 12, 'entrepreneurs_count' => 2, 'median_salary_lpa' => 7.2]);
        StudentPlacement::create(['program_id' => $prog->id, 'academic_year_id' => $caym2->id, 'final_year_students' => 118, 'placed_students' => 88, 'higher_studies_students' => 15, 'entrepreneurs_count' => 2, 'median_salary_lpa' => 6.5]);

        // 10. Financial Budgets (Criterion 10)
        $cfyBudget = FinancialBudget::create([
            'institution_id' => $inst->id,
            'program_id' => $prog->id,
            'academic_year_id' => $cay->id,
            'financial_year_name' => '2024-25 (CFY)',
            'cfy_type' => 'CFY',
            'total_budget_allocated' => 8500000.00,
            'total_actual_expenditure' => 7950000.00,
            'utilization_percentage' => 93.53,
        ]);
        BudgetItem::create(['financial_budget_id' => $cfyBudget->id, 'category' => 'Recurring', 'sub_category' => 'Faculty & Staff Salaries', 'budget_allocated' => 5200000.00, 'actual_expenditure' => 5180000.00]);
        BudgetItem::create(['financial_budget_id' => $cfyBudget->id, 'category' => 'Recurring', 'sub_category' => 'Software Licenses, Cloud & Subscriptions', 'budget_allocated' => 800000.00, 'actual_expenditure' => 780000.00]);
        BudgetItem::create(['financial_budget_id' => $cfyBudget->id, 'category' => 'Recurring', 'sub_category' => 'R&D, Conferences & Faculty Travel', 'budget_allocated' => 500000.00, 'actual_expenditure' => 490000.00]);
        BudgetItem::create(['financial_budget_id' => $cfyBudget->id, 'category' => 'Non-Recurring', 'sub_category' => 'AI & GPU Lab Infrastructure Upgrade', 'budget_allocated' => 2000000.00, 'actual_expenditure' => 1500000.00]);

        $cfym1Budget = FinancialBudget::create([
            'institution_id' => $inst->id,
            'program_id' => $prog->id,
            'academic_year_id' => $caym1->id,
            'financial_year_name' => '2023-24 (CFYm1)',
            'cfy_type' => 'CFYm1',
            'total_budget_allocated' => 7800000.00,
            'total_actual_expenditure' => 7420000.00,
            'utilization_percentage' => 95.13,
        ]);
        BudgetItem::create(['financial_budget_id' => $cfym1Budget->id, 'category' => 'Recurring', 'sub_category' => 'Faculty & Staff Salaries', 'budget_allocated' => 4800000.00, 'actual_expenditure' => 4790000.00]);
        BudgetItem::create(['financial_budget_id' => $cfym1Budget->id, 'category' => 'Non-Recurring', 'sub_category' => 'IoT & Embedded Systems Lab Setup', 'budget_allocated' => 1800000.00, 'actual_expenditure' => 1650000.00]);

        // 11. Master SAR Report
        $sar = SarReport::create([
            'program_id' => $prog->id,
            'academic_year_id' => $cay->id,
            'title' => 'Self-Assessment Report (SAR) for UG Engineering - B.Tech CSE (Tier-II)',
            'current_state' => 'DEPARTMENT_CONSOLIDATION',
            'submitted_by' => 'Dr. S. Narayan (NBA Coordinator)',
            'hod_verified_by' => 'Dr. Arvind Mehra (HOD CSE)',
            'submitted_at' => now()->subDays(5),
            'is_locked' => false,
            'total_claimed_marks' => 842.50,
            'workflow_notes' => 'Faculty mark entries and articulation matrix consolidated. Awaiting institutional review.',
        ]);

        // SAR Criteria 1 to 10 records
        $criteriaData = [
            ['num' => 1, 'title' => 'Vision, Mission and Program Educational Objectives', 'max' => 60, 'claimed' => 54.0],
            ['num' => 2, 'title' => 'Program Curriculum and Teaching-Learning Processes', 'max' => 120, 'claimed' => 108.0],
            ['num' => 3, 'title' => 'Course Outcomes and Program Outcomes', 'max' => 120, 'claimed' => 104.8],
            ['num' => 4, 'title' => "Students' Performance and Placement", 'max' => 150, 'claimed' => 130.0],
            ['num' => 5, 'title' => 'Faculty Information and Contributions', 'max' => 200, 'claimed' => 176.5],
            ['num' => 6, 'title' => 'Facilities and Technical Support', 'max' => 80, 'claimed' => 72.0],
            ['num' => 7, 'title' => 'Continuous Improvement', 'max' => 50, 'claimed' => 43.0],
            ['num' => 8, 'title' => 'First Year Academics', 'max' => 50, 'claimed' => 44.0],
            ['num' => 9, 'title' => 'Student Support Systems', 'max' => 50, 'claimed' => 45.0],
            ['num' => 10, 'title' => 'Governance, Institutional Support & Financial Resources', 'max' => 120, 'claimed' => 108.0],
        ];

        foreach ($criteriaData as $c) {
            SarCriterion::create([
                'sar_report_id' => $sar->id,
                'criterion_number' => $c['num'],
                'title' => "Criterion {$c['num']}: {$c['title']}",
                'max_marks' => $c['max'],
                'claimed_marks' => $c['claimed'],
                'status' => 'VERIFIED',
                'is_verified' => true,
            ]);
        }

        // Audit Logs
        SarAuditLog::create([
            'sar_report_id' => $sar->id,
            'user_name' => 'Dr. S. Narayan',
            'user_role' => 'NBA Coordinator',
            'action' => 'STATE_TRANSITION',
            'domain_module' => 'SAR',
            'payload' => ['from' => 'DRAFT', 'to' => 'DEPARTMENT_CONSOLIDATION'],
            'description' => 'Submitted SAR report for Department Consolidation review.',
            'ip_address' => '192.168.1.45',
        ]);

        SarAuditLog::create([
            'sar_report_id' => $sar->id,
            'user_name' => 'Dr. Arvind Mehra',
            'user_role' => 'HOD',
            'action' => 'METRIC_CALCULATED',
            'domain_module' => 'Faculty',
            'payload' => ['sfr' => '16.9:1', 'fqi' => '22.8/25.0', 'cadre_ratio' => '1:2.3:5.8'],
            'description' => 'Recalculated Criterion 5 SFR and FQI metrics for CAY 2024-25.',
            'ip_address' => '192.168.1.12',
        ]);
    }
}
