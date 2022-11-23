<?php

namespace App\Helper;

class CustomerSituationHelper
{
    public static function dataLegalCapacity()
    {
        return collect([
            ['id' => "Majeur Capable", "name" => "Majeur Capable"],
            ['id' => "Majeur sous tutelle", "name" => "Majeur sous tutelle"],
            ['id' => "Mineur", "name" => "Mineur"],
        ]);
    }

    public static function dataFamilySituation()
    {
        return collect([
            ['id' => "Célibataire", "name" => "Célibataire"],
            ['id' => "Divorcé", "name" => "Divorcé"],
            ['id' => "Marié", "name" => "Marié"],
            ['id' => "Pacsé", "name" => "Pacsé"],
            ['id' => "Séparé de corps", "name" => "Séparé de corps"],
            ['id' => "Union Libre", "name" => "Union Libre"],
            ['id' => "Veuf(ve)", "name" => "Veuf(ve)"],
        ]);
    }

    public static function dataLogement()
    {
        return collect([
            ["id" => "Propriétaire", "name" => "Propriétaire"],
            ["id" => "Locataire", "name" => "Locataire"],
            ["id" => "Logé par l'employeur", "name" => "Logé par l'employeur"],
            ["id" => "Logé à titre gratuit", "name" => "Logé à titre gratuit"],
            ["id" => "Logé par les parents", "name" => "Logé par les parents"],
            ["id" => "Sans Domicile Fixe", "name" => "Sans Domicile Fixe"],
            ["id" => "Hôtel, Autres", "name" => "Hôtel, Autres"],
        ]);
    }

    public static function dataProCategories()
    {
        return collect([
            ['id' => 'Agriculteur', 'name' => 'Agriculteur'],
            ['id' => "Artisan, Commerçant, Chef d'Entreprise", 'name' => "Artisan, Commerçant, Chef d'Entreprise"],
            ['id' => "Artisan, Commerçant, Chef d'Entreprise", 'name' => "Artisan, Commerçant, Chef d'Entreprise"],
            ['id' => "Cadre", 'name' => "Cadre"],
            ['id' => "Employé", 'name' => "Employé"],
            ['id' => "Ouvriers", 'name' => "Ouvriers"],
            ['id' => "Retraiter", 'name' => "Retraiter"],
            ['id' => "Sans Emploie", 'name' => "Sans Emploie"],
        ]);
    }

    public static function calcDiffInSituation($customer)
    {
        $income = $customer->income->pro_incoming + $customer->income->patrimoine;
        $charge = $customer->charge->rent + $customer->charge->credit + $customer->charge->divers;

        return $income - $charge;
    }
}
