$(document).ready(function() {

  /*********** VARIABLE ***************/

  var $conteneurListeProduits = $('div#ajoutprod');
  var $conteneurTable = $('table#tabliste');
  //var $conteneur = $('div#appbundle_commande_produits');
  var $conteneur = $('table#appbundle_commande_produits');

  var $ajoutLien = $('<a href="#" id="add_produits" class="btn btn-primary">Ajouter le produit</a>');
  var index = 0;

  /*******************************************/


  /************ EVENEMENTS ***********/

  //ajout d'un nouveau champ à chaque clic
  $ajoutLien.on( "click", function(e) {
    ajoutProduit($conteneur);
    e.preventDefault();
    return false;
  });

  /*******************************************/


  /************** CODE *******************/

  $conteneurListeProduits.append($ajoutLien);

  // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
  $conteneurTable.children('tr').each( function() {
    ajoutSuppressionLien($(this));
  });

  /*******************************************/


  /************** FONCTIONS *****************/

    // La fonction qui ajoute un formulaire Categorie
  function ajoutProduit($conteneur) {

    // on remplace le __name__ avec l'index en cours (pour des id unique) [length - 17 => <td></table></td>]
    var $prototype = $($conteneur.attr('data-prototype').substr(4, $conteneur.attr('data-prototype').length - 17)
      .replace(/table/g, "tr")
      .replace(/__name__label__/g, "")
      .replace(/__name__/g, index));


    //tableau json des produits passé par symfony (variable )
    var produits = $.parseJSON(listeproduits);
    //index du tableau json
    var idproduit = -1;

    // On ajoute au prototype un lien pour pouvoir supprimer la catégorie (dans un td)
    ajoutSuppressionLien($prototype);
 
    // On ajoute le prototype modifié à la fin de la balise <div>
    $conteneurTable.append($prototype);

    //On recupère la valeur de l'option sélectionné et on recherche l'index du produit dans le json
    jQuery.each(produits, function(index, value){
        if (value.idtProduit == $('#choixproduit option:selected')[0].value) {
            idproduit = index;
            return;
        }
    });

    //On rempli les champs
    if( idproduit >= 0 )
    {
      $('#appbundle_commande_produits_' + index + '_codeproduit').val(produits[idproduit].codeProduit);
      $('#appbundle_commande_produits_' + index + '_nomproduit').val(produits[idproduit].nomProduit);
      $('#appbundle_commande_produits_' + index + '_description').val(produits[idproduit].descriptionProduit);
      $('#appbundle_commande_produits_' + index + '_quantite').val(1);
      $('#appbundle_commande_produits_' + index + '_prixproduit').val(produits[idproduit].prixProduit);
      $('#appbundle_commande_produits_' + index + '_prixtotal').val(produits[idproduit].prixProduit);
    }

    // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
    index++;

    //total de la commande
    $('#totalcommande').html( String(parseInt($('#totalcommande').html()) + parseInt(produits[idproduit].prixProduit)) + " €" );

    //listener - modification du prix total quand changement de quantité
    $("input[id^='appbundle_commande_produits_'][id*='_quantite']").off().on( "change", function(e) {
      
      var position = this.id.split('_')[3];

      // si quantité inférieur à 1 on force à 1
      if( this.value < 1 )
      {
        //this.value = 1;
      }

      //pour le montant total de tous les articles
      var totalinter = parseInt($('#totalcommande').html());
      var totalfinal = totalinter - parseInt($('#appbundle_commande_produits_' + position + '_prixtotal').val());

      $('#appbundle_commande_produits_' + position + '_prixtotal').val(
        $('#appbundle_commande_produits_' + position + '_prixproduit').val() * this.value 
      );

      $('#totalcommande').html( String( totalfinal + parseInt($('#appbundle_commande_produits_' + position + '_prixtotal').val())) + " €" );

      e.preventDefault();

      return false;
    });
  }

  // La fonction qui ajoute un lien de suppression d'une catégorie
  function ajoutSuppressionLien($prototype) {
      // Création du lien
      $deleteLink = $('<td><a href="#" class="btn btn-danger">Supprimer</a></td>');

      // Ajout du lien
      $prototype.append($deleteLink);

      // Ajout du listener sur le clic du lien
      $deleteLink.click(function(e) {
        $prototype.remove();
        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
      });
  }

  /*******************************************/

}); //fin jQuery