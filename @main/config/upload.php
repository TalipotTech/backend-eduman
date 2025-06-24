<?php

return [
    /*
    |--------------------------------------------------------------------------
    | local upload
    |--------------------------------------------------------------------------
    |
    | Different configuration options for uploading files
    |
    */
    'directories' => [
        'media_image' =>'images/media_',
        'media_file' =>'files/media_',
        'media_video' =>'videos/media_',
        'blog_image' =>'images/blog_',
        'blog_file' =>'files/blog_',
        'blog_video' =>'videos/blog_',
        'event_image' =>'images/event_',
        'event_file' =>'files/event_',
        'event_video' =>'videos/event_',
        'course_image' =>'images/course_',
        'course_file' =>'files/course_',
        'course_video' =>'videos/course_',
        'owner_image' => 'images/user_',
    ],

    'restrictions' => [
        'image' => 'mimes:jpeg,gif,png|max:4096',
        'file' => 'mimes:doc,docx,csv,pdf,png,jpg,jpeg,gif|max:4096',
        'video' => 'mimes:mp4,pdf,png,jpg,jpeg,gif|max:10240',
    ],
];
