<?php 
    // Silence is golden

    /*
    
        Create a new “authors” post type

        The goal is to create a new post type called “authors” without using any Custom Post Type or Custom Fields plugin.

        When adding a new author, the edit screen needs to have the following fields:
        - First name
        - Last name
        - Biography
        - Facebook URL
        - Linkedin URL
        - Option to link this author to an existing WordPress user 
            (either a dropdown with WordPress users or a text field to enter a WordPress user ID)
        - Author’s image
        - Image gallery

        Author Single Page:
        Should be accessed at http://url/authors/first_name_field-last_name_field.
        All of the author’s custom fields should be displayed
        If the author is linked to a WordPress user, show a list of that user’s posts at the bottom of the page.

        The Authors archive should be accessed at http://url/authors, 
        and it should contain a list of all the authors with links to their individual single pages.
    
    
    */