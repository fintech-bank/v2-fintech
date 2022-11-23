<?php

namespace App\Helper;

class CustomerSituationHelper
{
    public static function dataLegalCapacity()
    {
        return collect([
            ['id' => "Majeur Capable", "value" => "Majeur Capable"],
            ['id' => "Majeur sous tutelle", "value" => "Majeur sous tutelle"],
            ['id' => "Mineur", "value" => "Mineur"],
        ]);
    }

    public static function dataFamilySituation()
    {
        return collect([
            ['id' => "Célibataire", "value" => "Célibataire"],
            ['id' => "Divorcé", "value" => "Divorcé"],
            ['id' => "Marié", "value" => "Marié"],
            ['id' => "Pacsé", "value" => "Pacsé"],
            ['id' => "Séparé de corps", "value" => "Séparé de corps"],
            ['id' => "Union Libre", "value" => "Union Libre"],
            ['id' => "Veuf(ve)", "value" => "Veuf(ve)"],
        ]);
    }

    public static function dataLogement()
    {
        return collect([
            ["id" => "Propriétaire", "value" => "Propriétaire"],
            ["id" => "Locataire", "value" => "Locataire"],
            ["id" => "Logé par l'employeur", "value" => "Logé par l'employeur"],
            ["id" => "Logé à titre gratuit", "value" => "Logé à titre gratuit"],
            ["id" => "Logé par les parents", "value" => "Logé par les parents"],
            ["id" => "Sans Domicile Fixe", "value" => "Sans Domicile Fixe"],
            ["id" => "Hôtel, Autres", "value" => "Hôtel, Autres"],
        ]);
    }

    public static function dataProCategories()
    {
        return collect([
            ['id' => 'Agriculteur', 'value' => 'Agriculteur'],
            ['id' => "Artisan, Commerçant, Chef d'Entreprise", 'value' => "Artisan, Commerçant, Chef d'Entreprise"],
            ['id' => "Artisan, Commerçant, Chef d'Entreprise", 'value' => "Artisan, Commerçant, Chef d'Entreprise"],
            ['id' => "Cadre", 'value' => "Cadre"],
            ['id' => "Employé", 'value' => "Employé"],
            ['id' => "Ouvriers", 'value' => "Ouvriers"],
            ['id' => "Retraiter", 'value' => "Retraiter"],
            ['id' => "Sans Emploie", 'value' => "Sans Emploie"],
        ]);
    }

    public static function calcDiffInSituation($customer)
    {
        $income = $customer->income->pro_incoming + $customer->income->patrimoine;
        $charge = $customer->charge->rent + $customer->charge->credit + $customer->charge->divers;

        return $income - $charge;
    }
}
