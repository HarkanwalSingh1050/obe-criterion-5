<template>
  <div>
    <!-- 1. If Not Authenticated -> Show Login View -->
    <LoginView v-if="!currentUser" @authenticated="handleAuthenticated" />

    <!-- 2. If Authenticated -> Full Enterprise Multi-View Dashboard -->
    <div v-else class="min-h-screen bg-slate-950 text-slate-100 flex font-sans selection:bg-indigo-500 selection:text-white">
      <!-- Collapsible Sidebar -->
      <aside class="w-64 bg-slate-900/95 border-r border-slate-800 flex flex-col shrink-0 z-40 transition-all duration-300">
        <!-- Sidebar Brand Header -->
        <div class="h-16 px-4 flex items-center space-x-3 border-b border-slate-800">
          <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 via-blue-500 to-emerald-400 p-[2px] shadow-lg shadow-indigo-500/20">
            <div class="w-full h-full bg-slate-950 rounded-[9px] flex items-center justify-center font-black text-indigo-400 text-sm">
              NBA
            </div>
          </div>
          <div>
            <h1 class="font-bold text-sm tracking-tight text-white flex items-center gap-1.5">
              SAR Enterprise <span class="text-[10px] px-1.5 py-0.2 rounded bg-indigo-500/20 text-indigo-300 font-semibold border border-indigo-500/30">v2.0</span>
            </h1>
            <p class="text-[10px] text-slate-400 truncate max-w-[140px]">{{ currentUser.department || 'Institution Portal' }}</p>
          </div>
        </div>

        <!-- Sidebar Navigation Links Grouped by Section -->
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6 scrollbar-thin">
          <!-- Section 1: Core Dashboard -->
          <div>
            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Analytics & KPI</div>
            <nav class="space-y-1">
              <button @click="activeView = 'overview'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'overview' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">📊</span>
                <span>Executive Dashboard</span>
              </button>
            </nav>
          </div>

          <!-- Section 2: Administration (Super Admin / HOD Access) -->
          <div>
            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2 flex items-center justify-between">
              <span>Administration</span>
              <span v-if="currentUser.role === 'Super Admin'" class="text-[9px] px-1 rounded bg-purple-500/20 text-purple-300 font-mono">ADMIN</span>
            </div>
            <nav class="space-y-1">
              <button @click="activeView = 'staff'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'staff' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">👥</span>
                <span>Staff & Faculty Management</span>
              </button>
              <button @click="activeView = 'academics'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'academics' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">🏛️</span>
                <span>Programs & Intake (UGT)</span>
              </button>
            </nav>
          </div>

          <!-- Section 3: Curriculum & Attainment -->
          <div>
            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">OBE & Attainment</div>
            <nav class="space-y-1">
              <button @click="activeView = 'matrix'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'matrix' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">🗺️</span>
                <span>Articulation Matrix (CO-PO)</span>
              </button>
              <button @click="activeView = 'attainment'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'attainment' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">🎯</span>
                <span>Attainment Evaluation Engine</span>
              </button>
            </nav>
          </div>

          <!-- Section 4: Criteria Calculation Engines -->
          <div>
            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Calculation Engines</div>
            <nav class="space-y-1">
              <button @click="activeView = 'sfr_fqi'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'sfr_fqi' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">📐</span>
                <span>SFR & FQI Simulator (Crit 5)</span>
              </button>
              <button @click="activeView = 'finance'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'finance' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">💰</span>
                <span>Financial Budgets (Crit 10)</span>
              </button>
              <button @click="activeView = 'criteria'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'criteria' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">📑</span>
                <span>Criteria 1 - 10 Breakdown</span>
              </button>
            </nav>
          </div>

          <!-- Section 5: Compliance & Reporting -->
          <div>
            <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Compliance & Output</div>
            <nav class="space-y-1">
              <button @click="activeView = 'workflow'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'workflow' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">🛡️</span>
                <span>SAR State Machine & Audit</span>
              </button>
              <button @click="activeView = 'document'"
                      class="w-full px-3 py-2 rounded-lg text-xs font-medium flex items-center gap-2.5 transition text-left"
                      :class="activeView === 'document' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 font-semibold' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/60'">
                <span class="text-sm">🖨️</span>
                <span>Official Printable Report</span>
              </button>
            </nav>
          </div>
        </div>

        <!-- Sidebar User Card Footer -->
        <div class="p-3 border-t border-slate-800 bg-slate-950/60">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2 truncate">
              <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white text-xs shrink-0">
                {{ currentUser.name.charAt(0) }}
              </div>
              <div class="truncate">
                <div class="text-xs font-bold text-white truncate">{{ currentUser.name }}</div>
                <div class="text-[10px] text-slate-400">{{ currentUser.role }}</div>
              </div>
            </div>
            <button @click="handleLogout" title="Sign Out"
                    class="text-slate-400 hover:text-rose-400 p-1.5 rounded-lg hover:bg-slate-800 transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
          </div>
        </div>
      </aside>

      <!-- Main App Content Area -->
      <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top Navigation Header -->
        <header class="h-16 bg-slate-900/80 border-b border-slate-800 backdrop-blur-md px-6 flex items-center justify-between sticky top-0 z-30">
          <div class="flex items-center space-x-4">
            <div class="text-xs text-slate-400">
              Active Module: <strong class="text-white capitalize">{{ currentViewTitle }}</strong>
            </div>
          </div>

          <div class="flex items-center space-x-4">
            <!-- Accreditation Status Badge -->
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold tracking-wide border shadow-sm"
                  :class="statusBadgeClass(sarData.current_state)">
              <span class="w-2 h-2 rounded-full mr-2" :class="statusDotClass(sarData.current_state)"></span>
              {{ formatState(sarData.current_state) }}
            </span>

            <!-- Quick Print Button -->
            <button @click="activeView = 'document'"
                    class="px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold flex items-center gap-1.5 shadow-lg shadow-indigo-600/25 transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
              Print SAR
            </button>
          </div>
        </header>

        <!-- Main Workspace Body -->
        <main class="flex-1 overflow-y-auto p-6">
          <div v-if="loading" class="flex flex-col items-center justify-center py-24 space-y-4">
            <div class="w-12 h-12 border-4 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
            <div class="text-sm text-slate-400">Loading SAR Domain Data & Calculations...</div>
          </div>

          <div v-else class="max-w-7xl mx-auto">
            <!-- 1. Executive Analytics View -->
            <section v-if="activeView === 'overview'">
              <ExecutiveDashboard :sar="sarData" @navigate="(view) => activeView = view" />
            </section>

            <!-- 2. Staff Management View -->
            <section v-if="activeView === 'staff'">
              <StaffManagementView />
            </section>

            <!-- 3. Academics & Intake View -->
            <section v-if="activeView === 'academics'">
              <AcademicsIntakeView :sar="sarData" />
            </section>

            <!-- 4. Articulation Matrix View -->
            <section v-if="activeView === 'matrix'">
              <ArticulationMatrixEditor :program-id="sarData.program?.id" @updated="refreshData" />
            </section>

            <!-- 5. Attainment View -->
            <section v-if="activeView === 'attainment'">
              <AttainmentDashboard :attainment="sarData.live_engines?.attainment" :program-id="sarData.program?.id" />
            </section>

            <!-- 6. SFR & FQI Engine View -->
            <section v-if="activeView === 'sfr_fqi'">
              <SfrSimulator :sfr="sarData.live_engines?.sfr" :program="sarData.program" />
              <div class="my-8 border-t border-slate-800"></div>
              <FqiSimulator :fqi="sarData.live_engines?.fqi" :cadre="sarData.live_engines?.cadre" :program="sarData.program" />
            </section>

            <!-- 7. Financial & Governance View -->
            <section v-if="activeView === 'finance'">
              <FinanceGovernanceView :sar="sarData" />
            </section>

            <!-- 8. Criteria 1 to 10 View -->
            <section v-if="activeView === 'criteria'">
              <CriteriaExplorer :criteria="sarData.criteria" :sar="sarData" />
            </section>

            <!-- 9. SAR Workflow View -->
            <section v-if="activeView === 'workflow'">
              <SarWorkflowPanel :report-id="sarData.report_id" @state-changed="refreshData" />
            </section>

            <!-- 10. Printable Official SAR Document -->
            <section v-if="activeView === 'document'">
              <PrintableSarReport :sar="sarData" />
            </section>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import LoginView from './LoginView.vue';
