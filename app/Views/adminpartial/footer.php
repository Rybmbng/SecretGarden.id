</main>
</div>

<!-- TOAST STACK -->
<div x-data="toastStack()" x-init="window.toastStackInstance = $data"
     class="fixed bottom-5 right-5 flex flex-col gap-3 items-end z-50 pointer-events-none">
  <template x-for="(t, index) in toasts" :key="t.id">
    <div x-show="t.visible"
         x-transition
         :class="{
           'bg-green-500': t.type === 'success',
           'bg-red-500': t.type === 'error',
           'bg-blue-500': t.type === 'info'
         }"
         class="text-white px-5 py-3 rounded-full shadow-lg flex items-center gap-3 min-w-[200px] max-w-xs pointer-events-auto">
      <template x-if="t.type === 'success'">
        <i class="fas fa-check-circle"></i>
      </template>
      <template x-if="t.type === 'error'">
        <i class="fas fa-times-circle"></i>
      </template>
      <template x-if="t.type === 'info'">
        <i class="fas fa-info-circle"></i>
      </template>
      <span x-text="t.message" class="break-words"></span>
    </div>
  </template>
</div>

<!-- JS Alpine Components -->
<script>
function sidebar() {
  return {
    expanded: true,
    sidebarOpen: true, // ✅ default terbuka (desktop aman)
    init() {
      // Ambil state dari localStorage
      const saved = localStorage.getItem('sidebarExpanded');
      if (saved !== null) this.expanded = saved === 'true';

      // Paksa sidebar selalu terbuka jika layar >= 1024px
      if (window.innerWidth >= 1024) this.sidebarOpen = true;
    },
    toggle() {
      if (window.innerWidth >= 1024) {
        // ✅ Desktop hanya toggle lebar
        this.expanded = !this.expanded;
        localStorage.setItem('sidebarExpanded', this.expanded);
      } else {
        // ✅ Mobile buka/tutup sidebar
        this.sidebarOpen = !this.sidebarOpen;
      }
    }
  }
}

function toastStack() {
  return {
    toasts: [], queue: [], idCounter: 0, processing: false, shownIds: new Set(),
    show(message, type = 'info', uniqueId = null, duration = 5000) {
      if (uniqueId && this.shownIds.has(uniqueId)) return;
      this.queue.push({ message, type, uniqueId, duration });
      if (uniqueId) this.shownIds.add(uniqueId);
      this.processQueue();
    },
    async processQueue() {
      if (this.processing || this.queue.length === 0) return;
      this.processing = true;
      while (this.queue.length > 0) {
        const { message, type, duration } = this.queue.shift();
        const id = this.idCounter++;
        const toast = { id, message, type, visible: true };
        this.toasts.push(toast);
        setTimeout(() => {
          toast.visible = false;
          setTimeout(() => this.toasts = this.toasts.filter(t => t.id !== id), 400);
        }, duration);
        try { new Audio("/assets/sounds/sound.mp3").play(); } catch (err) {}
        await new Promise(r => setTimeout(r, 2000));
      }
      this.processing = false;
    }
  }
}

function notificationDropdown() {
  return {
    open: false, notifications: [], count: 0,
    toggle() { this.open = !this.open },
    fetch() {
      fetch('/notifications/getNotifications')
        .then(res => res.json())
        .then(data => {
          this.notifications = data;
          this.count = data.length;
          data.forEach(notif => window.toastStackInstance.show(notif.message, 'info', notif.id));
        });
    },
    markRead(id) {
      fetch('/notifications/markAsRead/' + id, { method: 'POST' })
        .then(() => this.fetch());
    },
    init() {
      this.fetch();
      setInterval(() => this.fetch(), 5000);
    }
  }
}
</script>
</body>
</html>
