<?php
/**
 * Gelişmiş İçerik Yönetimi Kurulumu
 * Site genelindeki tüm metinleri düzenlenebilir yapar
 */

require_once 'includes/functions.php';

try {
    global $pdo;
    
    // site_contents tablosunu oluştur (eğer yoksa)
    $sql = "CREATE TABLE IF NOT EXISTS site_contents (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        content_key VARCHAR(255) NOT NULL UNIQUE,
        content_title VARCHAR(255) NOT NULL,
        content_text TEXT,
        content_type VARCHAR(50) DEFAULT 'text',
        page_location VARCHAR(100) DEFAULT 'general',
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "✅ site_contents tablosu hazır!\n";
    
    // Kapsamlı içerik listesi
    $contents = [
        // Ana Sayfa İçerikleri
        ['hero_title', 'Ana Sayfa Hero Başlığı', 'Online Casino Dünyasının Lideri', 'text', 'index'],
        ['hero_subtitle', 'Ana Sayfa Hero Alt Başlığı', 'Güvenli, hızlı ve kazançlı casino deneyimi için doğru adrestesiniz.', 'text', 'index'],
        ['hero_description', 'Ana Sayfa Hero Açıklaması', 'Binlerce oyun seçeneği, güvenli ödeme yöntemleri ve 7/24 müşteri desteği ile casino keyfini yaşayın.', 'textarea', 'index'],
        ['hero_button_text', 'Ana Sayfa Hero Buton Metni', 'Hemen Başla', 'text', 'index'],
        
        // İstatistik Metinleri
        ['stat_projects_label', 'Aktif Platform Etiketi', 'Aktif Platform', 'text', 'stats'],
        ['stat_clients_label', 'Aktif Oyuncu Etiketi', 'Aktif Oyuncu', 'text', 'stats'],
        ['stat_years_label', 'Yıllık Deneyim Etiketi', 'Yıllık Deneyim', 'text', 'stats'],
        ['stat_awards_label', 'Endüstri Ödülü Etiketi', 'Endüstri Ödülü', 'text', 'stats'],
        
        // Hakkımda Sayfası
        ['about_title', 'Hakkımda Başlığı', 'Casino Dünyasında Güvenilir Adres', 'text', 'about'],
        ['about_description', 'Hakkımda Açıklaması', 'Yılların verdiği deneyimle, casino oyunlarında en güvenilir ve kazançlı platformu sunuyoruz.', 'textarea', 'about'],
        ['about_mission_title', 'Misyon Başlığı', 'Misyonumuz', 'text', 'about'],
        ['about_mission_text', 'Misyon Metni', 'Oyuncularımıza en iyi casino deneyimini sunmak ve güvenli oyun ortamı sağlamak.', 'textarea', 'about'],
        
        // Hizmetler
        ['services_title', 'Hizmetler Başlığı', 'Casino Hizmetlerimiz', 'text', 'services'],
        ['services_subtitle', 'Hizmetler Alt Başlığı', 'Kapsamlı casino oyunları ve profesyonel hizmetlerle karşınızdayız', 'text', 'services'],
        
        // İletişim Sayfası
        ['contact_title', 'İletişim Başlığı', 'Bizimle İletişime Geçin', 'text', 'contact'],
        ['contact_subtitle', 'İletişim Alt Başlığı', '7/24 müşteri desteği ile size yardımcı olmaya hazırız', 'text', 'contact'],
        ['contact_address', 'Adres', 'İstanbul, Türkiye', 'text', 'contact'],
        ['contact_phone', 'Telefon', '+90 (212) 123 45 67', 'text', 'contact'],
        ['contact_email', 'E-posta', 'info@kasino.com', 'text', 'contact'],
        
        // Footer İçerikleri
        ['footer_about_title', 'Footer Hakkımda Başlığı', 'KASINO', 'text', 'footer'],
        ['footer_about_text', 'Footer Hakkımda Metni', 'Güvenli ve eğlenceli casino deneyimi için doğru adrestesiniz. Lisanslı ve güvenilir platform.', 'textarea', 'footer'],
        ['footer_links_title', 'Footer Linkler Başlığı', 'Hızlı Linkler', 'text', 'footer'],
        ['footer_services_title', 'Footer Hizmetler Başlığı', 'Casino Oyunları', 'text', 'footer'],
        ['footer_contact_title', 'Footer İletişim Başlığı', 'İletişim', 'text', 'footer'],
        ['footer_social_title', 'Footer Sosyal Medya Başlığı', 'Sosyal Medya', 'text', 'footer'],
        ['footer_copyright', 'Footer Telif Hakkı', '© 2024 KASINO. Tüm hakları saklıdır.', 'text', 'footer'],
        
        // Meta Açıklamaları
        ['meta_description', 'Site Meta Açıklaması', 'En güvenli ve kazançlı online casino deneyimi için KASINO\'yu seçin. Binlerce oyun, güvenli ödeme ve 7/24 destek.', 'textarea', 'meta'],
        ['meta_keywords', 'Site Anahtar Kelimeleri', 'casino, online casino, slot oyunları, poker, blackjack, rulet, güvenli casino', 'textarea', 'meta'],
        
        // Genel Site Metinleri
        ['site_brand', 'Site Markası', 'KASINO', 'text', 'general'],
        ['site_slogan', 'Site Sloganı', 'Kazancın Adresi', 'text', 'general'],
        ['loading_text', 'Yükleniyor Metni', 'Yükleniyor...', 'text', 'general'],
        ['success_message', 'Başarı Mesajı', 'İşlem başarıyla tamamlandı!', 'text', 'general'],
        ['error_message', 'Hata Mesajı', 'Bir hata oluştu, lütfen tekrar deneyin.', 'text', 'general'],
        
        // Buton Metinleri
        ['btn_more_info', 'Daha Fazla Bilgi Butonu', 'Daha Fazla Bilgi', 'text', 'buttons'],
        ['btn_contact', 'İletişim Butonu', 'İletişime Geç', 'text', 'buttons'],
        ['btn_play_now', 'Şimdi Oyna Butonu', 'Şimdi Oyna', 'text', 'buttons'],
        ['btn_register', 'Kayıt Ol Butonu', 'Kayıt Ol', 'text', 'buttons'],
        ['btn_login', 'Giriş Yap Butonu', 'Giriş Yap', 'text', 'buttons'],
        ['btn_submit', 'Gönder Butonu', 'Gönder', 'text', 'buttons'],
        
        // Oyun Kategorileri
        ['game_slots_title', 'Slot Oyunları Başlığı', 'Slot Oyunları', 'text', 'games'],
        ['game_table_title', 'Masa Oyunları Başlığı', 'Masa Oyunları', 'text', 'games'],
        ['game_live_title', 'Canlı Casino Başlığı', 'Canlı Casino', 'text', 'games'],
        ['game_poker_title', 'Poker Başlığı', 'Poker Oyunları', 'text', 'games'],
        
        // Bonus ve Promosyonlar
        ['bonus_welcome_title', 'Hoş Geldin Bonusu Başlığı', 'Hoş Geldin Bonusu', 'text', 'bonus'],
        ['bonus_welcome_text', 'Hoş Geldin Bonusu Metni', '%100 İlk Yatırım Bonusu + 50 Bedava Spin', 'text', 'bonus'],
        ['bonus_daily_title', 'Günlük Bonus Başlığı', 'Günlük Bonuslar', 'text', 'bonus'],
        ['bonus_vip_title', 'VIP Bonus Başlığı', 'VIP Üyelik', 'text', 'bonus']
    ];
    
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO site_contents (content_key, content_title, content_text, content_type, page_location) VALUES (?, ?, ?, ?, ?)");
    
    $added_count = 0;
    foreach ($contents as $content) {
        $stmt->execute($content);
        $added_count++;
    }
    
    echo "✅ $added_count adet içerik eklendi/güncellendi!\n";
    echo "🎉 Site genelindeki tüm metinler artık içerik yönetiminden düzenlenebilir!\n";
    echo "📝 Admin panelinden 'İçerik Yönetimi' bölümüne gidebilirsiniz.\n";
    
} catch (Exception $e) {
    echo "❌ Hata: " . $e->getMessage() . "\n";
}
?>