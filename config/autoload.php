<?php
/**
 * Runtime configuration for the Genesis connect Sensei LMS plugin. 
 * 
 * Returns a list of plugin files to be loaded, without path or extension. 
 */
return array( 
    'sensei-theme-support',
    'add-genesis-supports',
    'add-widget-areas',
    'add-sensei-body-class',
    'template-loader',
    // the course module functionality is now part of sensei-lms
    // 'add-course-module-to-lesson-admin'
);
