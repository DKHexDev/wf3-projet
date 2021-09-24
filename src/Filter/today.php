<?php

/*
 * This file is part of the MatthieuMota package.
 *
 * (c) Matthieu Mota <matthieu@boxydev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Filter;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Today
 * @author Matthieu Mota & Ulrick Evrard
 */

class Today
{
    /**
     * Déclaration approximative des saisons
     * 
     * @var array
     */
    private static $seasons = [

        'winter' => ['12', '01', '02'],
        'spring' => ['03', '04', '05'],
        'summer' => ['06', '07', '08'],
        'autumn' => ['09', '10', '11']
    ];

    /**
     * Déclaration de certains jours spéciaux dans l'année
     * 
     */
    private static $specialDays = [

        'christmas'     => '2021-12-25',
        'easter'        => '2022-04-17',
        'halloween'     => '2021-10-31',
        'nationalDay'   => '2022-07-14'
    ];

    /**
     * 
     * 
     * @return string|null event or null
     */
    public static function closeToSpecial(): string {

        foreach(self::$specialDays as $key => $specialDay){

        $today = new DateTime();
        $day = new DateTime($specialDay);

        $interval = $today->diff($day);

        if($interval->format("%m") == 0){

            return $key;
        }
    }
        $actual = Today::getSeason();
        return $actual;
    }

    /**
     * Fonction qui permet d'obtenir la saison en cours
     * 
     * @return string
     */
    public static function getSeason(): string {

        // On obtient d'abord la date du jour au format Datetime.
        $today = new DateTime();

        // On cherche dans chaque tableau de saison si le mois actuel correspond.
        foreach(self::$seasons as $key => $season){

            // Si une correspondance est trouvée, on retourne la clef, qui s'avère être le nom de la saison.
            if(in_array($today->format("m"), $season)){

                return $key;
            }
        }
        // Ne devrait jamais apparaître.
        return("Aucune saison en cours");
    }

}