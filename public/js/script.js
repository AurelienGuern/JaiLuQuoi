console.log("script OK");

document.addEventListener('DOMContentLoaded', function() {



const btnAddToLibrary = document.querySelector('.btnAddToLibrary');
btnAddToLibrary.addEventListener('mouseover', function() {
btnAddToLibrary.textContent = 'Ajouter à ma bibliothèque !'
});

btnAddToLibrary.addEventListener('mouseout', function() {
btnAddToLibrary.textContent = 'Déjà lu ?'

});

});
