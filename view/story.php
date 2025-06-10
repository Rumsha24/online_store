<?php
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductController($db);
?>

<?php include __DIR__ . '/header.php'; ?>

<style>
    body {
        background: #fff0f3;
        color: #590d22;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    h1, h2, h3 {
        color: #c9184a;
    }
    a, a:visited {
        color: #800f2f;
    }
    .story-hero {
        height: 60vh;
        background: linear-gradient(rgba(247, 87, 116, 0.7), rgba(255, 204, 213, 0.7)), 
                    url('../../images/story-hero.jpg') center/cover no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 40px;
        animation: fadeIn 1.5s ease-in-out;
    }
    .story-hero h1 {
        font-size: 4rem;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(89, 13, 34, 0.5);
        margin-bottom: 20px;
    }
    .story-hero p {
        font-size: 1.5rem;
        color: #fff;
        max-width: 800px;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(89, 13, 34, 0.5);
    }
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto 80px auto;
    }
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: #ffb3c1;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
        border-radius: 10px;
    }
    .timeline-container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }
    .timeline-container.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .timeline-container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -17px;
        background-color: #ffccd5;
        border: 4px solid #c9184a;
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }
    .left {
        left: 0;
    }
    .right {
        left: 50%;
    }
    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid #ffccd5;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent #ffccd5;
    }
    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid #ffccd5;
        border-width: 10px 10px 10px 0;
        border-color: transparent #ffccd5 transparent transparent;
    }
    .right::after {
        left: -16px;
    }
    .timeline-content {
        padding: 20px 30px;
        background-color: #ffccd5;
        position: relative;
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(200, 24, 74, 0.1);
    }
    .timeline-content h2 {
        margin-top: 0;
        color: #a4133c;
    }
    .timeline-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 6px;
        margin: 10px 0;
        border: 2px solid #ff4d6d;
        transition: transform 0.3s ease;
    }
    .timeline-img:hover {
        transform: scale(1.05);
    }
    .team-section {
        max-width: 1200px;
        margin: 0 auto 80px auto;
        text-align: center;
    }
    .team-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-top: 40px;
    }
    .team-member {
        width: 250px;
        background: #ffccd5;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(200, 24, 74, 0.1);
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }
    .team-member.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .team-member:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(200, 24, 74, 0.2);
    }
    .team-member img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ff4d6d;
        margin-bottom: 15px;
    }
    .team-member h3 {
        margin: 10px 0 5px 0;
    }
    .team-member p {
        color: #800f2f;
        font-style: italic;
        margin: 5px 0;
    }
    .values-section {
        max-width: 1000px;
        margin: 0 auto 80px auto;
        text-align: center;
    }
    .values-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        margin-top: 40px;
    }
    .value-card {
        width: 250px;
        background: #ffb3c1;
        border-radius: 10px;
        padding: 30px 20px;
        box-shadow: 0 4px 8px rgba(200, 24, 74, 0.1);
        transition: all 0.3s ease;
    }
    .value-card:hover {
        background: #ff4d6d;
        color: #fff0f3;
        transform: translateY(-10px);
    }
    .value-card:hover h3 {
        color: #fff0f3;
    }
    .value-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #c9184a;
    }
    .value-card:hover .value-icon {
        color: #fff0f3;
    }
    .interactive-gallery {
        max-width: 1200px;
        margin: 0 auto 80px auto;
        text-align: center;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        height: 250px;
        box-shadow: 0 4px 8px rgba(200, 24, 74, 0.1);
    }
    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(201, 24, 74, 0.8);
        color: #fff0f3;
        padding: 15px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }
    .gallery-item:hover .gallery-img {
        transform: scale(1.1);
    }
    .gallery-item:hover .gallery-caption {
        transform: translateY(0);
    }
    .cta-section {
        background: #ffb3c1;
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 60px;
        border-radius: 10px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }
    .cta-button {
        display: inline-block;
        background: #c9184a;
        color: #fff0f3;
        padding: 15px 40px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        margin-top: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(200, 24, 74, 0.3);
    }
    .cta-button:hover {
        background: #a4133c;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(200, 24, 74, 0.4);
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .floating {
        animation: float 3s ease-in-out infinite;
    }
</style>

<!-- Hero Section -->
<div class="story-hero">
    <div>
        <h1>Our Story</h1>
        <p>From a small boutique in Montreal to an international fragrance destination - this is the journey of Noire Essence</p>
    </div>
</div>

<!-- Timeline Section -->
<div class="timeline">
    <div class="timeline-container left">
        <div class="timeline-content">
            <h2>2005</h2>
            <p>Noire Essence was born in a small Montreal apartment, where founder Isabelle Roche began blending custom fragrances for friends and family.</p>
            <img src="../../images/story1.jpg" alt="Our humble beginnings" class="timeline-img">
        </div>
    </div>
    <div class="timeline-container right">
        <div class="timeline-content">
            <h2>2008</h2>
            <p>Our first boutique opened in Old Montreal, offering 12 signature scents that quickly became local favorites.</p>
            <img src="../../images/story2.jpg" alt="First boutique" class="timeline-img">
        </div>
    </div>
    <div class="timeline-container left">
        <div class="timeline-content">
            <h2>2012</h2>
            <p>We launched our first international shipment, sending our fragrances to customers in France and Japan.</p>
            <img src="../../images/story3.jpg" alt="International shipping" class="timeline-img">
        </div>
    </div>
    <div class="timeline-container right">
        <div class="timeline-content">
            <h2>2015</h2>
            <p>Noire Essence was featured in Vogue Paris, marking our breakthrough in the international fragrance scene.</p>
            <img src="../../images/story4.jpg" alt="Vogue feature" class="timeline-img">
        </div>
    </div>
    <div class="timeline-container left">
        <div class="timeline-content">
            <h2>2020</h2>
            <p>We committed to 100% sustainable sourcing and became carbon neutral, proving luxury and ethics can coexist.</p>
            <img src="../../images/story5.jpg" alt="Sustainability commitment" class="timeline-img">
        </div>
    </div>
    <div class="timeline-container right">
        <div class="timeline-content">
            <h2>Today</h2>
            <p>With over 200 unique fragrances and stores in 12 countries, we continue to innovate while staying true to our artisanal roots.</p>
            <img src="../../images/story6.jpg" alt="Current store" class="timeline-img floating">
        </div>
    </div>
</div>

<!-- Team Section -->
<div class="team-section">
    <h2>Meet Our Master Perfumers</h2>
    <p>The creative minds behind our signature scents</p>
    
    <div class="team-grid">
        <div class="team-member">
            <img src="../../images/team1.jpg" alt="Isabelle Roche">
            <h3>Isabelle Roche</h3>
            <p>Founder & Master Perfumer</p>
            <p>"Fragrance is the invisible accessory that completes your story."</p>
        </div>
        <div class="team-member">
            <img src="../../images/team2.jpg" alt="Marcus Chen">
            <h3>Marcus Chen</h3>
            <p>Head of Product Development</p>
            <p>"Every scent should evoke an emotion, a memory, a dream."</p>
        </div>
        <div class="team-member">
            <img src="../../images/team3.jpg" alt="Sophie Laurent">
            <h3>Sophie Laurent</h3>
            <p>Lead Aromachologist</p>
            <p>"The right fragrance doesn't just smell good - it makes you feel good."</p>
        </div>
        <div class="team-member">
            <img src="../../images/team4.jpg" alt="David Moreau">
            <h3>David Moreau</h3>
            <p>International Brand Director</p>
            <p>"Bringing the Noire Essence experience to the world."</p>
        </div>
    </div>
</div>

<!-- Our Values Section -->
<div class="values-section">
    <h2>Our Core Values</h2>
    <p>The principles that guide every bottle we create</p>
    
    <div class="values-grid">
        <div class="value-card">
            <div class="value-icon">✧</div>
            <h3>Artisan Quality</h3>
            <p>Each fragrance is handcrafted with meticulous attention to detail.</p>
        </div>
        <div class="value-card">
            <div class="value-icon">♻</div>
            <h3>Sustainability</h3>
            <p>Ethically sourced ingredients and eco-conscious packaging.</p>
        </div>
        <div class="value-card">
            <div class="value-icon">✿</div>
            <h3>Innovation</h3>
            <p>Pushing boundaries while honoring traditional perfumery.</p>
        </div>
        <div class="value-card">
            <div class="value-icon">♥</div>
            <h3>Customer Joy</h3>
            <p>Creating moments of delight through scent.</p>
        </div>
    </div>
</div>

<!-- Interactive Gallery -->
<div class="interactive-gallery">
    <h2>Behind the Scenes</h2>
    <p>A glimpse into our world of fragrance creation</p>
    
    <div class="gallery-grid">
        <div class="gallery-item">
            <img src="../../images/gallery1.jpg" alt="Perfume lab" class="gallery-img">
            <div class="gallery-caption">Our perfume lab where magic happens</div>
        </div>
        <div class="gallery-item">
            <img src="../../images/gallery2.jpg" alt="Ingredient selection" class="gallery-img">
            <div class="gallery-caption">Hand-selecting the finest ingredients</div>
        </div>
        <div class="gallery-item">
            <img src="../../images/gallery3.jpg" alt="Bottling process" class="gallery-img">
            <div class="gallery-caption">The meticulous bottling process</div>
        </div>
        <div class="gallery-item">
            <img src="../../images/gallery4.jpg" alt="Product testing" class="gallery-img">
            <div class="gallery-caption">Quality testing every batch</div>
        </div>
        <div class="gallery-item">
            <img src="../../images/gallery5.jpg" alt="Packaging" class="gallery-img">
            <div class="gallery-caption">Eco-friendly packaging</div>
        </div>
        <div class="gallery-item">
            <img src="../../images/gallery6.jpg" alt="Team meeting" class="gallery-img">
            <div class="gallery-caption">Our creative team at work</div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <h2>Experience the Noire Essence Difference</h2>
    <p>Discover our collection of handcrafted fragrances that tell your unique story.</p>
    <a href="/online_store/view/product.php" class="cta-button">Explore Our Collection</a>
</div>

<script>
    // Animation for timeline and team members
    document.addEventListener('DOMContentLoaded', function() {
        // Timeline animation
        const timelineItems = document.querySelectorAll('.timeline-container');
        
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.3 });
        
        timelineItems.forEach(item => {
            timelineObserver.observe(item);
        });
        
        // Team members animation
        const teamMembers = document.querySelectorAll('.team-member');
        
        const teamObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 200);
                }
            });
        }, { threshold: 0.1 });
        
        teamMembers.forEach(member => {
            teamObserver.observe(member);
        });
        
        // Gallery hover effect
        const galleryItems = document.querySelectorAll('.gallery-item');
        galleryItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.querySelector('.gallery-caption').style.transform = 'translateY(0)';
            });
            item.addEventListener('mouseleave', function() {
                this.querySelector('.gallery-caption').style.transform = 'translateY(100%)';
            });
        });
    });
</script>

<?php include __DIR__ . '/footer.php'; ?>