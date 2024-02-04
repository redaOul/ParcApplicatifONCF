<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class allTabsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apiresponseTabSeeder
        $apiresponse = new \App\Models\apiresponse();
        $apiresponse->apiresponseName = 'JSON';
        $apiresponse->save();

        $apiresponse = new \App\Models\apiresponse();
        $apiresponse->apiresponseName = 'XML';
        $apiresponse->save();

        // apitypeTabSeeder
        $apitype = new \App\Models\apitype();
        $apitype->apitypeName = 'REST';
        $apitype->save();

        $apitype = new \App\Models\apitype();
        $apitype->apitypeName = 'SOAP';
        $apitype->save();

        // applicationtypeTabSeeder
        $applicationtype = new \App\Models\applicationtype();
        $applicationtype->applicationtypeName = 'Web';
        $applicationtype->save();

        $applicationtype = new \App\Models\applicationtype();
        $applicationtype->applicationtypeName = 'Mobile';
        $applicationtype->save();

        // architecturetypeTabSeeder
        $architecturetype = new \App\Models\architecturetype();
        $architecturetype->architecturetypeName = '3 Tiers';
        $architecturetype->save();

        $architecturetype = new \App\Models\architecturetype();
        $architecturetype->architecturetypeName = 'Distribuée';
        $architecturetype->save();

        // databaseTabSeeder
        $database = new \App\Models\database();
        $database->databaseName = 'SQL Server';
        $database->save();

        $database = new \App\Models\database();
        $database->databaseName = 'MySQL';
        $database->save();

        $database = new \App\Models\database();
        $database->databaseName = 'MariaDB';
        $database->save();

        $database = new \App\Models\database();
        $database->databaseName = 'PostgreSQL';
        $database->save();

        // departmentTabSeeder
        $department = new \App\Models\department();
        $department->departmentName = 'DRP';
        $department->save();

        $department = new \App\Models\department();
        $department->departmentName = 'DVF';
        $department->save();

        // editorTabSeeder
        $editor = new \App\Models\editor();
        $editor->editorName = 'GRP';
        $editor->save();

        $editor = new \App\Models\editor();
        $editor->editorName = 'ALGO';
        $editor->save();

        $editor = new \App\Models\editor();
        $editor->editorName = 'CARL';
        $editor->save();

        $editor = new \App\Models\editor();
        $editor->editorName = 'Interne';
        $editor->save();

        // employeeTabSeeder
        $employee = new \App\Models\employee();
        $employee->employeeName = 'AMSSREGUE Chaimae';
        $employee->employeeType = 'employee';
        $employee->login = 'AMSSREGUE1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'RAGALA Zaynabe';
        $employee->employeeType = 'admin';
        $employee->login = 'RAGALA1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'LASFAR Zakaria';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'LASFAR1234';
        $employee->password = uniqid();
        $employee->save();//

        $employee = new \App\Models\employee();
        $employee->employeeName = 'AGOUMADA Akram';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'AGOUMADA1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'AL-AMRANI Hanane';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'AMRANI1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'ALHYANE Abdellah';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'ALHYANE1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'AMRI Hassnae';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'AMRI1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'AQUKAR Mourad';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'AQUKAR1234';
        $employee->password = uniqid();
        $employee->save();

        $employee = new \App\Models\employee();
        $employee->employeeName = 'BENDALAHCEN Oumaima';
        $employee->employeeType = 'superAdmin';
        $employee->login = 'BENDALAHCEN1234';
        $employee->password = uniqid();
        $employee->save();

        // languageTabSeeder
        $language = new \App\Models\language();
        $language->languageName = '.NET';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'Java';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'Spring Boot';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'PHP';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'Laravel';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'JavaScript';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'NodeJS';
        $language->save();

        $language = new \App\Models\language();
        $language->languageName = 'AngularJS';
        $language->save();

        // middlewareTabSeeder
        $middleware = new \App\Models\middleware();
        $middleware->middlewareName = 'Serveur APP';
        $middleware->save();

        $middleware = new \App\Models\middleware();
        $middleware->middlewareName = 'Apache Tomcat';
        $middleware->save();

        $middleware = new \App\Models\middleware();
        $middleware->middlewareName = 'Apache Web Server';
        $middleware->save();

        // platformTabSeeder
        $platform = new \App\Models\platform();
        $platform->platformName = 'Windows';
        $platform->save();

        $platform = new \App\Models\platform();
        $platform->platformName = 'Windows Server';
        $platform->save();

        $platform = new \App\Models\platform();
        $platform->platformName = 'Android';
        $platform->save();

        $platform = new \App\Models\platform();
        $platform->platformName = 'IOS';
        $platform->save();

        // serviceTabSeeder
        $service = new \App\Models\service();
        $service->serviceName = 'SCV';
        $service->save();

        $service = new \App\Models\service();
        $service->serviceName = 'SRF';
        $service->save();

        // solutiontypeTabSeeder
        $service = new \App\Models\solutiontype();
        $service->solutiontypeName = 'Progiciel';
        $service->save();

        $service = new \App\Models\solutiontype();
        $service->solutiontypeName = 'Développements Spécifiques';
        $service->save();
        
        $service = new \App\Models\solutiontype();
        $service->solutiontypeName = 'Solution prestataire';
        $service->save();

        // statusTabSeeder
        $status = new \App\Models\status();
        $status->statusName = 'En Production';
        $status->save();

        $status = new \App\Models\status();
        $status->statusName = 'En Pre-Production';
        $status->save();

        $status = new \App\Models\status();
        $status->statusName = 'En cours de Production';
        $status->save();
    }
}
