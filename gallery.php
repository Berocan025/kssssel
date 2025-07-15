<?php
/**
 * Gallery Page - BERAT K - R10 Portfolio
 * Developer: BERAT K - R10
 * Website: Portfolio Management System
 * Created by: BERAT K - R10
 */

require_once 'includes/functions.php';
checkMaintenanceMode();
trackVisitor(); // Ziyaretçi sayacı
$page_title = 'Galeri';

$filter = isset($_GET['filter']) ? clean($_GET['filter']) : 'all';

$sql = "SELECT * FROM gallery WHERE is_active = 1";
$params = [];

if ($filter !== 'all' && !empty($filter)) {
    $sql .= " AND type = ?";
    $params[] = $filter;
}

$sql .= " ORDER BY sort_order ASC, created_at DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $gallery_items = $stmt->fetchAll();
} catch(PDOException $e) {
    $gallery_items = [];
}
?>

<?php include 'includes/header.php'; ?>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h1 class="display-4 mb-4">
                    <span class="text-gradient"><?php echo getContent('gallery_page_title', 'Platform Galerisi'); ?></span>
                </h1>
                <p class="lead text-muted">
                    <?php echo getContent('gallery_intro', 'Platformlarımızdan fotoğraflar, videolar ve görsel içerikler. İş dünyamdan kareler ve başarı hikâyeleri.'); ?>
                </p>
            </div>
        </div>
        
        <!-- Gallery Filters -->
        <div class="row mb-5">
            <div class="col-lg-6 mx-auto">
                <div class="gallery-filters d-flex flex-wrap justify-content-center">
                    <button class="gallery-filter btn <?php echo $filter === 'all' ? 'btn-gradient' : 'btn-outline-gradient'; ?> me-2 mb-2" 
                            data-filter="all" onclick="filterGallery('all')">
                        <?php echo getContent('gallery_filter_all', 'Tümü'); ?>
                    </button>
                    <button class="gallery-filter btn <?php echo $filter === 'image' ? 'btn-gradient' : 'btn-outline-gradient'; ?> me-2 mb-2" 
                            data-filter="image" onclick="filterGallery('image')">
                        <i class="fas fa-image me-1"></i>
                        <?php echo getContent('gallery_filter_photos', 'Fotoğraflar'); ?>
                    </button>
                    <button class="gallery-filter btn <?php echo $filter === 'video' ? 'btn-gradient' : 'btn-outline-gradient'; ?> me-2 mb-2" 
                            data-filter="video" onclick="filterGallery('video')">
                        <i class="fas fa-play me-1"></i>
                        <?php echo getContent('gallery_filter_videos', 'Videolar'); ?>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Gallery Grid -->
        <?php if (!empty($gallery_items)): ?>
            <div class="row gallery-grid" id="galleryGrid">
                <?php foreach ($gallery_items as $item): ?>
                    <div class="col-lg-4 col-md-6 mb-4 gallery-item animate-on-scroll" data-type="<?php echo htmlspecialchars($item['type']); ?>">
                        <div class="gallery-card">
                            <?php if ($item['type'] === 'video'): ?>
                                <!-- Video Item -->
                                <div class="gallery-video">
                                    <?php if (!empty($item['youtube_url'])): ?>
                                        <div class="video-thumbnail" onclick="openVideo('<?php echo htmlspecialchars($item['youtube_url']); ?>')">
                                            <?php 
                                            // YouTube thumbnail çıkarma
                                            $youtube_id = '';
                                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $item['youtube_url'], $matches)) {
                                                $youtube_id = $matches[1];
                                            }
                                            ?>
                                            <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg" 
                                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                                 class="img-fluid">
                                            <div class="video-overlay">
                                                <div class="play-button">
                                                    <i class="fas fa-play"></i>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif (!empty($item['file_path'])): ?>
                                        <video class="gallery-video-player" controls>
                                            <source src="<?php echo htmlspecialchars($item['file_path']); ?>" type="video/mp4">
                                            Tarayıcınız video oynatmayı desteklemiyor.
                                        </video>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <!-- Image Item -->
                                <div class="gallery-image" onclick="openLightbox('<?php echo htmlspecialchars($item['file_path']); ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
                                    <img src="<?php echo htmlspecialchars($item['file_path']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                         class="img-fluid">
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="gallery-card-content">
                                <h5 class="gallery-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <?php if (!empty($item['description'])): ?>
                                    <p class="gallery-description"><?php echo htmlspecialchars($item['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-images fa-5x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3"><?php echo getContent('gallery_no_items', 'Henüz galeri öğesi yok'); ?></h3>
                        <p class="text-muted mb-4"><?php echo getContent('gallery_no_items_desc', 'Galeri öğeleri yayınlandığında burada görünecek.'); ?></p>
                        <a href="contact.php" class="btn btn-gradient">İletişime Geç</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Image Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 1051;"></button>
                <img id="lightboxImage" src="" alt="" class="img-fluid w-100">
                <div class="text-center mt-3">
                    <h5 id="lightboxTitle" class="text-white"></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 1051;"></button>
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Gallery Styles */
.gallery-card {
    background: var(--dark-card);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid var(--dark-border);
    height: 100%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.gallery-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(108, 92, 231, 0.2);
    border-color: var(--primary-color);
}

.gallery-image {
    position: relative;
    overflow: hidden;
    cursor: pointer;
    height: 250px;
}

.gallery-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-image:hover img {
    transform: scale(1.1);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(108, 92, 231, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-image:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay-content i {
    font-size: 2rem;
    color: white;
}

.gallery-video {
    position: relative;
    height: 250px;
}

.video-thumbnail {
    position: relative;
    height: 100%;
    cursor: pointer;
    overflow: hidden;
}

.video-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.video-thumbnail:hover .video-overlay {
    background: rgba(108, 92, 231, 0.8);
}

.play-button {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.play-button i {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-left: 3px;
}

.video-thumbnail:hover .play-button {
    background: white;
    transform: scale(1.1);
}

.gallery-video-player {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-card-content {
    padding: 1.5rem;
}

.gallery-title {
    color: var(--text-light);
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.gallery-description {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 0;
    line-height: 1.5;
}

.gallery-filters .btn {
    border-radius: 25px;
    font-weight: 500;
    padding: 8px 20px;
    transition: all 0.3s ease;
}

.empty-state i {
    color: var(--text-muted);
}

/* Lightbox Styles */
#lightboxModal .modal-dialog {
    max-width: 90vw;
}

#lightboxModal img {
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
}

/* Animation */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.animate-on-scroll.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-image,
    .gallery-video {
        height: 200px;
    }
    
    .gallery-filters {
        flex-direction: column;
        align-items: center;
    }
    
    .gallery-filters .btn {
        width: 200px;
        margin: 0 0 10px 0 !important;
    }
}
</style>

<script>
// Gallery Filter Function
function filterGallery(filter) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('filter', filter);
    window.location.href = currentUrl.toString();
}

// Open Lightbox
function openLightbox(imageSrc, title) {
    document.getElementById('lightboxImage').src = imageSrc;
    document.getElementById('lightboxTitle').textContent = title;
    const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
    modal.show();
}

// Open Video
function openVideo(youtubeUrl) {
    // YouTube URL'sini embed formatına çevir
    let videoId = '';
    if (youtubeUrl.includes('watch?v=')) {
        videoId = youtubeUrl.split('watch?v=')[1].split('&')[0];
    } else if (youtubeUrl.includes('youtu.be/')) {
        videoId = youtubeUrl.split('youtu.be/')[1].split('?')[0];
    }
    
    const embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
    document.getElementById('videoFrame').src = embedUrl;
    
    const modal = new bootstrap.Modal(document.getElementById('videoModal'));
    modal.show();
}

// Clear video when modal closes
document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('videoFrame').src = '';
});

// Animation on Scroll
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
});
</script>

<?php include 'includes/footer.php'; ?>