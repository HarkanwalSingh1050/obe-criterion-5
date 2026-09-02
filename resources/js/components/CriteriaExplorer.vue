<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-indigo-500/10 text-indigo-400 text-xs font-semibold border border-indigo-500/20">
          NBA Tier-II SAR Criteria (1 to 10)
        </div>
        <h3 class="text-xl font-bold text-white mt-1">
          Accreditation Criteria & Claimed Scores
        </h3>
      </div>
      <div class="text-right">
        <span class="text-xs text-slate-400">Total Score:</span>
        <span class="ml-1 text-xl font-black text-emerald-400">{{ sar.total_claimed_marks }}</span>
        <span class="text-xs text-slate-400"> / 1000.0</span>
      </div>
    </div>

    <!-- Criteria Accordion / List -->
    <div class="space-y-3">
      <div v-for="c in criteria" :key="c.number"
           class="glass-card rounded-xl overflow-hidden border border-slate-800 transition">
        <div @click="toggleExpand(c.number)"
             class="p-4 bg-slate-900/60 flex items-center justify-between cursor-pointer hover:bg-slate-900/90 transition">
          <div class="flex items-center space-x-3">
            <span class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center font-bold text-indigo-300 text-sm">
              C{{ c.number }}
            </span>
            <div>
              <div class="text-sm font-bold text-white">{{ c.title }}</div>
              <div class="text-xs text-slate-400">Criterion {{ c.number }} • Max Marks: {{ c.max_marks }}</div>
            </div>
          </div>

          <div class="flex items-center space-x-4">
            <div class="text-right">
              <div class="text-base font-bold text-emerald-400">
                {{ c.claimed_marks }} <span class="text-xs text-slate-400 font-normal">/ {{ c.max_marks }}</span>
              </div>
              <div class="text-[10px] text-slate-400">{{ c.percentage }}% Claimed</div>
            </div>
            <span class="text-slate-400 text-sm">{{ expanded === c.number ? '▲' : '▼' }}</span>
          </div>
        </div>

        <!-- Expanded Details -->
        <div v-if="expanded === c.number" class="p-5 border-t border-slate-800 bg-slate-950/40 space-y-4">
          <div>
            <h5 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Self-Assessment Summary</h5>
            <p class="text-xs text-slate-300 mt-1 leading-relaxed">{{ c.summary }}</p>
          </div>

          <!-- Specific Criterion In-Depth Data -->
          <div v-if="c.number === 4" class="p-3 rounded-lg bg-slate-900 border border-slate-800 text-xs space-y-2">
            <div class="font-semibold text-indigo-300">Criterion 4 Metrics Snapshot:</div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
              <div class="p-2 rounded bg-slate-950">
                <div class="text-slate-400 text-[10px]">Success Rate SI (w/o Backlog)</div>
                <div class="font-bold text-white font-mono">{{ sar.live_engines?.success_rate?.mean_si_without_backlog || 0.85 }} ({{ sar.live_engines?.success_rate?.marks_without_backlog || 21.25 }}/25)</div>
              </div>
              <div class="p-2 rounded bg-slate-950">
                <div class="text-slate-400 text-[10px]">Graduation in Stipulated Time</div>
                <div class="font-bold text-white font-mono">{{ sar.live_engines?.success_rate?.mean_si_stipulated_time || 0.98 }} ({{ sar.live_engines?.success_rate?.marks_stipulated_time || 14.7 }}/15)</div>
              </div>
              <div class="p-2 rounded bg-slate-950">
                <div class="text-slate-400 text-[10px]">Placement & Higher Studies Index</div>
                <div class="font-bold text-emerald-400 font-mono">{{ (sar.live_engines?.placement?.avg_placement_index * 100).toFixed(1) || 84.5 }}% ({{ sar.live_engines?.placement?.claimed_marks || 36 }}/40)</div>
              </div>
            </div>
          </div>

          <div v-if="c.number === 10" class="p-3 rounded-lg bg-slate-900 border border-slate-800 text-xs space-y-2">
            <div class="font-semibold text-indigo-300">Criterion 10 Budget & Governance Snapshot:</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <div class="p-2 rounded bg-slate-950">
                <div class="text-slate-400 text-[10px]">Total 3-Year Expenditure</div>
                <div class="font-bold text-white">₹{{ (sar.live_engines?.budget?.total_spent || 15370000).toLocaleString() }}</div>
              </div>
              <div class="p-2 rounded bg-slate-950">
                <div class="text-slate-400 text-[10px]">Budget Utilization Percentage</div>
                <div class="font-bold text-emerald-400 font-mono">{{ sar.live_engines?.budget?.overall_utilization || 94.3 }}% ({{ sar.live_engines?.budget?.claimed_marks || 28 }}/30 Pts)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CriteriaExplorer',
  props: {
    criteria: {
      type: Array,
      default: () => [],
    },
    sar: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      expanded: 1,
    };
  },
  methods: {
    toggleExpand(num) {
      this.expanded = this.expanded === num ? null : num;
    },
  },
};
</script>
