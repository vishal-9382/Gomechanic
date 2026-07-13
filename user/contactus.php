<?php
include('userheader.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>

        /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    margin: auto;
    padding-top: 0px;
}

.contact-header {
    text-align: center;
    font-size: 32px;
    color: #2c3e50;
    margin-bottom: 10px;
}

.contact-description {
    text-align: center;
    font-size: 18px;
    color: #7f8c8d;
    margin-bottom: 30px;
}

/* Contact Form Styles */
.contact-form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.contact-form .form-group {
    margin-bottom: 20px;
}

.contact-form label {
    font-size: 16px;
    color: #34495e;
    margin-bottom: 5px;
}

.contact-form .form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #dcdcdc;
    border-radius: 4px;
    background-color: #fafafa;
}

.contact-form .form-control:focus {
    outline: none;
    border-color: #2980b9;
    background-color: #fff;
}

.submit-btn {
    width: 100%;
    padding: 12px;
    background-color: #2980b9;
    color: white;
    font-size: 18px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #3498db;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 95%;
    }

    .contact-form .form-control {
        font-size: 14px;
    }

    .submit-btn {
        font-size: 16px;
    }
}

    </style>
</head>

<body>
    <!-- Contact Us Section -->
    <div class="container" style="margin-top: 50px;">
        <h2 class="contact-header">Contact Us</h2>
        <p class="contact-description">We'd love to hear from you! Fill out the form below and we’ll get back to you as soon as possible.</p>

        <div class="contact-form-container">
            <form method="POST" action="process_contact.php" class="contact-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                </div>

                <button type="submit" class="submit-btn" name="submit_contact">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>
</body>

</html>
