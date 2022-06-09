// Affichage des données sur la page favoris

// Imports
import * as local from './localStorage.js';

// const $div = document.querySelectorAll('.favorite');
const favoriteList = local.getData('favorite');

// Recherche des produits des annonces dans les favoris et affichage sur la page des favoris
favoriteList.forEach(product => {
    document.querySelector('.favorite').insertAdjacentHTML('beforeend',
        `
        <div class="item">
            <article>
                <img src='${product.file}' alt="${product.product_name}"/>
                <hr>
                <h3>${product.product_name}</h3>
                <div>
                    <strong>${product.price} €</strong>
                </div>
                <div class="article-icons">
                    <div class="border-icons">
                        <a class="see" href="productPage.php?id=${product.id}"><i class="eye fas fa-eye fa-2x"></i></a>
                    </div>
                </div>
            </article>
        </div>
        `
    )
});

/* <button data-id ="${product.id}" class="removefavorite submit"><i class="trash fas fa-trash-alt fa-2x"></i></button> */