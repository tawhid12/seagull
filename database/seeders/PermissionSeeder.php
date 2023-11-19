<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'Dashboard',
                'route_name' => 'dashboard',
            ],
            [
                'name' => 'Assign Permission',
                'route_name' => 'assignPermissions',
            ],
            [
                'name' => 'Assign company',
                'route_name' => 'assignCompany',
            ],
            [
                'name' => 'Company Access',
                'route_name' => 'salesExecutiveCompany',
            ],

            [
                'name' => 'View Roles',
                'route_name' => 'role.index',
            ],
            [
                'name' => 'Role Permission',
                'route_name' => 'rolePermission',
            ],
            [
                'name' => 'Role Edit',
                'route_name' => 'role.edit',
            ],

            [
                'name' => 'View Permissions',
                'route_name' => 'permission.index',
            ],
            [
                'name' => 'Create Permissions',
                'route_name' => 'permission.create',
            ],
            /*[
                'name' => 'Store Permissions',
                'route_name' => 'permission.store',
            ],*/

            [
                'name' => 'View Designation',
                'route_name' => 'designation.index',
            ],
            [
                'name' => 'Create Designation',
                'route_name' => 'designation.create',
            ],
            /*[
                'name' => 'Store Designation',
                'route_name' => 'designation.store',
            ],*/
            [
                'name' => 'Edit Designation',
                'route_name' => 'designation.edit',
            ],
            /*[
                'name' => 'Update Designation',
                'route_name' => 'designation.update',
            ],*/
            [
                'name' => 'Destroy Designation',
                'route_name' => 'designation.destroy',
            ],

            [
                'name' => 'View Users',
                'route_name' => 'adminuser.index',
            ],
            [
                'name' => 'Create User',
                'route_name' => 'adminuser.create',
            ],
            [
                'name' => 'Edit User',
                'route_name' => 'adminuser.edit',
            ],
            /*[
                'name' => 'Update User',
                'route_name' => 'adminuser.update',
            ],*/

            [
                'name' => 'View Company',
                'route_name' => 'company.index',
            ],
            [
                'name' => 'Create Company',
                'route_name' => 'company.create',
            ],
            /*[
                'name' => 'Store Company',
                'route_name' => 'company.store',
            ],*/
            [
                'name' => 'Edit Company',
                'route_name' => 'company.edit',
            ],
            /*[
                'name' => 'Update Company',
                'route_name' => 'company.update',
            ],*/
            [
                'name' => 'Destroy Company',
                'route_name' => 'company.destroy',
            ],

            [
                'name' => 'View Vessel',
                'route_name' => 'vessel.index',
            ],
            [
                'name' => 'Create Vessel',
                'route_name' => 'vessel.create',
            ],
            /*[
                'name' => 'Store Vessel',
                'route_name' => 'vessel.store',
            ],*/
            [
                'name' => 'Edit Vessel',
                'route_name' => 'vessel.edit',
            ],
            /*[
                'name' => 'Update Vessel',
                'route_name' => 'vessel.update',
            ],*/
            [
                'name' => 'Destroy Vessel',
                'route_name' => 'vessel.destroy',
            ],

            [
                'name' => 'View Client',
                'route_name' => 'client.index',
            ],
            [
                'name' => 'Create Client',
                'route_name' => 'client.create',
            ],
            /*[
                'name' => 'Store Client',
                'route_name' => 'client.store',
            ],*/
            [
                'name' => 'Edit Client',
                'route_name' => 'client.edit',
            ],
            /*[
                'name' => 'Update Client',
                'route_name' => 'client.update',
            ],*/
            [
                'name' => 'Destroy Client',
                'route_name' => 'client.destroy',
            ],
            

            [
                'name' => 'View Categories',
                'route_name' => 'category.index',
            ],
            [
                'name' => 'Create Category',
                'route_name' => 'category.create',
            ],
            /*[
                'name' => 'Store Category',
                'route_name' => 'category.store',
            ],*/
            [
                'name' => 'Edit Category',
                'route_name' => 'category.edit',
            ],
            /*[
                'name' => 'Update Category',
                'route_name' => 'category.update',
            ],*/
            [
                'name' => 'Destroy Category',
                'route_name' => 'category.delete',
            ],


            [
                'name' => 'View Products',
                'route_name' => 'product.index',
            ],
            [
                'name' => 'Create Product',
                'route_name' => 'product.create',
            ],
            /*[
                'name' => 'Store Product',
                'route_name' => 'product.store',
            ],*/
            [
                'name' => 'Edit Product',
                'route_name' => 'product.edit',
            ],
            /*[
                'name' => 'Update Product',
                'route_name' => 'product.update',
            ],*/
            [
                'name' => 'Destroy Product',
                'route_name' => 'product.destroy',
            ],

            [
                'name' => 'View Suppliers',
                'route_name' => 'supplier.index',
            ],
            [
                'name' => 'Create Supplier',
                'route_name' => 'supplier.create',
            ],
            /*[
                'name' => 'Store Spplier',
                'route_name' => 'supplier.store',
            ],*/
            [
                'name' => 'Edit Supplier',
                'route_name' => 'supplier.edit',
            ],
            /*[
                'name' => 'Update Supplier',
                'route_name' => 'supplier.update',
            ],*/
            [
                'name' => 'Destroy Supplier',
                'route_name' => 'supplier.destroy',
            ],

            [
                'name' => 'View Requisition',
                'route_name' => 'requisition.index',
            ],
            [
                'name' => 'Create Requisition',
                'route_name' => 'requisition.create',
            ],
            /*[
                'name' => 'Store Requisition',
                'route_name' => 'requisition.store',
            ],*/
            [
                'name' => 'Edit Requisition',
                'route_name' => 'requisition.edit',
            ],
            /*[
                'name' => 'Update Requisition',
                'route_name' => 'requisition.update',
            ],*/
            [
                'name' => 'Destroy Requisition',
                'route_name' => 'requisition.destroy',
            ],
            [
                'name' => 'Create Other Requisition',
                'route_name' => 'otherRequisition.create',
            ],
            /*[
                'name' => 'Store Other Requisition',
                'route_name' => 'otherRequisition.store',
            ],*/
            [
                'name' => 'Edit Other Requisition',
                'route_name' => 'otherRequisition.edit',
            ],
            /*[
                'name' => 'Destroy Other Requisition',
                'route_name' => 'otherRequisition.destroy',
            ],*/

            [
                'name' => 'Create AutoDebit Voucher',
                'route_name' => 'autodebitvoucher.create',
            ],
            /*[
                'name' => 'Store AutoDebit Voucher',
                'route_name' => 'autodebitvoucher.store',
            ],*/

            [
                'name' => 'View Employees',
                'route_name' => 'employee.index',
            ],
            [
                'name' => 'Create Employee',
                'route_name' => 'employee.create',
            ],
            /*[
                'name' => 'Store Employee',
                'route_name' => 'employee.store',
            ],*/
            [
                'name' => 'Edit Employee',
                'route_name' => 'employee.edit',
            ],
            /*[
                'name' => 'Update Employee',
                'route_name' => 'employee.update',
            ],*/
            [
                'name' => 'Destroy Employee',
                'route_name' => 'employee.destroy',
            ],

            [
                'name' => 'View Attendance',
                'route_name' => 'attendance.index',
            ],
            [
                'name' => 'Create Attendance',
                'route_name' => 'attendance.create',
            ],
            /*[
                'name' => 'Store Attendance',
                'route_name' => 'attendance.store',
            ],*/
            [
                'name' => 'Edit Attendance',
                'route_name' => 'attendance.edit',
            ],
            /*[
                'name' => 'Update Attendance',
                'route_name' => 'attendance.update',
            ],*/
            [
                'name' => 'Destroy Attendance',
                'route_name' => 'attendance.destroy',
            ],

            [
                'name' => 'View Leave Type',
                'route_name' => 'leave-type.index',
            ],
            [
                'name' => 'Create Leave Type',
                'route_name' => 'leave-type.create',
            ],
            /*[
                'name' => 'Store Leave Type',
                'route_name' => 'leave-type.store',
            ],*/
            [
                'name' => 'Edit Leave Type',
                'route_name' => 'leave-type.edit',
            ],
            /*[
                'name' => 'Update Leave Type',
                'route_name' => 'leave-type.update',
            ],*/
            [
                'name' => 'Destroy Leave Type',
                'route_name' => 'leave-type.destroy',
            ],

            [
                'name' => 'View Total Working Day',
                'route_name' => 'total-working-day.index',
            ],
            [
                'name' => 'Create Total Working Day',
                'route_name' => 'total-working-day.create',
            ],
            /*[
                'name' => 'Store Total Working Day',
                'route_name' => 'total-working-day.store',
            ],*/
            [
                'name' => 'Edit Total Working Day',
                'route_name' => 'total-working-day.edit',
            ],
            /*[
                'name' => 'Update Total Working Day',
                'route_name' => 'total-working-day.update',
            ],*/
            [
                'name' => 'Destroy Total Working Day',
                'route_name' => 'total-working-day.destroy',
            ],

            [
                'name' => 'View Total Leave Per Yer',
                'route_name' => 'total-leave-per-year.index',
            ],
            [
                'name' => 'Create Total Leave Per Yer',
                'route_name' => 'total-leave-per-year.create',
            ],
            /*[
                'name' => 'Store Total Leave Per Yer',
                'route_name' => 'total-leave-per-year.store',
            ],*/
            [
                'name' => 'Edit Total Leave Per Yer',
                'route_name' => 'total-leave-per-year.edit',
            ],
            /*[
                'name' => 'Update Total Leave Per Yer',
                'route_name' => 'total-leave-per-year.update',
            ],*/
            [
                'name' => 'Destroy Total Leave Per Yer',
                'route_name' => 'total-leave-per-year.destroy',
            ],

            [
                'name' => 'View Employe Leave',
                'route_name' => 'leave.index',
            ],
            [
                'name' => 'Create Employe Leave',
                'route_name' => 'leave.create',
            ],
            /*[
                'name' => 'Store Employe Leave',
                'route_name' => 'leave.store',
            ],*/
            [
                'name' => 'Edit Employe Leave',
                'route_name' => 'leave.edit',
            ],
            /*[
                'name' => 'Update Employe Leave',
                'route_name' => 'leave.update',
            ],*/
            [
                'name' => 'Destroy Employe Leave',
                'route_name' => 'leave.destroy',
            ],

            [
                'name' => 'View Salary Slip',
                'route_name' => 'salary-slip.index',
            ],
            [
                'name' => 'Create Salary Slip',
                'route_name' => 'salary-slip.create',
            ],
            /*[
                'name' => 'Store Salary Slip',
                'route_name' => 'salary-slip.store',
            ],*/
            [
                'name' => 'Edit Salary Slip',
                'route_name' => 'salary-slip.edit',
            ],
            /*[
                'name' => 'Update Salary Slip',
                'route_name' => 'salary-slip.update',
            ],*/
            [
                'name' => 'Destroy Salary Slip',
                'route_name' => 'salary-slip.destroy',
            ],

            [
                'name' => 'View Salary Advance',
                'route_name' => 'salary-advance-payment.index',
            ],
            [
                'name' => 'Create Salary Advance',
                'route_name' => 'salary-advance-payment.create',
            ],
            /*[
                'name' => 'Store Salary Advance',
                'route_name' => 'salary-advance-payment.store',
            ],*/
            [
                'name' => 'Edit Salary Advance',
                'route_name' => 'salary-advance-payment.edit',
            ],
            /*[
                'name' => 'Update Salary Advance',
                'route_name' => 'salary-advance-payment.update',
            ],*/
            [
                'name' => 'Destroy Salary Advance',
                'route_name' => 'salary-advance-payment.destroy',
            ],

            [
                'name' => 'View Master Account',
                'route_name' => 'master.index',
            ],
            [
                'name' => 'Create Master Account',
                'route_name' => 'master.create',
            ],
            /*[
                'name' => 'Store Master Account',
                'route_name' => 'master.store',
            ],*/
            [
                'name' => 'Edit Master Account',
                'route_name' => 'master.edit',
            ],
            /*[
                'name' => 'Update Master Account',
                'route_name' => 'master.update',
            ],*/


            [
                'name' => 'View Sub Head',
                'route_name' => 'sub_head.index',
            ],
            [
                'name' => 'Create Sub Head',
                'route_name' => 'sub_head.create',
            ],
            /*[
                'name' => 'Store Sub Head',
                'route_name' => 'sub_head.store',
            ],*/
            [
                'name' => 'Edit Sub Head',
                'route_name' => 'sub_head.edit',
            ],
            /*[
                'name' => 'Update Sub Head',
                'route_name' => 'sub_head.update',
            ],*/
            [
                'name' => 'Destroy Sub Head',
                'route_name' => 'sub_head.destroy',
            ],

            [
                'name' => 'View Child One',
                'route_name' => 'child_one.index',
            ],
            [
                'name' => 'Create Child One',
                'route_name' => 'child_one.create',
            ],
            /*[
                'name' => 'Store Child One',
                'route_name' => 'child_one.store',
            ],*/
            [
                'name' => 'Edit Child One',
                'route_name' => 'child_one.edit',
            ],
            /*[
                'name' => 'Update Child One',
                'route_name' => 'child_one.update',
            ],*/
            [
                'name' => 'Destroy Child One',
                'route_name' => 'child_one.destroy',
            ],

            [
                'name' => 'View Child Two',
                'route_name' => 'child_two.index',
            ],
            [
                'name' => 'Create Child Two',
                'route_name' => 'child_two.create',
            ],
            /*[
                'name' => 'Store Child Two',
                'route_name' => 'child_two.store',
            ],*/
            [
                'name' => 'Edit Child Two',
                'route_name' => 'child_two.edit',
            ],
            /*[
                'name' => 'Update Child Two',
                'route_name' => 'child_two.update',
            ],*/
            [
                'name' => 'Destroy Child Two',
                'route_name' => 'child_two.destroy',
            ],

            [
                'name' => 'View Navigation',
                'route_name' => 'navigate.index',
            ],

            [
                'name' => 'View Credit Voucher',
                'route_name' => 'credit.index',
            ],
            [
                'name' => 'Create Credit Voucher',
                'route_name' => 'credit.create',
            ],
            /*[
                'name' => 'Store Credit Voucher',
                'route_name' => 'credit.store',
            ],*/
            [
                'name' => 'Edit Credit Voucher',
                'route_name' => 'credit.edit',
            ],
            /*[
                'name' => 'Update Credit Voucher',
                'route_name' => 'credit.update',
            ],*/

            [
                'name' => 'View Debit Voucher',
                'route_name' => 'debit.index',
            ],
            [
                'name' => 'Create Purchase Voucher',
                'route_name' => 'debit.create',
            ],
            /*[
                'name' => 'Store Purchase Voucher',
                'route_name' => 'debit.store',
            ],*/
            [
                'name' => 'Edit Purchase Voucher',
                'route_name' => 'debit.edit',
            ],
            /*[
                'name' => 'Update Purchase Voucher',
                'route_name' => 'debit.update',
            ],*/

            [
                'name' => 'View Journal Voucher',
                'route_name' => 'journal.index',
            ],
            [
                'name' => 'Create Journal Voucher',
                'route_name' => 'journal.create',
            ],
            /*[
                'name' => 'Store Journal Voucher',
                'route_name' => 'journal.store',
            ],*/
            [
                'name' => 'Edit Journal Voucher',
                'route_name' => 'journal.edit',
            ],
            /*[
                'name' => 'Update Journal Voucher',
                'route_name' => 'journal.update',
            ],*/
            [
                'name' => 'View Journal Head',
                'route_name' => 'journal_get_head',
            ],


            


        ]);
        
    }
}
