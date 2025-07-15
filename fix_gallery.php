<?php
/**
 * Galeri Düzeltici Script
 * Galeri ekleme sorunlarını çözer
 */

echo "<h1>🎨 Galeri Sistemi Düzeltici</h1>";

try {
    require_once 'config/database.php';
    echo "<p>✅ Veritabanı bağlantısı başarılı</p>";

    // 1. Gallery tablosunu kontrol et ve oluştur
    try {
        $pdo->query("SELECT COUNT(*) FROM gallery");
        echo "<p>✅ Gallery tablosu mevcut</p>";
    } catch (Exception $e) {
        echo "<p>⚠️ Gallery tablosu yok, oluşturuluyor...</p>";
        
        $sql = "CREATE TABLE IF NOT EXISTS gallery (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            type VARCHAR(20) NOT NULL DEFAULT 'image',
            file_path VARCHAR(500),
            youtube_url VARCHAR(500),
            thumbnail VARCHAR(500),
            sort_order INTEGER DEFAULT 0,
            is_active INTEGER DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);
        echo "<p>✅ Gallery tablosu oluşturuldu!</p>";
    }

    // 2. Upload klasörlerini oluştur
    $dirs = [
        'uploads/',
        'uploads/gallery/'
    ];

    foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
            if (mkdir($dir, 0755, true)) {
                echo "<p>✅ Klasör oluşturuldu: $dir</p>";
            } else {
                echo "<p>❌ Klasör oluşturulamadı: $dir</p>";
            }
        } else {
            echo "<p>✅ Klasör mevcut: $dir</p>";
        }
        
        // İzin kontrolü
        if (is_writable($dir)) {
            echo "<p>✅ Yazma izni OK: $dir</p>";
        } else {
            echo "<p>⚠️ Yazma izni yok: $dir (chmod 755 gerekli)</p>";
        }
    }

    // 3. Örnek galeri öğesi ekle
    echo "<p>🔧 Örnek galeri öğesi ekleniyor...</p>";
    
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO gallery (title, description, type, youtube_url, sort_order) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        'Örnek Video',
        'Bu örnek bir YouTube videosu',
        'video',
        'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        0
    ]);
    
    echo "<p>✅ Örnek galeri öğesi eklendi!</p>";

    // 4. Test et
    $count = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
    echo "<p>📊 Galeri'de toplam $count öğe var</p>";

    echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h2>🎉 GALERİ SİSTEMİ DÜZELTİLDİ!</h2>";
    echo "<ul>";
    echo "<li>✅ Gallery tablosu hazır</li>";
    echo "<li>✅ Upload klasörleri oluşturuldu</li>";
    echo "<li>✅ Örnek öğe eklendi</li>";
    echo "</ul>";
    echo "<p><a href='admin/gallery-management.php' style='color: #007bff; font-weight: bold;'>Galeri Yönetimine Git</a></p>";
    echo "<p><a href='gallery.php' style='color: #007bff; font-weight: bold;'>Galeri Sayfasını Görüntüle</a></p>";
    echo "</div>";

    // 5. İzin önerileri
    echo "<h3>💡 İzin Sorunları İçin:</h3>";
    echo "<p><code>chmod 755 uploads/</code></p>";
    echo "<p><code>chmod 755 uploads/gallery/</code></p>";
    echo "<p>veya</p>";
    echo "<p><code>chown -R www-data:www-data uploads/</code></p>";

    echo "<p style='color: red; font-weight: bold;'>⚠️ Bu dosyayı (fix_gallery.php) silmeyi unutmayın!</p>";

} catch (Exception $e) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px;'>";
    echo "<h2>❌ HATA:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>