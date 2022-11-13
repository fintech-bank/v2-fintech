<?php

namespace App\Helper;

class CustomerSituationHelper
{
    public static function dataLegalCapacity()
    {
        return json_encode([
            [
                'key' => 'Majeur Capable',
                'value' => 'Majeur Capable',
            ],
            [
                'key' => 'Majeur sous tutelle',
                'value' => 'Majeur sous tutelle',
            ],
            [
                'key' => 'Mineur',
                'value' => 'Mineur',
            ],
        ]);
    }

    public static function dataFamilySituation()
    {
        return json_encode([
            ['key' => 'Célibataire', 'value' => "Célibataire"],
            ['key' => 'Divorcé', 'value' => "Divorcé"],
            ['key' => 'Marié', 'value' => "Marié"],
            ['key' => 'Pacsé', 'value' => "Pacsé"],
            ['key' => 'Séparé de corps', 'value' => "Séparé de corps"],
            ['key' => 'Union Libre', 'value' => "Union Libre"],
            ['key' => 'Veuf(ve)', 'value' => "Veuf(ve)"],
        ]);
    }

    public static function dataLogement()
    {
        return json_encode([
            ['key' => 'Propriétaire', 'value' => 'Propriétaire'],
            ['key' => 'Locataire', 'value' => 'Locataire'],
            ['key' => "Logé par l'employeur", 'value' => "Logé par l'employeur"],
            ['key' => 'Logé à titre gratuit', 'value' => 'Logé à titre gratuit'],
            ['key' => 'Logé par les parents', 'value' => 'Logé par les parents'],
            ['key' => 'Sans Domicile Fixe', 'value' => 'Sans Domicile Fixe'],
            ['key' => 'Hôtel, Autres', 'value' => 'Hôtel, Autres'],
        ]);
    }

    public static function dataProCategories()
    {
        return json_encode([
            ['key' => 'Agriculteur', "value" => "Agriculteur"],
            ['key' => "Artisan, Commerçant, Chef d'Entreprise", "value" => "Artisan, Commerçant, Chef d'Entreprise"],
            ['key' => 'Cadre', "value" => "Cadre"],
            ['key' => 'Employé', "value" => "Employé"],
            ['key' => 'Ouvriers', "value" => "Ouvriers"],
            ['key' => 'Retraiter', "value" => "Retraiter"],
            ['key' => 'Sans Emploie', "value" => "Sans Emploie"],
        ]);
    }

    public static function calcDiffInSituation($customer)
    {
        $income = $customer->income->pro_incoming + $customer->income->patrimoine;
        $charge = $customer->charge->rent + $customer->charge->credit + $customer->charge->divers;

        return $income - $charge;
    }
}
