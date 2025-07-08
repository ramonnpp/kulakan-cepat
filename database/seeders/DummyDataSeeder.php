<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Sales;
use App\Models\Customer;
use App\Models\CustomerTier;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Admin;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai proses seeding dengan data dummy Indonesia...');
        $faker = Faker::create('id_ID');

        // Mengosongkan tabel untuk memulai dari awal yang bersih
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TransactionDetail::truncate();
        Transaction::truncate();
        Product::truncate();
        ProductCategory::truncate();
        Customer::truncate();
        Sales::truncate();
        CustomerTier::truncate();
        Admin::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('Tabel lama berhasil dibersihkan.');

        // 1. Membuat Admin
        $this->command->info('Membuat data admin...');
        Admin::create([
            'name' => 'Admin Utama',
            'email' => 'admin@kulakancepat.com',
            'password' => 'password', 
        ]);

        // 2. Membuat Kategori Produk
        $this->command->info('Membuat kategori produk...');
        $categoriesData = [
            ['name' => 'Minuman Kemasan', 'description' => 'Berbagai macam minuman kemasan dan serbuk.'],
            ['name' => 'Makanan Ringan', 'description' => 'Camilan dan makanan ringan untuk segala suasana.'],
            ['name' => 'Kebutuhan Pokok', 'description' => 'Bahan-bahan pokok untuk kebutuhan dapur sehari-hari.'],
            ['name' => 'Perawatan Diri', 'description' => 'Produk kebersihan dan perawatan tubuh.'],
        ];
        foreach ($categoriesData as $cat) { ProductCategory::create($cat); }
        $categories = ProductCategory::all();

       // 3. Membuat Produk
