<?php
/**
 * Homepage - BERAT K - R10 Portfolio
 * Developer: BERAT K - R10
 * Website: Portfolio Management System
 * Created by: BERAT K - R10
 */

require_once 'includes/functions.php';
checkMaintenanceMode();
trackVisitor(); // Ziyaretçi sayacı
$page_title = 'Ana Sayfa';
?>

<?php include 'includes/header.php'; ?>

<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <div class="hero-image animate-on-scroll mb-4">
                    <?php 
                    $about_image = getSetting('about_image', '');
                    if($about_image && file_exists($about_image)): 
                    ?>
                        <div class="hero-profile-image">
                            <img src="<?php echo htmlspecialchars($about_image); ?>" alt="<?php echo getSetting('site_brand', 'BERAT K - R10'); ?>" class="img-fluid rounded-circle profile-img">
                        </div>
                    <?php else: ?>
                        <div class="hero-placeholder">
                            <div class="hero-placeholder-inner">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="hero-content animate-on-scroll">
                    <h1 style="margin-bottom: 0.2rem; line-height: 1.2;">
                        Merhaba, Ben<br>
                        <span class="text-gradient"><?php echo getSetting('hero_title', 'BERAT K'); ?> - <?php echo getSetting('hero_subtitle', 'R10'); ?></span>
                    </h1>
                    <p class="lead" style="margin-top: 0.3rem;">
                        <?php echo getSetting('hero_description', 'Profesyonel yazılım geliştirici olarak modern web uygulamaları, mobil çözümler ve yaratıcı dijital deneyimler tasarlıyorum.'); ?>
                    </p>
                    <div class="hero-buttons">
                        <a href="portfolio.php" class="btn btn-gradient me-3">Çalışmalarım</a>
                        <a href="contact.php" class="btn btn-outline-gradient">İletişim</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="floating-elements">
        <div class="floating-element" style="top: 20%; left: 10%; animation-delay: 0s;">
            <i class="fab fa-html5" style="font-size: 50px; color: var(--primary-color);"></i>
        </div>
        <div class="floating-element" style="top: 40%; right: 15%; animation-delay: 2s;">
            <i class="fab fa-js-square" style="font-size: 40px; color: var(--secondary-color);"></i>
        </div>
        <div class="floating-element" style="bottom: 30%; left: 20%; animation-delay: 4s;">
            <i class="fab fa-php" style="font-size: 45px; color: var(--primary-color);"></i>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="container">
        <div class="row">
            <?php 
            // Get stats from admin settings
            $stat_projects = getSetting('stat_projects', '150');
            $stat_clients = getSetting('stat_clients', '85'); 
            $stat_years = getSetting('stat_years', '5');
            $stat_awards = getSetting('stat_awards', '12');
            
            // Debug: Kontrol et (Bu satırı geçici olarak aktifleştirebilirsiniz)
            echo "<!-- DEBUG: Projects: $stat_projects, Clients: $stat_clients, Years: $stat_years, Awards: $stat_awards -->";
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item animate-on-scroll">
                    <span class="stat-number" data-count="<?php echo htmlspecialchars($stat_projects); ?>">0+</span>
                    <div class="stat-label">Tamamlanan Proje</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item animate-on-scroll">
                    <span class="stat-number" data-count="<?php echo htmlspecialchars($stat_clients); ?>">0+</span>
                    <div class="stat-label">Mutlu Müşteri</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item animate-on-scroll">
                    <span class="stat-number" data-count="<?php echo htmlspecialchars($stat_years); ?>">0+</span>
                    <div class="stat-label">Yıllık Deneyim</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item animate-on-scroll">
                    <span class="stat-number" data-count="<?php echo htmlspecialchars($stat_awards); ?>">0+</span>
                    <div class="stat-label">Ödül & Sertifika</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Hizmetlerim</h2>
        
        <div class="row">
            <?php
            $services = getServices(6);
            if (!empty($services)):
                foreach ($services as $service):
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card animate-on-scroll">
                        <div class="service-icon">
                            <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                        </div>
                        <h4><?php echo htmlspecialchars($service['title']); ?></h4>
                        <p><?php echo truncateText($service['description']); ?></p>
                        <a href="services.php" class="btn btn-outline-gradient btn-sm">Detaylar</a>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card animate-on-scroll">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4>Web Geliştirme</h4>
                        <p>Modern ve responsive web siteleri tasarlıyor ve geliştiriyorum.</p>
                        <a href="services.php" class="btn btn-outline-gradient btn-sm">Detaylar</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card animate-on-scroll">
                        <div class="service-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Mobil Uygulama</h4>
                        <p>iOS ve Android platformları için native ve hybrid uygulamalar.</p>
                        <a href="services.php" class="btn btn-outline-gradient btn-sm">Detaylar</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card animate-on-scroll">
                        <div class="service-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4>E-Ticaret</h4>
                        <p>Güvenli ve kullanıcı dostu e-ticaret çözümleri sunuyorum.</p>
                        <a href="services.php" class="btn btn-outline-gradient btn-sm">Detaylar</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="services.php" class="btn btn-gradient">Tüm Hizmetler</a>
        </div>
    </div>
