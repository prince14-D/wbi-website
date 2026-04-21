<?php
$pageTitle = 'Home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $pageTitle; ?> - William Bean Institute</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo.png">
	<link rel="shortcut icon" href="assets/images/logo.png">
	<link rel="manifest" href="manifest.json">
	<meta name="theme-color" content="#1E4FA3">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<meta name="apple-mobile-web-app-title" content="WBI">
	<link rel="apple-touch-icon" href="assets/images/logo.png">
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<?php include __DIR__ . '/includes/header.php'; ?>

	<main>
		<section class="hero hero-slider">
			<div id="homeHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
				<div class="carousel-indicators">
					<button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
					<button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
					<button type="button" data-bs-target="#homeHeroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
				</div>

				<div class="carousel-inner">
					<div class="carousel-item active">
						<div class="hero-slide">
							<img src="assets/images/banner.png" alt="WBI Logo" class="hero-slide-image">
							<div class="hero-content container">
								<h1>Welcome to William Bean Institute (WBI)</h1>
								<p>Raising a generation of disciplined, God-fearing, and skilled leaders for Liberia and the world.</p>
								<div class="hero-buttons">
									<a href="admissions.php" class="btn primary">Apply Now</a>
									<a href="about.php" class="btn secondary">Learn More</a>
									<a href="assets/uploads/information-sheet.pdf" class="btn light" download>Download Information Sheet</a>
								</div>
							</div>
						</div>
					</div>

					<div class="carousel-item">
						<div class="hero-slide">
							<img src="assets/images/logo.png" alt="WBI Logo" class="hero-slide-image">
							<div class="hero-content container">
								<h1>Excellence in Academics and Character</h1>
								<p>Our students are equipped for WAEC success, responsible leadership, and lifelong service.</p>
								<div class="hero-buttons">
									<a href="academics.php" class="btn primary">Explore Academics</a>
									<a href="assets/uploads/information-sheet.pdf" class="btn light" download>Download Information Sheet</a>
								</div>
							</div>
						</div>
					</div>

					<div class="carousel-item">
						<div class="hero-slide">
							<img src="assets/images/banner2.png" alt="WBI Logo" class="hero-slide-image">
							<div class="hero-content container">
								<h1>Admissions Are Open</h1>
								<p>Join the WBI family and give your child a strong foundation built on faith and discipline.</p>
								<div class="hero-buttons">
									<a href="admissions.php" class="btn primary">Start Admission</a>
									<a href="assets/uploads/information-sheet.pdf" class="btn light" download>Download Information Sheet</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
		</section>

		<section class="admissions-cta p-4 p-md-5" data-animate>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-8 text-center text-lg-start">
						<h2 class="section-title text-white">Admissions Now Open</h2>
						<p class="mb-0">Give your child a strong academic and moral foundation in a nurturing school community.</p>

						<div id="countdown" data-deadline="2026-09-30T23:59:59" class="d-flex flex-wrap gap-2 gap-md-3 mt-4 justify-content-center justify-content-lg-start">
							<div class="time-box"><h3 id="days">00</h3><small>Days</small></div>
							<div class="time-box"><h3 id="hours">00</h3><small>Hours</small></div>
							<div class="time-box"><h3 id="minutes">00</h3><small>Minutes</small></div>
							<div class="time-box"><h3 id="seconds">00</h3><small>Seconds</small></div>
						</div>
					</div>

					<div class="col-lg-4 text-center mt-4 mt-lg-0">
						<a href="admissions.php" class="btn btn-school btn-lg w-100 mb-2">Start Application</a>
						<a href="contact.php" class="btn btn-outline-light btn-lg w-100">Talk To Us</a>
					</div>
				</div>
			</div>
		</section>

		<section class="about-preview about-feature" data-animate>
			<div class="container">
				<div class="row align-items-center g-4">
					<div class="col-lg-5 fade-left">
						<div class="about-logo-panel">
							<img src="assets/images/logo.png" alt="William Bean Institute Logo" class="about-school-logo">
							<p class="school-meta"><strong>Year Established:</strong> April 2, 1982</p>
							<p class="school-meta"><strong>Type of School:</strong> Faith-based</p>
						</div>
					</div>

					<div class="col-lg-7 text-start fade-right">
						<h2>William Bean Institute (WBI)</h2>
						<p>
							Located on Duport Road, Monrovia, William Bean Institute (WBI), under the World Wide Missions School System,
							is known for academic excellence and moral leadership in Liberia. Since 1982, WBI has stayed committed to
							raising disciplined, God-fearing, and skilled students prepared to serve Liberia and the wider world.
						</p>
						<p>
							WBI offers quality education from kindergarten to senior high school, combining the Liberian curriculum with
							strong Christian values. Beyond exam success, the school builds character, critical thinking, and practical
							skills through structured teaching, mentorship, and co-curricular activities including computer studies,
							entrepreneurship, and vocational clubs.
						</p>
						<p>
							With a safe learning environment, close parent partnership, and a mission-driven culture rooted in devotion,
							discipline, and service, WBI shapes both mind and heart. From college pathways to trade and ministry,
							WBI remains a strong foundation for future leaders.
						</p>
						<a href="about.php" class="btn secondary">Read More</a>
					</div>
				</div>
			</div>
		</section>

		<section class="values section-soft">
			<div class="container">
				<h2>Our Core Values</h2>
				<div class="value-cards">
					<article class="card">
						<h3>Christ</h3>
						<p>Faith is at the center of everything we do.</p>
					</article>
					<article class="card">
						<h3>Character</h3>
						<p>We build disciplined and responsible students.</p>
					</article>
					<article class="card">
						<h3>Excellence</h3>
						<p>We strive for high academic and moral standards.</p>
					</article>
					<article class="card">
						<h3>Service</h3>
						<p>We prepare students to serve society and humanity.</p>
					</article>
				</div>
			</div>
		</section>

		<section class="programs">
			<div class="container">
				<h2>Academic Programs</h2>
				<div class="program-cards">
					<article class="card">
						<h3>Kindergarten</h3>
						<p>Strong foundation in literacy, numeracy, and values.</p>
					</article>
					<article class="card">
						<h3>Elementary</h3>
						<p>Core subjects with discipline and creativity.</p>
					</article>
					<article class="card">
						<h3>Junior High</h3>
						<p>Preparation for BECE with structured learning.</p>
					</article>
					<article class="card">
						<h3>Senior High</h3>
						<p>WAEC-focused education with career readiness.</p>
					</article>
				</div>
			</div>
		</section>

		<section class="principal-message section-soft">
			<div class="container">
				<h2>Message from the Principal</h2>
				<p>
					"At WBI, we train students not just for exams, but for life and eternity.
					We focus on Christ, Character, and Excellence in everything we do."
				</p>
				<p><strong>- Mr. Calvin Y. Goffah</strong></p>
				<a href="principal.php" class="btn secondary">Read Full Message</a>
			</div>
		</section>

		<section class="cta">
			<div class="container">
				<h2>Enroll Your Child Today</h2>
				<p>Join a school that builds both the mind and the heart.</p>
				<a href="admissions.php" class="btn light">Start Admission</a>
			</div>
		</section>

		<section class="news">
			<div class="container">
				<h2>Latest News</h2>
				<div class="news-cards">
					<article class="card">
						<h3>Admissions Open</h3>
						<p>Enrollment for the new academic year is now ongoing.</p>
					</article>
					<article class="card">
						<h3>WAEC Success</h3>
						<p>WBI students achieve excellent results in WASSCE.</p>
					</article>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
