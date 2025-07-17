<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KulakanCepat - Grosir Digital Jadi Gampang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html { scroll-behavior: smooth; }
        .gradient-bg { background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%); }
        .card-hover { transition: all 0.3s ease-in-out; }
        .card-hover:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .mobile-menu { display: none; }
        .mobile-menu.active { display: block; }
        @media (max-width: 768px) { .hero-title { font-size: 2.5rem; } }
    </style>
</head>
<body  id="page-top" class="bg-gray-50 text-gray-800 font-sans">

    <header id="header-top" class="bg-white shadow-md border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
            <div class="flex items-center justify-between">
                <a href="#" class="flex items-center space-x-3">
                    <div class="w-16 h-16 flex items-center justify-center">
                        <img src="{{ asset('img/logo/Artboard 1 copy.png') }}" alt="Logo KulakanCepat">
                    </div>
                    <span class="text-2xl font-extrabold text-red-700">KulakanCepat</span>
                </a>
                
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#merchant" class="text-gray-600 hover:text-red-700 font-semibold transition-colors">Merchant</a>
                    <a href="#solusi" class="text-gray-600 hover:text-red-700 font-semibold transition-colors">Solusi Kami</a>
                    <a href="#berita" class="text-gray-600 hover:text-red-700 font-semibold transition-colors">Berita</a>

                    {{-- Logika dinamis berdasarkan status login --}}
                    @guest
                        {{-- Jika user adalah tamu (belum login) --}}
                        <a href="{{ route('login') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-semibold hover:bg-red-800 transition-transform hover:scale-105 shadow-sm">Masuk</a>
                    @else
                        {{-- Jika user sudah login --}}
                        <span class="text-gray-700 font-medium">Hi, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="bg-gray-700 text-white px-6 py-2 rounded-full font-semibold hover:bg-gray-800 transition-colors shadow-sm">
                           Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </nav>
                
                <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            
            <div id="mobileMenu" class="mobile-menu md:hidden mt-4 pb-4 border-t border-gray-200">
                <div class="flex flex-col space-y-4 pt-4">
                    <a href="#merchant" class="text-gray-700 hover:text-red-700 font-medium px-2 py-1">Merchant</a>
                    <a href="#solusi" class="text-gray-700 hover:text-red-700 font-medium px-2 py-1">Solusi Kami</a>
                    <a href="#berita" class="text-gray-700 hover:text-red-700 font-medium px-2 py-1">Berita</a>
                    @guest
                        <a href="{{ route('login') }}" class="bg-red-700 text-white px-6 py-2 rounded-full font-semibold text-center mt-2">Masuk</a>
                        <a href="{{ route('register') }}" class="border border-red-700 text-red-700 px-6 py-2 rounded-full font-semibold text-center">Daftar</a>
                    @else
                        <span class="text-gray-700 font-medium px-4 py-2">Hi, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                           class="bg-gray-700 text-white px-6 py-2 rounded-full font-semibold text-center">
                           Logout
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <section class="gradient-bg text-white py-24 px-6 relative overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="text-center md:text-left max-w-xl">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 hero-title">Belanja Grosir, Nggak Pernah Segampang Ini</h1>
                <p class="text-lg md:text-xl mb-8 opacity-90">KulakanCepat hadir untuk bantu toko dan UMKM se-Indonesia naik kelas.</p>
                @guest
                    <a href="{{ route('register') }}" class="bg-white text-red-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-red-100 transition shadow-lg inline-block transform hover:scale-105">Daftar Sekarang</a>
                @else
                    <a href="{{ route('catalog.index') }}" class="bg-white text-red-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-red-100 transition shadow-lg inline-block transform hover:scale-105">Mulai Belanja</a>
                @endguest
            </div>
            <img src="{{ asset('img/logo/Truk.png') }}" alt="Truk" class="w-full max-w-2xl md:w-1/2 drop-shadow-2xl rounded-2xl transition-transform duration-300 hover:scale-105" />
        </div>
    </section>

    <section id="merchant" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-red-700 mb-4">Gabung Ekosistem Grosir Digital #1</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Baik Anda prinsipal besar atau pemilik toko, kami punya solusi untuk memajukan bisnis Anda.
                </p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8 items-stretch">
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-8 lg:p-12 rounded-3xl shadow-lg card-hover flex flex-col">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-red-700 rounded-2xl flex items-center justify-center mr-5 shadow-md">
                            <i class="fas fa-industry text-white text-2xl"></i>
                        </div>
                        <h3 class="text-red-800 font-bold text-3xl">#UntukPrinsipal</h3>
                    </div>
                    <p class="text-gray-700 text-lg mb-6 flex-grow">
                        Jangkau ribuan toko dan UMKM di seluruh Indonesia. Perluas distribusi produk Anda dengan lebih cepat dan efisien.
                    </p>
                    <ul class="text-gray-700 space-y-3">
                        <li class="flex items-center font-medium"><i class="fas fa-check-circle text-red-700 mr-3"></i> Akses ke ribuan toko retail potensial</li>
                        <li class="flex items-center font-medium"><i class="fas fa-check-circle text-red-700 mr-3"></i> Sistem distribusi terdigitalisasi</li>
                        <li class="flex items-center font-medium"><i class="fas fa-check-circle text-red-700 mr-3"></i> Dashboard analitik penjualan real-time</li>
                    </ul>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 lg:p-12 rounded-3xl shadow-lg card-hover flex flex-col">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-blue-700 rounded-2xl flex items-center justify-center mr-5 shadow-md">
                            <i class="fas fa-store text-white text-2xl"></i>
                        </div>
                        <h3 class="text-blue-800 font-bold text-3xl">#UntukToko</h3>
                    </div>
                    <p class="text-gray-700 text-lg mb-6 flex-grow">
                        Stok barang jadi lebih mudah dan murah. Dapatkan produk grosir terpercaya langsung dari distributor resmi.
                    </p>
                    <ul class="text-gray-700 space-y-3">
                        <li class="flex items-center font-medium"><i class="fas fa-check-circle text-blue-700 mr-3"></i> Harga grosir super kompetitif</li>
                        <li class="flex items-center font-medium"><i class="fas fa-check-circle text-blue-700 mr-3"></i> Pengiriman cepat dan terjamin</li>
                        <li class="flex items-center font-medium"><i class="fas fa-check-circle text-blue-700 mr-3"></i> Opsi pembayaran fleksibel (limit kredit)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="solusi" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-red-700 mb-4">Kenapa Memilih KulakanCepat?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Platform grosir digital terintegrasi yang dirancang khusus untuk memudahkan distribusi produk dan pengelolaan stok.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Fitur 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-red-100 text-red-700 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-bolt text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Proses Super Cepat</h3>
                <p class="text-gray-600">
                    Dari pesan sampai barang datang hanya dalam hitungan jam. Sistem kami yang terintegrasi memastikan proses pengiriman lebih efisien.
                </p>
            </div>
            
            <!-- Fitur 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-blue-100 text-blue-700 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-percentage text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Harga Grosir Terbaik</h3>
                <p class="text-gray-600">
                    Dapatkan harga langsung dari distributor tanpa perantara. Kami negosiasikan harga khusus untuk member KulakanCepat.
                </p>
            </div>
            
            <!-- Fitur 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-green-100 text-green-700 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">100% Produk Asli</h3>
                <p class="text-gray-600">
                    Hanya bekerja dengan distributor resmi dan merchant terverifikasi. Jaminan keaslian produk dan kualitas terbaik.
                </p>
            </div>
            
            <!-- Fitur 4 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-purple-100 text-purple-700 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-credit-card text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Pembayaran Fleksibel</h3>
                <p class="text-gray-600">
                    Berbagai metode pembayaran mulai dari transfer, COD, hingga fasilitas kredit untuk member terdaftar.
                </p>
            </div>
            
            <!-- Fitur 5 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-700 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Analisis Bisnis</h3>
                <p class="text-gray-600">
                    Fitur laporan penjualan dan prediksi stok membantu Anda mengambil keputusan bisnis yang lebih cerdas.
                </p>
            </div>
            
            <!-- Fitur 6 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow border border-gray-200 card-hover">
                <div class="w-16 h-16 bg-indigo-100 text-indigo-700 rounded-xl flex items-center justify-center mb-6">
                    <i class="fas fa-headset text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">Dukungan 24/7</h3>
                <p class="text-gray-600">
                    Tim support kami siap membantu kapan saja. Masalah teknis atau pertanyaan seputar produk? Kami siap bantu!
                </p>
            </div>
        </div>
        
        <div class="mt-16 bg-red-50 border border-red-200 rounded-2xl p-8 md:p-12 shadow-lg">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <h3 class="text-2xl md:text-3xl font-bold text-red-700 mb-4">Satu Platform untuk Semua Kebutuhan Grosir Anda</h3>
                    <p class="text-gray-700 mb-6">
                        KulakanCepat menghadirkan solusi end-to-end untuk distribusi produk grosir. Mulai dari pemesanan, pembayaran, hingga pengiriman - semua dalam satu platform yang mudah digunakan.
                    </p>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('img/logo/dasbord.jpg') }}" alt="Dashboard Preview" class="rounded-xl shadow-md w-full">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="how-it-works" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-red-700 mb-4">Hanya 3 Langkah Mudah</h2>
            <p class="text-xl text-gray-600">Mulai gunakan KulakanCepat sekarang juga</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-16">
            <div class="flex-1 text-center">
                <div class="w-24 h-24 bg-red-100 text-red-700 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">1</div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Daftar Gratis</h3>
                <p class="text-gray-600 max-w-md mx-auto">Buat akun merchant atau toko hanya dalam 2 menit. Verifikasi sederhana dan tanpa biaya.</p>
            </div>
            
            <div class="hidden md:block">
                <i class="fas fa-arrow-right text-gray-400 text-2xl"></i>
            </div>
            
            <div class="flex-1 text-center">
                <div class="w-24 h-24 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">2</div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Jelajahi Katalog</h3>
                <p class="text-gray-600 max-w-md mx-auto">Temukan ribuan produk grosir dengan harga terbaik langsung dari distributor.</p>
            </div>
            
            <div class="hidden md:block">
                <i class="fas fa-arrow-right text-gray-400 text-2xl"></i>
            </div>
            
            <div class="flex-1 text-center">
                <div class="w-24 h-24 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-6">3</div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pesan & Terima</h3>
                <p class="text-gray-600 max-w-md mx-auto">Order dengan sekali klik dan barang akan dikirim langsung ke lokasi Anda.</p>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Mulai Hari Ini, Rasakan Bedanya!</h3>
                    <p class="text-gray-600 mb-6">Bergabunglah dengan ribuan merchant dan toko yang sudah merasakan kemudahan berbisnis dengan KulakanCepat.</p>
                </div>
                <div class="hidden md:block bg-red-50 relative">
                    <img src="{{ asset('img/logo/mbak.jpg') }}" alt="Join Now" class="absolute h-full w-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<section id="achievements" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl font-bold text-red-700 mb-4">KulakanCepat dalam Angka</h2>
            <p class="text-xl text-gray-600">Bukti nyata dampak positif platform kami untuk bisnis Anda</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div class="p-6 rounded-xl bg-red-50 card-hover">
                <div class="text-5xl font-extrabold text-red-700 mb-3" id="counter1">0</div>
                <h3 class="text-xl font-semibold text-gray-800">Merchant Terdaftar</h3>
                <p class="text-gray-600 mt-2">Distributor & produsen terpercaya</p>
            </div>
            
            <div class="p-6 rounded-xl bg-blue-50 card-hover">
                <div class="text-5xl font-extrabold text-blue-700 mb-3" id="counter2">0</div>
                <h3 class="text-xl font-semibold text-gray-800">Toko Mitra</h3>
                <p class="text-gray-600 mt-2">UMKM yang berkembang bersama kami</p>
            </div>
            
            <div class="p-6 rounded-xl bg-green-50 card-hover">
                <div class="text-5xl font-extrabold text-green-700 mb-3" id="counter3">0</div>
                <h3 class="text-xl font-semibold text-gray-800">Produk Tersedia</h3>
                <p class="text-gray-600 mt-2">Beragam kategori kebutuhan usaha</p>
            </div>
            
            <div class="p-6 rounded-xl bg-yellow-50 card-hover">
                <div class="text-5xl font-extrabold text-yellow-700 mb-3" id="counter4">0</div>
                <h3 class="text-xl font-semibold text-gray-800">Transaksi/Bulan</h3>
                <p class="text-gray-600 mt-2">Bukti kepercayaan pelanggan</p>
            </div>
        </div>
    </div>
    
    <script>
        // Animasi counter
        function animateCounter(id, target, duration) {
            const element = document.getElementById(id);
            const increment = target / (duration / 16);
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target.toLocaleString();
                }
            };
            
            updateCounter();
        }
        
        // Jalankan saat section muncul di viewport
        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                animateCounter('counter1', 1250, 1000);
                animateCounter('counter2', 8500, 1000);
                animateCounter('counter3', 15000, 1000);
                animateCounter('counter4', 120000, 1000);
                observer.unobserve(entries[0].target);
            }
        }, { threshold: 0.5 });
        
        observer.observe(document.getElementById('achievements'));
    </script>
