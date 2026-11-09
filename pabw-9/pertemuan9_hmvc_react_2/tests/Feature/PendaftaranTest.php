<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Modules\Pendaftaran\Models\Daftar;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create());
});

/**
 * Storage::disk() bertipe kontrak Filesystem, sedangkan assertExists()
 * dan assertMissing() hanya ada pada FilesystemAdapter.
 */
function fakePublicDisk(): FilesystemAdapter
{
    /** @var FilesystemAdapter $disk */
    $disk = Storage::disk('public');

    return $disk;
}

function dataPendaftar(array $overrides = []): array
{
    return [
        'nama' => 'Budi Santoso',
        'asal_sekolah' => 'SMA Negeri 1',
        'prodi_tujuan' => 'Informatika',
        'email' => 'budi@example.com',
        'no_hp' => '081234567890',
        ...$overrides,
    ];
}

test('index renders the react page of the module', function () {
    $this->get('/pendaftaran')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component(
            'Pendaftaran::index',
            false
        ));
});

test('data endpoint returns registrations as json', function () {
    Daftar::factory()->count(3)->create();

    $this->getJson('/pendaftaran/data')->assertOk()->assertJsonCount(3);
});

test('store returns 422 when the form is empty', function () {
    $this->postJson('/pendaftaran', [])
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'nama',
            'asal_sekolah',
            'prodi_tujuan',
            'email',
            'no_hp',
            'berkas',
        ]);
});

test('store saves the data and the uploaded file', function () {
    $this->post('/pendaftaran', dataPendaftar([
        'berkas' => UploadedFile::fake()->image('rapor_budi.png'),
    ]), ['Accept' => 'application/json'])
        ->assertOk()
        ->assertJson(['success' => 'Data berhasil disimpan.']);

    $daftar = Daftar::firstOrFail();

    expect($daftar->nama_berkas)->toBe('rapor_budi.png');
    fakePublicDisk()->assertExists($daftar->berkas);
});

test('zip file is rejected', function () {
    $this->post('/pendaftaran', dataPendaftar([
        'berkas' => UploadedFile::fake()->create('berkas.zip', 100),
    ]), ['Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJsonValidationErrors('berkas');

    $this->assertDatabaseCount('daftars', 0);
});

test('update replaces the old file', function () {
    $this->post('/pendaftaran', dataPendaftar([
        'berkas' => UploadedFile::fake()->image('lama.png'),
    ]), ['Accept' => 'application/json'])->assertOk();

    $daftar = Daftar::firstOrFail();
    $oldPath = $daftar->berkas;

    $this->post("/pendaftaran/{$daftar->id}", dataPendaftar([
        '_method' => 'PUT',
        'prodi_tujuan' => 'Sistem Informasi',
        'berkas' => UploadedFile::fake()->create(
            'surat_keterangan.pdf',
            100,
            'application/pdf'
        ),
    ]), ['Accept' => 'application/json'])
        ->assertOk()
        ->assertJson(['success' => 'Data berhasil diperbarui.']);

    $daftar->refresh();

    fakePublicDisk()->assertMissing($oldPath);
    fakePublicDisk()->assertExists($daftar->berkas);
    expect($daftar->prodi_tujuan)->toBe('Sistem Informasi')
        ->and($daftar->nama_berkas)->toBe('surat_keterangan.pdf');
});

test('destroy deletes the data and its file, unknown id returns 404', function () {
    $this->post('/pendaftaran', dataPendaftar([
        'berkas' => UploadedFile::fake()->image('rapor.png'),
    ]), ['Accept' => 'application/json'])->assertOk();

    $daftar = Daftar::firstOrFail();
    $path = $daftar->berkas;

    $this->deleteJson("/pendaftaran/{$daftar->id}")->assertOk();

    fakePublicDisk()->assertMissing($path);
    $this->assertDatabaseMissing('daftars', ['id' => $daftar->id]);
    $this->deleteJson('/pendaftaran/999')->assertNotFound();
});
