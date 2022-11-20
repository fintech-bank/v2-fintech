<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\GeoHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vicopo\Vicopo;

class GeoController extends Controller
{
    public function states(Request $request)
    {
        $results = GeoHelper::getStateFromCountry($request->get('country'));
        ob_start();
        ?>
        <div class="mb-10">
            <label for="<?= $request->get('name') ?>" class="form-label"><?= $request->has('label') ? $request->get('label') : $request->get('name') ?></label>
            <select id="<?= $request->get('name') ?>" name="<?= $request->get('name') ?>" class="form-control form-control-solid" data-placeholder="<?= $request->get('placeholder') ?>">
                <?php foreach ($results as $result): ?>
                    <option value="<?= $result->name; ?>"><?= $result->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <script>
            $("#<?= $request->get('name') ?>").selectpicker()
        </script>
        <?php

        return response()->json(ob_get_clean());
    }
    public function cities(Request $request)
    {
        $results = GeoHelper::getCitiesFromCountry($request->get('country'));
        ob_start(); ?>
        <label for="citybirth" class="required form-label">
            Ville de Naissance
        </label>
        <select id="citybirth" class="form-select form-select-solid" data-placeholder="Selectionnez une ville de naissance" name="citybirth">
            <option value=""></option>
            <?php foreach ($results as $result) { ?>
                <option value="<?= $result ?>"><?= $result ?></option>
            <?php } ?>
        </select>
        <?php
        return response()->json(ob_get_clean());
    }

    public function citiesByPostal($postal)
    {
        $results = Vicopo::https($postal);
        ob_start(); ?>
        <label for="city" class="required form-label">
            Ville
        </label>
        <select id="city" class="form-select form-select-solid" data-placeholder="Selectionnez une ville" name="city">
            <option value=""></option>
            <?php foreach ($results as $result) { ?>
                <option value="<?= $result->city ?>"><?= $result->city ?></option>
            <?php } ?>
        </select>
        <?php
        return response()->json(ob_get_clean());
    }
}
