<?php
/**
 * 🚀 ZORLA ÖRNEK İÇERİK EKLEYİCİ - BERAT K R10
 * Bu script 3 örnek proje ve 3 örnek ürünü zorla ekler!
 */

echo "<h1>🚀 ÖRNEK İÇERİK EKLEYİCİ</h1>";
echo "<hr>";

try {
    // Veritabanı bağlantısı
    require_once 'config/database.php';
    require_once 'includes/functions.php';
    
    echo "<h2>1. VERİTABANI BAĞLANTISI ✅</h2>";
    echo "<p>SQLite veritabanına bağlanıldı.</p>";
    
    // Mevcut proje sayısını kontrol et
    echo "<h2>2. MEVCUT İÇERİK KONTROL EDİLİYOR</h2>";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM projects WHERE status = 1");
    $project_count = $stmt->fetchColumn();
    echo "<p>📊 Mevcut proje sayısı: <strong>$project_count</strong></p>";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1");
    $product_count = $stmt->fetchColumn();
    echo "<p>📦 Mevcut ürün sayısı: <strong>$product_count</strong></p>";
    
    // Tabloları kontrol et ve oluştur
    echo "<h2>3. TABLOLAR KONTROL EDİLİYOR</h2>";
    
    // Projects tablosu
    $pdo->exec("CREATE TABLE IF NOT EXISTS projects (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        image VARCHAR(500),
        demo_url VARCHAR(500),
        github_url VARCHAR(500),
        category VARCHAR(100),
        technologies TEXT,
        featured INTEGER DEFAULT 0,
        status INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p>✅ Projects tablosu hazır</p>";
    
    // Products tablosu
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        features TEXT,
        category VARCHAR(100),
        price VARCHAR(100),
        currency VARCHAR(10),
        image VARCHAR(500),
        demo_url VARCHAR(500),
        admin_demo_url VARCHAR(500),
        download_url VARCHAR(500),
        documentation_url VARCHAR(500),
        featured INTEGER DEFAULT 0,
        status INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p>✅ Products tablosu hazır</p>";
    
    // ÖRNEK PROJELER ZORLA EKLEME
    echo "<h2>4. ÖRNEK PROJELER EKLENİYOR</h2>";
    
    $sample_projects = [
        [
            'E-Ticaret Web Sitesi',
            'Modern ve responsive e-ticaret platformu. Kullanıcı dostu arayüz, güvenli ödeme sistemi ve admin paneli ile tam özellikli online mağaza çözümü. Bootstrap, PHP ve MySQL teknolojileri kullanılarak geliştirilmiştir.',
            'assets/img/projects/ecommerce.jpg',
            'https://demo.ecommerce.com',
            'https://github.com/beratk/ecommerce',
            'Web Development',
            'HTML5, CSS3, JavaScript, PHP, MySQL, Bootstrap',
            1
        ],
        [
            'Mobil ToDo Uygulaması',
            'React Native ile geliştirilmiş cross-platform görev yönetimi uygulaması. Offline çalışma, push notification ve senkronizasyon özellikleri içerir. iOS ve Android cihazlarda mükemmel performans sağlar.',
            'assets/img/projects/todo-app.jpg',
            'https://play.google.com/store/apps/details?id=com.beratk.todo',
            'https://github.com/beratk/todo-app',
            'Mobile App',
            'React Native, Redux, Firebase, Node.js, TypeScript',
            1
        ],
        [
            'Portföy Yönetim Sistemi',
            'Finansal portföy takibi ve analizi için geliştirilmiş profesyonel web uygulaması. Gerçek zamanlı veriler, interaktif grafikler, detaylı raporlama modülleri ve risk analizi araçları içerir.',
            'assets/img/projects/portfolio-system.jpg',
            'https://demo.portfolio-system.com',
            'https://github.com/beratk/portfolio-system',
            'Web Application',
            'Vue.js, Laravel, MySQL, Chart.js, WebSocket, Redis',
            1
        ]
    ];
    
    // Önce mevcut projeleri sil (temiz başlangıç)
    $pdo->exec("DELETE FROM projects");
    echo "<p>🗑️ Eski projeler temizlendi</p>";
    
    foreach ($sample_projects as $index => $project) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, demo_url, github_url, category, technologies, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute($project);
        echo "<p>✅ " . ($index + 1) . ". Proje eklendi: <strong>" . $project[0] . "</strong></p>";
    }
    
    // ÖRNEK ÜRÜNLER ZORLA EKLEME
    echo "<h2>5. ÖRNEK ÜRÜNLER EKLENİYOR</h2>";
    
    $sample_products = [
        [
            'CRM Yönetim Sistemi',
            'Müşteri ilişkileri yönetimi için kapsamlı çözüm. Satış takibi, raporlama, e-posta entegrasyonu ve daha fazlası. Küçük ve orta ölçekli işletmeler için ideal bir çözüm.',
            'Müşteri Yönetimi, Satış Takibi, Raporlama, E-posta Entegrasyonu, Kullanıcı Yetkilendirme, Dashboard, API Entegrasyonu',
            'Software',
            '2500',
            'TL',
            'assets/img/products/crm.jpg',
            'https://demo.crm-system.com',
            'https://admin.crm-system.com',
            'https://downloads.com/crm-system.zip',
            'https://docs.crm-system.com',
            1
        ],
        [
            'Blog Yönetim Scripti',
            'Modern ve SEO dostu blog scripti. Çoklu yazar desteği, kategori yönetimi, yorum sistemi ve gelişmiş admin paneli ile blogculuk deneyiminizi profesyonelleştirin.',
            'SEO Optimize, Çoklu Yazar, Kategori Yönetimi, Yorum Sistemi, Responsive Tasarım, Sosyal Medya Entegrasyonu, Analitik Dashboard',
            'Script',
            '850',
            'TL',
            'assets/img/products/blog-script.jpg',
            'https://demo.blog-script.com',
            'https://admin.blog-script.com',
            'https://downloads.com/blog-script.zip',
            'https://docs.blog-script.com',
            1
        ],
        [
            'E-İmza Entegrasyon Modülü',
            'Web uygulamaları için elektronik imza entegrasyon çözümü. Güvenli, hızlı ve kolay entegrasyon imkanı. Türkiye yasal mevzuatına uygun e-imza sistemi.',
            'Elektronik İmza, API Entegrasyonu, Güvenlik, Sertifika Yönetimi, Log Sistemi, Audit Trail, Zamanlı İmza Desteği',
            'Module',
            '1200',
            'TL',
            'assets/img/products/e-signature.jpg',
            'https://demo.e-signature.com',
            'https://admin.e-signature.com',
            'https://downloads.com/e-signature.zip',
            'https://docs.e-signature.com',
            1
        ]
    ];
    
    // Önce mevcut ürünleri sil (temiz başlangıç)
    $pdo->exec("DELETE FROM products");
    echo "<p>🗑️ Eski ürünler temizlendi</p>";
    
    foreach ($sample_products as $index => $product) {
        $stmt = $pdo->prepare("INSERT INTO products (title, description, features, category, price, currency, image, demo_url, admin_demo_url, download_url, documentation_url, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute($product);
        echo "<p>✅ " . ($index + 1) . ". Ürün eklendi: <strong>" . $product[0] . "</strong> - " . $product[4] . " " . $product[5] . "</p>";
    }
    
    // SAYAÇLARI DA KONTROL ET
    echo "<h2>6. SAYAÇLAR KONTROL EDİLİYOR</h2>";
    
    $counter_values = [
        'stat_projects' => '150',
        'stat_clients' => '85',
        'stat_years' => '5',
        'stat_awards' => '12'
    ];
    
    foreach ($counter_values as $key => $value) {
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO settings (setting_key, setting_value) VALUES (?, ?)");
        $stmt->execute([$key, $value]);
        echo "<p>✅ Sayaç ayarlandı: $key = $value</p>";
    }
    
    // FİNAL KONTROL
    echo "<h2>7. FİNAL KONTROL</h2>";
    
    $final_project_count = $pdo->query("SELECT COUNT(*) FROM projects WHERE status = 1")->fetchColumn();
    $final_product_count = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn();
    
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
    echo "<h3>🎉 BAŞARIYLA TAMAMLANDI!</h3>";
    echo "<p><strong>📊 Toplam Proje:</strong> $final_project_count adet</p>";
    echo "<p><strong>📦 Toplam Ürün:</strong> $final_product_count adet</p>";
    echo "<p><strong>📈 Sayaçlar:</strong> Projeler: 150, Müşteriler: 85, Yıl: 5, Ödül: 12</p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='index.php' style='background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 10px;'>🏠 Ana Sayfayı Kontrol Et</a>";
    echo "<a href='portfolio.php' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 10px;'>📁 Projeleri Gör</a>";
    echo "<a href='products.php' style='background: #17a2b8; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; margin: 10px;'>🛍️ Ürünleri Gör</a>";
    echo "</div>";
    
    echo "<p style='text-align: center; color: #666; margin-top: 30px;'>";
    echo "<small>⚠️ Bu dosyayı artık silebilirsiniz: add_sample_content_FORCE.php</small>";
    echo "</p>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h3>❌ HATA OLUŞTU!</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>