</section>

<section class="py-5" style="background: rgba(108, 92, 231, 0.05);">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Son Projelerim</h2>
        
        <div class="row">
            <?php
            $projects = getProjects(6);
            if (!empty($projects)):
                foreach ($projects as $project):
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="project-card animate-on-scroll">
                        <div class="project-image" style="background-image: url('<?php echo $project['image'] ? htmlspecialchars($project['image']) : 'assets/img/project-placeholder.jpg'; ?>');">
                            <div class="project-overlay">
                                <div class="project-links">
                                    <?php if($project['demo_url']): ?>
                                        <a href="<?php echo htmlspecialchars($project['demo_url']); ?>" target="_blank" title="Demo">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if($project['github_url']): ?>
                                        <a href="<?php echo htmlspecialchars($project['github_url']); ?>" target="_blank" title="GitHub">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h5><?php echo htmlspecialchars($project['title']); ?></h5>
                            <p class="project-desc"><?php echo truncateText($project['description']); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="project-date"><?php echo formatDate($project['created_at']); ?></small>
                                <span class="badge bg-gradient text-white"><?php echo htmlspecialchars($project['category']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="col-12 text-center">
                    <p class="no-content-text">Henüz proje eklenmemiş.</p>
                    <a href="admin/login.php" class="btn btn-outline-gradient">Admin Paneli</a>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($projects)): ?>
        <div class="text-center mt-4">
            <a href="portfolio.php" class="btn btn-gradient">Tüm Projeler</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Ürünlerim</h2>
        
        <div class="row">
            <?php
            $products = getProducts(3);
            if (!empty($products)):
                foreach ($products as $product):
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="product-card animate-on-scroll">
                        <div class="product-image" style="background-image: url('<?php echo $product['image'] ? htmlspecialchars($product['image']) : 'assets/img/product-placeholder.jpg'; ?>');"></div>
                        <div class="product-content">
                            <h5 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <p class="product-description"><?php echo truncateText($product['description']); ?></p>
                            
                            <?php if($product['price']): ?>
                            <div class="product-price mb-3">
                                <span class="price-text text-gradient fw-bold">
                                    <i class="fas fa-tag me-1"></i>
                                    <?php echo htmlspecialchars($product['price']); ?> ₺
                                </span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="product-links">
                                <?php if($product['demo_url']): ?>
                                    <a href="<?php echo htmlspecialchars($product['demo_url']); ?>" target="_blank" class="btn btn-outline-gradient btn-sm">Demo</a>
                                <?php endif; ?>
                                <?php if($product['admin_demo_url']): ?>
                                    <a href="<?php echo htmlspecialchars($product['admin_demo_url']); ?>" target="_blank" class="btn btn-gradient btn-sm">Admin Demo</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="col-12 text-center">
                    <p class="no-content-text">Henüz ürün eklenmemiş.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($products)): ?>
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-gradient">Tüm Ürünler</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if(getSetting('blog_enabled', '1') == '1'): ?>
<section class="py-5" style="background: rgba(108, 92, 231, 0.05);">
    <div class="container">
        <h2 class="section-title animate-on-scroll">Son Blog Yazıları</h2>
        
        <div class="row">
            <?php
            $blog_posts = getBlogPosts(3);
            if (!empty($blog_posts)):
                foreach ($blog_posts as $post):
            ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="blog-card-home animate-on-scroll">
                        <?php if ($post['featured_image']): ?>
                            <div class="blog-card-image">
                                <a href="blog.php?post=<?php echo $post['slug']; ?>">
                                    <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($post['title']); ?>" 
                                         class="img-fluid">
                                </a>
                                <?php if ($post['category_name']): ?>
                                    <div class="blog-card-category">
                                        <span class="badge badge-gradient">
                                            <?php echo htmlspecialchars($post['category_name']); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="blog-card-content">
                            <div class="blog-card-meta mb-2">
                                <span class="me-3">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo formatDate($post['created_at']); ?>
                                </span>
                                <span>
                                    <i class="fas fa-eye me-1"></i>
                                    <?php echo $post['views']; ?>
                                </span>
                            </div>
                            
                            <h4 class="blog-card-title">
                                <a href="blog.php?post=<?php echo $post['slug']; ?>">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </a>
                            </h4>
                            
                            <p class="blog-card-excerpt">
                                <?php echo $post['excerpt'] ? htmlspecialchars($post['excerpt']) : truncateText(strip_tags($post['content']), 100); ?>
                            </p>
                            
                            <a href="blog.php?post=<?php echo $post['slug']; ?>" class="btn btn-outline-gradient btn-sm">
                                Devamını Oku <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </article>
                </div>
            <?php 
                endforeach;
            else:
            ?>
                <div class="col-12 text-center">
                    <div class="empty-blog-state">
                        <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                        <h5 class="text-light">Henüz blog yazısı yok</h5>
                        <p class="text-muted">Blog yazıları yayınlandığında burada görünecek.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($blog_posts)): ?>
        <div class="text-center mt-4">
            <a href="blog.php" class="btn btn-gradient">Tüm Blog Yazıları</a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<section class="py-5" style="background: var(--dark-card);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="text-gradient mb-3"><?php echo getSetting('cta_title', 'Projene Başlayalım!'); ?></h3>
                <p class="mb-0 cta-text"><?php echo getSettingWithVariables('cta_text', 'Fikrini gerçeğe dönüştürmek için benimle iletişime geç. {site_brand} ile profesyonel çözümler.'); ?></p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-gradient btn-lg">İletişime Geç</a>
            </div>
        </div>
    </div>
