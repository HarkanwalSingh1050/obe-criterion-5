<template>
  <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Ambient glowing backgrounds -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center space-y-3">
      <!-- Logo -->
      <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 via-blue-500 to-emerald-400 p-[2px] shadow-xl shadow-indigo-500/25">
        <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center font-black text-indigo-400 text-2xl">
          NBA
        </div>
      </div>
      <h2 class="text-3xl font-extrabold tracking-tight text-white">
        SAR Platform • Portal
      </h2>
      <p class="text-xs text-slate-400 max-w-xs mx-auto">
        Outcome-Based Education & National Board of Accreditation Enterprise Platform
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
      <div class="glass-card py-8 px-6 sm:px-10 rounded-2xl border border-slate-800 shadow-2xl bg-slate-900/80 backdrop-blur-xl">
        <!-- Error Alert -->
        <div v-if="errorMessage" class="mb-5 p-3 rounded-lg bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-center gap-2">
          <span>⚠️</span>
          <span>{{ errorMessage }}</span>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-300">Email Address</label>
            <div class="mt-1">
              <input type="email" v-model="form.email" required placeholder="admin@nba-obe.edu"
                     class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition" />
            </div>
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label class="block text-xs font-semibold text-slate-300">Password</label>
              <span class="text-[11px] text-indigo-400 hover:text-indigo-300 cursor-pointer">Default: Admin@123</span>
            </div>
            <div class="mt-1">
              <input type="password" v-model="form.password" required placeholder="••••••••"
                     class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition" />
            </div>
          </div>

          <div class="flex items-center justify-between text-xs">
            <label class="flex items-center text-slate-400 cursor-pointer">
              <input type="checkbox" v-model="form.remember" class="rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0 mr-2" />
              Remember me
            </label>
            <span class="text-slate-500">Secure Session</span>
          </div>

          <div>
            <button type="submit" :disabled="loading"
                    class="w-full py-2.5 px-4 rounded-xl text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-sm font-bold shadow-lg shadow-indigo-600/30 transition disabled:opacity-50 flex items-center justify-center gap-2">
              <span v-if="loading" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin"></span>
              <span>{{ loading ? 'Authenticating...' : 'Sign In to Dashboard' }}</span>
            </button>
          </div>
        </form>

        <!-- Quick Demo Role Logins -->
        <div class="mt-6 pt-6 border-t border-slate-800">
          <div class="text-center">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
              One-Click Demo Role Logins
            </span>
          </div>

          <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
            <button @click="fillCredentials('admin@nba-obe.edu', 'Admin@123')"
                    class="p-2 rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/50 text-left transition flex items-center gap-2">
              <span>👑</span>
              <div>
                <div class="font-bold text-white text-[11px]">Super Admin</div>
                <div class="text-[10px] text-slate-500 truncate">Full System Access</div>
              </div>
            </button>

            <button @click="fillCredentials('hod.cse@niet-tech.edu.in', 'Password@123')"
                    class="p-2 rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/50 text-left transition flex items-center gap-2">
              <span>🏛️</span>
              <div>
                <div class="font-bold text-white text-[11px]">HOD (CSE)</div>
                <div class="text-[10px] text-slate-500 truncate">Dept Consolidation</div>
              </div>
            </button>

            <button @click="fillCredentials('faculty@niet-tech.edu.in', 'Password@123')"
                    class="p-2 rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/50 text-left transition flex items-center gap-2">
              <span>🎓</span>
              <div>
                <div class="font-bold text-white text-[11px]">Faculty</div>
                <div class="text-[10px] text-slate-500 truncate">Marks & CO Entry</div>
              </div>
            </button>

            <button @click="fillCredentials('iqac@niet-tech.edu.in', 'Password@123')"
                    class="p-2 rounded-lg bg-slate-950 border border-slate-800 hover:border-indigo-500/50 text-left transition flex items-center gap-2">
              <span>🔍</span>
              <div>
                <div class="font-bold text-white text-[11px]">IQAC / Principal</div>
                <div class="text-[10px] text-slate-500 truncate">Institutional Review</div>
              </div>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'LoginView',
  data() {
    return {
      loading: false,
      errorMessage: '',
      form: {
        email: 'admin@nba-obe.edu',
        password: 'Admin@123',
        remember: true,
      },
    };
  },
  methods: {
    fillCredentials(email, password) {
      this.form.email = email;
      this.form.password = password;
      this.handleLogin();
    },
    async handleLogin() {
      this.loading = true;
      this.errorMessage = '';
      try {
        const response = await axios.post('/api/v1/auth/login', {
          email: this.form.email,
          password: this.form.password,
          remember: this.form.remember,
        });

        if (response.data && response.data.success) {
          this.$emit('authenticated', response.data.user);
        } else {
          this.errorMessage = response.data.message || 'Login failed.';
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Invalid credentials or server error.';
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
