// Fichier contenant les méthodes de gestion des données du localStorage

// Récupération des données du localStorage ou initialisation avec un tableau vide
function getData(key) {
      return JSON.parse(localStorage.getItem(key)) ?? [];
}

// On enregistre dans le localStorage la clé et ses valeurs
function setData(key, data) {
      const convertData = JSON.stringify(data);
      localStorage.setItem(key, convertData);
}

// On vérifie si l'id existe déjà dans le localStorage
function checkId(idProduct, key) {
      const data = getData(key);
      let found = false;
      for (let i = 0; i < data.length; i++){
            if (idProduct === data[i].id){
                  found = true;
                  break;
            }
      }
      return found;
}

// On construit le produit que l'on va ajouter dans le localStorage
function addProduct(id, product_name, price, file) {
      return {
            id: id,
            product_name: product_name,
            price: price,
            file: file,
            qtt: 1 
      };
}

// Exports des méthodes
export { getData, setData, checkId, addProduct};