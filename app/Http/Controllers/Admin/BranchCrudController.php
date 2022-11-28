<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Database\Capsule\Manager;

/**
 * Class BranchCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BranchCrudController extends CrudController
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
        if(!backpack_auth()->user()->can('registerBranch')){
            $this->crud->denyAccess(['create' , 'update' , 'delete']);
        }
        $this->crud->setModel(\App\Models\Branch::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/branch');
        $this->crud->setEntityNameStrings('branch', 'branch');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        
       $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text'
       ]);
        $this->crud->addColumn([
            'name' => 'address',
            'label' => 'Address',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'label' => "Manager", // Table column heading
            'type' => "select",
            'name' => 'manager_id', // the column that contains the ID of that connected entity;
            'entity' => 'manager', // the method that defines the relationship in your Model
            'attribute' => "username", // foreign key attribute that is shown to user
            'model' => Branch::class,
        ]);
        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BranchRequest::class);

        $this->crud->addField([
            'name' => 'name',
            "label" => 'Name',
            "type" => 'text'
        ]);

        $this->crud->addField([
            'name' => 'address',
            'label' => 'Address',
            'type' => 'text'
        ]);
        
    
        $this->crud->addField([
            'label'     => "Manager",
            'type'      => 'select',
            'name'      => 'manager_id',
            'entity'    => 'manager',
            'model'     => User::class, 
            'attribute' => 'username',
            
        ]);
        
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
