function nav(k) {
    k.classList.toggle("change");
    var x = document.getElementById("nav_main");
    if (x.style.display === "flex") {
        x.style.display = "none";
    } else {
        x.style.display = "flex";
    }
}