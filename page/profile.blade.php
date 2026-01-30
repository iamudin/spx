{{ web_header() }}
@php
$field = $data->field;
@endphp

<section class="max-w-5xl mx-auto px-6 py-10 min-h-[80vh]">
    @if($profileComplete == true)
    <div class="flex items-start gap-4 p-5 bg-white border-l-4 border-green-500 rounded-lg shadow-sm">
        <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    
        <div>
            <h4 class="font-semibold text-gray-800">Profil Lengkap</h4>
            <p class="text-sm text-gray-600">
                Semua data wajib telah diisi. Silakan lanjutkan pengajuan lowongan.
            </p>
        </div>
    </div>
    <br>
    @endif
    <!-- TITLE -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Lengkapi Data Pelamar</h1>
        <p class="text-sm text-gray-500">
            Step <span id="stepText">1</span> dari 4 ·
            <span id="stepTitle">Data Pribadi</span>
        </p>
        @if (Session::has('success'))
            <br>
            <div class="mb-6 rounded-lg bg-green-50 border border-green-300 p-4">
                <ul class="text-green-700 text-sm list-disc pl-5">
                   {{ Session::get('success') }}
                </ul>
            </div>
        @endif
        @if ($errors->any())
        <br>
            <div class="mb-6 rounded-lg bg-red-50 border border-red-300 p-4">
                <ul class="text-red-700 text-sm list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

 

    </div>

    {{-- STATUS LAMARAN --}}

    @if(isset($appliedJob) && $appliedJob)
    <div class="mb-6 p-4 bg-white rounded-lg border-l-4 border-green-500 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h4 class="font-semibold text-gray-800">Anda telah mengajukan lamaran</h4>
                <p class="text-sm text-gray-600 mt-1">
                    Lowongan: <a href="{{ url('/jobs-apply?apply=' . $appliedJob->id) }}" class="font-semibold text-red-600">{{ $appliedJob->title }}</a>
                </p>
                @if(isset($appliedJob->short_content) && $appliedJob->short_content)
                    <p class="text-sm text-gray-600 mt-1">{{ $appliedJob->short_content }}</p>
                @endif
            </div>

            <div class="text-right">
                <a href="{{ url('/jobs-apply?apply=' . $appliedJob->id) }}" class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm">Lihat detail</a>
                <form action="{{ url('/jobs-apply?apply=' . $appliedJob->id) }}" method="post" class="mt-2">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm">Batalkan Lamaran</button>
                </form>
            </div>
        </div>
    </div>
    @else
        @if($profileComplete == false)
            <div class="mb-6 p-4 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm">
                Profile anda belum lengkap. Silakan lengkapi untuk
                mengajukan lamaran.
            </div>
        @else
        <div class="mb-6 p-4 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm">
            Anda belum memilih lowongan. Silakan <a href="/" class="font-semibold text-yellow-700">pilih lowongan</a> untuk mengajukan lamaran.
        </div>
        @endif
    @endif

    <!-- PROGRESS BAR -->
    <div class="w-full bg-gray-200 rounded-full h-3 mb-8">
        <div id="progressBar" class="bg-red-600 h-3 rounded-full transition-all duration-300" style="width:25%">
        </div>
    </div>

    <!-- FORM -->
    <form enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6 space-y-6 form-profile" method="post" action="{{ request()->fullUrl() }}">
        @csrf
     
        <!-- ================= STEP 1 ================= -->
    <div class="step-content">
        <h2 class="text-lg font-semibold mb-4">🧍 Data Pribadi</h2>
    
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="label">NIK</label>
                <input class="input" name="nik" type="text" placeholder="Masukkan NIK"
                    value="{{ old('nik', $field->nik ?? '') }}">
            </div>
    
            <div>
                <label class="label">Nama Lengkap</label>
                <input class="input" name="nama" type="text" placeholder="Masukkan nama lengkap"
                    value="{{ old('nama', $field->nama ?? '') }}">
            </div>
    
            <div>
                <label class="label">Email Aktif</label>
                <input class="input" name="email_aktif" type="email" placeholder="contoh@email.com"
                    value="{{ old('email_aktif', $field->email_aktif ?? '') }}">
            </div>
    
            <div>
                <label class="label">No WhatsApp</label>
                <input class="input bg-gray-100" type="text" placeholder="Nomor WhatsApp" value="{{ $data->title }}"
                    disabled>
            </div>
    
            <div>
                <label class="label">Tanggal Lahir</label>
                <input class="input" type="date" name="tanggal_lahir" placeholder="Pilih tanggal lahir"
                    value="{{ old('tanggal_lahir', $field->tanggal_lahir ?? '') }}">
            </div>
    
            <div class="md:col-span-2">
                <strong>Domisili</strong>
            </div>
    
            <div>
                <label class="label">Alamat Rumah Saat Ini</label>
                <textarea class="input" name="alamat_saat_ini"
                    placeholder="Masukkan alamat lengkap saat ini">{{ old('alamat_saat_ini', $field->alamat_saat_ini ?? '') }}</textarea>
            </div>
    
            <div>
                <label class="label">Kelurahan</label>
                <input class="input" name="kelurahan" type="text" placeholder="Nama kelurahan"
                    value="{{ old('kelurahan', $field->kelurahan ?? '') }}">
            </div>
    
            <div>
                <label class="label">Kecamatan</label>
                <input class="input" name="kecamatan" type="text" placeholder="Nama kecamatan"
                    value="{{ old('kecamatan', $field->kecamatan ?? '') }}">
            </div>
    
            <div>
                <label class="label">Kabupaten</label>
                <input class="input" type="text" name="kabupaten" placeholder="Nama kabupaten / kota"
                    value="{{ old('kabupaten', $field->kabupaten ?? '') }}">
            </div>
    
            <div class="md:col-span-2">
                <strong>Rekening</strong>
            </div>
    
            <div>
                <label class="label">No Rekening</label>
                <input class="input" type="text" name="no_rekening" placeholder="Nomor rekening"
                    value="{{ old('no_rekening', $field->no_rekening ?? '') }}">
            </div>
    
            <div>
                <label class="label">Nama Pemilik Rekening</label>
                <input class="input" type="text" name="nama_pemilik_rekening" placeholder="Nama sesuai buku rekening"
                    value="{{ old('nama_pemilik_rekening', $field->nama_pemilik_rekening ?? '') }}">
            </div>
    
            <div>
                <label class="label">Nama Bank</label>
                <input class="input" type="text" name="nama_bank" placeholder="Contoh: BRI, BCA, Mandiri"
                    value="{{ old('nama_bank', $field->nama_bank ?? '') }}">
            </div>
        </div>
    </div>


        <!-- ================= STEP 2 ================= -->
        <div class="step-content hidden">
            <h2 class="text-lg font-semibold mb-4">🪪 Data Kendaraan</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Jenis & Merk Kendaraan</label>
                    <input class="input" type="text" name="jenis_dan_merk_kendaraan" value="{{ $field->jenis_dan_merk_kendaraan ?? null }}" placeholder="Contoh : Yamaha Nmax">
                </div>
                <div>
                    <label class="label">Tahun Pembuatan</label>
                    <input class="input" type="text" name="tahun_pembuatan" value="{{ $field->tahun_pembuatan ?? null }}" placeholder="Contoh: 2018" >
                </div>
                <div>
                    <label class="label">No SIM</label>
                    <input class="input" type="text" name="no_sim" value="{{ $field->no_sim ?? null }}" placeholder="Nomor SIM">
                </div>
                <div>
                    <label class="label">Type SIM</label>
                    <input class="input" type="text" name="type_sim" value="{{ $field->type_sim ?? null }}" placeholder="contoh : SIM A">
                </div>
                <div>
                    <label class="label">Masa Berlaku SIM</label>
                    <input class="input" type="date" name="masa_berlaku_sim" value="{{ $field->masa_berlaku_sim ?? null }}" >
                </div>

                <div>
                    <label class="label">No Plat Motor</label>
                    <input class="input" type="text" name="no_plat_motor" value="{{ $field->no_plat_motor ?? null }}" placeholder="contoh : BM3039MP">
                </div>
                <div>
                    <label class="label">No STNK</label>
                    <input class="input" type="text"  name="no_stnk" value="{{ $field->no_stnk ?? null }}" placeholder="Nomor STNK" >
                </div>
                <div>
                    <label class="label">Tanggal Berlaku STNK</label>
                    <input class="input" type="date" name="tanggal_berlaku_stnk" value="{{ $field->tanggal_berlaku_stnk ?? null }}" >
                </div>
                <div>
                    <label class="label">Tanggal Berlaku Pajak Kendaraan</label>
                    <input class="input" type="date" name="tanggal_berlaku_pajak_kendaraan" value="{{ $field->tanggal_berlaku_pajak_kendaraan ?? null }}" >
                </div>

            </div>
        </div>

        <!-- ================= STEP 3 ================= -->
        <div class="step-content hidden">
            <h2 class="text-lg font-semibold mb-4">📞 Kontak Darurat</h2>

            <!-- Kontak 1 -->
        @for($i = 1; $i <= 3; $i++)
            @php
    $index = $i - 1;

    $lop = isset($data?->data) && count($data?->data) ? json_decode(json_encode($data->data), true)[$index] : [];
            @endphp

            <div class="border rounded-lg p-4 mb-4">
                <h3 class="font-semibold mb-3">Kontak Darurat {{ $i }}</h3>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="label">Nama Lengkap</label>
                        <input class="input" name="kd_nama_lengkap[]" placeholder="Nama Lengkap"
                            value="{{ $lop['nama_lengkap'] ?? '' }}">
                    </div>

                    <div>
                        <label class="label">Hubungan</label>
                        <input class="input" name="kd_hubungan[]" placeholder="Hubungan" value="{{ $lop['hubungan'] ?? '' }}">
                    </div>

                    <div>
                        <label class="label">No HP</label>
                        <input class="input" name="kd_no_hp[]" placeholder="No HP" value="{{ $lop['no_hp'] ?? '' }}">
                    </div>
                </div>
            </div>
        @endfor


        </div>

        <!-- ================= STEP 4 ================= -->
        <div class="step-content hidden">
            <h2 class="text-lg font-semibold mb-4">📎 Lampiran Wajib</h2>

        <div class="grid md:grid-cols-2 gap-4">
        
            {{-- FOTO SIM --}}
            <div>
                <label class="label">Foto SIM (Jika Aktif)</label>
                @if(isset($field?->foto_sim) && media_exists($field->foto_sim))
                    <a href="{{ media_download($field->foto_sim) }}" class="px-6 py-2 bg-blue-200 rounded-sm">
                        Lihat
                    </a>
                @else
                    <input class="input compress-image" name="foto_sim" type="file">
                @endif
            </div>
        
            {{-- STNK DEPAN --}}
            <div>
                <label class="label">Foto STNK (<small>Halaman 1</small>)</label>
                @if(isset($field?->foto_stnk_tampak_depan) && media_exists($field->foto_stnk_tampak_depan))
                    <a href="{{ media_download($field->foto_stnk_tampak_depan) }}" class="px-6 py-2 bg-blue-200 rounded-sm">
                        Lihat
                    </a>
                @else
                    <input class="input compress-image" name="foto_stnk_tampak_depan" type="file">
                @endif
            </div>
        
            {{-- STNK BELAKANG --}}
            <div>
                <label class="label">Foto STNK (<small>Halaman 2</small>)</label>
                @if(isset($field?->foto_stnk_tampak_belakang) && media_exists($field->foto_stnk_tampak_belakang))
                    <a href="{{ media_download($field->foto_stnk_tampak_belakang) }}" class="px-6 py-2 bg-blue-200 rounded-sm">
                        Lihat
                    </a>
                @else
                    <input class="input compress-image" name="foto_stnk_tampak_belakang" type="file">
                @endif
            </div>
        
            {{-- KTP --}}
            <div>
                <label class="label">Foto KTP</label>
                @if(isset($field?->foto_ktp) && media_exists($field->foto_ktp))
                    <a href="{{ media_download($field->foto_ktp) }}" class="px-6 py-2 bg-blue-200 rounded-sm">
                        Lihat
                    </a>
                @else
                    <input class="input compress-image" name="foto_ktp" type="file">
                @endif
            </div>
        
            {{-- IJAZAH --}}
            <div>
                <label class="label">Foto Ijazah</label>
                @if(isset($field?->foto_ijazah) && media_exists($field->foto_ijazah))
                    <a href="{{ media_download($field->foto_ijazah) }}" class="px-6 py-2 bg-blue-200 rounded-sm">
                        Lihat
                    </a>
                @else
                    <input class="input compress-image" name="foto_ijazah" type="file">
                @endif
            </div>
        
            {{-- KARTU KELUARGA --}}
            <div>
                <label class="label">Foto Kartu Keluarga</label>
                @if(isset($field?->foto_kartu_keluarga) && media_exists($field->foto_kartu_keluarga))
                    <a href="{{ media_download($field->foto_kartu_keluarga) }}" class="px-6 py-2 bg-blue-200 rounded-sm">
                        Lihat
                    </a>
                @else
                    <input class="input compress-image" name="foto_kartu_keluarga" type="file">
                @endif
            </div>
        
            {{-- SELFIE --}}
            <div class="md:col-span-2">
                <label class="label">Selfie Depan Rumah (Wajib)</label>
                @if(isset($field?->foto_selfie) && media_exists($field?->foto_selfie))
                    <img src="{{ $field?->foto_selfie }}"  height="100" style="width:100%" alt="">
                @else
                <div id="cameraFrame" class="relative rounded-xl overflow-hidden border bg-black hidden">
                    <video id="video" autoplay playsinline class="w-full h-full object-cover hidden"></video>
                    <img id="result" class="w-full h-full object-cover hidden">
                    <div id="overlay"
                        class="absolute bottom-2 left-2 right-2 bg-black/70 text-green-400 text-xs p-2 rounded hidden">
                        Memuat lokasi...
                    </div>
                </div>
        
                <canvas id="canvas" class="hidden"></canvas>
        
                <button type="button" id="captureBtn" class="mt-3 w-full bg-red-600 text-white py-2 rounded-lg">
                    📸 Ambil Foto
                </button>
        
                <input type="hidden" name="selfie_base64" id="selfie_base64">
                @endif
            </div>
        
        </div>

        </div>

        <!-- ACTION -->
        <div class="flex justify-between pt-6">
            <button type="button" id="prevBtn" class="px-6 py-2 bg-gray-200 rounded-lg hidden">
                Kembali
            </button>
            <button type="submit" style="display:none" class="submitform" ></button>
            <button type="button" id="nextBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg ml-auto">
                Selanjutnya
            </button>
        </div>

    </form>
