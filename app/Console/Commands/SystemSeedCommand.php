<?php

namespace App\Console\Commands;

use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Helper\UserHelper;
use App\Models\Core\Agency;
use App\Models\Core\DocumentCategory;
use App\Models\Core\EpargnePlan;
use App\Models\Core\LoanPlan;
use App\Models\Core\Package;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerCheck;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerCreditor;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerInfo;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerSetting;
use App\Models\Customer\CustomerSituation;
use App\Models\Customer\CustomerSituationCharge;
use App\Models\Customer\CustomerSituationIncome;
use App\Models\Customer\CustomerTransaction;
use App\Models\Customer\CustomerWallet;
use App\Models\User;
use Carbon\Carbon;
use IbanGenerator\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SystemSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:seed {--base} {--test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed System';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('base')) {
            $this->call('migrate:fresh', ['--force']);
            \Storage::disk('public')->deleteDirectory('gdd/');
            \Storage::disk('public')->deleteDirectory('reseller/');
        }

        $this->info('Seeding: Liste des agences');
        $this->call('db:seed', ['class' => 'AgencySeeder', 'force']);

        $this->info('Seeding: Liste des Banques');
        $this->call('db:seed', ['class' => 'BanksTableSeeder', 'force']);

        $this->info("Seeding: Liste des Plan d'??pargne");
        $this->call('db:seed', ['class' => 'EpargnePlanSeeder', 'force']);

        $this->info('Seeding: Liste des Plan de Pret');
        $this->call('db:seed', ['class' => 'LoanPlanSeeder', 'force']);

        $this->info('Seeding: Liste des Interets des plan de pret');
        $this->call('db:seed', ['class' => 'LoanPlanInterestSeeder', 'force']);

        $this->info('Seeding: Liste des Packages');
        $this->call('db:seed', ['class' => 'PackageSeeder', 'force']);

        $this->info('Seeding: Liste des Services');
        $this->call('db:seed', ['class' => 'ServiceSeeder', 'force']);

        $this->info('Seeding: Liste des Types de cartes');
        $this->call('db:seed', ['class' => 'CreditCardSupportSeeder', 'force']);

        $this->info('Seeding: Liste des Utilisateur de Test');
        $this->call('db:seed', ['class' => 'UserSeeder', 'force']);

        $this->info('Seeding: Liste des Cat??gories de documents');
        $this->call('db:seed', ['class' => 'DocumentCategorySeeder', 'force']);

        $this->info('Seeding: Liste des Cat??gories de pages');
        $this->call('db:seed', ['class' => 'CmsCategorySeeder', 'force']);

        $this->info('Seeding: Liste des Sous Cat??gories de pages');
        $this->call('db:seed', ['class' => 'CmsSubCategorySeeder', 'force']);

        $this->info('Seeding: Liste des Types de version');
        $this->call('db:seed', ['class' => 'TypeVersionSeeder', 'force']);

        $this->info('Seeding: Liste des Dossier Mail par d??fault');
        $this->call('db:seed', ['class' => 'MailboxFolderSeeder', 'force']);

        $this->info('Seeding: Type d\'assurance');
        $this->call('db:seed', ['class' => 'InsuranceTypeSeeder', 'force']);

        $this->info('Seeding: Forfait d\'assurance');
        $this->call('db:seed', ['class' => 'InsurancePackageSeeder', 'force']);

        $this->info('Seeding: Formule des forfaits d\'assurance');
        $this->call('db:seed', ['class' => 'InsurancePackageFormSeeder', 'force']);

        $this->info('Seeding: Garantie des Formules des forfaits d\'assurance');
        $this->call('db:seed', ['class' => 'InsurancePackageWarrantySeeder', 'force']);

        return 0;
    }

}
