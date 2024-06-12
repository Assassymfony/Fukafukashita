// public/js/scripts.js

function openPopup() {
    document.getElementById("followPopup").style.display = "block";
}

function closePopup() {
    document.getElementById("followPopup").style.display = "none";
}

// Close the popup if the user clicks outside of it
window.onclick = function(event) {
    var popup = document.getElementById("followPopup");
    if (event.target == popup) {
        popup.style.display = "none";
    }
}
