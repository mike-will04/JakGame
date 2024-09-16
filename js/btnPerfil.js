var btnPerfil = "fechado";

console.log(logado);

function perfil() {
    if (logado == true) {
        document.getElementById("btn1-1").style.display = "none";
        document.getElementById("btn1-2").style.display = "none";
        document.getElementById("btn2-1").style.display = "block";
        document.getElementById("btn2-2").style.display = "block";

        if (btnPerfil == "fechado") {
            document.getElementById("carde").style.display = "block";
            btnPerfil = "aberto";
        } else {
            document.getElementById("carde").style.display = "none";
            btnPerfil = "fechado";
        }
    } else {
        document.getElementById("btn1-1").style.display = "block";
        document.getElementById("btn1-2").style.display = "block";
        document.getElementById("btn2-1").style.display = "none";
        document.getElementById("btn2-2").style.display = "none";

        if (btnPerfil == "fechado") {
            document.getElementById("carde").style.display = "block";
            btnPerfil = "aberto";
        } else {
            document.getElementById("carde").style.display = "none";
            btnPerfil = "fechado";
        }
    }
}
