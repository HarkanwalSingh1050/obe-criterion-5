<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-blue-500/10 text-blue-400 text-xs font-semibold border border-blue-500/20">
          Criterion 5.1 • 20 Marks
        </div>
        <h3 class="text-xl font-bold text-white mt-1">
          Student-Faculty Ratio (SFR) Calculation & Simulator
        </h3>
        <p class="text-xs text-slate-400 mt-0.5">
          Formula: <code class="text-indigo-300 font-mono">SFR = N / F</code> where <code class="text-indigo-300 font-mono">N = UGT1 + UGT2 + UGT3</code> (across CAY, CAYm1, CAYm2)
        </p>
      </div>

      <!-- Live Score Badge -->
      <div class="flex items-center space-x-3 bg-slate-900 border border-slate-800 px-4 py-2 rounded-xl">
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">Claimed Score</div>
          <div class="text-xl font-black text-emerald-400">
            {{ sfr?.claimed_marks || 0 }} <span class="text-xs text-slate-400 font-normal">/ 20.0</span>
          </div>
        </div>
        <div class="h-8 w-px bg-slate-800"></div>
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">3-Year Average SFR</div>
          <div class="text-xl font-black text-indigo-400">
            {{ sfr?.avg_sfr || 0 }} : 1
          </div>
        </div>
      </div>
    </div>

    <!-- 3-Year Historical Academic Table -->
    <div class="glass-card rounded-xl overflow-hidden border border-slate-800">
      <div class="px-4 py-3 bg-slate-900/80 border-b border-slate-800 flex items-center justify-between">
        <h4 class="text-xs font-bold text-slate-200 uppercase tracking-wider">
          Historical Student Intake & Faculty Allocation (3-Year Cycle)
        </h4>
        <span class="text-xs text-emerald-400 font-medium">Compliance Target: SFR ≤ 15:1</span>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-950/60 text-slate-400 uppercase text-[10px] font-semibold border-b border-slate-800">
            <tr>
              <th class="p-3">Academic Year</th>
              <th class="p-3">Type</th>
              <th class="p-3 text-right">UG 1st Yr (UGT1)</th>
              <th class="p-3 text-right">UG 2nd Yr (UGT2)</th>
              <th class="p-3 text-right">UG 3rd Yr (UGT3)</th>
              <th class="p-3 text-right">UG 4th Yr (UGT4)</th>
              <th class="p-3 text-right font-bold text-slate-200">Total Enrolled (N)</th>
              <th class="p-3 text-right font-bold text-slate-200">Regular Faculty (F)</th>
              <th class="p-3 text-right font-bold text-indigo-300">SFR (N / F)</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="(row, key) in sfr?.yearly_breakdown" :key="key" class="hover:bg-slate-800/30">
              <td class="p-3 font-semibold text-white">{{ row.academic_year }}</td>
              <td class="p-3">
                <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                      :class="row.type === 'CAY' ? 'bg-indigo-500/20 text-indigo-300' : 'bg-slate-800 text-slate-400'">
                  {{ row.type }}
                </span>
              </td>
              <td class="p-3 text-right">{{ row.ugt1 }}</td>
              <td class="p-3 text-right">{{ row.ugt2 }}</td>
              <td class="p-3 text-right">{{ row.ugt3 }}</td>
              <td class="p-3 text-right">{{ row.ugt4 }}</td>
              <td class="p-3 text-right font-bold text-white">{{ row.total_students_N }}</td>
              <td class="p-3 text-right font-bold text-emerald-400">{{ row.total_faculty_F }}</td>
              <td class="p-3 text-right font-mono font-bold text-indigo-400">{{ row.sfr }} : 1</td>
            </tr>
          </tbody>
          <tfoot class="bg-slate-900/90 font-bold border-t border-slate-700 text-white">
            <tr>
              <td colspan="6" class="p-3 text-right text-slate-400 uppercase text-[11px]">3-Year Mean Average (CAY, CAYm1, CAYm2):</td>
              <td class="p-3 text-right text-indigo-300">{{ sfr?.avg_students_N }}</td>
              <td class="p-3 text-right text-emerald-400">{{ sfr?.avg_faculty_F }}</td>
              <td class="p-3 text-right text-emerald-300 text-sm font-mono">{{ sfr?.avg_sfr }} : 1</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    <!-- Live Interactive SFR Simulator -->
    <div class="glass-card rounded-xl p-5 border border-indigo-500/30 bg-slate-900/50">
      <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
        <div>
          <h4 class="text-sm font-bold text-white flex items-center gap-2">
            <span>⚡</span> Real-time Interactive SFR Simulator
          </h4>
          <p class="text-xs text-slate-400">Test hypothetical student intake or faculty hiring scenarios</p>
        </div>
        <button @click="resetSimulation" class="text-xs text-slate-400 hover:text-white underline">
          Reset to Baseline
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="text-[11px] font-semibold text-slate-300">1st Year Students (UGT1)</label>
          <input type="number" v-model.number="sim.ugt1" @input="runSimulation"
                 class="w-full mt-1 bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:border-indigo-500 outline-none" />
        </div>
        <div>
          <label class="text-[11px] font-semibold text-slate-300">2nd Year Students (UGT2)</label>
          <input type="number" v-model.number="sim.ugt2" @input="runSimulation"
                 class="w-full mt-1 bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:border-indigo-500 outline-none" />
        </div>
        <div>
          <label class="text-[11px] font-semibold text-slate-300">3rd Year Students (UGT3)</label>
          <input type="number" v-model.number="sim.ugt3" @input="runSimulation"
                 class="w-full mt-1 bg-slate-950 border border-slate-800 rounded-lg px-3 py-2 text-sm text-white focus:border-indigo-500 outline-none" />
        </div>
        <div>
          <label class="text-[11px] font-semibold text-indigo-400">Total Regular Faculty (F)</label>
          <input type="number" v-model.number="sim.faculty" @input="runSimulation"
                 class="w-full mt-1 bg-slate-950 border border-indigo-500/50 rounded-lg px-3 py-2 text-sm text-white focus:border-indigo-400 outline-none" />
        </div>
      </div>

      <!-- Simulation Outcome Box -->
      <div class="mt-5 p-4 rounded-xl bg-slate-950 border border-slate-800 grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">Total Students (N)</div>
          <div class="text-xl font-bold text-white">{{ simResult.total_students }}</div>
        </div>
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">Simulated SFR</div>
          <div class="text-xl font-bold text-indigo-400 font-mono">{{ simResult.simulated_sfr }} : 1</div>
        </div>
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">Predicted NBA Marks</div>
          <div class="text-xl font-bold text-emerald-400">{{ simResult.claimed_marks }} / 20.0</div>
        </div>
        <div class="text-right">
          <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-800 text-slate-200 border border-slate-700">
            {{ simResult.status }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'SfrSimulator',
  props: {
    sfr: {
      type: Object,
      default: () => ({}),
    },
    program: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      sim: {
        ugt1: 120,
        ugt2: 128,
        ugt3: 125,
        ugt4: 122,
        faculty: 22,
      },
      simResult: {
        total_students: 495,
        simulated_sfr: 16.9,
        claimed_marks: 18.0,
        status: 'Acceptable (15:1 to 20:1)',
      },
    };
  },
  mounted() {
    this.resetSimulation();
  },
  methods: {
    resetSimulation() {
      if (this.sfr && this.sfr.yearly_breakdown) {
        const cayData = this.sfr.yearly_breakdown['CAY'] || Object.values(this.sfr.yearly_breakdown)[0];
        if (cayData) {
          this.sim.ugt1 = cayData.ugt1 || 120;
          this.sim.ugt2 = cayData.ugt2 || 128;
          this.sim.ugt3 = cayData.ugt3 || 125;
          this.sim.ugt4 = cayData.ugt4 || 122;
          this.sim.faculty = cayData.total_faculty_F || 22;
        }
      }
      this.runSimulation();
    },
    async runSimulation() {
      try {
        const res = await axios.post('/api/v1/nba/sfr-simulate', {
          ugt1: this.sim.ugt1 || 0,
          ugt2: this.sim.ugt2 || 0,
          ugt3: this.sim.ugt3 || 0,
          ugt4: this.sim.ugt4 || 0,
          faculty_count: Math.max(1, this.sim.faculty || 1),
        });
        if (res.data && res.data.success) {
          this.simResult = res.data.data;
        }
      } catch (err) {
        console.error('SFR simulation error:', err);
      }
    },
  },
};
</script>
