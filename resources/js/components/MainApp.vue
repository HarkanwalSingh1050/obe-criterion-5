<template>
  <div class="min-h-screen bg-slate-950 text-slate-100 flex flex-col font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Top Global Header -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-blue-500 to-emerald-400 p-[2px] shadow-lg shadow-indigo-500/20">
            <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center font-black text-indigo-400 text-lg">
              NBA
            </div>
          </div>
          <div>
            <div class="flex items-center space-x-2">
              <h1 class="font-bold text-lg tracking-tight text-white flex items-center gap-2">
                SAR Platform <span class="text-xs px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 font-semibold border border-indigo-500/30">DDD v2.0</span>
              </h1>
            </div>
            <p class="text-xs text-slate-400">Tier-II UG Engineering Self-Assessment & Compliance Engine</p>
          </div>
        </div>

        <!-- Current SAR Status Badge & Quick Stats -->
        <div class="hidden md:flex items-center space-x-4">
          <div class="text-right">
            <div class="text-xs text-slate-400">Accreditation Cycle</div>
            <div class="text-sm font-semibold text-emerald-400">{{ sarData.academic_year || '2024-25 (CAY)' }}</div>
          </div>
          <div class="h-8 w-px bg-slate-800"></div>
          <div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold tracking-wide border shadow-sm"
                  :class="statusBadgeClass(sarData.current_state)">
              <span class="w-2 h-2 rounded-full mr-2" :class="statusDotClass(sarData.current_state)"></span>
              {{ formatState(sarData.current_state) }}
            </span>
          </div>
          <button @click="printSar" class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold flex items-center gap-1.5 shadow-lg shadow-indigo-600/25 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print / Export SAR
          </button>
        </div>
      </div>

      <!-- Navigation Tabs -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex space-x-1 overflow-x-auto border-t border-slate-800/80 scrollbar-none py-1">
        <button v-for="tab in tabs" :key="tab.id"
                @click="activeTab = tab.id"
                class="px-4 py-2 text-xs font-medium rounded-lg whitespace-nowrap transition-all duration-200 flex items-center gap-2"
                :class="activeTab === tab.id ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50'">
          <span>{{ tab.icon }}</span>
          <span>{{ tab.label }}</span>
          <span v-if="tab.badge" class="ml-1 px-1.5 py-0.2 rounded bg-indigo-500/30 text-[10px] text-indigo-200">{{ tab.badge }}</span>
        </button>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <!-- Loading State -->
      <div v-if="loading" class="flex flex-col items-center justify-center py-24 space-y-4">
        <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
        <div class="text-sm text-slate-400">Loading SAR Domain Calculations & Matrices...</div>
      </div>

      <!-- Tab Content Views -->
      <div v-else>
        <!-- 1. Executive Overview -->
        <section v-if="activeTab === 'overview'">
          <ExecutiveDashboard :sar="sarData" @navigate="(tab) => activeTab = tab" />
        </section>

        <!-- 2. SFR & FQI Engine (Criterion 5) -->
        <section v-if="activeTab === 'sfr_fqi'">
          <SfrSimulator :sfr="sarData.live_engines?.sfr" :program="sarData.program" />
          <div class="my-8 border-t border-slate-800"></div>
          <FqiSimulator :fqi="sarData.live_engines?.fqi" :cadre="sarData.live_engines?.cadre" :program="sarData.program" />
        </section>

        <!-- 3. Curriculum & Articulation Matrix (Criterion 2 & 3) -->
        <section v-if="activeTab === 'matrix'">
          <ArticulationMatrixEditor :program-id="sarData.program?.id" @updated="refreshData" />
        </section>

        <!-- 4. Direct & Indirect Attainment (Criterion 3) -->
        <section v-if="activeTab === 'attainment'">
          <AttainmentDashboard :attainment="sarData.live_engines?.attainment" :program-id="sarData.program?.id" />
        </section>

        <!-- 5. Criteria 1 to 10 Breakdown -->
        <section v-if="activeTab === 'criteria'">
          <CriteriaExplorer :criteria="sarData.criteria" :sar="sarData" />
        </section>

        <!-- 6. SAR Workflow & Audit Trail -->
        <section v-if="activeTab === 'workflow'">
          <SarWorkflowPanel :report-id="sarData.report_id" @state-changed="refreshData" />
        </section>

        <!-- 7. Official Printable SAR Document -->
        <section v-if="activeTab === 'document'">
          <PrintableSarReport :sar="sarData" />
        </section>
      </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-900 bg-slate-950 py-4 text-center text-xs text-slate-500">
      <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
        <div>
          Autonomous OBE & NBA Self-Assessment Engine • Domain-Driven Design (DDD)
        </div>
        <div class="flex items-center space-x-3 text-slate-400">
          <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> API Endpoints Active</span>
          <span>•</span>
          <span>Acadicron-ERP Module Compatible</span>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
