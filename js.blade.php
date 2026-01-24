<script>
        const compressImage = async (file, { quality = 1.0, maxWidth = 1700 } = {}) => {
        const imageBitmap = await createImageBitmap(file);

        let { width, height } = imageBitmap;
        if (width > maxWidth) {
            const scale = maxWidth / width;
            width = maxWidth;
            height = Math.round(height * scale);
        }

        const canvas = document.createElement('canvas');
        canvas.width = width;
        canvas.height = height;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(imageBitmap, 0, 0, width, height);

        const blob = await new Promise((resolve) =>
            canvas.toBlob(resolve, 'image/webp', quality)
        );

        const newFileName = file.name.replace(/\.[^/.]+$/, '') + '.webp';
        return new File([blob], newFileName, { type: 'image/webp' });
    };

const getIdentifier = (input) => input.name || 'input_' + Math.random().toString(36).substring(2, 8);

const compressAndPreview = async (file, preview, dataTransfer, quality) => {
    const originalSizeKB = (file.size / 1024).toFixed(2);
    const compressedFile = await compressImage(file, { quality });
    const compressedSizeKB = (compressedFile.size / 1024).toFixed(2);
    dataTransfer.items.add(compressedFile);

    const reader = new FileReader();
    reader.onload = (e) => {
        const wrapper = document.createElement('div');
        wrapper.style.width = '150px';
        wrapper.className = 'text-center position-relative';

        wrapper.innerHTML = `
            <img src="${e.target.result}" class="img-thumbnail mb-1 ml-2" style="height: 120px; object-fit: cover;" alt="Preview">
            <small class="text-muted d-block">⬇ ${originalSizeKB} KB → ${compressedSizeKB} KB</small>
            <select class="form-select form-select-sm mt-1 compression-select mb-2">
                <option value="0.6" ${quality === 0.6 ? 'selected' : ''}>Sedang (60%)</option>
               
              
            </select>
        `;

        wrapper.querySelector('.compression-select').addEventListener('change', async (e) => {
            const newQuality = parseFloat(e.target.value);
            dataTransfer.items.clear();
            preview.innerHTML = '';
            for (const f of originalFiles) {
                await compressAndPreview(f, preview, dataTransfer, newQuality);
            }
            input.files = dataTransfer.files;
        });

        preview.appendChild(wrapper);
    };
    reader.readAsDataURL(compressedFile);
};

let originalFiles = [];
let input;

const fileselect = async (targetInput) => {
    input = targetInput;
    const identifier = getIdentifier(input);
    const previewId = `preview_${identifier}`;

    let preview = document.getElementById(previewId);
    if (!preview) {
        preview = document.createElement('div');
        preview.id = previewId;
        preview.className = 'd-flex flex-wrap gap-3 mt-3';
        input.insertAdjacentElement('afterend', preview);
    }

    preview.innerHTML = '';
    const files = Array.from(input.files);
    originalFiles = files;

    const dataTransfer = new DataTransfer();

    for (const file of files) {
        const fileExt = file.name.toLowerCase();
        const allowed = /\.(jpe?g|png|webp|gif)$/;

        if (!allowed.test(fileExt)) {
            alert(`File "${file.name}" tidak didukung. Hanya JPG, JPEG,GIF dan PNG`);
            continue;
        }
     
            await compressAndPreview(file, preview, dataTransfer, 1.0); 
    }

    input.files = dataTransfer.files;
};

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.compress-image').forEach(inp => {
        inp.addEventListener('change', () => {
            const file = inp.files[0];
            if (file && file.type.startsWith('image/') && !file.type.includes('gif')) {
                fileselect(inp);
            }
        });
    });
});
</script>

<script>
  
const frame = document.getElementById('cameraFrame');
const video = document.getElementById('video');
const result = document.getElementById('result');
const overlay = document.getElementById('overlay');
const canvas = document.getElementById('canvas');
const btn = document.getElementById('captureBtn');
const inputs = document.getElementById('selfie_base64');

let stream = null;
let mode = 'idle'; // idle | camera | result

let lat='-', lon='-', address='Mengambil lokasi...';

// 📍 lokasi + alamat
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(async pos => {
    lat = pos.coords.latitude.toFixed(6);
    lon = pos.coords.longitude.toFixed(6);

    try {
      const res = await fetch(
        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`,
        { headers:{'User-Agent':'spx-selfie'} }
      );
      const data = await res.json();
      address = data.display_name || address;
    } catch(e){}
  });
}

// ⏰ waktu
function timestamp() {
  return new Date().toLocaleString('id-ID');
}

// 🎥 start camera
async function startCamera() {
  stream = await navigator.mediaDevices.getUserMedia({
    video: { facingMode: 'user' },
    audio: false
  });
  video.srcObject = stream;

  frame.classList.remove('hidden');
  video.classList.remove('hidden');
  result.classList.add('hidden');
  overlay.classList.remove('hidden');

  btn.textContent = '📸 Jepret Foto';
  mode = 'camera';

  updateOverlay();
}

// 🛑 stop camera
function stopCamera() {
  if (stream) {
    stream.getTracks().forEach(t => t.stop());
    stream = null;
  }
}

// 🔄 overlay realtime
function updateOverlay() {
  if (mode !== 'camera') return;

  overlay.innerHTML = `
    🕒 ${timestamp()}<br>
    📍 ${lat}, ${lon}<br>
    🏠 ${address}
  `;
  requestAnimationFrame(updateOverlay);
}

// 📸 capture
function takePhoto() {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const ctx = canvas.getContext('2d');

  ctx.drawImage(video, 0, 0);

  // watermark bg
  ctx.fillStyle = 'rgba(0,0,0,0.6)';
  ctx.fillRect(0, canvas.height - 90, canvas.width, 90);

  ctx.fillStyle = '#00ff99';
  ctx.font = '14px Arial';
  ctx.fillText(`Waktu: ${timestamp()}`, 10, canvas.height - 60);
  ctx.fillText(`Koordinat: ${lat}, ${lon}`, 10, canvas.height - 40);
  ctx.fillText(`Alamat: ${address}`, 10, canvas.height - 20);

  const dataURL = canvas.toDataURL('image/jpeg', 0.9);
  result.src = dataURL;
  inputs.value = dataURL;

  stopCamera();

  video.classList.add('hidden');
  result.classList.remove('hidden');
  overlay.classList.add('hidden');

  btn.textContent = '🔄 Ambil Foto Lagi';
  mode = 'result';
}

// 🧠 button logic
btn.onclick = () => {
  if (mode === 'idle' || mode === 'result') {
    startCamera();
  } else if (mode === 'camera') {
    takePhoto();
  }
};
</script>