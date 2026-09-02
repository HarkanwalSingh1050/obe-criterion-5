<template>
  <div class="space-y-8 max-w-6xl mx-auto pb-12">
    <!-- Header Hero Banner -->
    <div class="glass-card rounded-2xl p-8 bg-gradient-to-br from-slate-900 via-indigo-950/40 to-slate-900 border border-indigo-500/30 relative overflow-hidden shadow-2xl">
      <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="relative z-10 space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-indigo-500/20 border border-indigo-500/40 text-xs font-semibold text-indigo-300">
          <AppIcon name="info" size="14" />
          <span>Interactive Architecture & Flow Graph</span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
          Visual Data Flow Graph & How OBE Calculations Work
        </h2>
        <p class="text-sm text-slate-300 max-w-3xl leading-relaxed">
          Interactive flow diagram showing the complete end-to-end data pipeline from initial syllabus definition and student mark logging to dual-stream attainment calculations and final Tier-II NBA compliance accreditation.
        </p>
      </div>
    </div>

    <!-- Navigation Tabs for Guide -->
    <div class="flex flex-wrap gap-2 border-b border-slate-800 pb-3">
      <button v-for="tab in guideTabs" :key="tab.id"
              @click="activeTab = tab.id"
              class="px-4 py-2 text-xs font-bold rounded-xl transition flex items-center gap-2"
              :class="activeTab === tab.id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60'">
        <AppIcon :name="tab.icon" size="15" />
        <span>{{ tab.label }}</span>
      </button>
    </div>

    <!-- Tab 1: 📊 Interactive Visual Flow Graph -->
    <div v-if="activeTab === 'flow_graph'" class="space-y-6">
      <!-- Main Flow Graph Card -->
      <div class="glass-card rounded-2xl p-6 border border-slate-800 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-4">
          <div>
            <h3 class="text-base font-bold text-white flex items-center gap-2">
              <AppIcon name="matrix" size="18" custom-class="text-indigo-400" />
              <span>NBA SAR End-to-End Visual Data Flow Pipeline</span>
            </h3>
            <p class="text-xs text-slate-400 mt-0.5">
              Click any stage in the flow graph below to inspect the mathematical logic, input requirements, and live destination.
            </p>
          </div>
          <span class="text-xs text-emerald-400 font-mono bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20">
            Interactive Visual Model
          </span>
        </div>

        <!-- Visual Flow Graph Nodes & Animated Connectors -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-3 relative">
          <!-- Flow Step 1 -->
          <div @click="selectedNode = 'step1'"
               class="p-4 rounded-xl cursor-pointer transition flex flex-col justify-between border relative group"
               :class="selectedNode === 'step1' ? 'bg-indigo-600/20 border-indigo-500 shadow-lg shadow-indigo-500/20 ring-1 ring-indigo-500' : 'bg-slate-950/70 border-slate-800 hover:border-slate-700'">
            <div>
              <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-indigo-400">STAGE 1</span>
                <AppIcon name="academic" size="14" custom-class="text-indigo-400" />
              </div>
              <h4 class="text-xs font-bold text-white mt-2">Academics & Intake</h4>
              <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">Sanctioned Intake & Students (UGT1 to UGT4)</p>
            </div>
            <div class="mt-3 text-[10px] font-mono text-indigo-300 flex items-center justify-between">
              <span>Input: Enrolment</span>
              <span>→</span>
            </div>
          </div>

          <!-- Flow Step 2 -->
          <div @click="selectedNode = 'step2'"
               class="p-4 rounded-xl cursor-pointer transition flex flex-col justify-between border relative group"
               :class="selectedNode === 'step2' ? 'bg-indigo-600/20 border-indigo-500 shadow-lg shadow-indigo-500/20 ring-1 ring-indigo-500' : 'bg-slate-950/70 border-slate-800 hover:border-slate-700'">
            <div>
              <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-indigo-400">STAGE 2</span>
                <AppIcon name="courses" size="14" custom-class="text-indigo-400" />
              </div>
              <h4 class="text-xs font-bold text-white mt-2">Courses & COs</h4>
              <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">Course syllabus, Bloom taxonomy & thresholds</p>
            </div>
            <div class="mt-3 text-[10px] font-mono text-indigo-300 flex items-center justify-between">
              <span>Map: CO1 to CO5</span>
              <span>→</span>
            </div>
          </div>

          <!-- Flow Step 3 -->
          <div @click="selectedNode = 'step3'"
               class="p-4 rounded-xl cursor-pointer transition flex flex-col justify-between border relative group"
               :class="selectedNode === 'step3' ? 'bg-indigo-600/20 border-indigo-500 shadow-lg shadow-indigo-500/20 ring-1 ring-indigo-500' : 'bg-slate-950/70 border-slate-800 hover:border-slate-700'">
            <div>
              <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-indigo-400">STAGE 3</span>
                <AppIcon name="matrix" size="14" custom-class="text-indigo-400" />
              </div>
              <h4 class="text-xs font-bold text-white mt-2">Articulation Matrix</h4>
              <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">CO to PO1–PO12 Correlation Heatmap (1, 2, 3)</p>
            </div>
            <div class="mt-3 text-[10px] font-mono text-indigo-300 flex items-center justify-between">
              <span>Weights (1-3)</span>
              <span>→</span>
            </div>
          </div>

          <!-- Flow Step 4 -->
          <div @click="selectedNode = 'step4'"
               class="p-4 rounded-xl cursor-pointer transition flex flex-col justify-between border relative group"
               :class="selectedNode === 'step4' ? 'bg-emerald-600/20 border-emerald-500 shadow-lg shadow-emerald-500/20 ring-1 ring-emerald-500' : 'bg-slate-950/70 border-slate-800 hover:border-slate-700'">
            <div>
              <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-emerald-400">STAGE 4</span>
                <AppIcon name="target" size="14" custom-class="text-emerald-400" />
              </div>
              <h4 class="text-xs font-bold text-white mt-2">Attainment Engine</h4>
              <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">Direct (80% Marks) + Indirect (20% Surveys)</p>
            </div>
            <div class="mt-3 text-[10px] font-mono text-emerald-300 flex items-center justify-between">
              <span>Formula Pipeline</span>
              <span>→</span>
            </div>
          </div>

          <!-- Flow Step 5 -->
          <div @click="selectedNode = 'step5'"
               class="p-4 rounded-xl cursor-pointer transition flex flex-col justify-between border relative group"
               :class="selectedNode === 'step5' ? 'bg-indigo-600/20 border-indigo-500 shadow-lg shadow-indigo-500/20 ring-1 ring-indigo-500' : 'bg-slate-950/70 border-slate-800 hover:border-slate-700'">
            <div>
              <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-indigo-400">STAGE 5</span>
                <AppIcon name="calculator" size="14" custom-class="text-indigo-400" />
              </div>
              <h4 class="text-xs font-bold text-white mt-2">Faculty & Budget</h4>
              <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">SFR (N/F), FQI, Cadre (1:2:6) & Finance</p>
            </div>
            <div class="mt-3 text-[10px] font-mono text-indigo-300 flex items-center justify-between">
              <span>Indices & Criteria</span>
              <span>→</span>
            </div>
          </div>

          <!-- Flow Step 6 -->
          <div @click="selectedNode = 'step6'"
               class="p-4 rounded-xl cursor-pointer transition flex flex-col justify-between border relative group"
               :class="selectedNode === 'step6' ? 'bg-purple-600/20 border-purple-500 shadow-lg shadow-purple-500/20 ring-1 ring-purple-500' : 'bg-slate-950/70 border-slate-800 hover:border-slate-700'">
            <div>
              <div class="flex items-center justify-between text-[10px] font-bold">
                <span class="text-purple-400">STAGE 6</span>
                <AppIcon name="workflow" size="14" custom-class="text-purple-400" />
              </div>
              <h4 class="text-xs font-bold text-white mt-2">1000-Pt SAR Freeze</h4>
              <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">State Machine & Official Print Document</p>
            </div>
            <div class="mt-3 text-[10px] font-mono text-purple-300 flex items-center justify-between">
              <span>Final SAR</span>
              <span>★</span>
            </div>
          </div>
        </div>

        <!-- Node Detail & Mathematical Inspector Box -->
        <div class="p-6 rounded-2xl bg-slate-950/90 border border-indigo-500/40 space-y-4">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-800 pb-3">
            <div>
              <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-indigo-400">{{ activeNodeData.stage }}</span>
              <h4 class="text-base font-bold text-white mt-0.5">{{ activeNodeData.title }}</h4>
            </div>
            <button @click="$emit('navigate', activeNodeData.targetView)"
                    class="px-4 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold flex items-center gap-2 transition self-start sm:self-auto shadow-md shadow-indigo-600/25">
              <span>Open This Module</span>
              <span>→</span>
            </button>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
            <!-- 1. Inputs required -->
            <div class="p-3.5 rounded-xl bg-slate-900 border border-slate-800 space-y-1.5">
              <div class="font-bold text-slate-300 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                <span>1. Inputs Required</span>
              </div>
              <p class="text-slate-400 leading-relaxed">{{ activeNodeData.inputs }}</p>
            </div>

            <!-- 2. Logic & Formula -->
            <div class="p-3.5 rounded-xl bg-slate-900 border border-slate-800 space-y-1.5">
              <div class="font-bold text-emerald-400 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>2. Engine Logic & Formula</span>
              </div>
              <p class="text-emerald-300 font-mono text-[11px] leading-relaxed">{{ activeNodeData.formula }}</p>
            </div>

            <!-- 3. Output Produced -->
            <div class="p-3.5 rounded-xl bg-slate-900 border border-slate-800 space-y-1.5">
              <div class="font-bold text-purple-400 flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                <span>3. Compliance Output</span>
              </div>
              <p class="text-slate-300 leading-relaxed">{{ activeNodeData.output }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 2: 🚀 7-Step SAR Workflow Guide -->
    <div v-if="activeTab === 'workflow_guide'" class="space-y-6">
      <div class="glass-card rounded-2xl p-6 border border-slate-800 space-y-6">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
          <AppIcon name="workflow" size="18" custom-class="text-emerald-400" />
          <span>7-Step Operational Lifecycle for Accreditation</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Step 1 -->
          <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Step 1</span>
              <span class="text-[10px] text-purple-400 font-semibold">Super Admin</span>
            </div>
            <h4 class="text-sm font-bold text-white">System Setup & Staff Directory</h4>
            <p class="text-xs text-slate-400 leading-relaxed">
              Create staff accounts, assign roles (HOD, Faculty, IQAC), configure institution details, and upload logos, photos, and browser favicons in System Settings.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Step 2</span>
              <span class="text-[10px] text-indigo-400 font-semibold">HOD / Faculty</span>
            </div>
            <h4 class="text-sm font-bold text-white">Course Catalog & CO Definitions</h4>
            <p class="text-xs text-slate-400 leading-relaxed">
              Define syllabus courses across semesters (Sem 1 to 8) and add Course Outcomes (CO1 to CO5) with Bloom taxonomy levels and pass threshold targets (e.g., 60%).
            </p>
          </div>

          <!-- Step 3 -->
          <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Step 3</span>
              <span class="text-[10px] text-indigo-400 font-semibold">Faculty / Coordinator</span>
            </div>
            <h4 class="text-sm font-bold text-white">CO-PO Articulation Matrix Mapping</h4>
            <p class="text-xs text-slate-400 leading-relaxed">
              Map each Course Outcome to Program Outcomes (PO1 to PO12) and Specific Outcomes (PSO1, PSO2) with correlation levels (1=Low, 2=Medium, 3=High).
            </p>
          </div>

          <!-- Step 4 -->
          <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Step 4</span>
              <span class="text-[10px] text-emerald-400 font-semibold">Course Faculty</span>
            </div>
            <h4 class="text-sm font-bold text-white">Assessment Mark Entry & Direct Attainment</h4>
            <p class="text-xs text-slate-400 leading-relaxed">
              Record student assessment mark batches (Internal Tests, Assignments, End Sem Exams). The engine computes CIE & SEE percentage rates and CO direct attainment levels (1.0 to 3.0).
            </p>
          </div>

          <!-- Step 5 -->
          <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Step 5</span>
              <span class="text-[10px] text-indigo-400 font-semibold">HOD & Program Lead</span>
            </div>
            <h4 class="text-sm font-bold text-white">Criterion 5 Faculty Indices Simulation</h4>
            <p class="text-xs text-slate-400 leading-relaxed">
              Compute Student-Faculty Ratio (SFR = N/F), Faculty Qualification Index (FQI), and 1:2:6 cadre proportion ratio with real-time what-if simulators.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="p-4 rounded-xl bg-slate-950/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between">
              <span class="text-xs font-mono font-bold text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">Step 6</span>
              <span class="text-[10px] text-blue-400 font-semibold">Finance & IQAC</span>
            </div>
            <h4 class="text-sm font-bold text-white">Financial Resource Auditing & Criteria 1-10</h4>
            <p class="text-xs text-slate-400 leading-relaxed">
              Track 3-year recurring/non-recurring capital expenditure, verify student placement rates, and review all 10 criteria self-assessment scores against the 1000-point total.
            </p>
          </div>
        </div>

        <!-- Step 7 Highlight -->
        <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-950/80 to-purple-950/80 border border-indigo-500/30 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div>
            <div class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Step 7: Final Institutional Review & Export</div>
            <div class="text-sm font-bold text-white mt-1">Approval State Machine → Official Printable SAR Document</div>
            <p class="text-xs text-slate-300 mt-0.5">
              IQAC freezes and approves the report. Generate official Tier-II SAR document with print-ready tables and compliance audit trail.
            </p>
          </div>
          <button @click="$emit('navigate', 'workflow')" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold shrink-0">
            Open State Machine
          </button>
        </div>
      </div>
    </div>

    <!-- Tab 3: 📐 Mathematical Calculation Models -->
    <div v-if="activeTab === 'math_models'" class="space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- SFR Formula Card -->
        <div class="glass-card rounded-xl p-5 border border-slate-800 space-y-3">
          <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-white flex items-center gap-2">
              <AppIcon name="calculator" size="16" custom-class="text-indigo-400" />
              <span>Student-Faculty Ratio (SFR)</span>
            </h4>
            <span class="text-xs font-bold text-emerald-400">Criterion 5.1 • 20 Marks</span>
          </div>

          <div class="p-3 rounded-lg bg-slate-950 border border-slate-800 font-mono text-xs text-indigo-300">
            SFR = N / F <br />
            Where N = UGT₁ + UGT₂ + UGT₃ (Total 2nd, 3rd, 4th Yr Students) <br />
            F = Total Full-Time Faculty in Department
          </div>

          <div class="text-xs text-slate-300 space-y-1">
            <p><strong>Scoring Model:</strong></p>
            <ul class="list-disc list-inside text-slate-400 space-y-0.5">
              <li>SFR ≤ 15:1 ⇒ Full 20.0 Marks</li>
              <li>15 &lt; SFR ≤ 20 ⇒ Marks = 20 × (15 / SFR)</li>
              <li>20 &lt; SFR ≤ 25 ⇒ Marks = 20 × (15 / SFR) × 0.8</li>
              <li>SFR &gt; 25:1 ⇒ 0 Marks (Accreditation Red Flag)</li>
            </ul>
          </div>
        </div>

        <!-- FQI Formula Card -->
        <div class="glass-card rounded-xl p-5 border border-slate-800 space-y-3">
          <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-white flex items-center gap-2">
              <AppIcon name="calculator" size="16" custom-class="text-indigo-400" />
              <span>Faculty Qualification Index (FQI)</span>
            </h4>
            <span class="text-xs font-bold text-emerald-400">Criterion 5.3 • 25 Marks</span>
          </div>

          <div class="p-3 rounded-lg bg-slate-950 border border-slate-800 font-mono text-xs text-indigo-300">
            FQI = 2.5 × [ (10X + 4Y) / RF ] <br />
            Where X = Regular Faculty with Ph.D. <br />
            Y = Regular Faculty with M.Tech / ME <br />
            RF = Required Faculty for SFR of 15:1 (N / 15)
          </div>

          <div class="text-xs text-slate-300 space-y-1">
            <p><strong>Scoring Model:</strong></p>
            <ul class="list-disc list-inside text-slate-400 space-y-0.5">
              <li>Ph.D. holders receive weight of 10 points.</li>
              <li>M.Tech holders receive weight of 4 points.</li>
              <li>Claimed marks capped at maximum 25.0 Marks.</li>
            </ul>
          </div>
        </div>

        <!-- Attainment Formula Card -->
        <div class="glass-card rounded-xl p-5 border border-slate-800 space-y-3">
          <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-white flex items-center gap-2">
              <AppIcon name="target" size="16" custom-class="text-indigo-400" />
              <span>PO & PSO Attainment Integration</span>
            </h4>
            <span class="text-xs font-bold text-emerald-400">Criterion 3.3 • 120 Marks</span>
          </div>

          <div class="p-3 rounded-lg bg-slate-950 border border-slate-800 font-mono text-xs text-indigo-300">
            Direct Attainment = (0.20 × CIE) + (0.80 × SEE) <br />
            Final PO Attainment = (0.80 × Direct) + (0.20 × Indirect)
          </div>

          <div class="text-xs text-slate-300 space-y-1">
            <p><strong>NBA Attainment Thresholds:</strong></p>
            <ul class="list-disc list-inside text-slate-400 space-y-0.5">
              <li>Level 3: ≥ 70% of students meet/exceed target threshold.</li>
              <li>Level 2: ≥ 60% of students meet/exceed target threshold.</li>
              <li>Level 1: ≥ 50% of students meet/exceed target threshold.</li>
            </ul>
          </div>
        </div>

        <!-- Cadre Proportion Card -->
        <div class="glass-card rounded-xl p-5 border border-slate-800 space-y-3">
          <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-white flex items-center gap-2">
              <AppIcon name="users" size="16" custom-class="text-indigo-400" />
              <span>Cadre Proportion Ratio (1:2:6)</span>
            </h4>
            <span class="text-xs font-bold text-emerald-400">Criterion 5.2 • 25 Marks</span>
          </div>

          <div class="p-3 rounded-lg bg-slate-950 border border-slate-800 font-mono text-xs text-indigo-300">
            Target Cadre Ratio = 1 Professor : 2 Assoc. Prof : 6 Asst. Prof <br />
            Cadre Score = 25 × [ (AF₁/RF₁) + (AF₂/RF₂)×0.6 + (AF₃/RF₃)×0.4 ] / 2
          </div>

          <div class="text-xs text-slate-300 space-y-1">
            <p><strong>Cadre Requirement:</strong></p>
            <ul class="list-disc list-inside text-slate-400 space-y-0.5">
              <li>Maintains appropriate academic leadership hierarchy.</li>
              <li>Capped at maximum 25.0 Marks.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab 4: 🏛️ Architecture & System Layout -->
    <div v-if="activeTab === 'architecture'" class="space-y-6">
      <div class="glass-card rounded-2xl p-6 border border-slate-800 space-y-6">
        <div>
          <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <AppIcon name="criteria" size="18" custom-class="text-indigo-400" />
            <span>Domain-Driven Design (DDD) Modular Architecture</span>
          </h3>
          <p class="text-xs text-slate-400 mt-1">
            All business calculations and compliance evaluations live in pure domain services decoupled from HTTP controllers.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
          <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
            <div class="font-bold text-indigo-400 font-mono">app/Domains/Academic</div>
            <p class="text-slate-400">Institution, Department, Program, AcademicYear (CAY, CAYm1, CAYm2), and AcademicIntake (UGT1 to UGT4).</p>
          </div>

          <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
            <div class="font-bold text-indigo-400 font-mono">app/Domains/Curriculum</div>
            <p class="text-slate-400">Courses, Program Outcomes (PO1-12), PSOs (1-2), Course Outcomes (CO1-5), and Articulation Matrix mappings.</p>
          </div>

          <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
            <div class="font-bold text-indigo-400 font-mono">app/Domains/Attainment</div>
            <p class="text-slate-400">CIE/SEE Student Assessments, Indirect Surveys, DirectAttainmentService, and AttainmentEngine (0.8Direct + 0.2Indirect).</p>
          </div>

          <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
            <div class="font-bold text-indigo-400 font-mono">app/Domains/Faculty</div>
            <p class="text-slate-400">Faculty Profiles, FDPs, Publications, SfrCalculatorService, FqiCalculatorService, and CadreRatioCalculatorService.</p>
          </div>

          <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
            <div class="font-bold text-indigo-400 font-mono">app/Domains/Student</div>
            <p class="text-slate-400">Graduation Batches, SuccessRateCalculatorService, and PlacementIndexService.</p>
          </div>

          <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
            <div class="font-bold text-indigo-400 font-mono">app/Domains/SAR</div>
            <p class="text-slate-400">1000-Mark Compiler, SarStateMachine (Draft to Dept to IQAC to Locked), and immutable audit trail.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppIcon from './AppIcon.vue';

export default {
  name: 'AboutSystemView',
  components: { AppIcon },
  data() {
    return {
      activeTab: 'flow_graph',
      selectedNode: 'step4',
      guideTabs: [
        { id: 'flow_graph', label: 'Interactive Data Flow Graph', icon: 'matrix' },
        { id: 'workflow_guide', label: '7-Step SAR Workflow', icon: 'workflow' },
        { id: 'math_models', label: 'Formulas & Mathematical Models', icon: 'calculator' },
        { id: 'architecture', label: 'DDD Architecture & System Layout', icon: 'criteria' },
      ],
      nodesData: {
        step1: {
          stage: 'Stage 1 of 6 • Academic Setup',
          title: 'Student Intake, Cohorts & Academic Years',
          targetView: 'academics',
          inputs: 'Sanctioned intake (e.g. 120), CAY, CAYm1, CAYm2 student enrolment counts (UGT1, UGT2, UGT3, UGT4) and lateral entry numbers.',
          formula: 'N = UGT1 + UGT2 + UGT3\nTotal Cohort = Sanctioned + Lateral Entry',
          output: 'Establishes the base student population (N) used across SFR, FQI, graduation success rates, and budget allocations.',
        },
        step2: {
          stage: 'Stage 2 of 6 • Curriculum Design',
          title: 'Courses Catalog & Course Outcomes (COs)',
          targetView: 'courses',
          inputs: 'Course codes (CS101–CS808), semester, credits, lecture/practical hours, and 5–6 Course Outcomes with Bloom taxonomy levels.',
          formula: 'Target Threshold = ≥ 60% Marks\nTarget Level = 2.5 / 3.0',
          output: 'Provides structured competencies and measurable targets for student assessment and evaluation.',
        },
        step3: {
          stage: 'Stage 3 of 6 • Outcome Articulation',
          title: 'CO-PO & PSO Articulation Matrix Heatmap',
          targetView: 'matrix',
          inputs: 'Correlation levels between each CO and NBA Graduate Attributes (PO1 to PO12) + Department PSOs (PSO1–PSO2).',
          formula: 'Correlation Scale: 1 = Low (Slight), 2 = Moderate, 3 = Substantial (High)',
          output: 'Generates the program master correlation matrix used to weigh direct student mark contributions to PO scores.',
        },
        step4: {
          stage: 'Stage 4 of 6 • Dual Attainment Engine',
          title: 'Direct Marks & Indirect Survey Evaluation Engine',
          targetView: 'attainment',
          inputs: 'Faculty CIE marks (Test 1, Test 2, Assignments), SEE exam scores, and stakeholder Exit/Alumni/Employer surveys.',
          formula: 'Direct = (0.20 × CIE) + (0.80 × SEE)\nFinal PO = (0.80 × Direct) + (0.20 × Indirect)',
          output: 'Computes exact 3.0-scale achievement for PO1–PO12 and PSO1–PSO2 with benchmark attainment threshold flags.',
        },
        step5: {
          stage: 'Stage 5 of 6 • Faculty & Governance',
          title: 'Faculty Indices (SFR, FQI, Cadre) & Financial Auditing',
          targetView: 'sfr_fqi',
          inputs: 'Faculty headcounts, Ph.D./M.Tech qualifications, cadre designations (1:2:6), and 3-year recurring/non-recurring budgets.',
          formula: 'SFR = N / F  (≤ 15:1 → 20 pts)\nFQI = 2.5 × ((10X + 4Y)/RF)  (Max 25 pts)',
          output: 'Provides live mathematical simulations for Criterion 5 & 10 and auto-calculates claimed scores out of 1000 points.',
        },
        step6: {
          stage: 'Stage 6 of 6 • SAR Freeze & Audit',
          title: '1000-Point Score Compilation & State Machine',
          targetView: 'workflow',
          inputs: 'Consolidated Criterion 1–10 self-assessment scores and digital signatures from HOD and IQAC Director.',
          formula: 'Total = ∑ (Criteria 1 to 10 Claimed Marks) / 1000.0 Marks\nThreshold: ≥ 750 (6-Yr Full Accreditation)',
          output: 'Locks and freezes SAR with an immutable audit log and exports the official Tier-II NBA SAR compliance report.',
        },
      },
    };
  },
  computed: {
    activeNodeData() {
      return this.nodesData[this.selectedNode] || this.nodesData.step4;
    },
  },
};
</script>
