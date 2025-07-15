<?php
/**
 * Database İçerik Kontrol Scripti
 * Blog yazılarının nasıl geldiğini anlayalım
 */

echo "<h1>📊 VERİTABANI İÇERİK ANALİZİ</h1>";
echo "<hr>";

try {
    require_once 'config/database.php';
    
    echo "<h2>1. MEVCUT TABLOLAR</h2>";
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        echo "<h3>📋 $table tablosu</h3>";
        
        // Tablo yapısını göster
        $stmt = $pdo->query("PRAGMA table_info($table)");
        $columns = $stmt->fetchAll();
        
        echo "<p><strong>Kolonlar:</strong> ";
        $column_names = [];
        foreach ($columns as $col) {
            $column_names[] = $col['name'] . " (" . $col['type'] . ")";
        }
        echo implode(", ", $column_names);
        echo "</p>";
        
        // Veri sayısını göster
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetchColumn();
        echo "<p><strong>Kayıt sayısı:</strong> $count</p>";
        
        // Eğer az sayıda kayıt varsa, içeriği göster
        if ($count > 0 && $count < 10) {
            echo "<p><strong>İçerik:</strong></p>";
            $stmt = $pdo->query("SELECT * FROM $table LIMIT 5");
            $rows = $stmt->fetchAll();
            
            if (!empty($rows)) {
                echo "<table border='1' style='border-collapse: collapse; width: 100%; font-size: 12px;'>";
                
                // Header
                echo "<tr style='background: #f0f0f0;'>";
                foreach (array_keys($rows[0]) as $header) {
                    echo "<th style='padding: 5px; border: 1px solid #ccc;'>$header</th>";
                }
                echo "</tr>";
                
                // Rows
                foreach ($rows as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        $display_value = strlen($value) > 50 ? substr($value, 0, 50) . "..." : $value;
                        echo "<td style='padding: 5px; border: 1px solid #ccc;'>" . htmlspecialchars($display_value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
        echo "<hr>";
    }
    
    // Blog posts özel kontrol
    echo "<h2>2. BLOG YAZILARI ÖZEL ANALİZ</h2>";
    
    try {
        $stmt = $pdo->query("SELECT title, status, created_at FROM blog_posts LIMIT 10");
        $blog_posts = $stmt->fetchAll();
        
        if (!empty($blog_posts)) {
            echo "<p>✅ <strong>Blog yazıları mevcut:</strong></p>";
            echo "<ul>";
            foreach ($blog_posts as $post) {
                echo "<li>" . htmlspecialchars($post['title']) . " (Status: " . $post['status'] . ", Tarih: " . $post['created_at'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>❌ Blog yazısı bulunamadı</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Blog tablosu bulunamadı: " . $e->getMessage() . "</p>";
    }
    
    // Projects kontrol
    echo "<h2>3. PROJELER ANALİZ</h2>";
    
    try {
        $stmt = $pdo->query("SELECT title, status, created_at FROM projects LIMIT 10");
        $projects = $stmt->fetchAll();
        
        if (!empty($projects)) {
            echo "<p>✅ <strong>Projeler mevcut:</strong></p>";
            echo "<ul>";
            foreach ($projects as $project) {
                echo "<li>" . htmlspecialchars($project['title']) . " (Status: " . $project['status'] . ", Tarih: " . $project['created_at'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>❌ Proje bulunamadı</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Projects tablosu bulunamadı veya hata: " . $e->getMessage() . "</p>";
    }
    
    // Products kontrol
    echo "<h2>4. ÜRÜNLER ANALİZ</h2>";
    
    try {
        $stmt = $pdo->query("SELECT title, price, created_at FROM products LIMIT 10");
        $products = $stmt->fetchAll();
        
        if (!empty($products)) {
            echo "<p>✅ <strong>Ürünler mevcut:</strong></p>";
            echo "<ul>";
            foreach ($products as $product) {
                echo "<li>" . htmlspecialchars($product['title']) . " (Fiyat: " . $product['price'] . ", Tarih: " . $product['created_at'] . ")</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>❌ Ürün bulunamadı</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Products tablosu bulunamadı veya hata: " . $e->getMessage() . "</p>";
    }
    
    // Settings kontrol
    echo "<h2>5. SAYAÇLAR (SETTINGS) ANALİZ</h2>";
    
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'stat_%'");
        $stats = $stmt->fetchAll();
        
        if (!empty($stats)) {
            echo "<p>✅ <strong>Sayaç ayarları mevcut:</strong></p>";
            echo "<ul>";
            foreach ($stats as $stat) {
                echo "<li>" . $stat['setting_key'] . " = " . $stat['setting_value'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>❌ Sayaç ayarları bulunamadı</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Settings tablosu bulunamadı: " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Veritabanı bağlantı hatası: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Ana Sayfaya Git</a> | <a href='admin/login.php'>Admin Panel</a></p>";
?>