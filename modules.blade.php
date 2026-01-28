<?php
add_option('template', [['Logo Header', 'file', 'image/png,image/jpeg'], ['Body Style', ['Default', 'Boxed']], ['Body Background Color', 'color'], ['Body Background Image', 'file', 'image/png,image/jpeg'], ['Header Style', ['Default', 'Header 1', 'Header 2', 'Header 3', 'Header 4', 'Header 5', 'Header 6', 'Header 7']], ['Navigation Style', ['Static', 'Fixed']], ['Home Style', ['Default', 'Home 1', 'Home 2']], ['Scheme Color', ['Skin 1', 'Skin 2', 'Skin 3', 'Skin 4', 'Skin 5', 'Skin 6', 'Skin 7', 'Skin 8']]]);
use_module([
    'berita' => ['active' => false],
]);
add_route('public', [
    'name' => 'mitra.login',
    'path' => 'auth',
    'method' => ['get','post'],
    'function' => 'login',
    'controller' => 'App\Http\Controllers\VacancyController',
]);

add_route('public', [
    'name' => 'mitra.profile',
    'path' => 'auth/profile',
    'method' => ['get','post'],
    'function' => 'profile',
    'controller' => 'App\Http\Controllers\VacancyController',
    'middleware'=>'applier.exists'
]);
add_route('public', [
    'name' => 'mitra.ajukan',
    'path' => 'auth/ajukan',
    'method' => ['get','post'],
    'function' => 'dashboard',
    'controller' => 'App\Http\Controllers\VacancyController',
    'middleware'=>'applier.exists'
]);
add_route('public', [
    'name' => 'mitra.dashboard',
    'path' => 'auth/dashboard',
    'method' => ['get','post'],
    'function' => 'dashboard',
    'controller' => 'App\Http\Controllers\VacancyController',
    'middleware'=>'applier.exists'
]);
add_module([
    'position' => 1,
    'name' => 'regencies',
    'title' => 'Kabupaten',
    'description' => 'Menu Untuk Mengelola Kabupaten',
    'parent' => false,
    'icon' => 'fa-map',
    'route' => ['index', 'create', 'show', 'update', 'delete'],
    'datatable' => [
        'custom_column' => false,
        'data_title' => 'Kabupaten',
        'child_count'=> 'Total Kecamatan'
    ],
    'form' => [
        'unique_title' => true,
        'post_parent' => false,
        'thumbnail' => false,
        'editor' => false,
        'category' => false,
        'tag' => true,
        'looping_name' => 'Arsip',
        'looping_data' => false,
        'custom_field' =>false,
    ],
    'web' => [
        'api' => true,
        'archive' => true,
        'index' => true,
        'detail' => false,
        'history' => true,
        'auto_query' => true,
        'sortable' => false,
    ],
    'public' => true,
    'cache' => false,
    'active' => true,
]);
add_module([
    'position' => 1,
    'name' => 'districts',
    'title' => 'Kecamatan',
    'description' => 'Menu Untuk Mengelola Kecamatanb',
    'parent' => false,
    'icon' => 'fa-map',
    'route' => ['index', 'create', 'show', 'update', 'delete'],
    'datatable' => [
        'custom_column' => false,
        'data_title' => 'Kecamatan',
        'childs_count'=> 'Total HUB'
    ],
    'form' => [
        'unique_title' => true,
        'post_parent' => ['Kabupaten','regencies'],
        'thumbnail' => false,
        'editor' => false,
        'category' => false,
        'tag' => true,
        'looping_name' => 'Arsip',
        'looping_data' => false,
        'custom_field' =>false,
    ],
    'web' => [
        'api' => true,
        'archive' => true,
        'index' => true,
        'detail' => false,
        'history' => true,
        'auto_query' => true,
        'sortable' => false,
    ],
    'public' => true,
    'cache' => false,
    'active' => true,
]);
add_module([
    'position' => 1,
    'name' => 'hub',
    'title' => 'Hub SPX',
    'description' => 'Menu Untuk Mengelola Hub',
    'parent' => false,
    'icon' => 'fa-truck',
    'route' => ['index', 'create', 'show', 'update', 'delete'],
    'datatable' => [
        'custom_column' => false,
        'data_title' => 'Nama Hub',
        'child_count'=> 'Jumlah  Lowongan'
    ],
    'form' => [
        'unique_title' => true,
        'post_parent' => ['Kecamatan','districts'],
        'thumbnail' => true,
        'editor' => true,
        'category' => true,
        'tag' => true,
        'looping_name' => 'Arsip',
        'looping_data' => false,
        'custom_field' => [['Tanggal Entry', 'datetime']],
    ],
    'web' => [
        'api' => true,
        'archive' => true,
        'index' => true,
        'detail' => true,
        'history' => true,
        'auto_query' => true,
        'sortable' => false,
    ],
    'public' => true,
    'cache' => false,
    'active' => true,
]);
add_module([
    'position' => 1,
    'name' => 'lamaran',
    'title' => 'Data Lamaran',
    'description' => 'Menu Untuk Mengelola Lamar',
    'parent' => false,
    'icon' => 'fa-users ',
    'route' => ['index', 'create', 'show', 'update', 'delete'],
    'datatable' => [
        'custom_column' => ['Nama Lengkap','NIK','Tanggal Lahir','Alamat','Foto KTP','Foto STNK','Foto Kartu Keluarga'],
        'data_title' => 'Nomor Handphone',
    ],
    'form' => [
        'unique_title' => true,
        'post_parent' => ['Lowongan','jobs'],
        'thumbnail' => false,
        'editor' => false,
        'category' => true,
        'tag' => true,
        'looping_name' => 'Kontak darurat',
        'looping_data' => array(
    ['Nama', 'text'],
    ['Hubungan', 'text'],
    ['No HP ', 'text']),
        'custom_field' =>[

    ['Data Identitas', 'break'],
    ['Nama Lengkap', 'text'],
    ['NIK', 'number'],
    ['Tanggal Lahir', 'date'],
    ['No SIM', 'text'],
    ['Expired SIM', 'date'],
    ['No. WhatsApp', 'tel'],
    ['Email Aktif', 'email'],
    ['Alamat saat ini', 'textarea'],
    ['Bank', 'text'],
    ['Pemilik Rekening', 'text'],
    ['No. Rekening', 'number'],
    ['No Plat Motor', 'text'],
    ['Domisili', 'break'],
    ['Kelurahan', 'text'],
    ['Kecamatan', 'text'],
    ['Kabupaten', 'text'],
    ['Lampiran Wajib', 'break'],
    ['Foto SIM (Jika SIM Aktif)', 'file'],
    ['Foto STNK', 'file'],
    ['Foto KTP', 'file'],
    ['Foto Kartu Keluarga', 'file'],
    ['Foto Ijazah', 'file'],
    ['Foto Selfie', 'file'],
]
,
    ],
    'web' => [
        'api' => false,
        'archive' => false,
        'index' => false,
        'detail' => false,
        'history' => false,
        'auto_query' => false,
        'sortable' => false,
    ],
    'public' => true,
    'cache' => false,
    'active' => true,
]);
add_module([
    'position' => 1,
    'name' => 'jobs',
    'title' => 'Lowongan',
    'description' => 'Menu Untuk Mengelola Lowongan',
    'parent' => false,
    'icon' => 'fa-thumb-tack ',
    'route' => ['index', 'create', 'show', 'update', 'delete'],
    'datatable' => [
        'custom_column' => false,
        'data_title' => 'Nama Lowongan',
        'child_count'=>'Jumlah Pelamar'

    ],
    'form' => [
        'unique_title' => true,
        'post_parent' => ['Hub SPX','hub'],
        'thumbnail' => true,
        'editor' => true,
        'category' => true,
        'tag' => true,
        'looping_name' => 'Arsip',
        'looping_data' => false,
        'custom_field' => [['Tanggal Entry', 'datetime']],
    ],
    'web' => [
        'api' => true,
        'archive' => true,
        'index' => true,
        'detail' => true,
        'history' => true,
        'auto_query' => true,
        'sortable' => false,
    ],
    'public' => true,
    'cache' => false,
    'active' => true,
]);