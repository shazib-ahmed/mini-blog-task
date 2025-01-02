<?php

/**
 * View Controller Class
 * 
 * Handles the rendering of different views in the blog application.
 * This controller is responsible for loading the appropriate view files
 * based on the requested action.
 */
class ViewController
{
    /**
     * Renders the main index/listing page
     * 
     * @return void
     */
    public function index()
    {
        require '../public/views/index.php';
    }

    /**
     * Renders the create new post form
     * 
     * @return void
     */
    public function create()
    {
        require '../public/views/create.php';
    }

    /**
     * Renders the edit post form
     * 
     * @param int $id The ID of the post to edit
     * @return void
     */
    public function edit($id)
    {
        require '../public/views/edit.php';
    }

    /**
     * Renders the single post view page
     * 
     * @param int $id The ID of the post to view
     * @return void
     */
    public function view($id)
    {
        require '../public/views/view.php';
    }
}
