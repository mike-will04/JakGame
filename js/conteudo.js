function pessoal() {
    document.getElementById("pessoal").style.display = "block";
    document.getElementById("coment").style.display = "none";
    document.getElementById("favorit").style.display = "none";

    document.getElementById("corpessoal").style.color = "black";
    document.getElementById("corcoment").style.color = "white";
    document.getElementById("corfavorit").style.color = "white";
}

function coment() {
    document.getElementById("pessoal").style.display = "none";
    document.getElementById("coment").style.display = "block";
    document.getElementById("favorit").style.display = "none";

    document.getElementById("corpessoal").style.color = "white";
    document.getElementById("corcoment").style.color = "#1f2030";
    document.getElementById("corfavorit").style.color = "white";
}

function favorit() {
    document.getElementById("pessoal").style.display = "none";
    document.getElementById("coment").style.display = "none";
    document.getElementById("favorit").style.display = "block";

    document.getElementById("corpessoal").style.color = "white";
    document.getElementById("corcoment").style.color = "white";
    document.getElementById("corfavorit").style.color = "#1f2030";
}
