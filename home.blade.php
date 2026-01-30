<!-- ================= HERO ================= -->
<section class="relative bg-cover bg-center"
    style="background-image:url('https://images.unsplash.com/photo-1521791136064-7986c2920216');">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative max-w-7xl mx-auto px-6 py-20 text-white">
        <h1 class="text-4xl font-bold mb-4">Cari Lowongan Terbaik Bersama SPX Expedisi</h1>
        <p class="mb-8 max-w-xl">
            Bergabunglah bersama tim logistik terpercaya dengan peluang karier di berbagai daerah.
        </p>
        <!-- Search Form -->
        <form class="bg-white p-6 rounded-xl shadow grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-800">
            <select class="border rounded-lg px-3 py-2"
                onchange="if(this.value) window.location.href='{{ url()->current() }}?regencies='+this.value">
                <option value="">pilih kabupaten</option>
                @foreach(query()->whereType('regencies')->pluck('title', 'id') as $key => $row)
                    <option value="{{ $key }}" {{ $key == request('regencies', null) ? 'selected' : '' }}>{{$row}}</option>
                @endforeach
            </select>
            <select class="border rounded-lg px-3 py-2"
                onchange="if(this.value) window.location.href='{{ url()->current() }}?regencies={{ request('regencies', null) }}&districts='+this.value">
                <option value="">pilih kecamatan</option>

                @foreach(request('regencies') ? query()->onType('districts')->whereParentId(request('regencies'))->pluck('title', 'id') : [] as $key => $row)
                    <option value="{{ $key }}" {{ $key == request('districts', null) ? 'selected' : '' }}>{{$row}}</option>
                @endforeach
            </select>

            
          
            <button onclick="location.href='/'" class="sm:py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                Reset
            </button>
        </form>
    </div>
</section>

<!-- ================= LIST LOWONGAN ================= -->
<section class="max-w-7xl mx-auto px-6 py-16">
    @php
$regencyId = request('regencies');
$districtId = request('districts');

// Default query
$query = query()
    ->onType('jobs')
    ->published()
    ->latest()
    ->limit(6)
    ->get();

// Filter berdasarkan Kabupaten
if ($regencyId && !$districtId) {
    $query = query()
        ->onType('jobs')
        ->whereHas('parent', function ($q) {
            $q->whereType('hub')
                ->whereHas('parent', function ($q2) {
                    $q2->whereType('districts')
                        ->whereHas('parent', function ($q3) {
                            $q3->whereType('regencies')
                                ->whereId(request('regencies'));
                        });
                });
        })
        ->published()
        ->latest()
        ->limit(6)
        ->get();
}

// Filter berdasarkan Kabupaten + Kecamatan
if ($regencyId && $districtId) {
    $query = query()
        ->onType('jobs')
        ->whereHas('parent', function ($q) {
            $q->whereType('hub')
                ->whereHas('parent', function ($q2) {
                    $q2->whereType('districts')
                        ->whereHas('parent', function ($q3) {
                            $q3->whereType('regencies')
                                ->whereId(request('regencies'));
                        })
                        ->whereId(request('districts'));
                });
        })
        ->published()
        ->latest()
        ->limit(6)
        ->get();
}

$total = $query->count();
    @endphp

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold">
            Lowongan Terbaru
            <span class="text-sm font-normal text-gray-500">
                ({{ $total }} lowongan ditemukan)
            </span>
        </h2>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @if($total > 0)
            @foreach($query as $row)
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <img src="{{ $row->thumbnail }}" class="h-48 w-full object-cover" alt="Thumbnail Lowongan">

                    <div class="p-5">
                        <h3 class="font-bold text-lg">
                            {{ $row->category->name }}
                        </h3>

                        <span class="text-sm text-red-600">
                            Full Time
                        </span>

                        <p class="mt-3 text-sm text-gray-600">
                            {!! $row->short_content !!}
                        </p>

                        <button class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                           <a href="/jobs-apply?apply={{ $row->id }}" class="href">Ajukan Lamaran</a>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            {{-- Empty State --}}
            <div class="col-span-full">
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-lg text-center">
                    <h3 class="font-semibold text-lg mb-2">
                        Lowongan Tidak Ditemukan
                    </h3>
                    <p class="text-sm">
                        Tidak ada lowongan yang sesuai dengan filter wilayah yang Anda pilih.
                        Silakan ubah filter atau coba lagi nanti.
                    </p>
                </div>
            </div>
        @endif
    </div>
</section>


<!-- ================= BANNER ================= -->
<section class="bg-red-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
        <h3 class="text-2xl font-bold mb-4 md:mb-0">
            Siap Bergabung Bersama SPX Expedisi?
        </h3>
        <a href="/auth" class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
            Daftar Sekarang
        </a>
    </div>
</section>