</section>





    <section class="gradient-bg text-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-4xl lg:text-5xl font-extrabold mb-6">Siap Mengubah Cara Anda Berbisnis?</h2>
            <p class="text-xl lg:text-2xl mb-10 text-red-100 opacity-90">Mulai perjalanan bisnis grosir digital Anda bersama ribuan merchant dan toko lainnya.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#page-top"class="bg-white text-red-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-red-50 transition-transform hover:scale-105 shadow-lg inline-flex items-center justify-center">
                    <i class="fas fa-rocket mr-3"></i>Mulai Sekarang
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-red-700 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-phone mr-3"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    

  <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Kolom KulakanCepat -->
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">KulakanCepat</h3>
                <p class="text-sm">Platform grosir digital terdepan yang menghubungkan merchant dengan toko retail di seluruh Indonesia.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Kolom Produk -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Produk</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/produk/untuk-merchant') }}" class="hover:underline">Untuk Merchant</a></li>
                    <li><a href="{{ url('/produk/untuk-toko') }}" class="hover:underline">Untuk Toko</a></li>
                    <li><a href="{{ url('/produk/sistem-pembayaran') }}" class="hover:underline">Sistem Pembayaran</a></li>
                    <li><a href="{{ url('/produk/logistik') }}" class="hover:underline">Logistik</a></li>
                </ul>
            </div>

            <!-- Kolom Perusahaan -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Perusahaan</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/perusahaan/tentang-kami') }}" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="{{ url('/perusahaan/karir') }}" class="hover:underline">Karir</a></li>
                    <li><a href="{{ url('/perusahaan/blog') }}" class="hover:underline">Blog</a></li>
                    <li><a href="{{ url('/perusahaan/press-release') }}" class="hover:underline">Press Release</a></li>
                </ul>
            </div>

            <!-- Kolom Dukungan -->
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Dukungan</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/dukungan/pusat-bantuan') }}" class="hover:underline">Pusat Bantuan</a></li>
                    <li><a href="{{ url('/dukungan/syarat-ketentuan') }}" class="hover:underline">Syarat & Ketentuan</a></li>
                    <li><a href="{{ url('/dukungan/kebijakan-privasi') }}" class="hover:underline">Kebijakan Privasi</a></li>
                    <li><a href="{{ url('/dukungan/kontak') }}" class="hover:underline">Kontak</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm">
            &copy; {{ date('Y') }} KulakanCepat. All rights reserved. Universitas Amikom Yogyakarta. Kampus Tercintah.
        </div>
    </div>
</footer>


    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }
        
        // Fungsi untuk smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Tutup menu mobile jika sedang terbuka
                    const menu = document.getElementById('mobileMenu');
                    if(menu.classList.contains('active')) {
                        menu.classList.remove('active');
                    }
                    
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>