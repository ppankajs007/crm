<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(                 
                
                'add_permission' => array(                                    
                                    array(
                                            'field' => 'name',
                                            'label' => 'Name',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'description',
                                            'label' => 'Description',
                                            'rules' => 'required'
                                         )
                                    ),
                'edit_lead' => array(
                                    array(
                                            'field' => 'project_code',
                                            'label' => 'Project Code',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'project_title',
                                            'label' => 'Project Title',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'client',
                                            'label' => 'Client',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'start_date',
                                            'label' => 'Start Date',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'due_date',
                                            'label' => 'Due Date',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'assign_to',
                                            'label' => 'Assign To',
                                            'rules' => 'required'
                                         )

                                    ), 
);
