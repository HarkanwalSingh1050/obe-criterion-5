# NBA Self-Assessment Report (SAR) Platform

An autonomous, enterprise-grade NBA Self-Assessment Report (SAR) & Outcome-Based Education (OBE) platform engineered with **Domain-Driven Design (DDD)**, pure mathematical calculation services, reactive **Vue 3 + Vite** interface, and modular REST APIs.

---

## 🏛️ Domain-Driven Design (DDD) Architecture

The platform isolates business calculations, OBE attainment matrices, and state progression under `app/Domains/`:

```
app/
├── Domains/
│   ├── Academic/       # Institution, Department, Program, AcademicYear (CAY, CAYm1, CAYm2), AcademicIntake
│   ├── Faculty/        # FacultyProfile, FacultyAcademicYear, FDPs, Publications
│   │   └── Services/   # SfrCalculatorService, FqiCalculatorService, CadreRatioCalculatorService
│   ├── Curriculum/     # Course, ProgramOutcome (PO1-12), PSO (PSO1-2), CourseOutcome (CO1-5), CoPoMapping
│   │   └── Services/   # ArticulationMatrixService
│   ├── Attainment/     # StudentAssessment (CIE/SEE), IndirectAssessment (Surveys), AttainmentResult
│   │   └── Services/   # DirectAttainmentService, IndirectAttainmentService, AttainmentEngine
│   ├── Student/        # StudentCohort (Graduation Success), StudentPlacement (Placement/Higher Studies)
│   │   └── Services/   # SuccessRateCalculatorService, PlacementIndexService
│   ├── Finance/        # FinancialBudget (CFY, CFYm1, CFYm2), BudgetItem (Recurring/Non-recurring)
│   │   └── Services/   # BudgetAnalysisService
│   └── SAR/            # SarReport, SarCriterion (1 to 10), SarAuditLog
│       ├── StateMachine/ # SarStateMachine (DRAFT -> DEPT -> INST -> LOCKED -> ARCHIVED)
│       └── Services/     # SarReportCompilerService (1000-point aggregation)
├── Http/
│   └── Controllers/Api/V1/ # RESTful JSON APIs for all domains
└── ...
```

---

## 🚀 Porting / Moving to Acadicron-ERP (`Acadicron-ERP-new`)

This project was built to be **100% modular and decoupled**. When you want to port this into `Acadicron-ERP-new`:

1. **Backend**:
   - Copy `app/Domains/` directly into `Acadicron-ERP-new/app/Domains/` (or `app/Modules/NBA/`).
   - Copy `app/Http/Controllers/Api/V1/` into `Acadicron-ERP-new/app/Http/Controllers/Api/V1/`.
   - Copy the migrations in `database/migrations/2025_01_01_000001_...` to `Acadicron-ERP-new/database/migrations/`.
   - Add the routes from `routes/api.php` to Acadicron's API route file.

2. **Frontend**:
   - Copy `resources/js/components/` into Acadicron's Vue component folder.
   - All components interact exclusively through the `/api/v1/nba/...` REST endpoints, meaning no tight coupling with Blade session logic or database drivers!

---

## 📐 Mathematical Engines & Formulas Implemented

### 1. Student-Faculty Ratio ($SFR$) Engine
$$SFR = \frac{N}{F} = \frac{UGT_1 + UGT_2 + UGT_3}{F}$$
- **Evaluation Criteria**: $\le 15:1 \to 20\text{ Marks}$, $15:1 \text{ to } 20:1 \to 20 \times (15 / SFR)$, $> 25:1 \to 0\text{ Marks}$.

### 2. Faculty Qualification Index ($FQI$) Engine
$$FQI = 2.5 \times \left( \frac{10X + 4Y}{RF} \right)$$
- $X$ = Regular Faculty with Ph.D.
- $Y$ = Regular Faculty with M.Tech / M.E.
- $RF$ = Required Faculty based on standard $SFR = 20:1$ ($RF = \lceil N / 20 \rceil$). Max marks = $25.0$.

### 3. Cadre Proportion Ratio Engine
- Standard Target Ratio: $1 : 2 : 6$ (Professors : Associate Professors : Assistant Professors).
- Pro-rata calculation based on $AF_1 / RF_1, AF_2 / RF_2, AF_3 / RF_3$. Max marks = $25.0$.

### 4. CO-PO Attainment Calculation Pipeline
$$Final\_PO\_Attainment = (0.80 \times Direct\_Attainment) + (0.20 \times Indirect\_Attainment)$$
- **Direct Attainment**: $20\% \text{ CIE (Internal Tests/Assignments)} + 80\% \text{ SEE (End Semester Exam)}$.
- **Indirect Attainment**: $50\% \text{ Exit Survey} + 30\% \text{ Alumni Survey} + 20\% \text{ Employer Survey}$.
- Aggregated across all courses using the Course-PO Articulation Correlation Matrix ($1, 2, 3$).

### 5. SAR Workflow State Machine & Audit Trail
```
[DRAFT] ───> [DEPARTMENT_CONSOLIDATION] ───> [INSTITUTIONAL_REVIEW] ───> [APPROVED_LOCKED] ───> [ARCHIVED]
```
- Immutable event logging into `sar_audit_logs` tracking every state change, matrix update, and calculation run.

---

## ⚡ Quick Start Instructions

1. **Install & Prepare Database**:
   ```bash
   php artisan migrate --seed
   ```
2. **Build Frontend**:
   ```bash
   npm run build
   # Or for hot module reload:
   npm run dev
   ```
3. **Start Server**:
   ```bash
   php artisan serve
   ```
4. Open your browser at `http://localhost:8000`.

---

## 🧪 Automated Test Suite

Run the full suite of automated tests verifying all calculation engines and APIs:
```bash
php artisan test
```
All 10 feature tests pass with 51 assertions.
