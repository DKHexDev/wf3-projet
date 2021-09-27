<?php

namespace App\Filter\filter;
use Symfony\Component\HttpFoundation\Request;

final class Filter extends Request{

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
    private $request;
    // Définition de la liste des filtres.
    private $filters    = [
        'season'    => null,
        'event'     => null
    ];

    // Création de la variable contenant le message à afficher.
    private $messageFilters = " Filtres appliqués : ";


    // Définition des méthodes
    // --

    /**
     * Fonction qui récupère les données de Request et les intègre au tableau de filtres
     * 
     * @return void Ne retourne rien. 
     */
    public function __construct(){

        $this->request = Request::createFromGlobals();

    }
        
    /**
     * Va chercher les filtres définis en méthode get (Dans l'url)
     * 
     * @return void
     */
    public function setFilters()
    {
        $season = $this->query->request->get('season');
        $event  = $this->query->request->get('event');
    
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
    private function prepareMessage(){
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
    public function toString(){
        $this->prepareMessage();
        return($this->messageFilters);
    }
}