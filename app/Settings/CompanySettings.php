<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CompanySettings extends Settings{

    public string $company_name,$contact_person,$address,$country,
            $city,$province,$postal_code,$email,$phone,$website_url;

    public static function group(): string
    {
        return 'company';
    }

}