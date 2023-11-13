<?php

namespace Config;

use App\Actions\Patient\PatientActiveAction;
use App\Actions\Patient\PatientDestroyAction;
use App\Actions\Patient\PatientIndexAction;
use App\Actions\Patient\PatientStoreAction;
use App\Actions\Patient\PatientUpdateAction;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
    public static function patientIndexAction(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('PatientIndexAction');
        }

        return new PatientIndexAction();
    }

    public static function patientStoreAction(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('PatientStoreAction');
        }

        return new PatientStoreAction();
    }

    public static function patientUpdateAction(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('PatientUpdateAction');
        }

        return new PatientUpdateAction();
    }

    public static function patientDestroyAction(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('PatientDestroyAction');
        }

        return new PatientDestroyAction();
    }

    public static function patientActiveAction(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('PatientActiveAction');
        }

        return new PatientActiveAction();
    }
}
