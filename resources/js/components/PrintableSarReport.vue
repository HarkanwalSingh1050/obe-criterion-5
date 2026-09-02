<template>
  <div class="space-y-6">
    <!-- Action Bar -->
    <div class="no-print flex items-center justify-between bg-slate-900 border border-slate-800 p-4 rounded-xl">
      <div>
        <h3 class="text-sm font-bold text-white">Official NBA Self-Assessment Report (SAR) Document</h3>
        <p class="text-xs text-slate-400">Formatted for print & PDF generation (Tier-II UG Engineering format)</p>
      </div>
      <button @click="printDoc" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold flex items-center gap-2 shadow-lg transition">
        <span>🖨️</span> Print / Save to PDF
      </button>
    </div>

    <!-- Official Printable Document -->
    <div class="bg-white text-black p-8 sm:p-12 rounded-xl shadow-2xl border border-slate-200 font-sans leading-normal text-xs print:p-0 print:border-none print:shadow-none">
      <!-- Header -->
      <div class="text-center border-b-2 border-black pb-6 space-y-2">
        <h2 class="text-lg font-bold tracking-tight uppercase text-slate-800">
          National Board of Accreditation (NBA)
        </h2>
        <h1 class="text-xl font-extrabold uppercase text-black">
          Self-Assessment Report (SAR) - Undergraduate Engineering
        </h1>
        <p class="text-xs text-slate-600">
          Format for Tier-II Institutions (Outcome-Based Education)
        </p>
      </div>

      <!-- Part A: Program & Institute Information -->
      <div class="mt-6 space-y-3">
        <h3 class="text-sm font-bold uppercase bg-slate-100 p-2 border-l-4 border-black">
          Part A: Institutional & Program Information
        </h3>
        <table class="w-full border-collapse border border-slate-300 text-xs">
          <tbody>
            <tr>
              <td class="border border-slate-300 p-2 font-bold w-1/3 bg-slate-50">Name of Institution:</td>
              <td class="border border-slate-300 p-2">{{ sar.program?.institution || 'National Institute of Engineering & Technology' }}</td>
            </tr>
            <tr>
              <td class="border border-slate-300 p-2 font-bold bg-slate-50">Department:</td>
              <td class="border border-slate-300 p-2">{{ sar.program?.department || 'Department of Computer Science and Engineering' }}</td>
            </tr>
            <tr>
              <td class="border border-slate-300 p-2 font-bold bg-slate-50">Accredited Program:</td>
              <td class="border border-slate-300 p-2 font-bold">{{ sar.program?.name }} (Code: {{ sar.program?.code }})</td>
            </tr>
            <tr>
              <td class="border border-slate-300 p-2 font-bold bg-slate-50">Sanctioned Annual Intake:</td>
              <td class="border border-slate-300 p-2">{{ sar.program?.sanctioned_intake }} Students</td>
            </tr>
            <tr>
              <td class="border border-slate-300 p-2 font-bold bg-slate-50">Current Academic Year (CAY):</td>
              <td class="border border-slate-300 p-2">{{ sar.academic_year || '2024-25' }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Part B: Criteria Assessment Summary (1000 Marks) -->
      <div class="mt-8 space-y-3">
        <h3 class="text-sm font-bold uppercase bg-slate-100 p-2 border-l-4 border-black">
          Part B: Criteria Evaluation & Self-Assessment Summary (1000 Marks)
        </h3>
        <table class="w-full border-collapse border border-slate-300 text-xs text-left">
          <thead class="bg-slate-200 text-slate-800 font-bold uppercase text-[10px]">
            <tr>
              <th class="border border-slate-300 p-2 text-center w-12">Crit #</th>
              <th class="border border-slate-300 p-2">Criterion Title</th>
              <th class="border border-slate-300 p-2 text-right w-24">Max Marks</th>
              <th class="border border-slate-300 p-2 text-right w-24">Claimed Marks</th>
              <th class="border border-slate-300 p-2 text-right w-24">% Score</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="c in sar.criteria" :key="c.number" class="even:bg-slate-50">
              <td class="border border-slate-300 p-2 text-center font-bold">{{ c.number }}</td>
              <td class="border border-slate-300 p-2 font-semibold">{{ c.title }}</td>
              <td class="border border-slate-300 p-2 text-right font-mono">{{ c.max_marks }}</td>
              <td class="border border-slate-300 p-2 text-right font-mono font-bold">{{ c.claimed_marks }}</td>
              <td class="border border-slate-300 p-2 text-right font-mono">{{ c.percentage }}%</td>
            </tr>
          </tbody>
          <tfoot class="bg-slate-200 font-bold text-slate-900 border-t-2 border-black">
            <tr>
              <td colspan="2" class="border border-slate-300 p-2 text-right uppercase">Total Claimed Self-Assessment Score:</td>
              <td class="border border-slate-300 p-2 text-right font-mono">1000.0</td>
              <td class="border border-slate-300 p-2 text-right font-mono text-base">{{ sar.total_claimed_marks }}</td>
              <td class="border border-slate-300 p-2 text-right font-mono text-base">{{ sar.total_percentage }}%</td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Criterion 5 Faculty Key Metrics -->
      <div class="mt-8 space-y-3">
        <h3 class="text-sm font-bold uppercase bg-slate-100 p-2 border-l-4 border-black">
          Criterion 5: Key Faculty Indices
        </h3>
        <div class="grid grid-cols-3 gap-4 text-center">
          <div class="border border-slate-300 p-3 rounded bg-slate-50">
            <div class="text-[10px] text-slate-500 uppercase font-bold">Average SFR</div>
            <div class="text-base font-bold">{{ sar.live_engines?.sfr?.avg_sfr }} : 1</div>
            <div class="text-[10px] text-slate-600">Claimed: {{ sar.live_engines?.sfr?.claimed_marks }} / 20</div>
          </div>
          <div class="border border-slate-300 p-3 rounded bg-slate-50">
            <div class="text-[10px] text-slate-500 uppercase font-bold">Faculty Qualification (FQI)</div>
            <div class="text-base font-bold">{{ sar.live_engines?.fqi?.avg_fqi }} / 25.0</div>
            <div class="text-[10px] text-slate-600">Ph.D. & M.Tech Indexed</div>
          </div>
          <div class="border border-slate-300 p-3 rounded bg-slate-50">
            <div class="text-[10px] text-slate-500 uppercase font-bold">Cadre Proportion</div>
            <div class="text-base font-bold">{{ sar.live_engines?.cadre?.claimed_marks }} / 25.0</div>
            <div class="text-[10px] text-slate-600">Ratio 1 : 2 : 6</div>
          </div>
        </div>
      </div>

      <!-- Declaration and Signatures -->
      <div class="mt-12 pt-8 border-t border-slate-300 grid grid-cols-3 gap-8 text-center text-xs">
        <div class="space-y-8">
          <div class="h-10"></div>
          <div>
            <div class="font-bold border-t border-black pt-1">NBA Coordinator</div>
            <div class="text-slate-500 text-[10px]">{{ sar.program?.coordinator_name || 'Coordinator' }}</div>
          </div>
        </div>
        <div class="space-y-8">
          <div class="h-10"></div>
          <div>
            <div class="font-bold border-t border-black pt-1">Head of Department (HOD)</div>
            <div class="text-slate-500 text-[10px]">Department of Computer Science</div>
          </div>
        </div>
        <div class="space-y-8">
          <div class="h-10"></div>
          <div>
            <div class="font-bold border-t border-black pt-1">Principal / Head of Institute</div>
            <div class="text-slate-500 text-[10px]">National Institute of Engineering & Tech</div>
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
