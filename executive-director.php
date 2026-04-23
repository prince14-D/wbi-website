<?php
$pageTitle = 'Education Director';
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
		<section class="hero p-0 m-0" data-animate>
			<div class="hero-slide">
				<img src="assets/images/banner.png" alt="Education department banner" class="hero-slide-image">
				<div class="hero-content container">
					<h1>Education Director</h1>
					<p>Guiding teaching and learning with standards, values, and results at World Wide Missions School.</p>
					<div class="hero-buttons">
						<a href="admissions.php" class="btn primary">Apply Now</a>
						<a href="about.php" class="btn light">About WBI</a>
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
								<img src="assets/images/Principal.png" class="img-fluid proprietor-photo" alt="Education Director portrait">
							</div>
						</div>
						<div class="col-lg-8 text-start fade-right">
							<span class="proprietor-kicker">Education Department</span>
							<h2 class="section-title mb-3">Mr. G. Alphonso Menyon</h2>
							<p class="proprietor-text"><strong>Greetings to our parents, students, staff, and partners.</strong></p>
							<p class="proprietor-text">At World Wide Missions School System, the Education Department exists for one reason: to ensure quality teaching and learning happen every single day. Our mandate is clear: align every lesson, test, and activity with Ministry of Education standards while holding fast to our Christ-centered mission.</p>
							<p class="proprietor-text">This year, our focus is <strong>Standards + Values = Results</strong>. We are strengthening teacher training, monitoring lesson delivery, and upgrading our labs and learning materials so students master English, Mathematics, Science, Social Studies, and practical skills.</p>
							<p class="proprietor-text">We prepare students not just to pass WASSCE, but to think, solve problems, and lead with integrity.</p>
							<p class="proprietor-text">To teachers: professionalism is non-negotiable. Follow the Code of Conduct, dress modestly, plan your lessons, and assess fairly. To students: your effort plus our guidance equals success. To parents: join us, check homework, attend PTA, and hold us accountable.</p>
							<p class="proprietor-text">Together, we will keep WBI a model of discipline and excellence on Duport Road.</p>
							<div class="proprietor-signature mt-3">
								<h6 class="mb-0">Education Director, World Wide Missions School</h6>
								<small>Duport Road, Paynesville City</small>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 values section-soft" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">Academic Focus</span>
					<h2>Certificate Programs</h2>
					<p>Practical learning pathways that build employable skills alongside strong academic grounding.</p>
				</div>

				<div class="value-cards values-enhanced">
					<article class="card value-card-item text-start">
						<div class="value-icon"><i class="bi bi-cpu"></i></div>
						<h3>Biomedical Technology</h3>
						<p>Students gain foundational exposure to applied science and health support systems.</p>
					</article>
					<article class="card value-card-item text-start">
						<div class="value-icon"><i class="bi bi-lightning-charge"></i></div>
						<h3>Electrical Technology</h3>
						<p>Hands-on electrical concepts, safety, and basic installation skills for future careers.</p>
					</article>
					<article class="card value-card-item text-start">
						<div class="value-icon"><i class="bi bi-droplet-half"></i></div>
						<h3>Plumbing</h3>
						<p>Practical plumbing awareness that supports technical competence and problem solving.</p>
					</article>
					<article class="card value-card-item text-start">
						<div class="value-icon"><i class="bi bi-broadcast-pin"></i></div>
						<h3>Applied Electronics Technology</h3>
						<p>Technical instruction focused on circuits, devices, and modern electronic systems.</p>
					</article>
					<article class="card value-card-item text-start">
						<div class="value-icon"><i class="bi bi-wrench-adjustable"></i></div>
						<h3>Automotive Repair</h3>
						<p>Basic vehicle maintenance and repair skills that prepare learners for the workplace.</p>
					</article>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
