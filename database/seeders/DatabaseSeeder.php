<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PropertyUnit;
use App\Models\Asset;

class DatabaseSeeder extends Seeder
{
    private array $standardAssets = [
        ['name' => 'AC Split 1 PK',        'category' => 'AC',        'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Water Heater',          'category' => 'Plumbing',  'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Kulkas 2 Pintu',        'category' => 'Perabotan', 'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Mesin Cuci',            'category' => 'Perabotan', 'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Kompor & Hood Dapur',   'category' => 'Perabotan', 'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Lemari Pakaian',        'category' => 'Perabotan', 'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Panel Listrik Unit',    'category' => 'Listrik',   'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
        ['name' => 'Kran & Shower Kamar Mandi', 'category' => 'Plumbing', 'condition' => 'Good', 'status' => 'active', 'purchase_date' => '2022-01-01'],
    ];

    public function run(): void
    {
        // Roles: Admin
        User::create(['name' => 'Admin SIPEMA', 'email' => 'admin@mail.com', 'password' => Hash::make('AdminPalazzo123!'), 'role' => 'admin']);
        
        // Technicians
        User::create(['name' => 'Budi Santoso', 'email' => 'tech@mail.com', 'password' => Hash::make('TechBudi2026'), 'role' => 'technician']);
        User::create(['name' => 'Agus Prabowo', 'email' => 'tech2@mail.com', 'password' => Hash::make('TechAgus2026'), 'role' => 'technician']);
        
        // Owner
        User::create(['name' => 'Owner Properti', 'email' => 'owner@mail.com', 'password' => Hash::make('OwnerBos789'), 'role' => 'owner']);

        // 10 Tenant accounts with lease ending in 2030
        $tenants = [
            ['name' => 'Andi Wijaya',     'unit' => 'A-101', 'floor' => 'Lantai 1', 'lease_start' => '2023-01-01', 'lease_end' => '2030-05-15', 'phone' => '08111000001'],
            ['name' => 'Bela Pertiwi',    'unit' => 'A-102', 'floor' => 'Lantai 1', 'lease_start' => '2024-02-01', 'lease_end' => '2030-08-20', 'phone' => '08111000002'],
            ['name' => 'Candra Putra',    'unit' => 'A-201', 'floor' => 'Lantai 2', 'lease_start' => '2023-01-15', 'lease_end' => '2030-01-10', 'phone' => '08111000003'],
            ['name' => 'Dewi Lestari',    'unit' => 'A-202', 'floor' => 'Lantai 2', 'lease_start' => '2024-12-01', 'lease_end' => '2030-12-01', 'phone' => '08111000004'],
            ['name' => 'Eko Prasetyo',    'unit' => 'B-101', 'floor' => 'Lantai 1', 'lease_start' => '2025-03-01', 'lease_end' => '2030-06-30', 'phone' => '08111000005'],
            ['name' => 'Fitri Handayani', 'unit' => 'B-102', 'floor' => 'Lantai 1', 'lease_start' => '2025-04-01', 'lease_end' => '2030-11-15', 'phone' => '08111000006'],
            ['name' => 'Galih Santosa',   'unit' => 'B-201', 'floor' => 'Lantai 2', 'lease_start' => '2025-05-01', 'lease_end' => '2030-09-05', 'phone' => '08111000007'],
            ['name' => 'Hani Rahayu',     'unit' => 'B-202', 'floor' => 'Lantai 2', 'lease_start' => '2025-01-01', 'lease_end' => '2030-10-10', 'phone' => '08111000008'],
            ['name' => 'Irfan Maulana',   'unit' => 'C-101', 'floor' => 'Lantai 1', 'lease_start' => '2025-06-01', 'lease_end' => '2030-04-20', 'phone' => '08111000009'],
            ['name' => 'Jeni Susanti',    'unit' => 'C-102', 'floor' => 'Lantai 1', 'lease_start' => '2025-07-01', 'lease_end' => '2030-07-25', 'phone' => '08111000010'],
        ];

        foreach ($tenants as $i => $data) {
            $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
            $user = User::create([
                'name'     => $data['name'],
                'email'    => "tenant{$num}@mail.com",
                // Password dinamis berdasarkan nomor unit (Contoh: TenantA-101!)
                'password' => Hash::make('Tenant' . $data['unit'] . '!'),
                'role'     => 'tenant',
                'phone'    => $data['phone'],
            ]);

            $unit = PropertyUnit::create([
                'unit_number' => $data['unit'],
                'type'        => 'Hunian',
                'floor'       => $data['floor'],
                'status'      => 'occupied',
                'user_id'     => $user->id,
                'lease_start' => $data['lease_start'],
                'lease_end'   => $data['lease_end'],
            ]);

            foreach ($this->standardAssets as $asset) {
                Asset::create(array_merge($asset, ['property_unit_id' => $unit->id]));
            }
        }
    }
}
