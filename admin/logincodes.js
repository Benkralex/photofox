document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("dataTable")
    .addEventListener("click", function (event) {
      var target = event.target;
      if (target.tagName === "TD" && target.classList.contains("active")) {
        var code = target.parentNode.querySelector(".code").textContent;
        updateActiveStatus(code, target);
      }
    });

  // Funktion zum Senden der AJAX-Anfrage und Aktualisieren der Tabelle
  function updateActiveStatus(code, target) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "toggleActive-Code.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
      if (xhr.status === 200) {
        var response = xhr.responseText.trim();
        if (response === "TRUE" || response === "FALSE") {
          // Wenn die Antwort erfolgreich ist, aktualisieren Sie den Wert in der Tabelle
          target.textContent = response;
        } else {
          console.error("Fehler beim Aktualisieren des Aktivstatus");
        }
      } else {
        console.error("Fehler beim Senden der AJAX-Anfrage");
      }
    };
    xhr.send("code=" + encodeURIComponent(code));
  }
});
