<?php
$pageTitle = 'Principal';
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
<body class="principal-page">
	<?php include __DIR__ . '/includes/header.php'; ?>

	<main class="w-100 m-0">
		<section class="hero p-0 m-0" data-animate>
			<div class="hero-slide">
				<img src="assets/images/banner2.png" alt="Principal banner" class="hero-slide-image">
				<div class="hero-content container">
					<h1>Principal's Page</h1>
					<p>Leadership, discipline, and academic excellence at World Wide Missions School.</p>
					<div class="hero-buttons">
						<a href="admissions.php" class="btn primary">Apply Now</a>
						<a href="staff.php" class="btn light">Meet Our Staff</a>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 proprietor-section" data-animate>
			<div class="container">
				<div class="proprietor-wrap">
					<div class="row g-4 align-items-center">
						<div class="col-lg-4 text-center fade-left">
							<div class="proprietor-photo-frame mx-auto">
								<img src="assets/images/Principal.png" class="img-fluid proprietor-photo" alt="Principal portrait">
							</div>
						</div>
						<div class="col-lg-8 text-start fade-right">
							<span class="proprietor-kicker">Principal's Message</span>
							<h2 class="section-title mb-3">Mr. Calvin Y. Goffah</h2>
							<p class="proprietor-text"><strong>Warm greetings from the family of World Wide Missions School, Duport Road.</strong></p>
							<p class="proprietor-text">At WBI, we believe every child is a gift from God with a purpose to fulfill. Our duty is simple: train them well for life and for eternity. Each day, our teachers step into the classroom not just to teach subjects, but to shape character, instill discipline, and build competence that will serve Liberia and beyond.</p>
							<p class="proprietor-text">We hold firm to three pillars: <strong>Christ, Character, and Excellence</strong>. Your child will be challenged academically to meet Ministry of Education standards and pass WASSCE with integrity. They will also be mentored to respect authority, serve others, and work with their hands. We maintain zero tolerance for exam malpractice, drug abuse, and indiscipline, because real education cannot grow where values are broken.</p>
							<p class="proprietor-text">To our parents: thank you for trusting us. You are partners, not spectators. To our students: come ready to learn, obey, and lead. The future of Liberia sits in these desks.</p>
							<p class="proprietor-text">WBI is more than a school; it is a mission field and a launchpad. Together, let us raise a generation that is skilled, godly, and fearless.</p>
							<div class="proprietor-signature mt-3">
								<h6 class="mb-0">Mr. Calvin Y. Goffah</h6>
								<small>Principal, World Wide Missions School</small>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 section-soft" data-animate>
			<div class="container">
				<div class="section-heading text-center">
					<span class="section-kicker">Leadership Focus</span>
					<h2 class="section-title">What We Stand For</h2>
					<p>We keep teaching and discipline aligned to ministry standards, student growth, and strong moral values.</p>
				</div>

				<div class="row g-4">
					<div class="col-md-4">
						<div class="card value-card-item h-100 text-start p-3">
							<div class="value-icon"><i class="bi bi-cross"></i></div>
							<h3 class="h5">Christ</h3>
							<p class="mb-0">Faith shapes our teaching, our decisions, and our school culture.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card value-card-item h-100 text-start p-3">
							<div class="value-icon"><i class="bi bi-shield-check"></i></div>
							<h3 class="h5">Character</h3>
							<p class="mb-0">We teach respect, discipline, and responsibility every day.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card value-card-item h-100 text-start p-3">
							<div class="value-icon"><i class="bi bi-award"></i></div>
							<h3 class="h5">Excellence</h3>
							<p class="mb-0">We pursue strong academics, fairness, and high standards.</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5">
			<div class="container">
				<div class="verification-cta d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3 gap-lg-4 text-start text-lg-start">
					<div class="verification-copy">
						<span class="verification-kicker">School Message</span>
						<h4 class="mb-2 d-flex align-items-center gap-2">
							<i class="bi bi-people-fill" aria-hidden="true"></i>
							<span>Welcome to WBI</span>
						</h4>
						<p class="mb-0">We are committed to raising a generation that is skilled, godly, and fearless.</p>
					</div>
					<a href="contact.php" class="btn btn-school btn-lg verification-btn">Contact the School</a>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
