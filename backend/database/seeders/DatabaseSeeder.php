<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Setting;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['name'=>'Admin User','email'=>'admin@perfexcrm.com','password'=>bcrypt('password'),'role'=>'admin','is_active'=>true]);
        User::create(['name'=>'Manager Joe','email'=>'manager@perfexcrm.com','password'=>bcrypt('password'),'role'=>'manager','is_active'=>true]);
        User::create(['name'=>'Staff Alice','email'=>'staff@perfexcrm.com','password'=>bcrypt('password'),'role'=>'staff','is_active'=>true]);

        $clients = [
            ['company_name'=>'Acme Corporation','email'=>'contact@acme.com','phone'=>'+1 555-0100','city'=>'New York','country'=>'US','currency'=>'USD','status'=>'active'],
            ['company_name'=>'Globex Inc','email'=>'info@globex.com','phone'=>'+1 555-0200','city'=>'Chicago','country'=>'US','currency'=>'USD','status'=>'active'],
            ['company_name'=>'Initech','email'=>'hello@initech.com','phone'=>'+1 555-0300','city'=>'Austin','country'=>'US','currency'=>'USD','status'=>'active'],
        ];
        foreach($clients as $c) Client::create($c);

        $defaults = [
            ['key'=>'company_name','value'=>'Perfex CRM','group'=>'company'],
            ['key'=>'company_email','value'=>'info@perfexcrm.com','group'=>'company'],
            ['key'=>'default_currency','value'=>'USD','group'=>'company'],
            ['key'=>'invoice_prefix','value'=>'INV-','group'=>'company'],
            ['key'=>'estimate_prefix','value'=>'EST-','group'=>'company'],
            ['key'=>'tax_name','value'=>'Tax','group'=>'company'],
            ['key'=>'tax_rate','value'=>'0','group'=>'company'],
            ['key'=>'invoice_terms','value'=>'Payment due within 30 days.','group'=>'company'],
        ];
        foreach($defaults as $s) Setting::updateOrCreate(['key'=>$s['key']],$s);
    }
}