import StaffManagementView from './StaffManagementView.vue';
import ExecutiveDashboard from './ExecutiveDashboard.vue';
import AcademicsIntakeView from './AcademicsIntakeView.vue';
import SfrSimulator from './SfrSimulator.vue';
import FqiSimulator from './FqiSimulator.vue';
import ArticulationMatrixEditor from './ArticulationMatrixEditor.vue';
import AttainmentDashboard from './AttainmentDashboard.vue';
import FinanceGovernanceView from './FinanceGovernanceView.vue';
import CriteriaExplorer from './CriteriaExplorer.vue';
import SarWorkflowPanel from './SarWorkflowPanel.vue';
import PrintableSarReport from './PrintableSarReport.vue';

export default {
  name: 'MainApp',
  components: {
    LoginView,
    StaffManagementView,
    ExecutiveDashboard,
    AcademicsIntakeView,
    SfrSimulator,
    FqiSimulator,
    ArticulationMatrixEditor,
    AttainmentDashboard,
    FinanceGovernanceView,
    CriteriaExplorer,
    SarWorkflowPanel,
    PrintableSarReport,
  },
  data() {
    return {
      currentUser: null,
      loading: true,
      activeView: 'overview',
      sarData: {},
    };
  },
  computed: {
    currentViewTitle() {
      const titles = {
        overview: 'Executive Dashboard & KPI Scores',
        staff: 'Staff & Faculty Management',
        academics: 'Programs & Student Intake Cohorts',
        matrix: 'Curriculum Articulation Matrix (CO-PO)',
        attainment: 'Direct & Indirect Attainment Pipeline',
        sfr_fqi: 'Faculty Indices (SFR & FQI Calculation)',
        finance: 'Financial Resources & Budget Utilization',
        criteria: 'Criteria 1 - 10 Self-Assessment Breakdown',
        workflow: 'SAR Approval State Machine & Audit Trail',
        document: 'Official NBA Tier-II SAR Report Document',
      };
      return titles[this.activeView] || this.activeView;
    },
  },
  mounted() {
    this.checkAuth();
  },
  methods: {
    async checkAuth() {
      try {
        const res = await axios.get('/api/v1/auth/me');
        if (res.data && res.data.success && res.data.authenticated) {
          this.currentUser = res.data.user;
          this.fetchDashboardData();
        } else {
          this.currentUser = null;
          this.loading = false;
        }
      } catch (err) {
        this.currentUser = null;
        this.loading = false;
      }
    },
    handleAuthenticated(user) {
      this.currentUser = user;
      this.fetchDashboardData();
    },
    async handleLogout() {
      try {
        await axios.post('/api/v1/auth/logout');
      } catch (err) {
        console.error('Logout error:', err);
      } finally {
        this.currentUser = null;
      }
    },
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
  },
};
</script>
