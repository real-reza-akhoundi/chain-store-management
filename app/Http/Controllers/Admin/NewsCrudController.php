<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;

/**
 * Class NewsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NewsCrudController extends CrudController
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
        if(!backpack_auth()->user()->can('writeNews')){
            $this->crud->denyAccess(['create']);
        }
        $this->crud->setModel(\App\Models\News::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/news');
        $this->crud->setEntityNameStrings('news', 'news');
    }

    protected function update($id) {
        if ($this->crud->getEntry($id)->author_id != backpack_auth()->user()->id) 
            abort(403 , "You are not the creator of this news");
        return parent::update($id);
    }


    protected function destroy($id) {
        if ($this->crud->getEntry($id)->author_id != backpack_auth()->user()->id)
             abort(403 , 'You are not the creator of this news');
        
        return parent::destroy($id);
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
                'label' => 'Title',
                'name' => 'title',
                'type' => "text",
            ],
            [  // 1-n relationship
                'label' => "Author", // Table column heading
                'type' => "select",
                'name' => 'author_id', // the column that contains the ID of that connected entity;
                'entity' => 'author', // the method that defines the relationship in your Model
                'attribute' => "username", // foreign key attribute that is shown to user
                'model' => User::class,
            ],
            [
                'label' => "Category", // Table column heading
                'type' => "select",
                'name' => 'cat_id', // the column that contains the ID of that connected entity;
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => Category::class,
            ]
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
        $this->crud->setValidation(NewsRequest::class);
        $this->crud->addFields([
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'text'
            ],
            [
                'name' => 'body',
                'label' => 'body',
                'type' => 'textarea'
            ],
            [
                'label'     => "Category",
                'type'      => 'select',
                'name'      => 'cat_id',
                'entity'    => 'category',
                'model'     => Category::class, 
                'attribute' => 'name',
            ],
            [   
                'name'      => 'image',
                'label'     => 'Image',
                'type'      => 'upload',
                'upload'    => true,
            ],
            [   
                'name'      => 'author_id',
                'entity' => "author",
                'default' => backpack_auth()->user()->id,
                'type' => 'hidden'
            ]
        ]);

        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
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
        $this->setupCreateOperation();
    }
}
