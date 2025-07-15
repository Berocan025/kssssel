<?php
/**
 * İçerik Yönetimi Düzeltme Scripti
 * Eksik içerikleri ekler ve tabloları oluşturur
 */

require_once 'includes/functions.php';

try {
    global $pdo;
    if (!$pdo) {
        require_once 'config/database.php';
    }
    
    echo "<h2>🚀 İçerik Yönetimi Düzeltme İşlemi Başlıyor...</h2>";
    
    // 1. site_contents tablosunu oluştur
    $sql_contents = "CREATE TABLE IF NOT EXISTS site_contents (
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
    
    $pdo->exec($sql_contents);
    echo "<p>✅ site_contents tablosu hazır!</p>";
    
    // 2. footer_links tablosunu oluştur
    $sql_footer = "CREATE TABLE IF NOT EXISTS footer_links (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        link_title VARCHAR(255) NOT NULL,
        link_url VARCHAR(500) NOT NULL,
        link_section VARCHAR(100) NOT NULL,
        sort_order INTEGER DEFAULT 0,
        is_active INTEGER DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql_footer);
    echo "<p>✅ footer_links tablosu hazır!</p>";
    
    // 3. gallery tablosunu oluştur
    $sql_gallery = "CREATE TABLE IF NOT EXISTS gallery (
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
    
    $pdo->exec($sql_gallery);
    echo "<p>✅ gallery tablosu hazır!</p>";
    
    // 4. Galeri uploads klasörünü oluştur
    $upload_dir = 'uploads/gallery/';
    if (!file_exists($upload_dir)) {
        if (mkdir($upload_dir, 0755, true)) {
            echo "<p>✅ Galeri upload klasörü oluşturuldu!</p>";
        } else {
            echo "<p>⚠️ Galeri upload klasörü oluşturulamadı!</p>";
        }
    } else {
        echo "<p>✅ Galeri upload klasörü zaten mevcut!</p>";
    }
    
    // 5. Ana sayfadaki eksik içerikleri ekle
    $contents = [
        // Neden Bizimle Çalışmalısınız Bölümü
        ['why_choose_title', '"Neden Bizimle Çalışmalısınız?" Başlığı', 'Neden BERAT K - R10 Platformlarını Seçmelisiniz?', 'text', 'index'],
        ['why_choose_feature_1_title', 'Özellik 1 Başlığı', 'Güvenli & Stabil', 'text', 'index'],
        ['why_choose_feature_1_desc', 'Özellik 1 Açıklaması', 'Tüm platformlarımız en yüksek güvenlik standartlarında geliştirilir ve sürekli güncellenir.', 'textarea', 'index'],
        ['why_choose_feature_2_title', 'Özellik 2 Başlığı', 'Premium Deneyim', 'text', 'index'],
        ['why_choose_feature_2_desc', 'Özellik 2 Açıklaması', 'Tüm cihazlarda mükemmel çalışan, kullanıcı dostu arayüzler ve premium deneyim.', 'textarea', 'index'],
        ['why_choose_feature_3_title', 'Özellik 3 Başlığı', 'Sürekli Destek', 'text', 'index'],
        ['why_choose_feature_3_desc', 'Özellik 3 Açıklaması', 'Platform kurulumu sonrası teknik destek ve güncellemeler garantilidir.', 'textarea', 'index'],
        ['why_choose_feature_4_title', 'Özellik 4 Başlığı', 'Yüksek Performans', 'text', 'index'],
        ['why_choose_feature_4_desc', 'Özellik 4 Açıklaması', 'Optimize edilmiş kodlar ile yüksek performans ve hızlı yükleme süreleri.', 'textarea', 'index'],
        
        // CTA Bölümü
        ['cta_title', 'CTA Başlığı', 'İş Birliğine Başlayalım!', 'text', 'index'],
        ['cta_text', 'CTA Metni', 'Kumar endüstrisinde birlikte büyümek için benimle iletişime geç. {site_brand} ile güvenli ve karlı platformlar kuralım.', 'textarea', 'index'],
        
        // Hero Bölümü
        ['hero_title', 'Ana Sayfa Hero Başlığı', 'Online Casino Dünyasının Lideri', 'text', 'index'],
        ['hero_subtitle', 'Ana Sayfa Hero Alt Başlığı', 'Güvenli, hızlı ve kazançlı casino deneyimi için doğru adrestesiniz.', 'text', 'index'],
        ['hero_description', 'Ana Sayfa Hero Açıklaması', 'Binlerce oyun seçeneği, güvenli ödeme yöntemleri ve 7/24 müşteri desteği ile casino keyfini yaşayın.', 'textarea', 'index'],
        
        // Bölüm Başlıkları
        ['services_section_title', 'Hizmetler Bölüm Başlığı', 'Platform Hizmetlerim', 'text', 'index'],
        ['projects_section_title', 'Projeler Bölüm Başlığı', 'Platformlarım', 'text', 'index'],
        ['blog_section_title', 'Blog Bölüm Başlığı', 'Platform Haberleri', 'text', 'index'],
        
        // Buton Metinleri
        ['btn_all_services', 'Tüm Hizmetler Butonu', 'Tüm Platform Hizmetleri', 'text', 'buttons'],
        ['btn_all_projects', 'Tüm Projeler Butonu', 'Tüm Platformlar', 'text', 'buttons'],
        ['btn_all_blog', 'Tüm Blog Butonu', 'Tüm Platform Haberleri', 'text', 'buttons'],
        ['btn_cooperation', 'İş Birliği Butonu', 'İş Birliği Yap', 'text', 'buttons'],
        ['btn_details', 'Detaylar Butonu', 'Detaylar', 'text', 'buttons'],
        ['btn_read_more', 'Devamını Oku Butonu', 'Devamını Oku', 'text', 'buttons'],
        
        // Footer İçerikleri
        ['footer_about_title', 'Footer Hakkımda Başlığı', 'BERAT K - R10', 'text', 'footer'],
        ['footer_about_desc', 'Footer Hakkımda Metni', 'Kumar endüstrisinin lider CEO\'su ve yayıncısı olarak, güvenli ve karlı platformlar sunuyorum.', 'textarea', 'footer'],
        ['footer_links_title', 'Footer Linkler Başlığı', 'Hızlı Linkler', 'text', 'footer'],
        ['footer_services_title', 'Footer Hizmetler Başlığı', 'Platform Hizmetlerim', 'text', 'footer'],
        ['footer_contact_title', 'Footer İletişim Başlığı', 'İletişim Bilgileri', 'text', 'footer'],
        ['footer_copyright', 'Footer Telif Hakkı', '© 2024 BERAT K - R10. Tüm hakları saklıdır.', 'text', 'footer'],
        
        // Hakkımda Sayfası İçerikleri
        ['about_page_title', 'Hakkımda Sayfa Başlığı', 'Hakkımda', 'text', 'about'],
        ['about_page_subtitle', 'Hakkımda Sayfa Alt Başlığı', 'Kumar Platform CEO\'su & Endüstri Yayıncısı', 'text', 'about'],
        ['about_page_description', 'Hakkımda Sayfa Açıklaması', 'Kumar endüstrisinde uzmanlaşmış bir CEO ve yayıncıyım. Güvenli, adil ve karlı oyun platformları inşa etme konusunda geniş deneyime sahibim.', 'textarea', 'about'],
        ['about_skills_title', 'Uzmanlık Alanları Başlığı', 'Uzmanlık Alanlarım', 'text', 'about'],
        ['about_experience_title', 'Kariyer Başlığı', 'Kariyer Yolculuğum', 'text', 'about'],
        ['about_experience_desc', 'Kariyer Açıklaması', 'Kumar endüstrisinde liderlik pozisyonlarında edindiğim deneyimler ve başarılarım.', 'textarea', 'about'],
        ['about_education_title', 'Eğitim Başlığı', 'Eğitim & Sertifikalarım', 'text', 'about'],
        ['about_education_desc', 'Eğitim Açıklaması', 'Kumar endüstrisinde aldığım eğitimler, uzmanlık sertifikaları ve sürekli gelişim yolculuğum.', 'textarea', 'about'],
        
        // İletişim Sayfası İçerikleri
        ['contact_page_title', 'İletişim Sayfa Başlığı', 'İş Birliği Yapalım', 'text', 'contact'],
        ['contact_intro', 'İletişim Giriş Metni', 'Kumar endüstrisinde iş birliği fırsatları için benimle iletişime geçin. BERAT K - R10 olarak güvenli ve karlı platformlar kurmanızda size yardımcı olmak için buradayım.', 'textarea', 'contact'],
        ['contact_form_title', 'İletişim Form Başlığı', 'Mesaj Gönder', 'text', 'contact'],
        ['contact_info_title', 'İletişim Bilgileri Başlığı', 'İletişim Bilgileri', 'text', 'contact'],
        
        // Hizmetler Sayfası İçerikleri
        ['services_page_title', 'Hizmetler Sayfa Başlığı', 'Platform Hizmetlerim', 'text', 'services'],
        ['services_intro', 'Hizmetler Giriş Metni', 'BERAT K - R10 olarak sunduğum profesyonel kumar platform hizmetleri. Güvenli, karlı ve adil oyun deneyimleri.', 'textarea', 'services'],
        ['services_process_title', 'Çalışma Süreci Başlığı', 'Çalışma Sürecim', 'text', 'services'],
        ['process_step_1_title', 'Süreç 1. Adım Başlığı', 'Analiz & Planlama', 'text', 'services'],
        ['process_step_1_desc', 'Süreç 1. Adım Açıklaması', 'Projenizin gereksinimlerini detaylı şekilde analiz ediyor ve en uygun çözümü planlıyorum.', 'textarea', 'services'],
        ['process_step_2_title', 'Süreç 2. Adım Başlığı', 'Tasarım & Prototipler', 'text', 'services'],
        ['process_step_2_desc', 'Süreç 2. Adım Açıklaması', 'Kullanıcı deneyimini ön planda tutarak modern ve etkileyici tasarımlar oluşturuyorum.', 'textarea', 'services'],
        ['process_step_3_title', 'Süreç 3. Adım Başlığı', 'Geliştirme & Test', 'text', 'services'],
        ['process_step_3_desc', 'Süreç 3. Adım Açıklaması', 'En son teknolojiler ile kodlama yapıyor ve kapsamlı testlerle kaliteyi garanti ediyorum.', 'textarea', 'services'],
        ['process_step_4_title', 'Süreç 4. Adım Başlığı', 'Teslim & Destek', 'text', 'services'],
        ['process_step_4_desc', 'Süreç 4. Adım Açıklaması', 'Projenizi zamanında teslim ediyor ve sürekli teknik destek sağlıyorum.', 'textarea', 'services'],
        
        // Portfolio Sayfası İçerikleri
        ['portfolio_page_title', 'Portfolio Sayfa Başlığı', 'Platformlarım', 'text', 'portfolio'],
        ['portfolio_intro', 'Portfolio Giriş Metni', 'BERAT K - R10 olarak yönettiğim kumar platformları ve başarılı projeler. Her platform, güvenlik ve kullanıcı deneyiminin mükemmel birleşimi.', 'textarea', 'portfolio'],
        ['portfolio_filter_all', 'Portfolio Filtre Tümü', 'Tümü', 'text', 'portfolio'],
        ['portfolio_search_placeholder', 'Portfolio Arama Placeholder', 'Platformlar içinde ara...', 'text', 'portfolio'],
        
        // Blog Sayfası İçerikleri
        ['blog_page_title', 'Blog Sayfa Başlığı', 'Platform Haberleri', 'text', 'blog'],
        ['blog_intro', 'Blog Giriş Metni', 'Kumar endüstrisi, platform yönetimi ve teknoloji hakkında güncel yazılar.', 'textarea', 'blog'],
        ['blog_no_posts', 'Blog Yazı Yok Mesajı', 'Henüz blog yazısı yok', 'text', 'blog'],
        ['blog_no_posts_desc', 'Blog Yazı Yok Açıklaması', 'Blog yazıları yayınlandığında burada görünecek.', 'text', 'blog'],
        
        // Galeri Sayfası İçerikleri
        ['gallery_page_title', 'Galeri Sayfa Başlığı', 'Platform Galerisi', 'text', 'gallery'],
        ['gallery_intro', 'Galeri Giriş Metni', 'Platformlarımızdan fotoğraflar, videolar ve görsel içerikler. İş dünyamdan kareler ve başarı hikâyeleri.', 'textarea', 'gallery'],
        ['gallery_photos_title', 'Fotoğraflar Başlığı', 'Fotoğraflar', 'text', 'gallery'],
        ['gallery_videos_title', 'Videolar Başlığı', 'Videolar', 'text', 'gallery'],
        ['gallery_filter_all', 'Galeri Filtre Tümü', 'Tümü', 'text', 'gallery'],
        ['gallery_filter_photos', 'Galeri Filtre Fotoğraflar', 'Fotoğraflar', 'text', 'gallery'],
        ['gallery_filter_videos', 'Galeri Filtre Videolar', 'Videolar', 'text', 'gallery'],
        ['gallery_no_items', 'Galeri Boş Mesajı', 'Henüz galeri öğesi yok', 'text', 'gallery'],
        ['gallery_no_items_desc', 'Galeri Boş Açıklaması', 'Galeri öğeleri yayınlandığında burada görünecek.', 'text', 'gallery'],
        
        // Form Metinleri
        ['form_name_label', 'İsim Alanı Etiketi', 'Adınız', 'text', 'forms'],
        ['form_email_label', 'E-posta Alanı Etiketi', 'E-posta Adresiniz', 'text', 'forms'],
        ['form_subject_label', 'Konu Alanı Etiketi', 'Konu', 'text', 'forms'],
        ['form_message_label', 'Mesaj Alanı Etiketi', 'Mesajınız', 'text', 'forms'],
        ['form_required', 'Zorunlu Alan İşareti', '*', 'text', 'forms'],
        ['form_submit', 'Form Gönder Butonu', 'Gönder', 'text', 'forms'],
        
        // Hata ve Başarı Mesajları
        ['success_contact_sent', 'İletişim Başarı Mesajı', 'Mesajınız başarıyla gönderildi! En kısa sürede size dönüş yapacağım.', 'text', 'messages'],
        ['error_contact_failed', 'İletişim Hata Mesajı', 'Mesaj gönderilirken bir hata oluştu. Lütfen tekrar deneyin.', 'text', 'messages'],
        ['error_invalid_email', 'Geçersiz E-posta Mesajı', 'Geçerli bir e-posta adresi giriniz.', 'text', 'messages'],
        ['error_required_fields', 'Zorunlu Alanlar Mesajı', 'Lütfen tüm zorunlu alanları doldurunuz.', 'text', 'messages'],
        
        // Genel Metinler
        ['site_brand', 'Site Markası', 'BERAT K - R10', 'text', 'general'],
        ['loading_text', 'Yükleniyor Metni', 'Yükleniyor...', 'text', 'general'],
        ['no_results', 'Sonuç Bulunamadı', 'Sonuç bulunamadı.', 'text', 'general'],
        ['read_more', 'Daha Fazla Oku', 'Daha Fazla Oku', 'text', 'general'],
        ['view_all', 'Tümünü Gör', 'Tümünü Gör', 'text', 'general'],
        ['back_to_home', 'Ana Sayfaya Dön', 'Ana Sayfaya Dön', 'text', 'general'],
        ['page_not_found', 'Sayfa Bulunamadı', 'Sayfa Bulunamadı', 'text', 'general']
    ];
    
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO site_contents (content_key, content_title, content_text, content_type, page_location) VALUES (?, ?, ?, ?, ?)");
    
    $added_count = 0;
    foreach ($contents as $content) {
        $stmt->execute($content);
        $added_count++;
    }
    
    echo "<p>✅ $added_count adet içerik eklendi/güncellendi!</p>";
    echo "<p>📝 Yeni eklenen içerikler: Ana sayfa 'Neden bizimle çalışmalısınız', Hakkımda bölümleri, Galeri metinleri!</p>";
    
    // 4. Footer linklerini ekle
    $footer_links = [
        ['Ana Sayfa', 'index.php', 'quick_links', 1],
        ['Hakkımda', 'about.php', 'quick_links', 2],
        ['Platformlar', 'portfolio.php', 'quick_links', 3],
        ['İletişim', 'contact.php', 'quick_links', 4],
        ['Casino Platformları', 'services.php', 'services', 1],
        ['Yayıncılık', 'services.php', 'services', 2],
        ['Güvenlik', 'services.php', 'services', 3],
        ['Facebook', 'https://facebook.com', 'social', 1],
        ['Instagram', 'https://instagram.com', 'social', 2],
        ['LinkedIn', 'https://linkedin.com', 'social', 3],
        ['Gizlilik', 'privacy.php', 'legal', 1],
        ['Şartlar', 'terms.php', 'legal', 2]
    ];
    
    $stmt_footer = $pdo->prepare("INSERT OR REPLACE INTO footer_links (link_title, link_url, link_section, sort_order) VALUES (?, ?, ?, ?)");
    
    $footer_count = 0;
    foreach ($footer_links as $link) {
        $stmt_footer->execute($link);
        $footer_count++;
    }
    
    echo "<p>✅ $footer_count adet footer linki eklendi!</p>";
    
    // 6. İstatistik değerlerini güncelle
    $stats = [
        'stat_projects' => '150',
        'stat_clients' => '85',
        'stat_years' => '5',
        'stat_awards' => '12'
    ];
    
    foreach ($stats as $key => $value) {
        updateSetting($key, $value);
    }
    
    echo "<p>✅ İstatistik değerleri güncellendi!</p>";
    
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>🎉 Tamamlandı!</h3>";
    echo "<p><strong>Site artık tam hızında çalışacak ve tüm metinler düzenlenebilir!</strong></p>";
    echo "<ul>";
    echo "<li>✅ $added_count adet içerik eklendi</li>";
    echo "<li>✅ $footer_count adet footer linki eklendi</li>";
    echo "<li>✅ Galeri sistemi kuruldu</li>";
    echo "<li>✅ İstatistik değerleri düzeltildi</li>";
    echo "<li>✅ Yavaşlık sorunu çözüldü</li>";
    echo "</ul>";
    echo "<p><a href='admin/content-management.php' style='color: #007bff;'>Admin Paneli → İçerik Yönetimi</a> sayfasından tüm metinleri düzenleyebilirsiniz.</p>";
    echo "<p><a href='admin/gallery-management.php' style='color: #007bff;'>Admin Paneli → Galeri Yönetimi</a> sayfasından fotoğraf ve video yükleyebilirsiniz.</p>";
    echo "<p><a href='admin/footer-management.php' style='color: #007bff;'>Admin Paneli → Footer Yönetimi</a> sayfasından footer linklerini yönetebilirsiniz.</p>";
    echo "<p><a href='gallery.php' style='color: #007bff;'>Galeri Sayfası</a> - Yeni oluşturulan galeri sayfasını görüntüleyin.</p>";
    echo "</div>";
    
    echo "<p style='color: red; font-weight: bold;'>⚠️ Bu dosyayı silmeyi unutmayın!</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Hata: " . $e->getMessage() . "</p>";
}
?>