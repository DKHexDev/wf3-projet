<?php

namespace App\Filter\filter;

final class Filter {

    /* 
        Définition d'un tableau contenant les filtres de chaque type,
        ces filtres sont récupérés dans un formulaire :

        IMPORTANT : mettre un attribut 'name' à chaque input radio du formulaire,
        correspondant aux clefs du tableau filtre.
        
        Ces filtres serviront ensuite à déclarer les requêtes SQL, et ainsi afficher
        uniquement les recettes concernées.

    */


    // Définition des propriétés.
    // --

    // Définition de la liste des filtres.
    private $filters    = [
        'season'    => null,
        'culture'   => null,
        'diet'      => null,
        'event'     => null
    ];

    // Création de la variable contenant le message à afficher.
    private $messageFilters = " Filtres appliqués : ";


    // Définition des méthodes
    // --

    /**
     * Fonction qui permet d'ajouter les filtres.
     * 
     * @return void Ne retourne rien. 
     */
    public function setFilters()
    {

        // Affectation des données au sein du tableau, récupération des données
        // dans la superglobale POST.
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $this->filters['season']  = isset($_POST['season'])  ? $_POST['season']  : null;
            $this->filters['culture'] = isset($_POST['culture']) ? $_POST['culture'] : null;
            $this->filters['diet']    = isset($_POST['diet'])    ? $_POST['diet']    : null;
            $this->filters['event']   = isset($_POST['event'])   ? $_POST['event']   : null;
        }

        return;
    }

    /**
     * Fonction pour récupérer les filtres.
     * 
     * @return array Retourne les valeurs des filtres.
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Fonction qui prépare le message d'affichage de
     * la sélection des filtres.
     * 
     * @return void Ne retourne rien.
     */
    private function prepareMessage()
    {
        // Valeur témoin permettant de vérifier si aucun filtre n'est appliqué
        $a = 0;

        // Ici on boucle sur chaque valeur pour vérifier qu'elle est affectée,
        foreach($this->filters as $key => $value){

            if(isset($this->filters[$key])){
                // Si elle l'est, on la concat au message avec des guillements
                // ( échappés par l'antislash )
                $this->messageFilters.= "\"".$this->filters[$key]."\" ";
            }
            else
            {
                // Sinon, on incrémente une valeur témoin, qui servira à afficher
                // " Aucun " si aucun filtre n'est appliqué.
                $a++;
            }
        }

        // La boucle a parcouru chaque valeur du tableau, si elle n'a trouvée 
        // aucun filtre appliqué, on renvoie "Aucun".
        // Sinon on rajoute un point pour terminer la phrase proprement.
        $this->messageFilters .= $a == 4 ? "Aucun !" : ".";
    }

    /**
     * Méthode 'magique' appellée lorsque l'objet sera traité comme une chaîne 
     * de caractère. Exemples : "Filtres appliqués : 'Hiver', 'Asiatique', 'Végétarien',
     * 'Pâques'." | " Filtres appliqués : Aucun!."
     * 
     * @return string Retourne le message de filtre.
     */
    public function toString()
    {
        $this->prepareMessage();
        return($this->messageFilters);
    }
}