import axios from 'axios';
import ExecutiveDashboard from './ExecutiveDashboard.vue';
import SfrSimulator from './SfrSimulator.vue';
import FqiSimulator from './FqiSimulator.vue';
import ArticulationMatrixEditor from './ArticulationMatrixEditor.vue';
import AttainmentDashboard from './AttainmentDashboard.vue';
import CriteriaExplorer from './CriteriaExplorer.vue';
import SarWorkflowPanel from './SarWorkflowPanel.vue';
import PrintableSarReport from './PrintableSarReport.vue';

export default {
  name: 'MainApp',
  components: {
    ExecutiveDashboard,
    SfrSimulator,
    FqiSimulator,
    ArticulationMatrixEditor,
    AttainmentDashboard,
    CriteriaExplorer,
    SarWorkflowPanel,
    PrintableSarReport,
  },
  data() {
    return {
      loading: true,
      activeTab: 'overview',
      sarData: {},
      tabs: [
        { id: 'overview', label: 'Executive Dashboard', icon: '📊', badge: '1000 Pts' },
        { id: 'sfr_fqi', label: 'SFR & FQI Engines (Crit 5)', icon: '📐' },
        { id: 'matrix', label: 'Articulation Matrix (CO-PO)', icon: '🗺️' },
        { id: 'attainment', label: 'Direct / Indirect Attainment', icon: '🎯' },
        { id: 'criteria', label: 'Criteria 1 - 10 Breakdown', icon: '📑' },
        { id: 'workflow', label: 'SAR Workflow & Audit', icon: '🛡️' },
        { id: 'document', label: 'Printable Official Report', icon: '🖨️' },
      ],
    };
  },
  mounted() {
    this.fetchDashboardData();
  },
  methods: {
    async fetchDashboardData() {
      this.loading = true;
      try {
        const response = await axios.get('/api/v1/nba/dashboard');
        if (response.data && response.data.success) {
          this.sarData = response.data.data;
        }
      } catch (error) {
        console.error('Failed to load SAR dashboard data:', error);
      } finally {
        this.loading = false;
      }
    },
    refreshData() {
      this.fetchDashboardData();
    },
    formatState(state) {
      if (!state) return 'Draft';
      return state.replace(/_/g, ' ');
    },
    statusBadgeClass(state) {
      switch (state) {
        case 'APPROVED_LOCKED':
          return 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30';
        case 'INSTITUTIONAL_REVIEW':
          return 'bg-purple-500/10 text-purple-400 border-purple-500/30';
        case 'DEPARTMENT_CONSOLIDATION':
          return 'bg-amber-500/10 text-amber-400 border-amber-500/30';
        case 'ARCHIVED':
          return 'bg-slate-500/10 text-slate-400 border-slate-500/30';
        default:
          return 'bg-blue-500/10 text-blue-400 border-blue-500/30';
      }
    },
    statusDotClass(state) {
      switch (state) {
        case 'APPROVED_LOCKED': return 'bg-emerald-400 animate-pulse';
        case 'INSTITUTIONAL_REVIEW': return 'bg-purple-400';
        case 'DEPARTMENT_CONSOLIDATION': return 'bg-amber-400';
        default: return 'bg-blue-400';
      }
    },
    printSar() {
      this.activeTab = 'document';
      this.$nextTick(() => {
        window.print();
      });
    },
  },
};
</script>
