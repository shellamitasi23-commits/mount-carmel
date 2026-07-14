<?php

use App\Models\User;
use App\Models\Cluster;
use App\Models\Lahan;
use App\Models\Reservasi;

it('allows a field coordinator to confirm land as available', function () {
    // 1. Setup data
    $buyer = User::factory()->create(['role' => 'pembeli']);
    $coordinator = User::factory()->create(['role' => 'koordinator_lapangan']);
    
    $cluster = Cluster::create([
        'nama_cluster' => 'Test Cluster',
        'kategori' => 'Muslim',
        'deskripsi' => 'Test Description'
    ]);
    
    $lahan = Lahan::create([
        'cluster_id' => $cluster->id,
        'nomor_lahan' => 'A1',
        'tipe_lahan' => 'Single',
        'hadap' => 'Utara',
        'ukuran' => '2x5',
        'kapasitas' => 1,
        'harga' => 15000000,
        'status' => 'Reservasi (Lunas)'
    ]);
    
    $reservasi = Reservasi::create([
        'user_id' => $buyer->id,
        'lahan_id' => $lahan->id,
        'tanggal_reservasi' => now()->toDateString(),
        'status_reservasi' => 'Menunggu Validasi',
        'konfirmasi_lahan' => 'Belum Dikonfirmasi',
        'status_pembayaran' => 'Belum Bayar',
        'jenis_pembayaran' => 'tunai',
        'biaya_reservasi' => 15000000,
        'biaya_penuh' => 15000000,
    ]);
    
    // 2. Perform action as coordinator
    $response = $this->actingAs($coordinator)
        ->from(route('koordinator_lapangan.reservasi.index'))
        ->put(route('koordinator_lapangan.reservasi.konfirmasi_tersedia', $reservasi->id));
        
    // 3. Assertions
    $response->assertRedirect(route('koordinator_lapangan.reservasi.index'));
    $response->assertSessionHas('success');
    
    $reservasi->refresh();
    expect($reservasi->konfirmasi_lahan)->toBe('Tersedia');
    expect($reservasi->status_reservasi)->toBe('Menunggu Validasi');
});

it('allows a field coordinator to confirm land as unavailable and automatically rejects reservation', function () {
    // 1. Setup data
    $buyer = User::factory()->create(['role' => 'pembeli']);
    $coordinator = User::factory()->create(['role' => 'koordinator_lapangan']);
    
    $cluster = Cluster::create([
        'nama_cluster' => 'Test Cluster',
        'kategori' => 'Muslim',
        'deskripsi' => 'Test Description'
    ]);
    
    $lahan = Lahan::create([
        'cluster_id' => $cluster->id,
        'nomor_lahan' => 'B2',
        'tipe_lahan' => 'Single',
        'hadap' => 'Selatan',
        'ukuran' => '2x5',
        'kapasitas' => 1,
        'harga' => 15000000,
        'status' => 'Reservasi (Lunas)'
    ]);
    
    $reservasi = Reservasi::create([
        'user_id' => $buyer->id,
        'lahan_id' => $lahan->id,
        'tanggal_reservasi' => now()->toDateString(),
        'status_reservasi' => 'Menunggu Validasi',
        'konfirmasi_lahan' => 'Belum Dikonfirmasi',
        'status_pembayaran' => 'Belum Bayar',
        'jenis_pembayaran' => 'tunai',
        'biaya_reservasi' => 15000000,
        'biaya_penuh' => 15000000,
    ]);
    
    // 2. Perform action as coordinator
    $response = $this->actingAs($coordinator)
        ->from(route('koordinator_lapangan.reservasi.index'))
        ->put(route('koordinator_lapangan.reservasi.konfirmasi_tidak_tersedia', $reservasi->id));
        
    // 3. Assertions
    $response->assertRedirect(route('koordinator_lapangan.reservasi.index'));
    $response->assertSessionHas('success');
    
    $reservasi->refresh();
    $lahan->refresh();
    expect($reservasi->konfirmasi_lahan)->toBe('Tidak Tersedia');
    expect($reservasi->status_reservasi)->toBe('Ditolak');
    expect($lahan->status)->toBe('Tersedia');
});

it('prevents non-field coordinators from confirming land availability', function () {
    $buyer = User::factory()->create(['role' => 'pembeli']);
    $otherUser = User::factory()->create(['role' => 'marketing']);
    
    $cluster = Cluster::create([
        'nama_cluster' => 'Test Cluster',
        'kategori' => 'Muslim',
        'deskripsi' => 'Test Description'
    ]);
    
    $lahan = Lahan::create([
        'cluster_id' => $cluster->id,
        'nomor_lahan' => 'C3',
        'tipe_lahan' => 'Single',
        'hadap' => 'Timur',
        'ukuran' => '2x5',
        'kapasitas' => 1,
        'harga' => 15000000,
        'status' => 'Reservasi (Lunas)'
    ]);
    
    $reservasi = Reservasi::create([
        'user_id' => $buyer->id,
        'lahan_id' => $lahan->id,
        'tanggal_reservasi' => now()->toDateString(),
        'status_reservasi' => 'Menunggu Validasi',
        'konfirmasi_lahan' => 'Belum Dikonfirmasi',
        'status_pembayaran' => 'Belum Bayar',
        'jenis_pembayaran' => 'tunai',
        'biaya_reservasi' => 15000000,
        'biaya_penuh' => 15000000,
    ]);
    
    $response = $this->actingAs($otherUser)
        ->put(route('koordinator_lapangan.reservasi.konfirmasi_tersedia', $reservasi->id));
        
    $response->assertRedirect(route('marketing.dashboard'));
});
