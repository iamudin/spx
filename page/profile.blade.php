{{ web_header() }}
@php
    $field = $data->field;
@endphp

<section class="max-w-5xl mx-auto px-6 py-10 min-h-[80vh]">

    <!-- TITLE -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Lengkapi Data Pelamar</h1>
        <p class="text-sm text-gray-500">
            Step <span id="stepText">1</span> dari 4 ·
            <span id="stepTitle">Data Pribadi</span>
        </p>
    </div>

    <!-- PROGRESS BAR -->
    <div class="w-full bg-gray-200 rounded-full h-3 mb-8">
        <div id="progressBar" class="bg-red-600 h-3 rounded-full transition-all duration-300" style="width:25%">
        </div>
    </div>

    <!-- FORM -->
    <form class="bg-white rounded-xl shadow p-6 space-y-6">
        <!-- ================= STEP 1 ================= -->
        <div class="step-content">
            <h2 class="text-lg font-semibold mb-4">🧍 Data Pribadi</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="label">NIK</label>
                    <input class="input" type="text" value="{{ $field->nik ?? null }}">
                </div>

                <div>
                    <label class="label">Nama Lengkap</label>
                    <input class="input" type="text" placeholder="Masukkan nama lengkap"
                        value="{{ $field->nama_lengkap ?? null }}">
                </div>

                <div>
                    <label class="label">Email Aktif</label>
                    <input class="input" type="email" value="{{ $field->email_aktif ?? null }}">
                </div>

                <div>
                    <label class="label">No WhatsApp</label>
                    <input class="input bg-gray-100" type="text" value="{{ $data->title }}" disabled>
                </div>

                <div>
                    <label class="label">Tanggal Lahir</label>
                    <input class="input" type="date" value="{{ $field->tanggal_lahir ?? null }}">
                </div>
                <div class="md:col-span-2">
                    <strong>Domisili</strong>
                </div>
                <div>
                    <label class="label">Alamat Rumah Saat Ini</label>
                    <textarea class="input">{{ $field->alamat_saat_ini ?? null }}</textarea>
                </div>
                <div>
                    <label class="label">Kelurahan</label>
                    <input class="input" type="text" value="{{ $field->kelurhan ?? null }}">
                </div>
                <div>
                    <label class="label">Kecamatan</label>
                    <input class="input" type="text" value="{{ $field->kecamatan ?? null }}">
                </div>

                <div>
                    <label class="label">Kabupaten</label>
                    <input class="input" type="text" value="{{ $field->kabupaten ?? null }}">
                </div>
                <div class="md:col-span-2">
                    <strong>Rekening</strong>
                </div>
                <div>
                    <label class="label">No Rekening</label>
                    <input class="input" type="text" value="{{ $field->no_rekening ?? null }}">
                </div>
                <div>
                    <label class="label">Nama Pemilik Rekening</label>
                    <input class="input" type="text" value="{{ $field->nama_pemilik_rekening ?? null }}">
                </div>
                <div>
                    <label class="label">Nama Bank</label>
                    <input class="input" type="text" value="{{ $field->nama_bank ?? null }}">
                </div>
            </div>
        </div>

        <!-- ================= STEP 2 ================= -->
        <div class="step-content hidden">
            <h2 class="text-lg font-semibold mb-4">🪪 Data Kenderaan</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Jenis & Merk Kendaraan</label>
                    <input class="input" type="text" value="{{ $field->jenis_dan_merk_kendaraan ?? null }}">
                </div>
                <div>
                    <label class="label">Tahun Pembuatan</label>
                    <input class="input" type="text" value="{{ $field->tahun_pembuatan ?? null }}">
                </div>
                <div>
                    <label class="label">No SIM</label>
                    <input class="input" type="text" value="{{ $field->no_sim ?? null }}">
                </div>
                <div>
                    <label class="label">Type SIM</label>
                    <input class="input" type="text" value="{{ $field->type_sim ?? null }}">
                </div>
                <div>
                    <label class="label">Masa Berlaku SIM</label>
                    <input class="input" type="date" value="{{ $field->masa_berlaku_sim ?? null }}">
                </div>

                <div>
                    <label class="label">No Plat Motor</label>
                    <input class="input" type="text" value="{{ $field->no_plat_motor ?? null }}">
                </div>
                <div>
                    <label class="label">No STNK</label>
                    <input class="input" type="text" value="{{ $field->no_stnk ?? null }}">
                </div>
                <div>
                    <label class="label">Tanggal Berlaku STNK</label>
                    <input class="input" type="date" value="{{ $field->tanggal_berlaku_stnk ?? null }}">
                </div>
                <div>
                    <label class="label">Tanggal Berlaku Pajak Kendararan</label>
                    <input class="input" type="date" value="{{ $field->tanggal_berlaku_pajak_kendaraan ?? null }}">
                </div>

            </div>
        </div>

        <!-- ================= STEP 3 ================= -->
        <div class="step-content hidden">
            <h2 class="text-lg font-semibold mb-4">📞 Kontak Darurat</h2>

            <!-- Kontak 1 -->
            <div class="border rounded-lg p-4 mb-4">
                <h3 class="font-semibold mb-3">Kontak Darurat 1</h3>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="label">Nama Lengkap</label>
                        <input class="input" name="kd_nama_lengkap[]">
                    </div>
                    <div>
                        <label class="label">Hubungan</label>
                        <input class="input" name="kd_hubungan[]">
                    </div>
                    <div>
                        <label class="label">No HP</label>
                        <input class="input" name="kd_no_hp[]">
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= STEP 4 ================= -->
        <div class="step-content hidden">
            <h2 class="text-lg font-semibold mb-4">📎 Lampiran Wajib</h2>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Foto Profile</label>
                    <input class="compress-image input" name="foto_profile" type="file">
                </div>
                <div>
                    <label class="label">Foto SIM (Jika Aktif)</label>
                    <input class="compress-image input " name="foto_sim" type="file">
                </div>

                <div>
                    <label class="label">Foto STNK ( <small>Halaman 1</small> )</label>

                    <input class="input compress-image" name="foto_stnk" type="file">
                </div>

                <div>
                    <label class="label">Foto STNK ( <small>Halaman 2</small>)</label>


                    <input class="input compress-image" type="file" name="foto_stnk">
                </div>
                <div>
                    <label class="label">Foto KTP</label>
                    <input class="input compress-image" type="file" name="foto_ktp">
                </div>

                <div>
                    <label class="label">Foto Kartu Keluarga</label>
                    <input class="input compress-image" type="file" name="foto_kartu_keluarga">
                </div>

                <!-- SELFIE CAMERA -->
                <div class="md:col-span-2">
                    <label class="label">Selfie Depan Rumah (Wajib)</label>

                    <!-- FRAME -->
                    <div id="cameraFrame" class="relative rounded-xl overflow-hidden border bg-black hidden">

                        <!-- CAMERA -->
                        <video id="video" autoplay playsinline class="w-full h-full object-cover hidden"></video>

                        <!-- RESULT -->
                        <img id="result" class="w-full h-full object-cover hidden">

                        <!-- OVERLAY -->
                        <div id="overlay"
                            class="absolute bottom-2 left-2 right-2 bg-black/70 text-green-400 text-xs p-2 rounded hidden">
                            Memuat lokasi...
                        </div>
                    </div>

                    <canvas id="canvas" class="hidden"></canvas>

                    <!-- BUTTON -->
                    <button type="button" id="captureBtn" class="mt-3 w-full bg-red-600 text-white py-2 rounded-lg">
                        📸 Ambil Foto
                    </button>

                    <input type="hidden" name="selfie_base64" id="selfie_base64">
                </div>

            </div>
        </div>

        <!-- ACTION -->
        <div class="flex justify-between pt-6">
            <button type="button" id="prevBtn" class="px-6 py-2 bg-gray-200 rounded-lg hidden">
                Kembali
            </button>

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
        'Data Identitas',
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
            alert('Data berhasil disimpan');
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
