<template>
  <div class="space-y-6">
    <!-- Action Bar (Screen Only) -->
    <div class="no-print flex items-center justify-between bg-slate-900 border border-slate-800 p-4 rounded-xl shadow-sm">
      <div>
        <h3 class="text-sm font-bold text-white">Official NBA Self-Assessment Report (SAR) Document</h3>
        <p class="text-xs text-slate-400">Formatted specifically for A4 standard print & PDF evaluation (Tier-II Engineering format)</p>
      </div>
      <button @click="printDoc" class="px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold flex items-center gap-2 shadow-lg shadow-indigo-600/30 transition">
        <span>🖨️</span>
        <span>Print Document / Save PDF</span>
      </button>
    </div>

    <!-- Official Printable A4 Document Body -->
    <div class="bg-white text-slate-950 p-8 sm:p-12 rounded-xl shadow-xl border border-slate-300 font-sans leading-relaxed text-xs print:p-0 print:border-none print:shadow-none print:w-full print:m-0">
      <!-- NBA Document Official Header -->
      <div class="text-center border-b-2 border-slate-900 pb-5 space-y-1.5">
        <div class="text-xs font-bold uppercase tracking-wider text-slate-600">
          NATIONAL BOARD OF ACCREDITATION (NBA) • NEW DELHI, INDIA
        </div>
        <h1 class="text-lg sm:text-xl font-black uppercase text-slate-950 tracking-tight">
          SELF-ASSESSMENT REPORT (SAR) - UNDERGRADUATE ENGINEERING
        </h1>
        <div class="text-[11px] font-semibold text-slate-700">
          Accreditation Tier: <span class="font-bold text-black">{{ sar.tier || 'Tier-II (Outcome-Based Education)' }}</span> • Academic Year: <span class="font-bold text-black">{{ sar.academic_year || '2024-25 (CAY)' }}</span>
        </div>
      </div>

      <!-- Part A: Institutional & Program Profile -->
      <div class="mt-6 space-y-2">
        <h3 class="text-xs font-bold uppercase bg-slate-100 px-3 py-1.5 border-l-4 border-slate-900 text-slate-900">
          PART A: INSTITUTIONAL & PROGRAM INFORMATION
        </h3>
        <table class="w-full border-collapse border border-slate-800 text-xs">
          <tbody>
            <tr class="border-b border-slate-800">
              <td class="border-r border-slate-800 p-2 font-bold w-1/3 bg-slate-50 text-slate-800">Institution Name:</td>
              <td class="p-2 font-medium text-slate-950">{{ sar.program?.institution || 'National Institute of Engineering & Technology' }}</td>
            </tr>
            <tr class="border-b border-slate-800">
              <td class="border-r border-slate-800 p-2 font-bold bg-slate-50 text-slate-800">Department:</td>
              <td class="p-2 font-medium text-slate-950">{{ sar.program?.department || 'Department of Computer Science and Engineering' }}</td>
            </tr>
            <tr class="border-b border-slate-800">
              <td class="border-r border-slate-800 p-2 font-bold bg-slate-50 text-slate-800">Accredited Program:</td>
              <td class="p-2 font-bold text-slate-950">{{ sar.program?.name }} (Code: {{ sar.program?.code }})</td>
            </tr>
            <tr class="border-b border-slate-800">
              <td class="border-r border-slate-800 p-2 font-bold bg-slate-50 text-slate-800">Sanctioned Annual Intake:</td>
              <td class="p-2 font-medium text-slate-950">{{ sar.program?.sanctioned_intake }} Students (Level: Undergraduate 4-Year B.Tech)</td>
            </tr>
            <tr>
              <td class="border-r border-slate-800 p-2 font-bold bg-slate-50 text-slate-800">Evaluation State & Status:</td>
              <td class="p-2 font-semibold text-slate-950">{{ sar.current_state?.replace(/_/g, ' ') || 'APPROVED LOCKED' }} (Compliance Score: {{ sar.total_claimed_marks }}/1000 Pts)</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Part B: Criteria Summary Table (1000 Marks) -->
      <div class="mt-6 space-y-2">
        <h3 class="text-xs font-bold uppercase bg-slate-100 px-3 py-1.5 border-l-4 border-slate-900 text-slate-900">
          PART B: CRITERIA EVALUATION & SELF-ASSESSMENT SUMMARY (1000 MARKS)
        </h3>
        <table class="w-full border-collapse border border-slate-800 text-xs text-left">
          <thead class="bg-slate-200 text-slate-950 font-bold uppercase text-[10px] border-b-2 border-slate-900">
            <tr>
              <th class="border-r border-slate-800 p-2 text-center w-12">Crit #</th>
              <th class="border-r border-slate-800 p-2">Criterion Title & Coverage</th>
              <th class="border-r border-slate-800 p-2 text-right w-24">Max Marks</th>
              <th class="border-r border-slate-800 p-2 text-right w-28">Claimed Marks</th>
              <th class="p-2 text-right w-20">% Score</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800">
            <tr v-for="c in sar.criteria" :key="c.number" class="even:bg-slate-50">
              <td class="border-r border-slate-800 p-2 text-center font-bold font-mono">{{ c.number }}</td>
              <td class="border-r border-slate-800 p-2 font-medium text-slate-900">
                <span class="font-bold">{{ c.title }}</span>
                <div class="text-[10px] text-slate-600 line-clamp-1">{{ c.summary }}</div>
              </td>
              <td class="border-r border-slate-800 p-2 text-right font-mono font-semibold">{{ c.max_marks }}</td>
              <td class="border-r border-slate-800 p-2 text-right font-mono font-bold text-slate-950">{{ c.claimed_marks }}</td>
              <td class="p-2 text-right font-mono font-semibold">{{ c.percentage }}%</td>
            </tr>
          </tbody>
          <tfoot class="bg-slate-200 font-bold text-slate-950 border-t-2 border-slate-900">
            <tr>
              <td colspan="2" class="border-r border-slate-800 p-2 text-right uppercase tracking-wider">
                Total Claimed Self-Assessment Score:
              </td>
              <td class="border-r border-slate-800 p-2 text-right font-mono">1000.0</td>
              <td class="border-r border-slate-800 p-2 text-right font-mono text-sm font-black">{{ sar.total_claimed_marks }}</td>
              <td class="p-2 text-right font-mono text-sm font-black">{{ sar.total_percentage }}%</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Part C: Key Faculty & Attainment Metrics -->
      <div class="mt-6 space-y-2">
        <h3 class="text-xs font-bold uppercase bg-slate-100 px-3 py-1.5 border-l-4 border-slate-900 text-slate-900">
          PART C: KEY FACULTY INDICES & ATTAINMENT SUMMARY
        </h3>
        <table class="w-full border-collapse border border-slate-800 text-xs">
          <thead class="bg-slate-100 font-bold text-slate-900 border-b border-slate-800">
            <tr>
              <th class="border-r border-slate-800 p-2 text-left">Key Performance Metric</th>
              <th class="border-r border-slate-800 p-2 text-center">Observed Value</th>
              <th class="border-r border-slate-800 p-2 text-center">NBA Benchmark</th>
              <th class="p-2 text-right">Marks Claimed</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800">
            <tr>
              <td class="border-r border-slate-800 p-2 font-bold">Student-Faculty Ratio (SFR - Crit 5.1)</td>
              <td class="border-r border-slate-800 p-2 text-center font-mono font-semibold">{{ sar.live_engines?.sfr?.avg_sfr || 16.9 }} : 1</td>
              <td class="border-r border-slate-800 p-2 text-center">Target ≤ 15:1</td>
              <td class="p-2 text-right font-mono font-bold">{{ sar.live_engines?.sfr?.claimed_marks || 17.6 }} / 20.0</td>
            </tr>
            <tr>
              <td class="border-r border-slate-800 p-2 font-bold">Faculty Qualification Index (FQI - Crit 5.3)</td>
              <td class="border-r border-slate-800 p-2 text-center font-mono font-semibold">{{ sar.live_engines?.fqi?.avg_fqi || 22.8 }} / 25.0</td>
              <td class="border-r border-slate-800 p-2 text-center">Ph.D. + M.Tech Weighted</td>
              <td class="p-2 text-right font-mono font-bold">{{ sar.live_engines?.fqi?.claimed_marks || 22.8 }} / 25.0</td>
            </tr>
            <tr>
              <td class="border-r border-slate-800 p-2 font-bold">Average PO/PSO Attainment (Crit 3.3)</td>
              <td class="border-r border-slate-800 p-2 text-center font-mono font-semibold">{{ sar.live_engines?.attainment?.overall_po_average || 2.62 }} / 3.0</td>
              <td class="border-r border-slate-800 p-2 text-center">80% Direct + 20% Indirect</td>
              <td class="p-2 text-right font-mono font-bold">Attained</td>
            </tr>
            <tr>
              <td class="border-r border-slate-800 p-2 font-bold">3-Year Budget Utilization (Crit 10.1)</td>
              <td class="border-r border-slate-800 p-2 text-center font-mono font-semibold">{{ sar.live_engines?.budget?.overall_utilization || 94.3 }}%</td>
              <td class="border-r border-slate-800 p-2 text-center">Recurring & Capital</td>
              <td class="p-2 text-right font-mono font-bold">{{ sar.live_engines?.budget?.claimed_marks || 28 }} / 30.0</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Part D: Official Declaration and Signatures -->
      <div class="mt-10 pt-6 border-t border-slate-800 space-y-6">
        <p class="text-[11px] text-slate-700 leading-normal italic">
          <strong>Institutional Declaration:</strong> We hereby certify that the information, calculations, student counts, and outcome attainment values presented in this Tier-II Self-Assessment Report are authentic, accurate, and backed by verifiable institutional evidence.
        </p>

        <div class="grid grid-cols-3 gap-6 text-center text-xs pt-6">
          <div class="space-y-6">
            <div class="h-8"></div>
            <div>
              <div class="font-bold border-t border-slate-900 pt-1 text-slate-950">NBA Program Coordinator</div>
              <div class="text-slate-600 text-[10px]">{{ sar.program?.coordinator_name || 'Program Coordinator' }}</div>
            </div>
          </div>
          <div class="space-y-6">
            <div class="h-8"></div>
            <div>
              <div class="font-bold border-t border-slate-900 pt-1 text-slate-950">Head of Department (HOD)</div>
              <div class="text-slate-600 text-[10px]">Department of Computer Science</div>
            </div>
          </div>
          <div class="space-y-6">
            <div class="h-8"></div>
            <div>
              <div class="font-bold border-t border-slate-900 pt-1 text-slate-950">Principal / Head of Institution</div>
              <div class="text-slate-600 text-[10px]">National Institute of Engineering & Tech</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PrintableSarReport',
  props: {
    sar: {
      type: Object,
      default: () => ({}),
    },
  },
  methods: {
    printDoc() {
      window.print();
    },
  },
};
</script>
