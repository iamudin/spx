{{ web_header() }}

<section class="min-h-[calc(100vh-120px)] flex items-center justify-center px-6 bg-gray-100">

    <!-- CARD WRAPPER -->
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden grid md:grid-cols-2">

        <!-- ================= DESKRIPSI ================= -->
        <div class="bg-red-600 text-white p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold mb-4">
                Selamat Datang di SPX Expedisi
            </h2>
            <p class="text-sm leading-relaxed mb-4">
                Portal resmi rekrutmen SPX Expedisi.  
                Silakan masuk menggunakan nomor WhatsApp aktif untuk melanjutkan
                proses pendaftaran dan pengajuan lamaran kerja.
            </p>

            <ul class="text-sm space-y-2">
                <li>✅ Proses cepat & aman</li>
                <li>✅ Verifikasi via WhatsApp</li>
                <li>✅ Pantau status lamaran</li>
                <li>✅ Data tersimpan otomatis</li>
            </ul>
        </div>

        <!-- ================= LOGIN ================= -->
        <div class="p-8">
            <h3 class="text-xl font-bold mb-6 text-center">
                Masuk / Registrasi dengan WhatsApp
            </h3>

            <!-- STEP 1 -->
            <form action="{{ URL::current() }}" method="post">
              @csrf
              @if(!$hasOtp)
            <div>
    <label class="block text-sm mb-1">Nomor WhatsApp</label>

    <div class="flex rounded-lg overflow-hidden border focus-within:ring-2 focus-within:ring-green-500">
        <!-- Prefix -->
        <span class="bg-gray-100 px-4 flex items-center text-sm font-medium text-gray-700">
            <b>+62</b>
        </span>

        <!-- Input -->
        <input type="tel"
               name="phone"
               id="phone"
               placeholder="8xxxxxxxxx"
               class="w-full px-3 py-2 outline-none"
               inputmode="numeric"
               autocomplete="tel"
               style="font-weight: bold"
               required>
    </div>

    <button name="request_otp"
            value="true"
            class="w-full mt-4 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
        Kirim OTP
    </button>
</div>
<script>
const phoneInput = document.getElementById('phone');

phoneInput.addEventListener('input', function () {
    // Hanya angka
    this.value = this.value.replace(/\D/g, '');

    // Jika digit pertama bukan 8, hapus
    if (this.value.length > 0 && this.value.charAt(0) !== '8') {
        this.value = '';
    }

    // Optional: batasi panjang nomor (contoh 11-12 digit tanpa +62)
    if (this.value.length > 12) {
        this.value = this.value.slice(0, 12);
    }
});
</script>

            @else
            <!-- STEP 2 -->
     <div class="mt-6">
@if ($errors->has('otp'))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3">
        {{ $errors->first('otp') }}
    </div>
@endif
    <!-- INFO OTP -->
    <div class="mb-3 text-sm text-gray-600">
        Kode OTP telah dikirim ke nomor
        <span class="font-semibold text-gray-800" id="maskedPhone">
           {{ Str::mask(Session::get('otp_phone'), '*', 0, 8) }}
        </span>
    </div>


    <input type="text"
           name="otp"
           id="otp"
           placeholder="******"
           maxlength="6"
           inputmode="numeric"
           autocomplete="one-time-code"
           style="font-weight:bold; letter-spacing:6px"
           class="w-full text-center border rounded-lg px-3 py-2 mb-2">

    <!-- TIMER -->
    <div class="text-sm text-gray-500 mb-4">
        Waktu tersisa
        <span id="timer" class="font-semibold text-red-600"></span>
        detik
    </div>

    <!-- BUTTON VERIFY -->
    <button 
       id="verifyBtn"
       class="block w-full text-center bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 opacity-50 pointer-events-none">
        Verifikasi & Masuk
    </button>

</div>
<script>
const otpInput   = document.getElementById('otp');
const verifyBtn  = document.getElementById('verifyBtn');
const timerEl    = document.getElementById('timer');
const otpDuration = {{ $remainingValidOtp }}; // detik
otpInput.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '');

    if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
    }

    if (this.value.length === 6) {
        verifyBtn.classList.remove('opacity-50', 'pointer-events-none');
    } else {
        verifyBtn.classList.add('opacity-50', 'pointer-events-none');
    }
});

// ================= TIMER =================
let timeLeft = otpDuration;

const timerInterval = setInterval(() => {
    timeLeft--;
    timerEl.textContent = timeLeft;

    if (timeLeft <= 1) {
      window.location.href="/auth?time={{ time() }}";
    }
}, 1000);


</script>


            @endif
</form>
            <p class="text-xs text-gray-500 text-center mt-4">
                Dengan masuk, Anda menyetujui syarat & ketentuan SPX Expedisi
            </p>
        </div>

    </div>

</section>

{{ web_footer() }}
