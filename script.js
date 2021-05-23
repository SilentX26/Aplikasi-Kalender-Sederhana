var filter = 0;

function __loader(action)
{
    var element = document.getElementsByClassName("preloader")[0];

    if(action == "show") {
        element.style.display = "block";
        element.classList.add("show");
    } else {
        element.style.display = "none";
        element.classList.remove("show");
    }
}

function init()
{
    __loader("show");

    var element = document.getElementById("content");
    var xhr = new XMLHttpRequest();

    xhr.open("GET", `render.php?filter=${filter}`);
    xhr.send();

    xhr.addEventListener("load", function(event) {
        __loader("hide");
        element.innerHTML = event.srcElement.response;

        document.getElementById("btn-prev-month")
            .addEventListener("click", function() {
                filter -= 1;
                init();
            }
        );

        document.getElementById("btn-next-month")
            .addEventListener("click", function() {
                filter += 1;
                init();
            }
        );
    });
}

function theme(theme = null)
{
    var is_dark = (localStorage.getItem("theme") === "dark" && theme === null) || theme === "dark";
    if(theme !== null)
        localStorage.setItem("theme", theme);

    if(is_dark === true) {
        document.getElementsByTagName("body")[0].className = "bg-dark";
        document.querySelector("footer div a i").className = "fas fa-sun text-warning";
        document.querySelector("footer div a span").innerHTML = "Siang";
        document.querySelector("footer div a").setAttribute("href", "javascript:theme('sun');");

    } else {
        document.getElementsByTagName("body")[0].className = "bg-light";
        document.querySelector("footer div a i").className = "fas fa-moon text-dark";
        document.querySelector("footer div a span").innerHTML = "Malam";
        document.querySelector("footer div a").setAttribute("href", "javascript:theme('dark');");
    }
}