<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$permissions = [
'role-list',
'role-create',
'role-edit',
'role-delete',
'role-show',

'user-list',
'user-create',
'user-edit',
'user-delete',
'user-show',

'patient-list',
'patient-create',
'patient-edit',
'patient-delete',
'patient-show',

'appointment-list',
'appointment-create',
'appointment-edit',
'appointment-delete',
'appointment-show',
'appointment-payment',

'insurance-list',
'insurance-create',
'insurance-edit',
'insurance-delete',
'insurance-show',

'lab-list',
'lab-create',
'lab-edit',
'lab-delete',
'lab-show',

'area-list',
'area-create',
'area-edit',
'area-delete',
'area-show',


'addition-list',
'addition-create',
'addition-edit',
'addition-delete',
'addition-show',

'medicine-list',
'medicine-create',
'medicine-edit',
'medicine-delete',
'medicine-show',

'service-list',
'service-create',
'service-edit',
'service-delete',
'service-show',

'todayvisit-list',
'patient-entry',


'labrequest-list',
'labrequest-create',
'labrequest-edit',
'labrequest-delete',
'labrequest-show',
'labrequest-payment',

'paymenttransaction-list',
'paymenttransaction-create',
'paymenttransaction-edit',
'paymenttransaction-delete',
'paymenttransaction-show',

'expense-list',
'expense-create',
'expense-edit',
'expense-delete',
'expense-show',

'appointment-reports',
'expense-reports',
'payment-reports',
'medicine-reports',
'patient-reports'
























];
foreach ($permissions as $permission) {
Permission::create(['name' => $permission]);
}
}
}
