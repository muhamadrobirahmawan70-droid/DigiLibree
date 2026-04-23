<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Variabel Filter
$authFilter = ['filter' => 'auth'];

// Variabel Role
$admin     = ['filter' => 'role:admin'];
$petugas     = ['filter' => 'role:petugas'];
$anggota     = ['filter' => 'role:anggota'];
$intRole   = ['filter' => 'role:admin, petugas'];
$allRole   = ['filter' => 'role:admin, petugas, anggota'];

// Login
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// Halaman utama
$routes->get('/', 'Home::index', $authFilter);
$routes->get('/dashboard', 'Home::index', $authFilter);
$routes->get('/users/create', 'Users::create'); // form tambah user
$routes->post('/users/store', 'Users::store'); // aksi simpan user

$routes->get('/users', 'Users::index', $intRole); // menampilkan data user
$routes->get('/users/edit/(:num)', 'Users::edit/$1', $allRole); // form edit user
$routes->post('/users/update/(:num)', 'Users::update/$1', $allRole); // aksi update user
$routes->get('/users/delete/(:num)', 'Users::delete/$1', $allRole); // aksi hapus user
$routes->get('users/detail/(:num)', 'Users::detail/$1', $allRole); // aksi detail user
$routes->get('users/print', 'Users::print', $allRole); // aksi print data user
$routes->get('users/wa/(:num)', 'Users::wa/$1', $allRole); // aksi kirim ke whatsapp

$routes->get('/buku', 'Buku::index');
$routes->get('buku/create', 'Buku::create');
$routes->post('buku/store', 'Buku::store');
$routes->get('buku/detail/(:num)', 'Buku::detail/$1');
$routes->get('buku/edit/(:num)', 'Buku::edit/$1');
$routes->post('buku/update/(:num)', 'Buku::update/$1');
$routes->get('buku/delete/(:num)', 'Buku::delete/$1');
$routes->get('buku/print', 'Buku::print');
$routes->get('buku/wa/(:num)', 'Buku::wa/$1');


    // Hapus atau komen kode lama, ganti dengan ini untuk tes
$routes->get('peminjaman', 'Peminjaman::index',$allRole);
$routes->get('peminjaman/create', 'Peminjaman::new',$allRole);
$routes->post('peminjaman/store', 'Peminjaman::store',$allRole); 
$routes->add('peminjaman/store', 'Peminjaman::store',$allRole); // Tambahan: antisipasi kalau method berubah
$routes->get('peminjaman/edit/(:num)', 'Peminjaman::edit/$1',$allRole); 
$routes->post('peminjaman/update/(:num)', 'Peminjaman::update/$1',$allRole); // Proses update
$routes->get('peminjaman/delete/(:num)', 'Peminjaman::delete/$1',$allRole); // Proses hapus
$routes->resource('peminjaman', ['except' => 'show']);
// Route tambahan untuk proses pengembalian buku
$routes->post('peminjaman/kembalikan/(:num)', 'Peminjaman::kembalikan/$1',$allRole);
$routes->get('log', 'Log::index',$allRole);
$routes->get('riwayat', 'Peminjaman::riwayat',$allRole);
// Tambahkan ini di dalam file Routes.php
$routes->post('peminjaman/pinjamKilat/(:num)', 'Peminjaman::pinjamKilat/$1');
$routes->get('peminjaman/riwayat', 'Peminjaman::riwayat');
$routes->get('log/delete/(:num)', 'Log::delete/$1'); // Hapus log per ID (angka)
$routes->get('log/clear', 'Log::clear');     // Kosongkan semua log
// Grouping biar lebih rapi
$routes->group('denda', function($routes) {
    $routes->get('/', 'Denda::index');
    $routes->get('kirimPeringatan/(:any)', 'Denda::kirimPeringatan/$1');
    $routes->post('lunas/(:num)', 'Denda::lunas/$1'); // Tambahin ini Min!
});
$routes->get('peminjaman/persetujuan', 'Peminjaman::persetujuan');
$routes->get('peminjaman/approve/(:num)', 'Peminjaman::approve/$1');
$routes->get('peminjaman/reject/(:num)', 'Peminjaman::reject/$1');

$routes->get('/backup', 'Backup::index');
// Pastikan ini ada di dalam group 'peminjaman' atau sesuaikan dengan URL-mu
$routes->post('peminjaman/lunas/(:num)', 'Peminjaman::lunas/$1');
$routes->post('konfirmasi_bayar/(:num)', 'Peminjaman::konfirmasi_bayar/$1');
$routes->post('peminjaman/simpanUlasan', 'Peminjaman::simpanUlasan');


