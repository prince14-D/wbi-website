<?php
$pageTitle = 'Staff';
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
				<img src="assets/images/banner2.png" alt="WBI staff banner" class="hero-slide-image">
				<div class="hero-content container">
					<h1>Our Staff</h1>
					<p>Meet the administration, teachers, and supporting staff who serve with discipline, care, and excellence.</p>
					<div class="hero-buttons">
						<a href="#administration" class="btn primary">Administration</a>
						<a href="#teachers" class="btn light">Teachers</a>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 administration-section" id="administration" data-animate>
			<div class="container">
				<div class="section-heading text-center">
					<span class="section-kicker">Leadership</span>
					<h2 class="section-title">Administration Section</h2>
					<p>School leadership that guides vision, discipline, academic planning, and daily operations.</p>
				</div>
				<div class="row g-4 justify-content-center">
					<div class="col-12 col-md-6 col-lg-3">
						<div class="admin-card text-center fade-left h-100">
							<div class="admin-photo-wrap">
								<img src="assets/images/Principal.png" class="team-photo" alt="Principal portrait">
							</div>
							<h6 class="mt-3 mb-1">Mr. Calvin Y. Goffah</h6>
							<span class="admin-role">Principal</span>
							<p class="mt-3 mb-0 text-muted small">Leads the school with a commitment to Christ, Character, and Excellence.</p>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-3">
						<div class="admin-card text-center fade-right h-100">
							<div class="admin-photo-wrap"><img src="assets/images/SA.png" class="team-photo" alt="Education Director portrait"></div>
							<h6 class="mt-3 mb-1">Mr. G. Alphonso Menyon</h6>
							<span class="admin-role">Education Director</span>
							<p class="mt-3 mb-0 text-muted small">Oversees teaching standards, supervision, and academic quality.</p>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-3">
						<div class="admin-card text-center fade-left h-100">
							<div class="admin-photo-wrap"><img src="assets/images/Dean.jpeg" class="team-photo" alt="Academic Dean portrait"></div>
							<h6 class="mt-3 mb-1">Ms. Joevina C. Grant</h6>
							<span class="admin-role">Academic Dean</span>
							<p class="mt-3 mb-0 text-muted small">Supports lesson delivery, assessments, and instructional improvement.</p>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-3">
						<div class="admin-card text-center fade-right h-100">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Vice Principal portrait"></div>
							<h6 class="mt-3 mb-1">Mr. James M. Folley</h6>
							<span class="admin-role">Vice Principal For Instructions</span>
							<p class="mt-3 mb-0 text-muted small">Ensures classroom discipline and academic coordination.</p>
						</div>
					</div>
				</div>
		</div>
		</section>

		<section class="py-5 section-soft" id="teachers" data-animate>
			<div class="container">
				<div class="section-heading text-center">
					<span class="section-kicker">Instruction</span>
					<h2 class="section-title">Teacher Section</h2>
					<p>Meet some of our classroom teachers and the subjects they handle.</p>
				</div>

				<div class="row g-4 justify-content-center">
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100 fade-left">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="English teacher"></div>
							<h6 class="mt-3 mb-1">Ms. Martha Kollie</h6>
							<span class="admin-role">English &amp; Literature</span>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100 fade-right">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Mathematics teacher"></div>
							<h6 class="mt-3 mb-1">Mr. Emmanuel Doe</h6>
							<span class="admin-role">Mathematics</span>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100 fade-left">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Science teacher"></div>
							<h6 class="mt-3 mb-1">Ms. Sarah Nyemah</h6>
							<span class="admin-role">Science</span>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100 fade-right">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Social studies teacher"></div>
							<h6 class="mt-3 mb-1">Mr. Samuel G. Cooper</h6>
							<span class="admin-role">Social Studies</span>
						</div>
					</div>
				</div>
		</div>
		</section>

		<section class="py-5" data-animate>
			<div class="container">
				<div class="section-heading text-center">
					<span class="section-kicker">Support Team</span>
					<h2 class="section-title">Supporting Staff</h2>
					<p>The people who keep the school running safely, cleanly, and efficiently every day.</p>
				</div>

				<div class="row g-4 justify-content-center">
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Office support"></div>
							<h6 class="mt-3 mb-1">Office Support</h6>
							<span class="admin-role">Records &amp; Communication</span>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Security team"></div>
							<h6 class="mt-3 mb-1">Security Team</h6>
							<span class="admin-role">Safety &amp; Protection</span>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Custodial team"></div>
							<h6 class="mt-3 mb-1">Custodial Team</h6>
							<span class="admin-role">Cleaning &amp; Maintenance</span>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="admin-card text-center h-100">
							<div class="admin-photo-wrap"><img src="assets/images/logo.png" class="team-photo" alt="Library and ICT support"></div>
							<h6 class="mt-3 mb-1">Library &amp; ICT Support</h6>
							<span class="admin-role">Learning Resources</span>
						</div>
					</div>
				</div>
		</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