</section>



<!-- JS WIZARD -->
<script>
    let step = 0;
    const steps = document.querySelectorAll('.step-content');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const progressBar = document.getElementById('progressBar');
    const stepText = document.getElementById('stepText');
    const stepTitle = document.getElementById('stepTitle');

    const titles = [
        'Data Pribadi',
        'Data Kendaraan',
        'Kontak Darurat',
        'Lampiran Wajib'
    ];

    function updateWizard() {
        steps.forEach((el, i) => el.classList.toggle('hidden', i !== step));
        prevBtn.classList.toggle('hidden', step === 0);
        nextBtn.textContent = step === steps.length - 1 ? 'Simpan Data' : 'Selanjutnya';

        const percent = ((step + 1) / steps.length) * 100;
        progressBar.style.width = percent + '%';

        stepText.textContent = step + 1;
        stepTitle.textContent = titles[step];
    }

    nextBtn.onclick = () => {
        if (step < steps.length - 1) {
            step++;
            updateWizard();
        } else {
            $('.submitform').click();
        }
    };

    prevBtn.onclick = () => {
        if (step > 0) {
            step--;
            updateWizard();
        }
    };

    updateWizard();
</script>

<style>
    .label {
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 4px;
        display: block;
    }

    .input {
        width: 100%;
        border: 1px solid #d1d5db;
        padding: 10px;
        border-radius: 8px;
    }
</style>
{{ get_element('js') }}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{ web_footer() }}
