document.addEventListener("DOMContentLoaded", function () {
  var header = document.querySelector(".site-header");
  var backToTopBtn = document.getElementById("backToTopBtn");

  function updateHeaderState() {
    if (!header) {
      return;
    }

    if (window.scrollY > 8) {
      header.classList.add("is-scrolled");
    } else {
      header.classList.remove("is-scrolled");
    }
  }

  function updateBackToTopState() {
    if (!backToTopBtn) {
      return;
    }

    if (window.scrollY > 280) {
      backToTopBtn.classList.add("is-visible");
    } else {
      backToTopBtn.classList.remove("is-visible");
    }
  }

  updateHeaderState();
  updateBackToTopState();
  window.addEventListener("scroll", updateHeaderState, { passive: true });
  window.addEventListener("scroll", updateBackToTopState, { passive: true });

  if (backToTopBtn) {
    backToTopBtn.addEventListener("click", function () {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }


  var splash = document.getElementById("splash-screen");
  if (splash) {
    window.setTimeout(function () {
      splash.classList.add("hidden");
      window.setTimeout(function () {
        splash.remove();
      }, 600);
    }, 1200);
  }

  var deferredPrompt = null;
  var installBtn = document.getElementById("installBtn");

  window.addEventListener("beforeinstallprompt", function (event) {
    event.preventDefault();
    deferredPrompt = event;

    if (installBtn) {
      installBtn.style.display = "inline-block";
    }
  });

  if (installBtn) {
    installBtn.addEventListener("click", async function () {
      if (!deferredPrompt) {
        return;
      }

      deferredPrompt.prompt();
      await deferredPrompt.userChoice;
      deferredPrompt = null;
      installBtn.style.display = "none";
    });
  }

  var countdown = document.getElementById("countdown");
  if (countdown) {
    var deadlineAttr = countdown.getAttribute("data-deadline");
    var deadline = deadlineAttr ? new Date(deadlineAttr).getTime() : NaN;
    var daysEl = document.getElementById("days");
    var hoursEl = document.getElementById("hours");
    var minutesEl = document.getElementById("minutes");
    var secondsEl = document.getElementById("seconds");

    function pad(value) {
      return String(value).padStart(2, "0");
    }

    function updateCountdown() {
      if (Number.isNaN(deadline)) {
        return;
      }

      var now = Date.now();
      var distance = deadline - now;

      if (distance <= 0) {
        countdown.innerHTML = '<div class="countdown-ended">Admissions Closing Date Reached</div>';
        return;
      }

      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      daysEl.textContent = pad(days);
      hoursEl.textContent = pad(hours);
      minutesEl.textContent = pad(minutes);
      secondsEl.textContent = pad(seconds);
    }

    updateCountdown();
    var countdownTimer = window.setInterval(function () {
      updateCountdown();
      if (countdown.querySelector(".countdown-ended")) {
        window.clearInterval(countdownTimer);
      }
    }, 1000);
  }

  var animatedSections = document.querySelectorAll("[data-animate]");

  function animateStatNumbers(section) {
    if (!section || section.dataset.statsAnimated === "true") {
      return;
    }

    var statNumbers = section.querySelectorAll(".stat-number");
    if (statNumbers.length === 0) {
      return;
    }

    section.dataset.statsAnimated = "true";

    statNumbers.forEach(function (el) {
      var target = parseInt(el.getAttribute("data-target") || "0", 10);
      var suffix = el.getAttribute("data-suffix") || "";
      var duration = 1200;
      var startTime = null;

      function updateFrame(timestamp) {
        if (!startTime) {
          startTime = timestamp;
        }

        var progress = Math.min((timestamp - startTime) / duration, 1);
        var value = Math.floor(progress * target);
        el.textContent = String(value) + suffix;

        if (progress < 1) {
          window.requestAnimationFrame(updateFrame);
        } else {
          el.textContent = String(target) + suffix;
        }
      }

      window.requestAnimationFrame(updateFrame);
    });
  }

  if (animatedSections.length > 0 && "IntersectionObserver" in window) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            if (entry.target.classList.contains("stats-section")) {
              animateStatNumbers(entry.target);
            }
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );

    animatedSections.forEach(function (section) {
      observer.observe(section);
    });
  } else {
    animatedSections.forEach(function (section) {
      section.classList.add("is-visible");
      if (section.classList.contains("stats-section")) {
        animateStatNumbers(section);
      }
    });
  }
});
