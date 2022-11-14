<?php

namespace App\Helper;

trait CustomerWalletTrait
{
    public function numberBankCardExceeded()
    {
        if($this->cards()->count() >= $this->customer->package->nb_carte_physique):
        ob_start();
        ?>
            <div class="alert bg-light-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                <i class="fa-solid fa-credit-card fs-2hx text-danger me-4 mb-5 mb-sm-0"></i>
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h4 class="fw-semibold">Nombre de carte bancaire dépassé</h4>
                    <span>Le nombre de cartes bancaire pour le client <strong><?= $this->customer->info->full_name ?></strong> est dépassé, des frais supplémentaires vont s'appliquer.</span>
                </div>
            </div>
        <?php
        return ob_get_clean();
        endif;
    }
}
