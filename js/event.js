// Fichier de gestion des évènements

// Imports
import { setStorage, clearStorage, removeItemFromStorage } from "./storage.js";

// Variables des bouttons ajouter/vider/retirer du localStorage
let addButton = document.querySelectorAll('.addfavorite');
let clearButton = document.querySelectorAll('.empty-favorite');
let removeButton = document.querySelectorAll('.remove-favorite');

// Fonction de l'event du boutton 'Ajouter aux favoris' des annonces de la page d'accueil
function addButtonEvent() {
      addButton.forEach(product => product.addEventListener('click', setStorage));
}
addButtonEvent();

// Fonction de l'event du boutton 'Vider toute la liste' des annonces de la page des favoris
function clearButtonEvent() {
      clearButton.forEach(product => product.addEventListener('click', clearStorage));
}
clearButtonEvent();

// Fonction de l'event du boutton 'Retirer de la liste' des annonces de la page des favoris
function removeButtonEvent() {
      removeButton.forEach(product => product.addEventListener('click', removeItemFromStorage));
}
removeButtonEvent();