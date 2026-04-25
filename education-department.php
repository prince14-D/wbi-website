<?php
$pageTitle = 'Education Department';
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
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<?php include __DIR__ . '/includes/header.php'; ?>

	<main>
		<section class="hero hero-slider">
			<div class="hero-slide">
				<img src="assets/images/banner2.png" alt="Education Department banner" class="hero-slide-image">
				<div class="hero-content container">
					<h1>Education Department</h1>
					<p>Strengthening curriculum quality, teaching standards, and student outcomes across every level.</p>
					<div class="hero-buttons">
						<a href="academics.php" class="btn primary">View Academics</a>
						<a href="contact.php" class="btn secondary">Contact Department</a>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 about-feature" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">Department Overview</span>
					<h2>What We Do</h2>
					<p>
						The Education Department oversees curriculum implementation, teacher development,
						assessment quality, and continuous improvement to ensure students achieve excellence.
					</p>
				</div>

				<div class="value-cards values-enhanced">
					<article class="card value-card-item fade-left">
						<div class="value-icon"><i class="bi bi-journal-check"></i></div>
						<h3>Curriculum Leadership</h3>
						<p>We align instruction with national standards and school values across all grade levels.</p>
					</article>
					<article class="card value-card-item fade-right">
						<div class="value-icon"><i class="bi bi-person-workspace"></i></div>
						<h3>Teacher Support</h3>
						<p>We equip teachers with planning tools, mentorship, and regular professional development.</p>
					</article>
					<article class="card value-card-item fade-left">
						<div class="value-icon"><i class="bi bi-graph-up-arrow"></i></div>
						<h3>Student Performance</h3>
						<p>We monitor learning outcomes and use data-driven interventions to improve results.</p>
					</article>
				</div>
			</div>
		</section>

		<section class="py-4 verification-section" data-animate>
			<div class="container">
				<div class="verification-cta d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3 text-start">
					<div class="verification-copy">
						<span class="verification-kicker">Get In Touch</span>
						<h4 class="mb-2 d-flex align-items-center gap-2">
							<i class="bi bi-telephone-fill" aria-hidden="true"></i>
							<span>Speak With The Education Team</span>
						</h4>
						<p class="mb-0">For curriculum, academic support, and departmental inquiries, contact our office.</p>
					</div>
					<a href="contact.php" class="btn btn-school btn-lg verification-btn">Contact Education Department</a>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
