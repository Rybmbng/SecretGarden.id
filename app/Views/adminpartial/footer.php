
    <!-- Konten halaman -->
  </main>

</div>

<script>
function sidebar() {
  return {
    expanded: true,
    sidebarOpen: false,
    init() {
      const stored = localStorage.getItem('sidebarExpanded');
      if (stored !== null) this.expanded = stored === 'true';
    },
    toggle() {
      this.expanded = !this.expanded;
      localStorage.setItem('sidebarExpanded', this.expanded);
    }
  }
}

function notificationDropdown() {
    return {
        open: false,
        notifications: [],
        count: 0,
        toggle() { this.open = !this.open; },
        fetch() {
            fetch('/notifications/getNotifications')
            .then(res => res.json())
            .then(data => {
                this.notifications = data;
                this.count = data.length;
            });
        },
        markRead(id) {
            fetch('/notifications/markAsRead/' + id, { method: 'POST' })
            .then(res => res.json())
            .then(() => this.fetch());
        },
        init() {
            this.fetch(); // ambil notifikasi pertama kali
            setInterval(() => this.fetch(), 5000); // polling tiap 5 detik
        }
    }
}
</script>
</body>
</html>
