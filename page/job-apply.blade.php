{{ web_header() }}

<section class="max-w-4xl mx-auto px-6 py-10 min-h-[70vh]">

    @if (Session::has('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-300 p-4">
            <p class="text-green-700 text-sm">{{ Session::get('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-300 p-4">
            <ul class="text-red-700 text-sm list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <img src="{{ $job->thumbnail }}" alt="" class="w-full h-full object-cover rounded-lg mb-4">
                <h1 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h1>
                @if(isset($job->short_content) && $job->short_content)
                    <p class="text-sm text-gray-600 mt-2">{{ $job->short_content }}</p>
                @endif
                <div class="mt-4 prose max-w-none text-gray-700">
                    {!! $job->content !!}
                </div>
            </div>

            <div class="w-48 shrink-0 text-right">
                @if($jobsApplied)
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"/></svg>
                        Sudah Mengajukan
                    </span>
                    <form  @if($data->status == 'new') action="{{ request()->fullUrl() }}"  @endif method="post" class="mt-4">
                        @csrf
                        @if($data->status == 'new')
                        <input type="hidden" name="apply_id" value="{{ $job->id }}">
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Batalkan Lamaran</button>
                        @else
                            <button type="button" disabled class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Batalkan
                                Lamaran</button>
                        @endif
                    </form>

                @elseif(!empty($hasAppliedElsewhere) && $hasAppliedElsewhere)

                    <div class="p-3 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm">
                        Anda sudah melamar pada lowongan:
                        <a href="{{ request()->url() . '?apply=' . ($appliedJob?->id ?? '') }}" class="font-semibold text-yellow-700">{{ $appliedJob?->title ?? 'Lowongan sebelumnya' }}</a>.
                        Untuk melamar lowongan ini, batalkan lamaran sebelumnya terlebih dahulu.
                    </div>

                    <button class="w-full mt-4 px-4 py-2 bg-gray-200 text-gray-600 rounded-lg" disabled>
                        Lamar Sekarang
                    </button>

                @else
                @if($profileComplete == false)
                    <div class="p-3 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm mb-4">
                        Profil Anda belum lengkap. Silakan lengkapi profil Anda di halaman
                        <a href="/auth/profile" class="font-semibold text-blue-700">Profil Saya</a>
                        sebelum mengajukan lamaran.
                    </div>
                @else
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">Belum Diapply</span>
                    <form action="{{ request()->fullUrl() }}" method="post" class="mt-4">
                        @csrf
                        <input type="hidden" name="apply" value="{{ $job->id }}">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Lamar Sekarang</button>
                    </form>
                @endif
                @endif

                <a href="/" class="block mt-3 text-xs text-gray-500">Kembali ke lowongan</a>
            </div>
        </div>
    </div>

</section>

{{ web_footer() }}
