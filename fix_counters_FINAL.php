<?php
/**
 * KESİN SAYAÇ DÜZELTMESİ - BERAT K - R10 Portfolio
 * Bu script sayaçları kesin olarak düzeltir!
 */

echo "<h1>🔧 SAYAÇ DÜZELTMESİ - KESİN ÇÖZÜM</h1>";
echo "<hr>";

// Veritabanı bağlantısını kontrol et
try {
    echo "<h2>1. VERİTABANI BAĞLANTISI KONTROL EDİLİYOR...</h2>";
    require_once 'config/database.php';
    echo "✅ Veritabanı bağlantısı başarılı!<br>";
    echo "📍 Veritabanı Tipi: <strong>SQLite</strong><br>";
    echo "📁 Dosya Yolu: " . dirname(__FILE__) . "/database/portfolio.db<br><br>";
    
} catch (Exception $e) {
    echo "❌ Veritabanı bağlantı hatası: " . $e->getMessage() . "<br>";
    die();
}

// Mevcut tabloları kontrol et
echo "<h2>2. MEVCUT TABLOLAR KONTROL EDİLİYOR...</h2>";
try {
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (!empty($tables)) {
        echo "📋 Bulunan tablolar:<br>";
        foreach ($tables as $table) {
            echo "- $table<br>";
        }
    } else {
        echo "⚠️ Hiç tablo bulunamadı!<br>";
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Tablo kontrol hatası: " . $e->getMessage() . "<br>";
}

// Settings tablosunu kontrol et
echo "<h2>3. SETTINGS TABLOSU KONTROL EDİLİYOR...</h2>";
try {
    // Settings tablosunu oluştur
    $pdo->exec("CREATE TABLE IF NOT EXISTS settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key VARCHAR(255) NOT NULL UNIQUE,
        setting_value TEXT
    )");
    echo "✅ Settings tablosu hazır!<br>";
    
    // Mevcut ayarları kontrol et
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'stat_%'");
    $current_settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    
    if (!empty($current_settings)) {
        echo "📊 Mevcut sayaç ayarları:<br>";
        foreach ($current_settings as $key => $value) {
            echo "- $key: <strong>$value</strong><br>";
        }
    } else {
        echo "⚠️ Sayaç ayarları bulunamadı!<br>";
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Settings kontrol hatası: " . $e->getMessage() . "<br>";
}

// Sayaç değerlerini zorla ayarla
echo "<h2>4. SAYAÇLAR ZORLA AYARLANIYOR...</h2>";
$counter_values = [
    'stat_projects' => '150',
    'stat_clients' => '85',
    'stat_years' => '5',
    'stat_awards' => '12'
];

try {
    foreach ($counter_values as $key => $value) {
        $stmt = $pdo->prepare("INSERT OR REPLACE INTO settings (setting_key, setting_value) VALUES (?, ?)");
        $result = $stmt->execute([$key, $value]);
        
        if ($result) {
            echo "✅ $key = $value (Zorla ayarlandı)<br>";
        } else {
            echo "❌ $key ayarlanamadı<br>";
        }
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Sayaç ayarlama hatası: " . $e->getMessage() . "<br>";
}

// getSetting fonksiyonunu test et
echo "<h2>5. getSetting FONKSİYONU TEST EDİLİYOR...</h2>";
try {
    require_once 'includes/functions.php';
    
    foreach ($counter_values as $key => $expected_value) {
        $actual_value = getSetting($key, 'BULUNAMADI');
        
        if ($actual_value == $expected_value) {
            echo "✅ $key: $actual_value (Doğru!)<br>";
        } else {
            echo "❌ $key: Beklenen '$expected_value', Bulunan '$actual_value'<br>";
        }
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Fonksiyon test hatası: " . $e->getMessage() . "<br>";
}

// Örnek projeler kontrol et ve ekle
echo "<h2>6. ÖRNEK PROJELER KONTROL EDİLİYOR...</h2>";
try {
    // Projects tablosunu oluştur
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
    
    // Mevcut proje sayısını kontrol et
    $stmt = $pdo->query("SELECT COUNT(*) FROM projects WHERE status = 1");
    $project_count = $stmt->fetchColumn();
    
    echo "📊 Mevcut aktif proje sayısı: <strong>$project_count</strong><br>";
    
    if ($project_count == 0) {
        echo "📥 Örnek projeler ekleniyor...<br>";
        
        $sample_projects = [
            [
                'E-Ticaret Web Sitesi',
                'Modern ve responsive e-ticaret platformu. Kullanıcı dostu arayüz, güvenli ödeme sistemi ve admin paneli ile tam özellikli online mağaza çözümü.',
                'assets/img/projects/ecommerce.jpg',
                'https://demo.ecommerce.com',
                'https://github.com/user/ecommerce',
                'Web Development',
                'HTML5, CSS3, JavaScript, PHP, MySQL, Bootstrap',
                1
            ],
            [
                'Mobil ToDo Uygulaması',
                'React Native ile geliştirilmiş cross-platform görev yönetimi uygulaması. Offline çalışma, push notification ve senkronizasyon özellikleri.',
                'assets/img/projects/todo-app.jpg',
                'https://play.google.com/store/apps/details?id=com.todo',
                'https://github.com/user/todo-app',
                'Mobile App',
                'React Native, Redux, Firebase, Node.js',
                1
            ],
            [
                'Portföy Yönetim Sistemi',
                'Finansal portföy takibi ve analizi için geliştirilmiş web uygulaması. Gerçek zamanlı veriler, grafikler ve raporlama modülleri.',
                'assets/img/projects/portfolio-system.jpg',
                'https://demo.portfolio.com',
                'https://github.com/user/portfolio-system',
                'Web Application',
                'Vue.js, Laravel, MySQL, Chart.js, WebSocket',
                1
            ]
        ];
        
        foreach ($sample_projects as $project) {
            $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, demo_url, github_url, category, technologies, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($project);
        }
        
        echo "✅ 3 örnek proje eklendi!<br>";
    } else {
        echo "✅ Projeler zaten mevcut!<br>";
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Proje kontrol hatası: " . $e->getMessage() . "<br>";
}

// Örnek ürünler kontrol et ve ekle
echo "<h2>7. ÖRNEK ÜRÜNLER KONTROL EDİLİYOR...</h2>";
try {
    // Products tablosunu oluştur
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
    
    // Mevcut ürün sayısını kontrol et
    $stmt = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1");
    $product_count = $stmt->fetchColumn();
    
    echo "📊 Mevcut aktif ürün sayısı: <strong>$product_count</strong><br>";
    
    if ($product_count == 0) {
        echo "📥 Örnek ürünler ekleniyor...<br>";
        
        $sample_products = [
            [
                'CRM Yönetim Sistemi',
                'Müşteri ilişkileri yönetimi için kapsamlı çözüm. Satış takibi, raporlama, e-posta entegrasyonu ve daha fazlası.',
                'Müşteri Yönetimi, Satış Takibi, Raporlama, E-posta Entegrasyonu, Kullanıcı Yetkilendirme',
                'Software',
                '2500',
                'TL',
                'assets/img/products/crm.jpg',
                'https://demo.crm.com',
                'https://admin.crm.com',
                'https://downloads.com/crm.zip',
                'https://docs.crm.com',
                1
            ],
            [
                'Blog Yönetim Scripti',
                'Modern ve SEO dostu blog scripti. Çoklu yazar desteği, kategori yönetimi, yorum sistemi ve admin paneli.',
                'SEO Optimize, Çoklu Yazar, Kategori Yönetimi, Yorum Sistemi, Responsive Tasarım',
                'Script',
                '850',
                'TL',
                'assets/img/products/blog-script.jpg',
                'https://demo.blog.com',
                'https://admin.blog.com',
                'https://downloads.com/blog.zip',
                'https://docs.blog.com',
                1
            ],
            [
                'E-İmza Entegrasyon Modülü',
                'Web uygulamaları için elektronik imza entegrasyon çözümü. Güvenli, hızlı ve kolay entegrasyon.',
                'Elektronik İmza, API Entegrasyonu, Güvenlik, Sertifika Yönetimi, Log Sistemi',
                'Module',
                '1200',
                'TL',
                'assets/img/products/e-signature.jpg',
                'https://demo.esign.com',
                'https://admin.esign.com',
                'https://downloads.com/esign.zip',
                'https://docs.esign.com',
                1
            ]
        ];
        
        foreach ($sample_products as $product) {
            $stmt = $pdo->prepare("INSERT INTO products (title, description, features, category, price, currency, image, demo_url, admin_demo_url, download_url, documentation_url, featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($product);
        }
        
        echo "✅ 3 örnek ürün eklendi!<br>";
    } else {
        echo "✅ Ürünler zaten mevcut!<br>";
    }
    echo "<br>";
    
} catch (Exception $e) {
    echo "❌ Ürün kontrol hatası: " . $e->getMessage() . "<br>";
}

// Final test - Ana sayfadaki sayaçları test et
echo "<h2>8. FİNAL TEST - SAYAÇLAR TESTİ</h2>";
try {
    $test_stats = [
        'stat_projects' => getSetting('stat_projects', '0'),
        'stat_clients' => getSetting('stat_clients', '0'),
        'stat_years' => getSetting('stat_years', '0'),
        'stat_awards' => getSetting('stat_awards', '0')
    ];
    
    $all_working = true;
    foreach ($test_stats as $key => $value) {
        if ($value != '0' && !empty($value)) {
            echo "✅ $key: <strong style='color: green;'>$value</strong><br>";
        } else {
            echo "❌ $key: <strong style='color: red;'>Çalışmıyor ($value)</strong><br>";
            $all_working = false;
        }
    }
    
    echo "<br>";
    
    if ($all_working) {
        echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>🎉 BAŞARILI! SAYAÇLAR ÇALIŞIYOR!</h3>";
        echo "<p>✅ Tüm sayaçlar doğru değerleri gösteriyor</p>";
        echo "<p>✅ Projeler ve ürünler yüklendi</p>";
        echo "<p>✅ SQLite veritabanı düzgün çalışıyor</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>❌ HALA SORUN VAR!</h3>";
        echo "<p>Bazı sayaçlar çalışmıyor. Lütfen includes/functions.php dosyasını kontrol edin.</p>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "❌ Final test hatası: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>📝 ÖZET BİLGİ</h2>";
echo "<p><strong>Veritabanı Tipi:</strong> SQLite (Hafif ve hızlı)</p>";
echo "<p><strong>Veritabanı Dosyası:</strong> database/portfolio.db</p>";
echo "<p><strong>Sayaç Değerleri:</strong> Projeler: 150, Müşteriler: 85, Yıl: 5, Ödül: 12</p>";
echo "<p><strong>Ana Sayfa:</strong> <a href='index.php' target='_blank'>Ana Sayfayı Kontrol Et</a></p>";
echo "<p><strong>Admin Panel:</strong> <a href='admin/login.php' target='_blank'>Admin Paneli</a></p>";

echo "<div style='background: #cff4fc; border: 1px solid #b6effb; color: #055160; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>📋 SONRAKI ADIMLAR:</h4>";
echo "<ol>";
echo "<li>Ana sayfayı yenileyin (F5)</li>";
echo "<li>Sayaçların çalıştığını kontrol edin</li>";
echo "<li>Bu dosyayı silebilirsiniz (fix_counters_FINAL.php)</li>";
echo "</ol>";
echo "</div>";

echo "<p><small>© 2024 BERAT K - R10 Portfolio - SQLite Düzeltme Scripti</small></p>";
?>