document.addEventListener("DOMContentLoaded", function () {
  var header = document.querySelector(".site-header");
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

  updateHeaderState();
  window.addEventListener("scroll", updateHeaderState, { passive: true });

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
  if (animatedSections.length > 0 && "IntersectionObserver" in window) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
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
    });
  }
});
