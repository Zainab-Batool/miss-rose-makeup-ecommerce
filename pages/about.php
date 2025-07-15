<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
include '../includes/header.php';
?>

<style>
    .about-section {
        padding: 4rem 0;
        margin-bottom: 3rem;
        background-color: #f8f9fa;
    }

    .about-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .about-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgb(6, 91, 189);
    }

    .about-header p {
        font-size: 1.2rem;
        color: #666;
    }

    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        height: 100%;
        transition: transform 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        color: rgb(28, 147, 245);
    }

    .feature-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
        color: rgb(6, 91, 189);
    }

    .feature-card p {
        color: #666;
        line-height: 1.6;
    }

    .contact-section {
        background: white;
        padding: 3rem 0;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .contact-info {
        padding: 2rem;
        background: white;
        border-radius: 10px;
        height: 100%;
        border: 1px solid rgba(28, 147, 245, 0.2);
    }

    .contact-info h2 {
        color: rgb(6, 91, 189);
        margin-bottom: 1.5rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .contact-icon {
        margin-right: 1rem;
        font-size: 1.5rem;
        color: rgb(28, 147, 245);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(28, 147, 245, 0.1);
        border-radius: 50%;
    }

    .contact-item h5 {
        color: rgb(6, 91, 189);
        font-weight: 600;
    }

    .contact-item p {
        color: #666;
        margin: 0;
    }

    .mission-list {
        list-style: none;
        padding: 0;
    }

    .mission-list li {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        color: #666;
    }

    .mission-list li i {
        margin-right: 1rem;
        color: rgb(28, 147, 245);
        font-size: 1.2rem;
    }
</style>

<div class="about-section">
    <div class="container">
        <div class="about-header">
            <h1>Welcome to <?php echo SITE_NAME; ?></h1>
            <p>Your Premier Destination for Beauty Excellence</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="feature-title">Premium Quality</h3>
                    <p>We offer only the finest selection of cosmetics and beauty products, carefully curated for our discerning customers.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="feature-title">Customer First</h3>
                    <p>Your satisfaction is our priority. We're committed to providing exceptional service and support.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h3 class="feature-title">Luxury for All</h3>
                    <p>Making high-end beauty accessible with competitive prices and regular special offers.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="contact-info">
                <h2>Our Mission</h2>
                <ul class="mission-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Provide premium quality cosmetics</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Ensure customer satisfaction</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Offer competitive prices</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Support sustainable beauty</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="contact-info">
                <h2>Contact Us</h2>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5>Email</h5>
                        <p>info@missrose.com</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <h5>Phone</h5>
                        <p>(123) 456-7890</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h5>Address</h5>
                        <p>123 Beauty Street, Makeup City, MC 12345</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
