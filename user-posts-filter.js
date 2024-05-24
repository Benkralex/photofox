document.getElementById("showImages").addEventListener("click", function () {
  toggleVisibility("image");
});

document.getElementById("showVideos").addEventListener("click", function () {
  toggleVisibility("video");
});

document.getElementById("showAll").addEventListener("click", function () {
  showAll();
});

function toggleVisibility(className) {
  var containers = document.querySelectorAll(".content-box");
  containers.forEach(function (container) {
    if (container.classList.contains(className)) {
      container.style.display = "block";
    } else {
      container.style.display = "none";
    }
  });
}

function showAll() {
  var containers = document.querySelectorAll(".content-box");
  containers.forEach(function (container) {
    container.style.display = "block";
  });
}
