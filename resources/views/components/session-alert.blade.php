@auth
<!-- Modal Auto Logout Warning -->
<div class="modal fade" id="sessionAlertModal" tabindex="-1" aria-labelledby="sessionAlertLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <i class="bi bi-clock-history text-warning" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold mb-3" id="sessionAlertLabel">Sesi Akan Berakhir</h4>
                <p class="text-muted mb-4">
                    Anda sudah tidak melakukan aktivitas selama beberapa waktu. Untuk alasan keamanan, sesi Anda akan otomatis berakhir dalam <strong id="sessionCountdown" class="text-danger fs-5">60</strong> detik.
                </p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary rounded-pill py-2 fw-bold" id="btnKeepAlive">
                        <i class="bi bi-shield-check me-2"></i> Tetap Login
                    </button>
                    <form action="{{ route('logout') }}" method="POST" id="formLogoutSession">
                        @csrf
                        <button type="submit" class="btn btn-light text-danger w-100 rounded-pill py-2">
                            Logout Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 15 menit (dari config session)
    const sessionLifetimeMinutes = {{ config('session.lifetime', 15) }};
    const warningTimeMinutes = sessionLifetimeMinutes - 1; // Muncul 1 menit sebelum habis
    
    let warningTimer;
    let countdownInterval;
    let countdownValue = 60;
    
    const modalElement = document.getElementById('sessionAlertModal');
    let sessionModal = null;
    
    // Pastikan bootstrap sudah di-load
    if (typeof bootstrap !== 'undefined') {
        sessionModal = new bootstrap.Modal(modalElement);
    }

    function startWarningTimer() {
        clearTimeout(warningTimer);
        clearInterval(countdownInterval);
        countdownValue = 60;
        
        // Timer sampai pop-up muncul
        warningTimer = setTimeout(() => {
            showWarningModal();
        }, warningTimeMinutes * 60 * 1000);
    }

    function showWarningModal() {
        isModalShowing = true;
        if(sessionModal) sessionModal.show();
        
        const countdownEl = document.getElementById('sessionCountdown');
        countdownEl.innerText = countdownValue;
        
        countdownInterval = setInterval(() => {
            countdownValue--;
            countdownEl.innerText = countdownValue;
            
            if(countdownValue <= 0) {
                clearInterval(countdownInterval);
                document.getElementById('formLogoutSession').submit();
            }
        }, 1000);
    }

    // Handle "Tetap Login"
    document.getElementById('btnKeepAlive')?.addEventListener('click', function() {
        fetch('{{ route("session.keep-alive") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if(data.status === 'alive') {
                  isModalShowing = false;
                  if(sessionModal) sessionModal.hide();
                  startWarningTimer();
              }
          }).catch(error => {
              console.error("Gagal memperbarui sesi:", error);
              // Jika gagal (mungkin sudah expired di server), refresh paksa agar middleware auto logout bekerja
              window.location.reload();
          });
    });

    // Reset timer on user activity (mouse move, key press, scroll)
    function resetActivity() {
        // Jangan terus-menerus memanggil server, cukup reset local timer
        startWarningTimer();
        
        // Kita tidak mengirim AJAX ke server di sini karena bisa spam server.
        // Server akan meng-update session('lastActivityTime') secara otomatis
        // setiap kali user pindah halaman atau men-submit form.
    }

    let throttleTimer;
    let isModalShowing = false;

    const throttleActivity = () => {
        if (isModalShowing) return; // Jangan reset timer otomatis jika modal peringatan sedang muncul
        if (throttleTimer) return;
        throttleTimer = setTimeout(() => {
            resetActivity();
            throttleTimer = null;
        }, 5000);
    };

    window.addEventListener('mousemove', throttleActivity);
    window.addEventListener('keypress', throttleActivity);
    window.addEventListener('scroll', throttleActivity);
    window.addEventListener('click', throttleActivity);

    // Initialize first timer
    startWarningTimer();
});
</script>
@endauth
