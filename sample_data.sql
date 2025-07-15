-- ÖRNEK VERİLER - BERAT K - R10 Portfolio (SQLite Edition)
-- Bu dosyayı SQLite veritabanına import edebilirsiniz

-- Örnek Projeler (SQLite uyumlu)
INSERT INTO projects (title, description, technologies, category, image, demo_url, github_url, featured, status) VALUES
('E-Ticaret Web Sitesi', 'Modern ve responsive e-ticaret platformu. Kullanıcı dostu arayüz, güvenli ödeme sistemi ve admin paneli ile tam özellikli online mağaza çözümü.', 'HTML5, CSS3, JavaScript, PHP, MySQL, Bootstrap', 'Web Development', 'assets/img/projects/ecommerce.jpg', 'https://demo.ecommerce.com', 'https://github.com/user/ecommerce', 1, 1),

('Mobil ToDo Uygulaması', 'React Native ile geliştirilmiş cross-platform görev yönetimi uygulaması. Offline çalışma, push notification ve senkronizasyon özellikleri.', 'React Native, Redux, Firebase, Node.js', 'Mobile App', 'assets/img/projects/todo-app.jpg', 'https://play.google.com/store/apps/details?id=com.todo', 'https://github.com/user/todo-app', 1, 1),

('Portföy Yönetim Sistemi', 'Finansal portföy takibi ve analizi için geliştirilmiş web uygulaması. Gerçek zamanlı veriler, grafikler ve raporlama modülleri.', 'Vue.js, Laravel, MySQL, Chart.js, WebSocket', 'Web Application', 'assets/img/projects/portfolio-system.jpg', 'https://demo.portfolio.com', 'https://github.com/user/portfolio-system', 1, 1);

-- Örnek Ürünler (SQLite uyumlu)  
INSERT INTO products (title, description, features, category, price, currency, image, demo_url, admin_demo_url, download_url, documentation_url, featured, status) VALUES
('CRM Yönetim Sistemi', 'Müşteri ilişkileri yönetimi için kapsamlı çözüm. Satış takibi, raporlama, e-posta entegrasyonu ve daha fazlası.', 'Müşteri Yönetimi, Satış Takibi, Raporlama, E-posta Entegrasyonu, Kullanıcı Yetkilendirme', 'Software', '2500', 'TL', 'assets/img/products/crm.jpg', 'https://demo.crm.com', 'https://admin.crm.com', 'https://downloads.com/crm.zip', 'https://docs.crm.com', 1, 1),

('Blog Yönetim Scripti', 'Modern ve SEO dostu blog scripti. Çoklu yazar desteği, kategori yönetimi, yorum sistemi ve admin paneli.', 'SEO Optimize, Çoklu Yazar, Kategori Yönetimi, Yorum Sistemi, Responsive Tasarım', 'Script', '850', 'TL', 'assets/img/products/blog-script.jpg', 'https://demo.blog.com', 'https://admin.blog.com', 'https://downloads.com/blog.zip', 'https://docs.blog.com', 1, 1),

('E-İmza Entegrasyon Modülü', 'Web uygulamaları için elektronik imza entegrasyon çözümü. Güvenli, hızlı ve kolay entegrasyon.', 'Elektronik İmza, API Entegrasyonu, Güvenlik, Sertifika Yönetimi, Log Sistemi', 'Module', '1200', 'TL', 'assets/img/products/e-signature.jpg', 'https://demo.esign.com', 'https://admin.esign.com', 'https://downloads.com/esign.zip', 'https://docs.esign.com', 1, 1);

-- İstatistik değerlerini güncelle (SQLite uyumlu)
INSERT OR REPLACE INTO settings (setting_key, setting_value) VALUES 
('stat_projects', '150'),
('stat_clients', '85'),
('stat_years', '5'),
('stat_awards', '12'),
('blog_enabled', '1'),
('blog_posts_per_page', '6'),
('blog_page_title', 'Blog'),
('blog_description', 'Teknoloji, yazılım geliştirme ve projelerim hakkında yazılar'),
('site_title', 'BERAT K - R10 Portfolio'),
('site_description', 'Profesyonel yazılımcı BERAT K - R10 portföy sitesi'),
('contact_email', 'admin@beratk.com');

-- Blog kategorileri ekle
INSERT INTO blog_categories (name, slug, description) VALUES
('Teknoloji', 'teknoloji', 'Teknoloji dünyasından haberler ve gelişmeler'),
('Web Geliştirme', 'web-gelistirme', 'Web geliştirme konularında ipuçları ve rehberler'),
('Mobil Geliştirme', 'mobil-gelistirme', 'Mobil uygulama geliştirme hakkında yazılar');

-- Hizmetler ekle
INSERT INTO services (title, description, icon) VALUES
('Web Geliştirme', 'Modern ve responsive web siteleri tasarlıyor ve geliştiriyorum. HTML5, CSS3, JavaScript ve PHP teknolojileri kullanarak profesyonel çözümler sunuyorum.', 'fas fa-code'),
('Mobil Uygulama', 'iOS ve Android platformları için native ve hybrid uygulamalar geliştiriyorum. React Native ve Flutter teknolojileri ile çapraz platform çözümler.', 'fas fa-mobile-alt'),
('E-Ticaret', 'Güvenli ve kullanıcı dostu e-ticaret çözümleri sunuyorum. WooCommerce, Shopify ve özel e-ticaret platformları geliştiriyorum.', 'fas fa-shopping-cart'),
('SEO Optimizasyon', 'Web sitenizin arama motorlarında üst sıralarda yer alması için teknik ve içerik SEO hizmetleri veriyorum.', 'fas fa-search'),
('Sistem Yönetimi', 'Sunucu kurulumu, güvenlik yapılandırması ve sistem optimizasyonu hizmetleri sunuyorum. Linux ve Windows sunucu yönetimi.', 'fas fa-server'),
('UI/UX Tasarım', 'Kullanıcı dostu arayüz tasarımları ve kullanıcı deneyimi optimizasyonu yapıyorum. Figma ve Adobe XD kullanarak modern tasarımlar oluşturuyorum.', 'fas fa-paint-brush');