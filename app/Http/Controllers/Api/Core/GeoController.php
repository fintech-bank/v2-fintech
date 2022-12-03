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
        $data = [];
        if($request->get('q')) {
            $data = $results->search($request->get('q'));
        } else {
            $data = $results->all();
        }

        return response()->json($data);
    }
    public function cities(Request $request)
    {
        $results = GeoHelper::getCitiesFromCountry($request->get('country'));
        $data = [];
        if($request->get('q')) {
            $data = $results->search($request->get('q'));
        } else {
            $data = $results->all();
        }

        return response()->json($data);
    }

    public function citiesByPostal($postal)
    {
        $results = Vicopo::https($postal);
        ob_start(); ?>
        <label for="city" class="required form-label">
            Ville
        </label>
        <select id="city" class="form-select form-select-solid selectpicker" data-placeholder="Selectionnez une ville" name="city">
            <option value=""></option>
            <?php foreach ($results as $result) { ?>
                <option value="<?= $result->city ?>"><?= $result->city ?></option>
            <?php } ?>
        </select>
        <script>
            $("[name='city']").selectpicker()
        </script>
        <?php
        return response()->json(ob_get_clean());
    }
}
