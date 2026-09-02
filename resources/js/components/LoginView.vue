<template>
  <div class="min-h-screen bg-slate-950 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden font-sans selection:bg-indigo-500 selection:text-white">
    <!-- Ambient glowing backgrounds -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10 text-center space-y-3">
      <!-- Dynamic Login Logo / Icon -->
      <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 via-blue-500 to-emerald-400 p-[2px] shadow-xl shadow-indigo-500/25">
        <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center p-1.5 overflow-hidden">
          <img v-if="branding.login_logo" :src="branding.login_logo" class="w-full h-full object-contain rounded-lg" alt="Portal Logo" />
          <div v-else class="font-black text-indigo-400 text-2xl">
            {{ branding.app_short_name || 'NBA' }}
          </div>
        </div>
      </div>

      <h2 class="text-3xl font-extrabold tracking-tight text-white">
        {{ branding.app_name || 'NBA SAR Platform' }}
      </h2>
      <p class="text-xs text-slate-400 max-w-xs mx-auto">
        {{ branding.app_tagline || 'Outcome-Based Education & National Board of Accreditation Enterprise Platform' }}
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
              <input type="email" v-model="form.email" required placeholder="name@institution.edu"
                     class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition" />
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-300">Password</label>
            <div class="mt-1">
              <input type="password" v-model="form.password" required placeholder="Enter your password"
                     class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-600 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition" />
            </div>
          </div>

          <div class="flex items-center justify-between text-xs">
            <label class="flex items-center text-slate-400 cursor-pointer">
              <input type="checkbox" v-model="form.remember" class="rounded bg-slate-950 border-slate-800 text-indigo-600 focus:ring-0 mr-2" />
              Remember me
            </label>
            <span class="text-slate-500">Encrypted Session</span>
          </div>

          <div class="pt-2">
            <button type="submit" :disabled="loading"
                    class="w-full py-2.5 px-4 rounded-xl text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-sm font-bold shadow-lg shadow-indigo-600/30 transition disabled:opacity-50 flex items-center justify-center gap-2">
              <span v-if="loading" class="w-4 h-4 border-2 border-white/20 border-t-white rounded-full animate-spin"></span>
              <span>{{ loading ? 'Authenticating...' : 'Sign In to Dashboard' }}</span>
            </button>
          </div>
        </form>
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
      branding: {
        app_name: 'NBA SAR & OBE Platform',
        app_short_name: 'NBA',
        app_tagline: 'Outcome-Based Education & National Board of Accreditation Enterprise Platform',
        login_logo: '',
      },
      form: {
        email: '',
        password: '',
        remember: true,
      },
    };
  },
  mounted() {
    this.fetchBranding();
  },
  methods: {
    async fetchBranding() {
      try {
        const res = await axios.get('/api/v1/settings');
        if (res.data && res.data.success) {
          this.branding = { ...this.branding, ...res.data.data };
          if (this.branding.favicon) {
            let link = document.querySelector("link[rel~='icon']");
            if (link) link.href = this.branding.favicon;
          }
        }
      } catch (err) {
        // Fallback to default
      }
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
