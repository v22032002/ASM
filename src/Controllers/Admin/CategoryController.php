<?php

namespace Admin\PhpOop\Controllers\Admin;

use Admin\PhpOop\Commons\Controller;
use Admin\PhpOop\Models\Category;
use Rakit\Validation\Validator;

class CategoryController extends Controller {

    private Category $category;
    public function __construct()
    {
        $this->category = new Category();
    }
    public function index()
    {
        $categories = $this->category->all();



        $this->renderViewAdmin('categories.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $this->renderViewAdmin('categories.create');
    }
    public function store()
    {
        $validator = new Validator;
        $validation = $validator->make($_POST + $_FILES, [
            'name'                  => 'required|max:50',
        ]);
        $validation->validate();
        if ($validation->fails()) {
            $_SESSION['errors'] =  $validation->errors()->firstOfAll();

            header('location: ' . url('admin/categories/create'));
            exit;
        } else {
            $data = [
                'name'                  => $_POST['name'],
            ];
            $this->category->insert($data);
            $_SESSION['status'] = true;
            $_SESSION['msg'] = 'Thao Tác Thành Công';
            header('location: ' . url('admin/categories'));
            exit;
        }
    }
    public function show($id)
    {

        $category = $this->category->findByID($id);

        $this->renderViewAdmin('categories.show', [
            'categories' => $category
        ]);
    }
    public function edit($id)
    {
        $category = $this->category->findByID($id);
        $this->renderViewAdmin('categories.edit', [
            'categories' => $category
        ]);
    }
    

    public function update($id)
    {
        $category = $this->category->findByID($id);
    
        // Kiểm tra xem $_POST có dữ liệu không
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            $validator = new Validator;
            $validation = $validator->make($_POST, [
                'name' => 'required|max:50',
            ]);
            $validation->validate();
    
            if ($validation->fails()) {
                $_SESSION['errors'] = $validation->errors()->firstOfAll();
                header('location: ' . url("admin/categories/{$category['id']}/edit"));
                exit;
            } else {
                $data = [
                    'name' => $_POST['name']
                ];
    
                $this->category->update($id, $data);
                $_SESSION['status'] = true;
                $_SESSION['msg'] = 'Thao Tác Thành Công';
                header('location: ' . url("admin/categories/{$category['id']}/edit"));
                exit;
            }
        } else {
            // Xử lý trường hợp không có dữ liệu POST
            $_SESSION['errors'] = ['general' => 'Không có dữ liệu để cập nhật'];
header('location: ' . url("admin/categories/{$category['id']}/edit"));
            exit;
        }
    }
    

    public function delete($id)
    {

        $category = $this->category->findByID($id);

        $this->category->delete($id);

        header('Location: ' . url('admin/categories'));
        exit();
    }


}