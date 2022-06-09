// import dept => les callBacks par exemple ;-)
import * as callBack from './ajaxCallBacks.js'

// Ecoute global (au chargement)
$(function () {
  // search keyword
  $('#search').on('keyup', function (event) {
    const word = $(event.currentTarget[1]).val()
    // Test if search or not
    if (word.length > 1) {
      callBack.search(word)
    } else $('.result-search').empty()
  })

  // Control all form (insert, auth, delete) on submit event
  $('#insert, #auth, #delete').on('submit', function (event) {

    // Block form auto refresh
    event.preventDefault()

    // Check le form concerné (get action)
    /*
      Ici je récupère dans l'event principal
        la cible courante : currentTarget
          Le 1er élément html à l'intérieur (input=>hidden)
        et en particulier sa valeur
    */
    const action = $(event.currentTarget[0]).val()

    // Stockage des données du form pour préparer l'envoi
    const form = new FormData($(`#${action}`).get(0))

    // Ko Objet jQuery
    // console.log($(this));
    // OK Html entities
    /* console.log($(`#${action}`).get(0));
    console.log(this); */

    // Get action to define which request to execute
    // Transmission des données avant la requête
    switch (action) {
      case 'insert':
        callBack.insert(form)
        break;

      case 'auth':
        callBack.auth(form)
        break;

      case 'delete':
        callBack.remove(form)
        break;

      default:
        break;
    }


  })

  // Event logout
  $('#logout').on('click', callBack.logout)

})
