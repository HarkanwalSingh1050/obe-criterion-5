<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 text-xs font-semibold border border-emerald-500/20">
          Criterion 3.2 & 3.3 • 120 Marks
        </div>
        <h3 class="text-xl font-bold text-white mt-1">
          PO & PSO Attainment Evaluation Pipeline
        </h3>
        <p class="text-xs text-slate-400 mt-0.5">
          Formula: <code class="text-emerald-300 font-mono">Final PO Attainment = (0.80 × Direct) + (0.20 × Indirect)</code>
        </p>
      </div>

      <!-- Quick Summary Score -->
      <div class="flex items-center space-x-3 bg-slate-900 border border-slate-800 px-4 py-2 rounded-xl">
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">Overall PO Attainment</div>
          <div class="text-xl font-black text-emerald-400">
            {{ attainment?.overall_po_average || 2.62 }} <span class="text-xs text-slate-400 font-normal">/ 3.0</span>
          </div>
        </div>
        <div class="h-8 w-px bg-slate-800"></div>
        <div>
          <div class="text-[10px] text-slate-400 uppercase font-bold">Overall PSO Attainment</div>
          <div class="text-xl font-black text-indigo-400">
            {{ attainment?.overall_pso_average || 2.64 }} <span class="text-xs text-slate-400 font-normal">/ 3.0</span>
          </div>
        </div>
      </div>
    </div>

    <!-- PO Attainment Table -->
    <div class="glass-card rounded-xl overflow-hidden border border-slate-800">
      <div class="px-4 py-3 bg-slate-900/80 border-b border-slate-800 flex items-center justify-between">
        <h4 class="text-xs font-bold text-slate-200 uppercase tracking-wider">
          Program Outcome (PO1 to PO12) Attainment Matrix (Direct 80% + Indirect 20%)
        </h4>
        <span class="text-xs text-slate-400">Benchmark Target: 2.50 / 3.0 (83.3%)</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-950/80 text-slate-400 text-[10px] uppercase font-bold border-b border-slate-800">
            <tr>
              <th class="p-3">PO Code</th>
              <th class="p-3">Program Outcome Description</th>
              <th class="p-3 text-right">Direct (80%)</th>
              <th class="p-3 text-right">Indirect (20%)</th>
              <th class="p-3 text-right font-bold text-white">Final Attainment (3.0)</th>
              <th class="p-3 text-right">Percentage</th>
              <th class="p-3 text-center">Target Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="po in attainment?.po_attainments" :key="po.po_code" class="hover:bg-slate-800/30">
              <td class="p-3 font-bold font-mono text-indigo-400 whitespace-nowrap">{{ po.po_code }}</td>
              <td class="p-3 text-slate-300 max-w-sm">{{ po.title }}</td>
              <td class="p-3 text-right font-mono">{{ po.direct_attainment }}</td>
              <td class="p-3 text-right font-mono text-slate-400">{{ po.indirect_attainment }}</td>
              <td class="p-3 text-right font-mono font-bold text-base text-emerald-400">{{ po.final_attainment }}</td>
              <td class="p-3 text-right font-semibold">{{ po.percentage }}%</td>
              <td class="p-3 text-center">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold"
                      :class="po.is_attained ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30'">
                  {{ po.is_attained ? 'Target Met' : 'Action Required' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- PSO Attainment Table -->
    <div class="glass-card rounded-xl overflow-hidden border border-slate-800">
      <div class="px-4 py-3 bg-slate-900/80 border-b border-slate-800 flex items-center justify-between">
        <h4 class="text-xs font-bold text-slate-200 uppercase tracking-wider">
          Program Specific Outcomes (PSO1 to PSO2) Attainment
        </h4>
        <span class="text-xs text-indigo-400 font-semibold">Specialization Level</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-950/80 text-slate-400 text-[10px] uppercase font-bold border-b border-slate-800">
            <tr>
              <th class="p-3">PSO Code</th>
              <th class="p-3">Program Specific Outcome Title</th>
              <th class="p-3 text-right">Direct (80%)</th>
              <th class="p-3 text-right">Indirect (20%)</th>
              <th class="p-3 text-right font-bold text-white">Final Score (3.0)</th>
              <th class="p-3 text-right">Percentage</th>
              <th class="p-3 text-center">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="pso in attainment?.pso_attainments" :key="pso.pso_code" class="hover:bg-slate-800/30">
              <td class="p-3 font-bold font-mono text-purple-400">{{ pso.pso_code }}</td>
              <td class="p-3 text-slate-300">{{ pso.title }}</td>
              <td class="p-3 text-right font-mono">{{ pso.direct_attainment }}</td>
              <td class="p-3 text-right font-mono text-slate-400">{{ pso.indirect_attainment }}</td>
              <td class="p-3 text-right font-mono font-bold text-base text-purple-400">{{ pso.final_attainment }}</td>
              <td class="p-3 text-right font-semibold">{{ pso.percentage }}%</td>
              <td class="p-3 text-center">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                  Target Met
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AttainmentDashboard',
  props: {
    attainment: {
      type: Object,
      default: () => ({}),
    },
    programId: {
      type: Number,
      default: 1,
    },
  },
};
</script>
