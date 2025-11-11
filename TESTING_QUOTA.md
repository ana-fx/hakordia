# Panduan Testing Quota Tiket

## Cara Menguji Apakah Quota Berkurang Ketika Payment Diterima

### 1. Persiapan Data

Pastikan Anda memiliki tiket dengan quota terbatas. Contoh dari seeder:
- **Presale 1**: Quota 200 peserta
- **Presale 2**: Quota 300 peserta
- **Normal Price**: Quota unlimited (null)

### 2. Cara Testing Manual

#### Langkah 1: Cek Quota Awal
```bash
php artisan tinker
```

```php
use App\Models\Ticket;

// Cek quota awal tiket
$ticket = Ticket::where('name', 'Presale 1')->first();
echo "Quota awal: " . $ticket->quota . "\n";
echo "Quota terpakai: " . $ticket->getUsedQuota() . "\n";
echo "Sisa quota: " . $ticket->getRemainingQuota() . "\n";
```

#### Langkah 2: Buat Checkout Baru
1. Buka halaman registrasi di browser
2. Isi form pendaftaran dengan beberapa peserta (misalnya 2 peserta)
3. Submit form untuk membuat checkout dengan status "pending"

#### Langkah 3: Cek Quota Sebelum Payment Diterima
```php
// Di tinker atau di code
$ticket = Ticket::where('name', 'Presale 1')->first();
echo "Sisa quota (sebelum paid): " . $ticket->getRemainingQuota() . "\n";
// Seharusnya masih sama dengan quota awal karena status masih pending
```

#### Langkah 4: Ubah Status Menjadi "paid"
1. Login sebagai admin
2. Buka dashboard admin
3. Cari order yang baru dibuat
4. Klik untuk mengubah status menjadi "paid"

#### Langkah 5: Verifikasi Quota Berkurang
```php
// Di tinker
$ticket = Ticket::where('name', 'Presale 1')->first();
echo "Quota awal: " . $ticket->quota . "\n";
echo "Quota terpakai: " . $ticket->getUsedQuota() . "\n";
echo "Sisa quota (setelah paid): " . $ticket->getRemainingQuota() . "\n";

// Contoh hasil:
// Quota awal: 200
// Quota terpakai: 2 (karena ada 1 checkout dengan 2 peserta yang statusnya paid)
// Sisa quota: 198
```

### 3. Testing dengan Artisan Command

Buat command untuk testing cepat:

```bash
php artisan make:command TestQuota
```

Isi command:
```php
<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use App\Models\Checkout;
use Illuminate\Console\Command;

class TestQuota extends Command
{
    protected $signature = 'test:quota {ticket_id}';
    protected $description = 'Test quota reduction for a ticket';

    public function handle()
    {
        $ticketId = $this->argument('ticket_id');
        $ticket = Ticket::find($ticketId);
        
        if (!$ticket) {
            $this->error('Ticket not found');
            return;
        }
        
        $this->info("=== Quota Info untuk {$ticket->name} ===");
        $this->info("Quota awal: {$ticket->quota}");
        $this->info("Quota terpakai: {$ticket->getUsedQuota()}");
        $this->info("Sisa quota: {$ticket->getRemainingQuota()}");
        
        // Tampilkan semua checkout dengan status paid
        $paidCheckouts = Checkout::where('ticket_id', $ticketId)
            ->where('status', 'paid')
            ->get();
            
        $this->info("\n=== Checkout dengan Status Paid ===");
        foreach ($paidCheckouts as $checkout) {
            $this->info("Order: {$checkout->order_number} - Peserta: {$checkout->total_participants}");
        }
    }
}
```

Gunakan:
```bash
php artisan test:quota 1
```

### 4. Testing Otomatis dengan Unit Test

Buat test file:
```bash
php artisan make:test QuotaTest
```

```php
<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\Checkout;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuotaTest extends TestCase
{
    use RefreshDatabase;

    public function test_quota_decreases_when_payment_accepted()
    {
        // Buat tiket dengan quota terbatas
        $ticket = Ticket::create([
            'name' => 'Test Ticket',
            'price' => 100000,
            'start_date' => now()->subDays(1),
            'end_date' => now()->addDays(30),
            'quota' => 100,
        ]);
        
        // Buat checkout dengan status pending
        $checkout = Checkout::create([
            'order_number' => 'TEST001',
            'ticket_id' => $ticket->id,
            'total_amount' => 200000,
            'total_participants' => 2,
            'status' => 'pending',
        ]);
        
        // Verifikasi quota belum berkurang
        $this->assertEquals(100, $ticket->getRemainingQuota());
        
        // Ubah status menjadi paid
        $checkout->status = 'paid';
        $checkout->save();
        
        // Verifikasi quota berkurang
        $ticket->refresh();
        $this->assertEquals(98, $ticket->getRemainingQuota());
        $this->assertEquals(2, $ticket->getUsedQuota());
    }
}
```

Jalankan test:
```bash
php artisan test --filter QuotaTest
```

### 5. Monitoring via Logs

Sistem akan mencatat perubahan quota di log file. Cek:
```bash
tail -f storage/logs/laravel.log | grep "Quota updated"
```

Atau buka file `storage/logs/laravel.log` dan cari "Quota updated".

### 6. Verifikasi di Database

```sql
-- Cek quota tiket
SELECT id, name, quota FROM tickets WHERE id = 1;

-- Cek checkout dengan status paid untuk tiket tertentu
SELECT 
    c.id,
    c.order_number,
    c.status,
    c.total_participants,
    SUM(c.total_participants) OVER (PARTITION BY c.ticket_id) as total_used
FROM checkouts c
WHERE c.ticket_id = 1 AND c.status = 'paid';

-- Hitung sisa quota secara manual
SELECT 
    t.quota - COALESCE(SUM(c.total_participants), 0) as remaining_quota
FROM tickets t
LEFT JOIN checkouts c ON c.ticket_id = t.id AND c.status = 'paid'
WHERE t.id = 1
GROUP BY t.id, t.quota;
```

### 7. Tips Testing

1. **Test dengan berbagai skenario:**
   - Quota cukup → status berubah menjadi paid ✅
   - Quota tidak cukup → status tidak bisa diubah menjadi paid ❌
   - Status diubah dari paid ke pending → quota kembali tersedia ✅

2. **Test edge cases:**
   - Quota = 0
   - Quota = null (unlimited)
   - Multiple checkout dengan status paid

3. **Monitor log file** untuk melihat detail perubahan quota

### 8. Troubleshooting

Jika quota tidak berkurang:
1. Pastikan `ticket_id` di checkout sudah benar
2. Pastikan status checkout adalah "paid" (bukan "waiting" atau "pending")
3. Cek log file untuk error messages
4. Pastikan method `getRemainingQuota()` dipanggil setelah status diubah

