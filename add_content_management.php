<?php
/**
 * Content Management System Database Setup
 * Adds content management functionality to the portfolio system
 */

require_once 'config/database.php';

try {
    // Create site_contents table for managing all site texts
    $sql = "CREATE TABLE IF NOT EXISTS site_contents (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        content_key VARCHAR(100) UNIQUE NOT NULL,
        content_title VARCHAR(255) NOT NULL,
        content_text TEXT,
        content_type VARCHAR(50) DEFAULT 'text',
        page_location VARCHAR(100) DEFAULT 'general',
        is_active INTEGER DEFAULT 1,
        sort_order INTEGER DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "✅ site_contents tablosu oluşturuldu.<br>";
    
    // Insert default content for casino platform theme
    $default_contents = [
        // Portfolio/Platforms page
        [
            'content_key' => 'portfolio_intro',
            'content_title' => 'Platformlar Sayfası Açıklaması',
            'content_text' => 'BERAT K - R10 olarak yönettiğim kumar platformları ve başarılı projeler. Her platform, güvenlik ve kullanıcı deneyiminin mükemmel birleşimi.',
            'content_type' => 'text',
            'page_location' => 'portfolio'
        ],
        [
            'content_key' => 'services_intro',
            'content_title' => 'Platform Hizmetleri Açıklaması',
            'content_text' => 'BERAT K - R10 olarak sunduğum profesyonel kumar platform hizmetleri. Güvenli, karlı ve adil oyun deneyimleri.',
            'content_type' => 'text',
            'page_location' => 'services'
        ],
        [
            'content_key' => 'products_intro',
            'content_title' => 'Premium Ürünler Açıklaması',
            'content_text' => 'BERAT K - R10 tarafından özel olarak tasarlanan premium kumar ürünleri. Lüks, güvenilir ve karlı çözümler.',
            'content_type' => 'text',
            'page_location' => 'products'
        ],
        [
            'content_key' => 'contact_intro',
            'content_title' => 'İş Birliği Sayfası Açıklaması',
            'content_text' => 'Kumar endüstrisinde iş birliği fırsatları için benimle iletişime geçin. BERAT K - R10 olarak güvenli ve karlı platformlar kurmanızda size yardımcı olmak için buradayım.',
            'content_type' => 'text',
            'page_location' => 'contact'
        ],
        
        // Why choose us section
        [
            'content_key' => 'why_choose_title',
            'content_title' => 'Neden Bizi Seçin Başlığı',
            'content_text' => 'Neden BERAT K - R10 Platformlarını Seçmelisiniz?',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_1_title',
            'content_title' => 'Özellik 1 Başlığı',
            'content_text' => 'Güvenli & Stabil',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_1_desc',
            'content_title' => 'Özellik 1 Açıklaması',
            'content_text' => 'Tüm platformlarımız en yüksek güvenlik standartlarında geliştirilir ve sürekli güncellenir.',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_2_title',
            'content_title' => 'Özellik 2 Başlığı',
            'content_text' => 'Premium Deneyim',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_2_desc',
            'content_title' => 'Özellik 2 Açıklaması',
            'content_text' => 'Tüm cihazlarda mükemmel çalışan, kullanıcı dostu arayüzler ve premium deneyim.',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_3_title',
            'content_title' => 'Özellik 3 Başlığı',
            'content_text' => 'Sürekli Destek',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_3_desc',
            'content_title' => 'Özellik 3 Açıklaması',
            'content_text' => 'Platform kurulumu sonrası teknik destek ve güncellemeler garantilidir.',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_4_title',
            'content_title' => 'Özellik 4 Başlığı',
            'content_text' => 'Yüksek Performans',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'why_choose_feature_4_desc',
            'content_title' => 'Özellik 4 Açıklaması',
            'content_text' => 'Optimize edilmiş kodlar ile yüksek performans ve hızlı yükleme süreleri.',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        
        // Footer content
        [
            'content_key' => 'footer_about_title',
            'content_title' => 'Footer Hakkımda Başlığı',
            'content_text' => 'BERAT K - R10',
            'content_type' => 'text',
            'page_location' => 'footer'
        ],
        [
            'content_key' => 'footer_about_desc',
            'content_title' => 'Footer Hakkımda Açıklaması',
            'content_text' => 'Kumar endüstrisinin lider CEO\'su ve yayıncısı olarak, güvenli ve karlı platformlar sunuyorum.',
            'content_type' => 'text',
            'page_location' => 'footer'
        ],
        [
            'content_key' => 'footer_links_title',
            'content_title' => 'Footer Hızlı Linkler Başlığı',
            'content_text' => 'Hızlı Linkler',
            'content_type' => 'text',
            'page_location' => 'footer'
        ],
        [
            'content_key' => 'footer_services_title',
            'content_title' => 'Footer Hizmetler Başlığı',
            'content_text' => 'Platform Hizmetlerim',
            'content_type' => 'text',
            'page_location' => 'footer'
        ],
        [
            'content_key' => 'footer_contact_title',
            'content_title' => 'Footer İletişim Başlığı',
            'content_text' => 'İletişim Bilgileri',
            'content_type' => 'text',
            'page_location' => 'footer'
        ],
        
        // Hero content
        [
            'content_key' => 'hero_greeting',
            'content_title' => 'Hero Karşılama Metni',
            'content_text' => 'Hoş Geldiniz, Ben',
            'content_type' => 'text',
            'page_location' => 'home'
        ],
        [
            'content_key' => 'hero_description',
            'content_title' => 'Hero Açıklama Metni',
            'content_text' => 'Kumar platformu CEO\'su ve yayıncı olarak, endüstrinin en güvenilir ve yenilikçi oyun deneyimlerini sunuyorum. Milyonlarca oyuncunun güvendiği platformların lideri.',
            'content_type' => 'textarea',
            'page_location' => 'home'
        ],
        
        // CTA content
        [
            'content_key' => 'cta_title',
            'content_title' => 'CTA Başlığı',
            'content_text' => 'İş Birliğine Başlayalım!',
            'content_type' => 'text',
            'page_location' => 'general'
        ],
        [
            'content_key' => 'cta_text',
            'content_title' => 'CTA Açıklaması',
            'content_text' => 'Kumar endüstrisinde birlikte büyümek için benimle iletişime geç. BERAT K - R10 ile güvenli ve karlı platformlar kuralım.',
            'content_type' => 'textarea',
            'page_location' => 'general'
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO site_contents (content_key, content_title, content_text, content_type, page_location) VALUES (?, ?, ?, ?, ?)");
    
    $inserted = 0;
    foreach ($default_contents as $content) {
        if ($stmt->execute([$content['content_key'], $content['content_title'], $content['content_text'], $content['content_type'], $content['page_location']])) {
            $inserted++;
        }
    }
    
    echo "✅ $inserted adet varsayılan içerik eklendi.<br>";
    
    // Create footer_links table for managing footer links
    $sql_footer = "CREATE TABLE IF NOT EXISTS footer_links (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        link_title VARCHAR(100) NOT NULL,
        link_url VARCHAR(255) NOT NULL,
        link_section VARCHAR(50) DEFAULT 'quick_links',
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql_footer);
    echo "✅ footer_links tablosu oluşturuldu.<br>";
    
    // Insert default footer links
    $default_footer_links = [
        // Quick Links
        ['Ana Sayfa', 'index.php', 'quick_links', 1],
        ['Hakkımda', 'about.php', 'quick_links', 2],
        ['Platformlar', 'portfolio.php', 'quick_links', 3],
        ['İş Birliği', 'contact.php', 'quick_links', 4],
        
        // Services
        ['Casino Platformları', 'services.php', 'services', 1],
        ['Yayıncılık Hizmetleri', 'services.php', 'services', 2],
        ['Platform Güvenliği', 'services.php', 'services', 3],
        ['Premium Ürünler', 'products.php', 'services', 4]
    ];
    
    $stmt_footer = $pdo->prepare("INSERT OR IGNORE INTO footer_links (link_title, link_url, link_section, sort_order) VALUES (?, ?, ?, ?)");
    
    $inserted_links = 0;
    foreach ($default_footer_links as $link) {
        if ($stmt_footer->execute($link)) {
            $inserted_links++;
        }
    }
    
    echo "✅ $inserted_links adet footer linki eklendi.<br>";
    
    echo "<br>🎰 Content Management System başarıyla kuruldu!<br>";
    echo "Admin panelinden tüm site içeriklerini düzenleyebilirsiniz.<br>";
    
} catch(PDOException $e) {
    echo "❌ Hata: " . $e->getMessage();
}
?>