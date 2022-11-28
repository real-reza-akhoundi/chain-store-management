<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        if(!backpack_auth()->user()->can('registerUser')){
            $this->crud->denyAccess(['create' , 'update' , 'delete']);
        }
        $this->crud->setModel(\App\Models\User::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');
        $this->crud->setEntityNameStrings('user', 'user');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'username', // The db column name
                'label' => "User Name", // Table column heading
                'type' => 'text'
            ],
            [
                'name' => 'first_name', // The db column name
                'label' => "First Name", // Table column heading
                'type' => 'text'
            ],
            [
                'name' => 'last_name', // The db column name
                'label' => "Last Name", // Table column heading
                'type' => 'text'
            ],
            [
                'name' => 'job_title', // The db column name
                'label' => "Job Title", // Table column heading
                'type' => 'text'
            ],
            [
                // 1-n relationship
                'label' => "Branch", // Table column heading
                'type' => "select",
                'name' => 'branch_id', // the column that contains the ID of that connected entity;
                'entity' => 'branch', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => User::class,
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.permission'), // foreign key model
            ],

        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(UserRequest::class);
        $this->crud->addFields([
            ['name' => 'username', 'type' => 'text' , 'label' => "User Name"],
            ['name' => 'first_name', 'type' => 'text' , 'label' => "First Name"],
            ['name' => 'last_name', 'type' => 'text' , 'label' => "Last Name"],
            ['name' => 'password', 'type' => 'password' , 'label' => "Password"],
            [
                'name'  => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type'  => 'password',
            ],
            ['name' => 'job_title', 'type' => 'text' , 'label' => "Job Title"],
            [
                'label'     => "Branch",
                'type'      => 'select',
                'name'      => 'branch_id',
                'entity'    => 'branch',
                'model'     => Branch::class, 
                'attribute' => 'name',
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
            ],
            [
                'name'      => 'avatar',
                'label'     => 'Avatar',
                'type'      => 'upload',
                'upload'    => true,
                // 'disk'      => 'uploads',
                // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
            ],
            
        ]);
        if(backpack_auth()->user()->can('assignPermission')){

            
            $this->crud->addField([
                // two interconnected entities
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ]);
        }
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(UserRequest::class);
        $this->crud->addFields([
            ['name' => 'username', 'type' => 'text' , 'label' => "User Name"],
            ['name' => 'first_name', 'type' => 'text' , 'label' => "First Name"],
            ['name' => 'last_name', 'type' => 'text' , 'label' => "Last Name"],
            ['name' => 'job_title', 'type' => 'text' , 'label' => "Job Title"],
            [
                'label'     => "Branch",
                'type'      => 'select',
                'name'      => 'branch_id',
                'entity'    => 'branch',
                'model'     => Branch::class, 
                'attribute' => 'name',
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
            ],
            [
                'name'      => 'avatar',
                'label'     => 'Avatar',
                'type'      => 'upload',
                'upload'    => true,
                // 'disk'      => 'uploads',
                // 'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
            ],
        ]);
        if(backpack_auth()->user()->can('assignPermission')){

            
            $this->crud->addField([
                // two interconnected entities
                'label'             => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('backpack::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ]);
        }
            
    }
}
