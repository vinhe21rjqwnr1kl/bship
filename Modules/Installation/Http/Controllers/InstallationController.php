<?php

namespace Modules\Installation\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Installation\Helpers\RequirementsChecker;
use Modules\Installation\Helpers\PermissionsChecker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Modules\Installation\Events\EnvironmentSaved;
use Modules\Installation\Events\LaravelInstallerFinished;
use Modules\Installation\Helpers\EnvironmentManager;
use Modules\Installation\Helpers\DatabaseManager;
use Modules\Installation\Helpers\FinalInstallManager;
use Modules\Installation\Helpers\InstalledFileManager;
use App\Models\User;
use App\Models\Configuration;
use Validator;

class InstallationController extends Controller
{

    /**
     * @var RequirementsChecker
     */
    protected $requirements;
    protected $permissions;
    protected $EnvironmentManager;
    private   $databaseManager;

    /**
     * @param RequirementsChecker $checker
     */
    public function __construct(RequirementsChecker $rChecker, PermissionsChecker $pChecker, EnvironmentManager $environmentManager, DatabaseManager $databaseManager)
    {
        $this->requirements = $rChecker;
        $this->permissions = $pChecker;
        $this->EnvironmentManager = $environmentManager;
        $this->databaseManager = $databaseManager;
    }


    public function welcome()
    {
        $prevUrlArray = explode('/', url()->previous());
        if(end($prevUrlArray) == 'install'){
            setcookie('w3cms_locale', 'en', time() + (86400), '/');
        }
        return view('installation::welcome');
    }

    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function requirements(Request $request)
    {
        if($request->isMethod('post'))
        {
            if($request->filled('language')) {
                setcookie('w3cms_locale', $request->language, time() + (86400), '/');
                return redirect()->route('LaravelInstaller::requirements');
            }
        }

        Artisan::call('config:clear');
        Artisan::call('route:clear');

        $res            = $this->checkRequirements();
        $requirements   = $res['requirements'];
        $permissions    = $res['permissions'];
        $phpSupportInfo = $res['version'];

        return view('installation::requirements', compact('requirements', 'phpSupportInfo', 'permissions'));
    }

    private function checkRequirements()
    {
        $res['version'] = $this->requirements->checkPHPversion(
            config('installation.core.minPhpVersion')
        );
        $res['requirements'] = $this->requirements->check(
            config('installation.requirements')
        );

        $res['permissions'] = $this->permissions->check(
            config('installation.permissions')
        );

        return $res;
    }

    /**
     * Display the Environment page.
     *
     * @return \Illuminate\View\View
     */
    public function environmentWizard()
    {
        $res = $this->checkRequirements();
        if(isset($res['requirements']['errors']) || isset($res['permissions']['errors']) || !$res['version']['supported'])
        {
            return redirect('/')->with('message', trans('installation::installer_messages.requirements.error'));
        }
        $envConfig = $this->EnvironmentManager->getEnvContent();

        return view('installation::environment-wizard', compact('envConfig'));
    }

    /**
     * Processes the newly saved environment configuration (Form Wizard).
     *
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveWizard(Request $request, Redirector $redirect)
    {

        $rules = config('installation.environment.form.rules');
        $messages = [
            'environment_custom.required_if' => trans('installation::installer_messages.environment.wizard.form.name_required'),
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $redirect->route('LaravelInstaller::environmentWizard')->withInput()->withErrors($validator->errors());
        }

        if (! $this->checkDatabaseConnection($request)) {
            return $redirect->route('LaravelInstaller::environmentWizard')->withInput()->withErrors([
                'database_connection' => trans('installation::installer_messages.environment.wizard.form.db_connection_failed'),
            ]);
        }

        $results = $this->EnvironmentManager->saveFileWizard($request);

        event(new EnvironmentSaved($request));

        return redirect()->route('LaravelInstaller::database');
    }

    /**
     * TODO: We can remove this code if PR will be merged: https://github.com/RachidLaasri/LaravelInstaller/pull/162
     * Validate database connection with user credentials (Form Wizard).
     *
     * @param Request $request
     * @return bool
     */
    private function checkDatabaseConnection(Request $request)
    {
        $connection = $request->input('database_connection') ? $request->input('database_connection') : env('DB_CONNECTION');

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('database_hostname') ? $request->input('database_hostname') : env('DB_HOST'),
                        'port' => $request->input('database_port') ? $request->input('database_port') : env('DB_PORT'),
                        'database' => $request->input('database_name') ? $request->input('database_name') : env('DB_DATABASE'),
                        'username' => $request->input('database_username') ? $request->input('database_username') : env('DB_USERNAME'),
                        'password' => $request->input('database_password') ? $request->input('database_password') : env('DB_PASSWORD'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

        try {
            DB::connection()->getPdo();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\View\View
     */
    public function database(Request $request)
    {
        if (! $this->checkDatabaseConnection($request)) {
            return redirect()->route('LaravelInstaller::environmentWizard')->withInput()->withErrors([
                'database_connection' => trans('installation::installer_messages.environment.wizard.form.db_connection_failed'),
            ]);
        }
        if($request->isMethod('post'))
        {

            $response = $this->databaseManager->migrateAndSeed();
            $config = new Configuration();
            $config->saveConfig('Site.w3cms_locale', !empty($_COOKIE['w3cms_locale']) ? $_COOKIE['w3cms_locale'] : 'en');

            setcookie('w3cms_locale', '', time(), '/');

            if(!empty($response['status']) && $response['status'] == 'error')
            {

                return redirect()->back()->withInput()->with(['message' => $response]);
            }

            return redirect()->route('LaravelInstaller::admin');
        }
        return view('installation::database-setup');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin()
    {

        $migration = DB::table('migrations')->count();

        if($migration < 22)
        {
            return redirect()->back()->withInput()->with(['message' => __('Something went wrong. Please reinstall database.')]);
        }

        return view('installation::admin-setup');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function saveAdmin(Request $request)
    {
        $rules      =   array(
                                'name'              => 'required',
                                'email'             => 'required|email|unique:users',
                                'password'          => 'required|min:8|required_with:confirm_password|same:confirm_password',
                                'confirm_password'  => 'required|min:8',
                            );
        $messages   =   array(
                                'name.required'                 => __('The name field is required.'),
                                'email.required'                => __('The email field is required.'),
                                'password.required'             => __('The password field is required.'),
                                'confirm_password.required'     => __('The confirm_password field is required.'),
                            );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('LaravelInstaller::admin')->withInput()->withErrors($validator->errors());
        }
        $name                   = explode(' ', $request->name);
        $first_name             = $name[0];
        $last_name              = isset($name[1]) ? $name[1] : '';
        $user                   = new User();
        $user->name             = $request->name;
        $user->first_name       = $first_name;
        $user->last_name        = $last_name;
        $user->email            = $request->email;
        $user->password         = Hash::make($request->password);
        $res                    = $user->save();

        if($res) 
        {
            $config = new Configuration();
            $config->saveConfig('Site.email', $request->email);
            $user->assignRole('Super Admin');
            return redirect()->route('LaravelInstaller::final');
        }
        return redirect()->route('LaravelInstaller::admin')->with('error', __('Sorry, Something went wrong with form submission.'));
    }

    /**
     * Update installed file and display finished view.
     *
     * @param \Modules\Installation\Helpers\InstalledFileManager $fileManager
     * @param \Modules\Installation\Helpers\FinalInstallManager $finalInstall
     * @param \Modules\Installation\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('installation::finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
