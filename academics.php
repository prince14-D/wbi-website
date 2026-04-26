<?php
$pageTitle = 'Academics';
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
<body class="academics-page">
	<?php include __DIR__ . '/includes/header.php'; ?>

	<main class="w-100 m-0">
		<section class="hero p-0 m-0" data-animate>
			<div class="hero-slide">
				<img src="assets/images/banner2.png" alt="WBI academics banner" class="hero-slide-image">
				<div class="hero-content container">
					<h1>Academics at World Wide Missions School</h1>
					<p>Structured programs, clear standards, and Christ-centered learning from kindergarten to senior high.</p>
					<div class="hero-buttons">
						<a href="admissions.php" class="btn primary">Apply Now</a>
						<a href="assets/uploads/information-sheet.pdf" class="btn light" download>Download Information Sheet</a>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">Academics</span>
					<h1>Our Academic Programs</h1>
					<p>Structured learning pathways from kindergarten to senior high, designed for excellence and character.</p>
				</div>

				<div class="program-cards">
					<article class="card value-card-item fade-left">
						<h3>Kindergarten</h3>
						<p>Early literacy, numeracy, social skills, and faith-centered foundations.</p>
					</article>
					<article class="card value-card-item fade-right">
						<h3>Elementary</h3>
						<p>Core subject mastery through guided instruction and active learning.</p>
					</article>
					<article class="card value-card-item fade-left">
						<h3>Junior High</h3>
						<p>Academic preparation for BECE and growth in discipline and leadership.</p>
					</article>
					<article class="card value-card-item fade-right">
						<h3>Senior High</h3>
						<p>WASSCE readiness, career awareness, and practical life competence.</p>
					</article>
				</div>
			</div>
		</section>

		<section class="py-5 why-choose-section" data-animate>
			<div class="container">
				<div class="row g-4 align-items-center">
					<div class="col-lg-7 text-start fade-left">
						<span class="section-kicker">School Schedule</span>
						<h2 class="section-title">Academic Calendar</h2>
						<p class="mb-3">Access our academic calendar to view term dates, examinations, holidays, and important school activities.</p>
						<p class="mb-0">The latest calendar details are currently included in the school information sheet.</p>
					</div>
					<div class="col-lg-5 fade-right">
						<div class="verification-cta text-start">
							<span class="verification-kicker">PDF Download</span>
							<h4 class="mb-2 d-flex align-items-center gap-2">
								<i class="bi bi-calendar-event-fill" aria-hidden="true"></i>
								<span>Academic Calendar (PDF)</span>
							</h4>
							<p class="mb-3">Download the current sheet for term-by-term schedule and key dates.</p>
							<a href="assets/uploads/information-sheet.pdf" class="btn btn-school" download>
								<i class="bi bi-download me-1"></i> Download Calendar PDF
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 downloads-section" data-animate>
			<div class="container">
				<div class="downloads-wrap">
					<div class="text-center mb-4">
						<h2 class="section-title mb-2">Downloads</h2>
						<p class="text-muted mb-0">Get the latest brochure and information sheet for admissions and programs.</p>
					</div>
					<div class="row g-4 justify-content-center">
						<div class="col-md-6 col-lg-5">
							<div class="download-card fade-left">
								<div class="download-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
								<h5 class="mb-2">School Brochure</h5>
								<p class="mb-3">Overview of our programs, facilities, and student life at William Bean Institute.</p>
								<a href="assets/uploads/wbi-school-brochure.pdf" class="btn btn-school" download>
									<i class="bi bi-download me-1"></i> Download Brochure
								</a>
							</div>
						</div>
						<div class="col-md-6 col-lg-5">
							<div class="download-card fade-right">
								<div class="download-icon"><i class="bi bi-file-earmark-text-fill"></i></div>
								<h5 class="mb-2">Information Sheet</h5>
								<p class="mb-3">Quick facts on admissions, school calendar, contacts, and key requirements.</p>
								<a href="assets/uploads/information-sheet.pdf" class="btn btn-outline-secondary" download>
									<i class="bi bi-download me-1"></i> Download Info Sheet
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5 proprietor-section" data-animate>
			<div class="container">
				<div class="section-heading text-center">
					<span class="section-kicker">Requirements</span>
					<h2 class="section-title">Academic &amp; Admission Requirements</h2>
					<p>Requirements may vary slightly by grade level and transfer status.</p>
				</div>

				<div class="row g-4">
					<div class="col-lg-6">
						<div class="proprietor-wrap h-100 text-start">
							<h3 class="h4 mb-3">Academic Requirements</h3>
							<ul class="mb-0">
								<li>Completed previous grade level report card or transcript</li>
								<li>Entrance assessment for class placement (where applicable)</li>
								<li>Acceptable conduct and attendance record</li>
								<li>Readiness for continuous assessment and examinations</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="proprietor-wrap h-100 text-start">
							<h3 class="h4 mb-3">Admission Requirements</h3>
							<ul class="mb-0">
								<li>Completed application form from the Admissions Office</li>
								<li>Copy of birth certificate or valid identification</li>
								<li>Two recent passport-size photographs</li>
								<li>Parent or guardian interview and fee payment clearance</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="py-5" data-animate>
			<div class="container">
				<div class="section-heading text-center">
					<span class="section-kicker">Finance</span>
					<h2 class="section-title">Fee Structure</h2>
					<p>Indicative tuition guide for current academic session. Please contact the school for latest updates.</p>
				</div>

				<div class="table-responsive card text-start">
					<table class="table table-bordered align-middle mb-0">
						<thead class="table-light">
							<tr>
								<th>Level</th>
								<th>Registration Fee</th>
								<th>Tuition (Per Term)</th>
								<th>Other Charges</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Kindergarten</td>
								<td>USD 25</td>
								<td>USD 120</td>
								<td>Books, PTA, and activity fees</td>
							</tr>
							<tr>
								<td>Elementary</td>
								<td>USD 30</td>
								<td>USD 150</td>
								<td>Books, exams, and activity fees</td>
							</tr>
							<tr>
								<td>Junior High</td>
								<td>USD 35</td>
								<td>USD 180</td>
								<td>Lab, exams, and activity fees</td>
							</tr>
							<tr>
								<td>Senior High</td>
								<td>USD 40</td>
								<td>USD 220</td>
								<td>Lab, WAEC prep, and activity fees</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="text-center mt-4">
					<a href="admissions.php" class="btn btn-school">Start Admission Process</a>
					<a href="contact.php" class="btn btn-outline-secondary">Request Full Fee Breakdown</a>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
