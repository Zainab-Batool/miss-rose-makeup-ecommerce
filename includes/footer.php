    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>About Miss Rose</h5>
                    <p class="text-light">Your premier destination for high-quality cosmetics and beauty products.</p>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITE_URL; ?>/pages/products.php">Products</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/pages/about.php">About Us</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Connect With Us</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="text-center mt-3">
                <span>© 2024 <?php echo SITE_NAME; ?>. All rights reserved.</span>
            </div>
        </div>
    </footer>

    <style>
        .footer {
            background: linear-gradient(to right, #FF69B4, #FF1493);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer p {
            opacity: 0.9;
        }

        .footer ul li {
            margin-bottom: 0.5rem;
        }

        .footer a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            opacity: 0.9;
        }

        .footer a:hover {
            color: #FFB6C1;
            opacity: 1;
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }

        .footer-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 2rem 0 1rem 0;
        }

        @media (max-width: 768px) {
            .footer {
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
</body>
</html>
