<?php
$pageTitle = 'Home';
require __DIR__ . '/includes/content_store.php';
$latestNews = wbi_get_news(2);
$latestActivities = wbi_get_activities(6);
$foundingYear = 1982;
$yearsInOperation = date('Y') - $foundingYear;
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

        	<section class="stats-section py-5 text-center text-light" data-animate>
			<div class="container">
				<h2 class="text-white">Our Impact</h2>
				<div class="row g-3 mt-3">
							<div class="col-md-3"><div class="stat-card"><h3 class="stat-number" data-target="<?php echo $foundingYear; ?>">0</h3><p>Founded</p></div></div>
							<div class="col-md-3"><div class="stat-card"><h3 class="stat-number" data-target="<?php echo $yearsInOperation; ?>" data-suffix="+">0+</h3><p>Years of Operation</p></div></div>
						<div class="col-md-3"><div class="stat-card"><h3 class="stat-number" data-target="98" data-suffix="%">0%</h3><p>Success Rate</p></div></div>
						<div class="col-md-3"><div class="stat-card"><h3 class="stat-number" data-target="3">0</h3><p>Academic Levels</p></div></div>
				</div>
			</div>
		</section>

        	<section class="py-5 proprietor-section" data-animate>
			<div class="container">
				<div class="proprietor-wrap">
					<div class="row g-4 align-items-center">
						<div class="col-lg-5 text-center text-lg-start fade-left">
							<div class="proprietor-photo-frame mx-auto mx-lg-0">
								<img src="assets/images/Principal.png" class="img-fluid proprietor-photo" alt="Principal portrait">
							</div>
						</div>
						<div class="col-lg-7 text-start fade-right">
							<span class="proprietor-kicker">Principal's Message</span>
							<h2 class="section-title mb-3">A Welcome From The Principal</h2>
								<p class="proprietor-text"><strong>Warm greetings from the family of World Wide Missions School, Duport Road.</strong></p>
								<p class="proprietor-text">At WBI, we believe every child is a gift from God with a purpose to fulfill. Our duty is simple: train them well for life and for eternity. Each day, our teachers step into the classroom not just to teach subjects, but to shape character, instill discipline, and build competence that will serve Liberia and beyond.</p>
								<p class="proprietor-text">We hold firm to three pillars: <strong>Christ, Character, and Excellence</strong>. Your child will be challenged academically to meet Ministry of Education standards and pass WASSCE with integrity. They will also be mentored to respect authority, serve others, and work with their hands. We maintain zero tolerance for exam malpractice, drug abuse, and indiscipline, because real education cannot grow where values are broken.</p>
								<p class="proprietor-text">To our parents: thank you for trusting us. You are partners, not spectators. To our students: come ready to learn, obey, and lead. The future of Liberia sits in these desks.</p>
								<p class="proprietor-text">WBI is more than a school; it is a mission field and a launchpad. Together, let us raise a generation that is skilled, godly, and fearless.</p>
							<div class="proprietor-signature mt-3">
								<h6 class="mb-0">Mr. Calvin Y. Goffah</h6>
								<small>Principal, World Wide Missions School</small>
							</div>
									<a href="principal.php" class="btn btn-school mt-4">Read More About the Principal</a>
						</div>
					</div>
				</div>
			</div>
		</section>


        <section class="values section-soft" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">WBI Identity</span>
					<h2>Our Core Values</h2>
					<p>
						At WBI, values are not only taught in class, they are lived daily through worship,
						learning, discipline, and community impact.
					</p>
				</div>

				<div class="value-cards values-enhanced">
					<article class="card value-card-item fade-left">
						<div class="value-icon"><i class="bi bi-cross"></i></div>
						<h3>Christ</h3>
						<p>Faith guides our decisions, relationships, and school culture every day.</p>
					</article>
					<article class="card value-card-item fade-right">
						<div class="value-icon"><i class="bi bi-shield-check"></i></div>
						<h3>Character</h3>
						<p>We shape disciplined, respectful, and responsible young leaders.</p>
					</article>
					<article class="card value-card-item fade-left">
						<div class="value-icon"><i class="bi bi-award"></i></div>
						<h3>Excellence</h3>
						<p>We pursue high standards in academics, conduct, and performance.</p>
					</article>
					<article class="card value-card-item fade-right">
						<div class="value-icon"><i class="bi bi-people"></i></div>
						<h3>Service</h3>
						<p>We empower students to serve family, church, nation, and humanity.</p>
					</article>
				</div>
			</div>
		</section>


		<section class="py-5 why-choose-section" data-animate>
			<div class="container">
				<div class="row g-4 align-items-center">

					<div class="col-lg-6 fade-left">
						<div class="video-panel">
							<div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
								<iframe src="https://www.youtube.com/embed/SNQtms7IoTE"
									title="William Bean Institute"
									allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
									allowfullscreen></iframe>
							</div>
							<p class="video-note mb-0">Take a quick look at school life and learning at WBI.</p>
						</div>
					</div>

					<div class="col-lg-6 fade-right">
						<span class="section-kicker">Why Parents Choose WBI</span>
						<h2 class="section-title mb-1">Why Choose WBI?</h2>
						<p class="text-muted mb-4">We do not just teach, we shape futures.</p>

						<div class="why-list">
							<div class="why-list-item">
								<div class="why-list-icon"><i class="bi bi-patch-check-fill"></i></div>
								<div>
									<h6 class="mb-1">Quality Academic Programs</h6>
									<p class="mb-0 text-muted">A structured curriculum from kindergarten through senior high school.</p>
								</div>
							</div>
							<div class="why-list-item">
								<div class="why-list-icon"><i class="bi bi-people-fill"></i></div>
								<div>
									<h6 class="mb-1">Experienced and Caring Staff</h6>
									<p class="mb-0 text-muted">Qualified teachers dedicated to each child's growth and wellbeing.</p>
								</div>
							</div>
							<div class="why-list-item">
								<div class="why-list-icon"><i class="bi bi-shield-fill-check"></i></div>
								<div>
									<h6 class="mb-1">Safe and Nurturing Environment</h6>
									<p class="mb-0 text-muted">A secure space where students feel valued, confident, and motivated.</p>
								</div>
							</div>
							<div class="why-list-item">
								<div class="why-list-icon"><i class="bi bi-heart-fill"></i></div>
								<div>
									<h6 class="mb-1">Values-Based Education</h6>
									<p class="mb-0 text-muted">Christ, Character, and Excellence are woven into every lesson.</p>
								</div>
							</div>
						</div>

						<a href="about.php" class="btn btn-school mt-4">Discover More About Us</a>
					</div>

				</div>
			</div>
		</section>

	

	

		<section class="py-5 administration-section" data-animate>
			<div class="container">
				<h2 class="section-title text-center mb-2">Meet Our Administration</h2>
				<p class="text-center text-muted mb-5">The dedicated leaders who guide our school every day.</p>
				<div class="row g-4 justify-content-center">

					<div class="col-6 col-md-4 col-lg-3">
						<div class="admin-card text-center fade-left">
							<div class="admin-photo-wrap">
								<img src="assets/images/Princapal.jpeg" class="team-photo" alt="Principal">
							</div>
							<h6 class="mt-3 mb-1">Mr. Arthur Z Kpogbah </h6>
							<span class="admin-role">Principal</span>
						</div>
					</div>

					<div class="col-6 col-md-4 col-lg-3">
						<div class="admin-card text-center fade-right">
							<div class="admin-photo-wrap">
								<img src="assets/images/SA.png" class="team-photo" alt="Vice Principal">
							</div>
							<h6 class="mt-3 mb-1">Mr. G. Alphanso Menyon</h6>
							<span class="admin-role">Chief Learning Officer</span>
						</div>
					</div>

					<div class="col-6 col-md-4 col-lg-3">
						<div class="admin-card text-center fade-left">
							<div class="admin-photo-wrap">
								<img src="assets/images/Dean.jpeg" class="team-photo" alt="Academic Dean">
							</div>
							<h6 class="mt-3 mb-1">Ms. Joevina C. Grant</h6>
							<span class="admin-role">Academic Dean</span>
						</div>
					</div>

					<div class="col-6 col-md-4 col-lg-3">
						<div class="admin-card text-center fade-right">
							<div class="admin-photo-wrap">
								<img src="assets/images/Mr. James M. Folley .jpeg" class="team-photo" alt="Bursar">
							</div>
							<h6 class="mt-3 mb-1">Mr. James M. Folley</h6>
							<span class="admin-role">Vice Principal For Instructions</span>
						</div>
					</div>

				</div>
				<div class="text-center mt-4">
					<a href="about.php#administration" class="btn btn-outline-secondary">View Full Team</a>
				</div>
			</div>
		</section>

		<section class="py-5 downloads-section" data-animate>
			<div class="container">
				<div class="downloads-wrap">
					<div class="text-center mb-4">
						<h2 class="section-title mb-2">Download School Documents</h2>
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
					<p class="text-center text-muted small mt-4 mb-0">Need help? Call us at (+231) 886-126-154 for assistance.</p>
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

		<section class="py-5 values section-soft" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">Partnership Network</span>
					<h2>Partner Schools</h2>
					<p>WBI collaborates with trusted schools and institutions to strengthen academic pathways, student exchange, and shared learning opportunities.</p>
				</div>

				<div class="value-cards values-enhanced">
					<article class="card value-card-item partner-card fade-left text-center">
						<div class="partner-logo-badge">
							<img src="https://logo.clearbit.com/hopeacademy.edu" alt="Hope Academy logo" class="partner-school-logo" loading="lazy" onerror="this.src='assets/images/logo.png'">
						</div>
						<h3>Hope Academy</h3>
						<p>Collaborating on foundational literacy and lower school teaching excellence.</p>
						<a href="https://www.hopeacademy.edu" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm">Visit Website</a>
					</article>
					<article class="card value-card-item partner-card fade-right text-center">
						<div class="partner-logo-badge">
							<img src="https://logo.clearbit.com/graceinternationalschool.org" alt="Grace International School logo" class="partner-school-logo" loading="lazy" onerror="this.src='assets/images/logo.png'">
						</div>
						<h3>Grace International School</h3>
						<p>Joint student development activities, leadership forums, and mentoring programs.</p>
						<a href="https://www.graceinternationalschool.org" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm">Visit Website</a>
					</article>
					<article class="card value-card-item partner-card fade-left text-center">
						<div class="partner-logo-badge">
							<img src="https://logo.clearbit.com/libertyhighinstitute.edu" alt="Liberty High Institute logo" class="partner-school-logo" loading="lazy" onerror="this.src='assets/images/logo.png'">
						</div>
						<h3>Liberty High Institute</h3>
						<p>Academic coordination for exam preparation and high school transition support.</p>
						<a href="https://www.libertyhighinstitute.edu" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm">Visit Website</a>
					</article>
					<article class="card value-card-item partner-card fade-right text-center">
						<div class="partner-logo-badge">
							<img src="https://logo.clearbit.com/kingdomchristianschool.edu" alt="Kingdom Christian School logo" class="partner-school-logo" loading="lazy" onerror="this.src='assets/images/logo.png'">
						</div>
						<h3>Kingdom Christian School</h3>
						<p>Faith-based partnership for character formation and values-driven education.</p>
						<a href="https://www.kingdomchristianschool.edu" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm">Visit Website</a>
					</article>
				</div>

				<div class="text-center mt-4">
					<a href="contact.php" class="btn btn-school">Become a Partner School</a>
				</div>
			</div>
		</section>

        	<section class="py-5 parent-testimonials" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">Parents Speak</span>
					<h2>Parent Testimonials</h2>
					<p>What families are saying about their experience at William Bean Institute.</p>
				</div>

				<div id="parentTestimonials" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
					<div class="carousel-indicators testimonials-indicators">
						<button type="button" data-bs-target="#parentTestimonials" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Testimonial 1"></button>
						<button type="button" data-bs-target="#parentTestimonials" data-bs-slide-to="1" aria-label="Testimonial 2"></button>
						<button type="button" data-bs-target="#parentTestimonials" data-bs-slide-to="2" aria-label="Testimonial 3"></button>
					</div>

					<div class="carousel-inner">
						<div class="carousel-item active">
							<article class="testimonial-card mx-auto">
								<img src="assets/images/logo.png" alt="Parent testimonial photo" class="testimonial-photo">
								<p class="testimonial-quote">"WBI has transformed my child's confidence, discipline, and academic performance. The teachers genuinely care, and we feel supported as parents every step of the way."</p>
								<h5 class="mb-0">Mrs. Martha Kollie</h5>
								<small>Parent - Junior High Student</small>
							</article>
						</div>
						<div class="carousel-item">
							<article class="testimonial-card mx-auto">
								<img src="assets/images/logo.png" alt="Parent testimonial photo" class="testimonial-photo">
								<p class="testimonial-quote">"The learning environment is safe, faith-based, and focused on excellence. My daughter has improved in both character and classwork since joining WBI."</p>
								<h5 class="mb-0">Mr. Emmanuel Doe</h5>
								<small>Parent - Elementary Student</small>
							</article>
						</div>
						<div class="carousel-item">
							<article class="testimonial-card mx-auto">
								<img src="assets/images/logo.png" alt="Parent testimonial photo" class="testimonial-photo">
								<p class="testimonial-quote">"From communication to academics, WBI continues to exceed our expectations. We are proud to be part of a school that builds both mind and heart."</p>
								<h5 class="mb-0">Mrs. Sarah Nyemah</h5>
								<small>Parent - Senior High Student</small>
							</article>
						</div>
					</div>

					<button class="carousel-control-prev" type="button" data-bs-target="#parentTestimonials" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#parentTestimonials" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</div>
		</section>

		<section class="students-activities py-5" data-animate>
			<div class="container">
				<div class="section-heading">
					<span class="section-kicker">Campus Life</span>
					<h2>Student Activities</h2>
					<p>Moments from clubs, sports, chapel programs, field learning, and school-wide events.</p>
				</div>

				<div class="activity-grid">
					<?php foreach ($latestActivities as $activity): ?>
						<article class="activity-card fade-left">
							<?php if (!empty($activity['image_path'])): ?>
								<img src="<?php echo htmlspecialchars($activity['image_path']); ?>" alt="<?php echo htmlspecialchars($activity['title']); ?>" class="activity-photo">
							<?php else: ?>
								<div class="activity-photo activity-photo-placeholder d-flex align-items-center justify-content-center">
									<i class="bi bi-camera-fill" aria-hidden="true"></i>
								</div>
							<?php endif; ?>
							<div class="activity-content">
								<h3><?php echo htmlspecialchars($activity['title']); ?></h3>
								<p><?php echo htmlspecialchars($activity['summary']); ?></p>
							</div>
						</article>
					<?php endforeach; ?>

					<?php if (empty($latestActivities)): ?>
						<article class="activity-card text-start">
							<div class="activity-photo activity-photo-placeholder d-flex align-items-center justify-content-center">
								<i class="bi bi-camera-fill" aria-hidden="true"></i>
							</div>
							<div class="activity-content">
								<h3>No Student Activities Yet</h3>
								<p>Activity photos posted from the admin dashboard will appear here.</p>
							</div>
						</article>
					<?php endif; ?>
				</div>
			</div>
		</section>



		<section class="cta">
			<div class="container">
				<h2>Enroll Your Child Today</h2>
				<p>Join a school that builds both the mind and the heart.</p>
				<a href="admissions.php" class="btn light">Start Admission</a>
			</div>
		</section>

		<section class="news" data-animate>
			<div class="container">
				<h2>Latest News</h2>
				<div class="news-cards">
					<?php foreach ($latestNews as $item): ?>
						<article class="card text-start">
							<?php if (!empty($item['image_path'])): ?>
								<img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="img-fluid rounded mb-3" style="width: 100%; max-height: 220px; object-fit: cover;">
							<?php endif; ?>
							<h3><?php echo htmlspecialchars($item['title']); ?></h3>
							<p><strong><?php echo htmlspecialchars($item['summary']); ?></strong></p>
							<p class="mb-2"><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
							<small class="text-muted">Posted: <?php echo date('M d, Y', strtotime($item['created_at'])); ?></small>
						</article>
					<?php endforeach; ?>
					<?php if (empty($latestNews)): ?>
						<article class="card">
							<h3>No News Yet</h3>
							<p>Updates from the school administration will appear here.</p>
						</article>
					<?php endif; ?>
				</div>
				<div class="text-center mt-4">
					<a href="news.php" class="btn secondary">View All News</a>
				</div>
			</div>
		</section>

		<section class="py-4 verification-section" data-animate>
			<div class="container">
				<div class="verification-cta d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3 gap-lg-4 text-start text-lg-start">
					<div class="verification-copy">
						<span class="verification-kicker">Digital Records</span>
						<h4 class="mb-2 d-flex align-items-center gap-2">
							<i class="bi bi-patch-check-fill" aria-hidden="true"></i>
							<span>Student Verification System</span>
						</h4>
						<p class="mb-0">Parents and other school partners can verify official records using a unique school UID.</p>
					</div>
					<a href="verification.php" class="btn btn-school btn-lg verification-btn">Verify Student Information</a>
				</div>
			</div>
		</section>
	</main>

	<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
