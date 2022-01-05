console.log("JS marche");

/*Gestion du formulaire de connexion*/
var formulaireConnexion = document.getElementById("formulaireConnexion");
var btnOuvertureFormConnexion = document.getElementById("ouvertureFenetreConnexion");

btnOuvertureFormConnexion.addEventListener("click", afficherFormConnexion);


function afficherFormConnexion() {
    formulaireConnexion.classList.remove("elementCache");
};

var btnConnexion = document.getElementById("btnConnexion");
btnConnexion.addEventListener("click", securiserLaSaisie);
//TODO
function securiserLaSaisie() {
        document.forms["formConnexion"].submit();    
};