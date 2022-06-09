const PATH = 'src/services/ajax.php'

/**
 * Refresh user delete list
 */
function refresh() {
  // Vider ancienne liste
  $('#delUserList').empty()
  const $userListToDel = $('#delUserList')

  // Get all user
  fetch(PATH + '?action=findAll')
    .then(response => response.json())
    .then(users => {

      // Display in a '#delUserList' each input with checkbox
      if (users.length > 0) {
        // Création de la liste d'input à supprimer
        users.map(user => {
          const $div = $('<div>').addClass('checkbox').append($('<input>').attr('type', 'checkbox').attr('name', 'users[]').val(user.id))
          $div.append($('<label>').text(user.name))
          $userListToDel.append($div)
        })
        $userListToDel.fadeIn(800)
      } else $userListToDel.append($('<div>').text('Aucun user to delete'))
    })
}

/**
 * Return results for search users
 * @param {String} word
 */
function search(word) {
  // On vide l'ancienne recherche
  $('.result-search').empty()
  $('.error-search').empty()
  const $ul = $('<ul>')
  // On parcours le tableau de résultats customers récupéré
  fetch(PATH + '?action=search&word=' + word)
    .then(response => response.json())
    .then(users => {
      users.map(user => {
        const $li = $('<li>').text(user.name)
        $ul.append($li)
      })
      $('.result-search').append($ul).fadeIn(400)

      // Message pas de résult
      if (users.length === 0) $('.error-search').text('Aucun résultats trouvé')
    })
}

/**
 * Insert user
 * @param {FormData} form
 */
function insert(form) {
  // Request Ajax POST
  fetch(
    PATH,
    {
      method: 'post',
      body: form
    }
  )
    .then(response => response.text())
    .then(msg => {
      const $resultInsert = $('.result-insert')
      // Display notifications if success or error
      /*
        Dans les 2 cas :
          -> On supprime les class d'avant
          -> on ajoute les bonnes en fonctions du cas
          -> On définit un temps d'affichage (pour que la notif disparaisse)
          -> On insert le message
          -> On cache la notif
      */
      if (msg.length === 0) {
        $resultInsert.removeClass('alert alert-danger alert-success')
          .addClass('alert alert-success')
          .show(800).delay(2000)
          .text('Contact enregistré avec succes')
          .hide(400)

        // Action qui découle de l'ajout d'un nouveau contact ???

      } else {
        $resultInsert.removeClass('alert alert-danger alert-success')
          .addClass('alert alert-danger')
          .show(800).delay(2000)
          .text(msg)
          .hide(400)
      }

      // Clean form
      $('#insert')[0].reset() // Simule le click sur un button de type reset
    })
}

function remove(form) {
  // Refresh Displaying List users
  // Request Ajax POST
  fetch(
    PATH,
    {
      method: 'post',
      body: form
    }
  )
    .then(response => response.text())
    .then(msg => {
      const $resultDelete = $('.result-delete')
      // Display notifications if success or error
      if (msg.length === 0) {
        $resultDelete.removeClass('alert alert-danger alert-success')
          .addClass('alert alert-success')
          .show(800).delay(2000)
          .text('Contacts supprimé avec succès')
          .hide(400)

        // Action qui découle de l'ajout d'un nouveau contact ???

      } else {
        $resultDelete.removeClass('alert alert-danger alert-success')
          .addClass('alert alert-danger')
          .show(800).delay(2000)
          .text(msg)
          .hide(400)
      }

      // Refresh list
      refresh()
    })
}

function auth(form) {
  // Display notifications if success or error
  // Request Ajax POST
  fetch(
    PATH,
    {
      method: 'post',
      body: form
    }
  )
    .then(response => response.text())
    .then(data => {
      // Cibler la zone d'affichage
      const $resultAuth = $('.result-auth')
      const test = data.includes('user')

      // Display notifications if success or error
      if (test) {
        // On récupère l'object, sur la clé 'user'
        const user = JSON.parse(data).user
        $resultAuth.removeClass('alert alert-danger alert-success')
          .addClass('alert alert-success')
          .show(800)
          .text(`Hello ${user.name} you are connected`)

        // Action qui découle de la connexion d'un contact
        // Switch form + btn logout
        $('#creation').fadeOut(400)
        $('#auth').fadeOut(400)
        $('#logout').fadeIn(800)

        // Display delete User form
        refresh()

      } else {
        $resultAuth.removeClass('alert alert-danger alert-success')
          .addClass('alert alert-danger')
          .show(800).delay(2000)
          .text(data)
          .hide(400)
      }

      // Clean form
      $('#auth')[0].reset() // Simule le click sur un button de type reset
    })
}

function logout() {
  // Display notifications if success or error
  $('.result-auth').removeClass('alert alert-danger alert-success')
    .addClass('alert alert-success')
    .show(800).delay(1500)
    .text(`You are disconnected`)
    .hide(400)

  // Display or hide elements
  $('#delUserList').empty().fadeOut(400)
  $('#logout').fadeOut(800)
  $('#creation').fadeIn(400)
  $('#auth').fadeIn(400)
}

// Exports functions ;-)
export {
  insert,
  auth,
  remove,
  logout,
  search
}