</section>

<style>
/* Blog Cards for Homepage */
.blog-card-home {
    background: var(--dark-card);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid var(--dark-border);
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.blog-card-home:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2);
    border-color: var(--primary-color);
}

.blog-card-home .blog-card-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.blog-card-home .blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-card-home:hover .blog-card-image img {
    transform: scale(1.05);
}

.blog-card-home .blog-card-category {
    position: absolute;
    top: 15px;
    left: 15px;
}

.blog-card-home .badge-gradient {
    background: var(--gradient);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
}

.blog-card-home .blog-card-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.blog-card-home .blog-card-meta {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.blog-card-home .blog-card-title {
    margin-bottom: 15px;
    font-size: 1.25rem;
    line-height: 1.4;
    font-weight: 600;
}

.blog-card-home .blog-card-title a {
    color: var(--text-light);
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-card-home .blog-card-title a:hover {
    color: var(--primary-color);
}

.blog-card-home .blog-card-excerpt {
    color: var(--text-muted);
    margin-bottom: 20px;
    line-height: 1.6;
    flex-grow: 1;
    font-size: 0.95rem;
}

.blog-card-home .btn-outline-gradient {
    align-self: flex-start;
    margin-top: auto;
}

.empty-blog-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-blog-state i {
    opacity: 0.5;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .blog-card-home .blog-card-image {
        height: 180px;
    }
    
    .blog-card-home .blog-card-content {
        padding: 20px;
    }
    
    .blog-card-home .blog-card-title {
        font-size: 1.1rem;
    }
    
    .blog-card-home .blog-card-excerpt {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .blog-card-home .blog-card-image {
        height: 160px;
    }
    
    .blog-card-home .blog-card-content {
        padding: 15px;
    }
    
    .blog-card-home .blog-card-title {
        font-size: 1rem;
        margin-bottom: 10px;
    }
    
    .blog-card-home .blog-card-meta {
        font-size: 0.8rem;
        margin-bottom: 10px;
    }
    
    .blog-card-home .blog-card-excerpt {
        font-size: 0.85rem;
        margin-bottom: 15px;
    }
}
</style>

<?php include 'includes/footer.php'; ?>