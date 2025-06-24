<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use RachidLaasri\LaravelInstaller\Events\EnvironmentSaved;
use RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager;
use RachidLaasri\LaravelInstaller\Helpers\DatabaseManager;
use Validator;

class EdumanInstallController extends Controller
{
    /**
     * @var EnvironmentManager
     */
    protected $EnvironmentManager;

    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     * @param EnvironmentManager $environmentManager
     */
    public function __construct(DatabaseManager $databaseManager, EnvironmentManager $environmentManager)
    {
        $this->databaseManager = $databaseManager;
        $this->EnvironmentManager = $environmentManager;
    }

    /**
     * Processes the newly saved environment configuration (Classic).
     *
     * @param Request $input
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function installerRun(Request $input, Redirector $redirect)
    {
        $message = $this->EnvironmentManager->saveFileClassic($input);
        event(new EnvironmentSaved($input));

        return redirect()->route("edumanDatabaseSave");
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database()
    {
        $response = $this->databaseManager->migrateAndSeed();
        return redirect()->route('LaravelInstaller::final')
            ->with(['message' => $response]);
    }
}