$this->command->info('Membuat data produk...');
$productsData = [
    // Minuman Kemasan
    ['name' => 'Teh Botol Sosro Kotak 250ml (24 kardus)', 'sku' => 'TBS-K250', 'price' => 84000, 'stock' => 5000, 'category_id' => $categories->firstWhere('name', 'Minuman Kemasan')->id_product_category, 'image_path' => 'https://placehold.co/600x400/e74c3c/ffffff?text=Teh+Botol'],
    ['name' => 'Aqua Botol 600ml (24 kardus)', 'sku' => 'AQUA-600', 'price' => 78000, 'stock' => 4000, 'category_id' => $categories->firstWhere('name', 'Minuman Kemasan')->id_product_category, 'image_path' => 'https://placehold.co/600x400/2980b9/ffffff?text=Aqua'],
    ['name' => 'Kopi Kapal Api Sachet (20 pack)', 'sku' => 'KKA-20', 'price' => 68000, 'stock' => 3000, 'category_id' => $categories->firstWhere('name', 'Minuman Kemasan')->id_product_category, 'image_path' => 'https://placehold.co/600x400/2c3e50/ffffff?text=Kapal+Api'],

    // Makanan Ringan
    ['name' => 'Chitato Sapi Panggang 68g (20 kardus)', 'sku' => 'CHT-SP68', 'price' => 200000, 'stock' => 3000, 'category_id' => $categories->firstWhere('name', 'Makanan Ringan')->id_product_category, 'image_path' => 'https://placehold.co/600x400/d35400/ffffff?text=Chitato'],
    ['name' => 'Taro Net BBQ 75g (24 kardus)', 'sku' => 'TARO-BBQ', 'price' => 192000, 'stock' => 2500, 'category_id' => $categories->firstWhere('name', 'Makanan Ringan')->id_product_category, 'image_path' => 'https://placehold.co/600x400/16a085/ffffff?text=Taro'],
    ['name' => 'Qtela Singkong 60g (20 kardus)', 'sku' => 'QTELA-SG', 'price' => 150000, 'stock' => 2200, 'category_id' => $categories->firstWhere('name', 'Makanan Ringan')->id_product_category, 'image_path' => 'https://placehold.co/600x400/8e44ad/ffffff?text=Qtela'],

    // Kebutuhan Pokok
    ['name' => 'Indomie Goreng Original (40 kardus)', 'sku' => 'IDM-GO', 'price' => 120000, 'stock' => 10000, 'category_id' => $categories->firstWhere('name', 'Kebutuhan Pokok')->id_product_category, 'image_path' => 'https://placehold.co/600x400/e67e22/ffffff?text=Indomie'],
    ['name' => 'Beras Ramos 5kg (10 sak)', 'sku' => 'BER-RMS', 'price' => 150000, 'stock' => 2000, 'category_id' => $categories->firstWhere('name', 'Kebutuhan Pokok')->id_product_category, 'image_path' => 'https://placehold.co/600x400/f1c40f/000000?text=Beras'],
    ['name' => 'Minyak Goreng Bimoli 2L (12 kardus)', 'sku' => 'BML-2L', 'price' => 420000, 'stock' => 1500, 'category_id' => $categories->firstWhere('name', 'Kebutuhan Pokok')->id_product_category, 'image_path' => 'https://placehold.co/600x400/f39c12/ffffff?text=Bimoli'],

    // Perawatan Diri
    ['name' => 'Sabun Lifebuoy Batang Merah (36 pcs)', 'sku' => 'LFB-BM', 'price' => 144000, 'stock' => 4000, 'category_id' => $categories->firstWhere('name', 'Perawatan Diri')->id_product_category, 'image_path' => 'https://placehold.co/600x400/c0392b/ffffff?text=Lifebuoy'],
    ['name' => 'Shampo Pantene 180ml (24 botol)', 'sku' => 'PNT-180', 'price' => 480000, 'stock' => 3000, 'category_id' => $categories->firstWhere('name', 'Perawatan Diri')->id_product_category, 'image_path' => 'https://placehold.co/600x400/9b59b6/ffffff?text=Pantene'],
    ['name' => 'Pepsodent 190g (24 kardus)', 'sku' => 'PPSD-190', 'price' => 240000, 'stock' => 2000, 'category_id' => $categories->firstWhere('name', 'Perawatan Diri')->id_product_category, 'image_path' => 'https://placehold.co/600x400/34495e/ffffff?text=Pepsodent'],
];

        foreach ($productsData as $prod) {
            Product::create([
                'name_product' => $prod['name'],
                'SKU' => $prod['sku'],
                'price' => $prod['price'],             
                'total_stock' => $prod['stock'],       
                'id_product_category' => $prod['category_id'],
                'image_path' => $prod['image_path'],   
                'description' => 'Ini adalah deskripsi contoh untuk ' . $prod['name'],
            ]);
        }
        $products = Product::all();

        // 4. Membuat Customer Tiers
        $this->command->info('Membuat tingkatan pelanggan...');
        $tiersData = [['name' => 'Bronze'], ['name' => 'Silver'], ['name' => 'Gold']];
        foreach ($tiersData as $tier) { CustomerTier::create($tier); }
        $tiers = CustomerTier::all();

        // 5. Membuat Tim Sales
        $this->command->info('Membuat tim sales...');
        $salesTeam = Sales::factory(5)->create()->each(function ($sales) use ($faker) {
            $sales->name = $faker->name();
            $sales->save();
        });
        
        // 6. Membuat Pelanggan
        $this->command->info('Membuat data pelanggan...');
        $customers = Customer::factory(50)->create()->each(function ($customer) use ($faker, $salesTeam, $tiers) {
            $customer->name_owner = $faker->name();
            $customer->name_store = 'Toko ' . $faker->lastName . ' Sejahtera';
            $customer->address = $faker->address();
            $customer->id_sales = $salesTeam->random()->id_sales;
            $customer->customer_tier_id = $tiers->random()->id_customer_tier;
            $customer->save();
        });
        
        // 7. Membuat Transaksi untuk 24 bulan terakhir
        $this->command->info('Membuat riwayat transaksi selama 2 tahun...');
        $progressBar = $this->command->getOutput()->createProgressBar(24);
        $progressBar->start();

        for ($i = 23; $i >= 0; $i--) {
            $currentMonth = now()->subMonths($i);
            $numberOfTransactions = rand(5, 20);

            for ($j = 0; $j < $numberOfTransactions; $j++) {
                $transactionDate = $faker->dateTimeInInterval($currentMonth, '+'.rand(0,28).' days');
                
                $transaction = Transaction::create([
                    'id_customer' => $customers->random()->id_customer,
                    'date_transaction' => $transactionDate,
                    'total_price' => 0,
                    'status' => $faker->randomElement(['FINISH', 'FINISH', 'PROCESS', 'SEND', 'CANCEL']),
                    'method_payment' => $faker->randomElement(['Transfer Bank', 'COD']),
                ]);

                $items = $products->random(rand(1, 4));
                $totalPrice = 0;

                foreach ($items as $item) {
                    $quantity = rand(1, 10);
                    $totalPrice += $quantity * $item->price; 
                    TransactionDetail::create([
                        'id_transaction' => $transaction->id_transaction,
                        'id_product' => $item->id_product,
                        'quantity' => $quantity,
                        'unit_price' => $item->price,
                    ]);
                }

                $transaction->total_price = $totalPrice;
                $transaction->save();
            }
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->command->info("\nProses seeding data dummy selesai!");
    }
}
