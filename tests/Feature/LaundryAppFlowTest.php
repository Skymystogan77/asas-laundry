<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LaundryAppFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $kasir;
    protected $layanan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->kasir = User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir@test.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);

        $this->layanan = Layanan::create([
            'nama_layanan' => 'Reguler',
            'harga_per_kg' => 7000,
            'durasi' => '3-4 hari',
            'deskripsi' => 'Paket cuci reguler hemat',
        ]);
    }

    public function test_login_and_logout_flow(): void
    {
        // 1. Tampilan login dapat diakses
        $res = $this->get('/login');
        $res->assertStatus(200);

        // 2. Login berhasil dengan akun benar
        $loginRes = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);
        $loginRes->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);

        // 3. Logout
        $logoutRes = $this->post('/logout');
        $logoutRes->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_registration_flow(): void
    {
        $res = $this->post('/register', [
            'name' => 'User Baru',
            'email' => 'baru@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'kasir',
        ]);

        $res->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'baru@test.com',
            'role' => 'kasir',
        ]);
    }

    public function test_admin_can_crud_layanan(): void
    {
        // Akses sebagai Admin
        $this->actingAs($this->admin);

        // 1. Create Layanan
        $createRes = $this->post('/layanan', [
            'nama_layanan' => 'Superkilat',
            'harga_per_kg' => 25000,
            'durasi' => '5 jam',
            'deskripsi' => 'Cuci kilat 5 jam',
        ]);
        $createRes->assertRedirect('/layanan');
        $this->assertDatabaseHas('layanans', ['nama_layanan' => 'Superkilat']);

        $layananBaru = Layanan::where('nama_layanan', 'Superkilat')->first();

        // 2. Update Layanan
        $updateRes = $this->put("/layanan/{$layananBaru->id}", [
            'nama_layanan' => 'Superkilat Premium',
            'harga_per_kg' => 28000,
            'durasi' => '4 jam',
            'deskripsi' => 'Cuci ekstra kilat',
        ]);
        $updateRes->assertRedirect('/layanan');
        $this->assertDatabaseHas('layanans', ['nama_layanan' => 'Superkilat Premium', 'harga_per_kg' => 28000]);

        // 3. Delete Layanan
        $deleteRes = $this->delete("/layanan/{$layananBaru->id}");
        $deleteRes->assertRedirect('/layanan');
        $this->assertDatabaseMissing('layanans', ['id' => $layananBaru->id]);
    }

    public function test_kasir_cannot_create_or_delete_layanan(): void
    {
        // Akses sebagai Kasir
        $this->actingAs($this->kasir);

        // Kasir coba akses form create layanan -> ditolak / redirect
        $resCreate = $this->get('/layanan/create');
        $resCreate->assertRedirect('/layanan');

        // Kasir coba hapus layanan -> ditolak / redirect
        $resDelete = $this->delete("/layanan/{$this->layanan->id}");
        $resDelete->assertRedirect('/layanan');
        $this->assertDatabaseHas('layanans', ['id' => $this->layanan->id]);
    }

    public function test_transaksi_order_and_status_flow(): void
    {
        $this->actingAs($this->kasir);

        // 1. Buat transaksi baru
        $storeRes = $this->post('/transaksi', [
            'kode_invoice' => 'TRX-TEST-001',
            'nama_pelanggan' => 'Andi Wijaya',
            'no_hp' => '081299998888',
            'layanan_id' => $this->layanan->id,
            'berat' => 3.0,
            'status_pembayaran' => 'Lunas',
            'catatan' => 'Baju batik tolong hati-hati',
        ]);

        $storeRes->assertRedirect('/transaksi');
        $this->assertDatabaseHas('transaksis', [
            'kode_invoice' => 'TRX-TEST-001',
            'nama_pelanggan' => 'Andi Wijaya',
            'total_harga' => 21000, // 3.0 * 7000
            'status_pengerjaan' => 'Proses',
        ]);

        $trx = Transaksi::where('kode_invoice', 'TRX-TEST-001')->first();

        // 2. Update status pengerjaan ke Selesai
        $statusRes = $this->patch("/transaksi/{$trx->id}/status", [
            'status_pengerjaan' => 'Selesai',
        ]);
        $statusRes->assertStatus(302);
        $this->assertDatabaseHas('transaksis', [
            'id' => $trx->id,
            'status_pengerjaan' => 'Selesai',
        ]);

        // 3. Lihat halaman nota
        $notaRes = $this->get("/transaksi/{$trx->id}");
        $notaRes->assertStatus(200);
        $notaRes->assertSee('TRX-TEST-001');
        $notaRes->assertSee('Andi Wijaya');
        $notaRes->assertSee('21.000');
    }

    public function test_transaksi_filter_and_search(): void
    {
        $this->actingAs($this->admin);

        Transaksi::create([
            'kode_invoice' => 'TRX-TEST-SEARCH',
            'nama_pelanggan' => 'Pelanggan Unik',
            'no_hp' => '0899112233',
            'layanan_id' => $this->layanan->id,
            'berat' => 2.0,
            'total_harga' => 14000,
            'status_pengerjaan' => 'Proses',
            'status_pembayaran' => 'Belum Lunas',
            'user_id' => $this->admin->id,
        ]);

        // Test filter search
        $searchRes = $this->get('/transaksi?cari=Pelanggan+Unik');
        $searchRes->assertStatus(200);
        $searchRes->assertSee('TRX-TEST-SEARCH');

        // Test filter status
        $statusFilterRes = $this->get('/transaksi?status=Proses');
        $statusFilterRes->assertStatus(200);
        $statusFilterRes->assertSee('TRX-TEST-SEARCH');
    }
}
