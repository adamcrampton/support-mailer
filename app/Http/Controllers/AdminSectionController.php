<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AdminTrait;
use Validator;

class AdminSectionController extends Controller
{
    // The purpose of this controller is to set up all of the repeated properties and methods that /admin pages should inherit.
    protected $configData;
    protected $adminSections;
    protected $issueList;
    protected $insertValidateOptions;
    protected $updateValidationOptions;
    protected $controllerType;

    use AdminTrait;

    public function __construct()
    {
    	// Require authentication.
        $this->middleware('auth');

        // Get global config.
        $this->configData = $this->getGlobalConfig();

        // Get admin section names and routes for front end.
        $this->adminSections = $this->getAdminSections();

        // Determine fields required for validation and associated rules.
        $this->setValidationRules($this->controllerType);
    }

    protected function buildDeleteArray($request, $fieldPrefix)
    {
    	// Checks the request for items tagged for deletion and return an array if found.
    	$deleteArray = [];

    	$request->fieldPrefix = $fieldPrefix;

        foreach ($request->$fieldPrefix as $item => $fieldValues) {
    		if (array_key_exists('delete', $fieldValues)) {
            	$deleteArray[$fieldValues[$fieldPrefix . '_name']] = $fieldValues['id'];
        	}	
        }

        return $deleteArray;
    }

    protected function buildUpdateArray($request, $fieldPrefix, array $fieldsToCheck)
    {
    	// Checks the request for any fields that have been updated and return an array if found.
    	$updateArray = [];

    	$request->fieldPrefix = $fieldPrefix;

    	foreach ($request->$fieldPrefix as $item => $fieldValues) {
    		foreach ($fieldsToCheck as $index => $fieldName) {
	   			if ($fieldValues['original_value_' . $fieldName] !== $fieldValues[$fieldName]) {
	                $updateArray[$fieldValues['id']][$index]['original_value'] = $fieldValues['original_value_' . $fieldName];
	                $updateArray[$fieldValues['id']][$index]['new_value'] = $fieldValues[$fieldName];
	                $updateArray[$fieldValues['id']][$index]['column_name'] = $fieldName;
	            }
    		}    
        }

        return $updateArray;
    }

    protected function checkForRecordChanges($deleteArray, $updateArray, $returnRoute)
    {
    	// If nothing has been updated, we can just return to the view without any further processing.
    	if (empty($deleteArray) && empty($updateArray)) {
            return redirect()->route($returnRoute)->with('warning', 'No items to update or delete.');
        }
    }

    protected function unsetDeletedItemsFromUpdateArray($deleteArray, $updateArray)
    {
    	// Unset any items tagged for deletion so we don't try to update them.
        foreach ($deleteArray as $issueTypeId) {
            unset($updateArray[$issueTypeId]);
        }

    	return $updateArray;
    }

    protected function buildSuccessMessage($deleteArray, $updateArray)
    {
    	// Nested arrays, so count all items (there's probably a neater way to do this).
    	$updateCount = 0;
    	$deleteCount = count($deleteArray) ? count($deleteArray) : 0;

    	if (count($updateArray)) {
    		foreach($updateArray as $updates) {
    			$updateCount += count($updates);
    		}
    	}

    	// Build sucess messages to pass back to the front end.
        $successMessage = '<p>Success! The following updates were made:</p>';

        if (! empty($updateArray)) {
            $successMessage .= '<p>'. $updateCount .' record(s) were updated:</p>';    
            foreach ($updateArray as $issueTypeId => $updates) {
            	$successMessage .= '<ul>';
            	foreach ($updates as $updatedValues) {
            		$successMessage .= '<li><strong>'. $updatedValues['original_value'] .'</strong> updated to <strong>'. $updatedValues['new_value'] .'</strong></li>';
            	}
            	$successMessage .= '</ul>';
            }  
        }

        if (! empty($deleteArray)) {
            $successMessage .= '<p>'. $deleteCount .' record(s) were deleted:</p>';
            $successMessage .= '<ul>';

            foreach ($deleteArray as $itemName => $itemId) {
                $successMessage .= '<li>'. $itemName .'</li>';
            }

            $successMessage .= '</ul>';   
        }

        return $successMessage;
    }

    private function setValidationRules($controllerType)
    {
    	// Depending on the admin page, return the set of required validation rules.
    	switch ($controllerType) {
    		case 'config':
    			$this->insertValidationOptions = [];
    			$this->updateValidationOptions = [
    				'form_heading' => 'required|max:255', 
    				'form_title' => 'required|max:255', 
    				'intro_html' => 'required|max:255', 
    				'provider_list' => 'required', 
    				'show_multiple_providers' => 'required', 
    				'use_staff_list' => 'required'
    			];

    		case 'issueType':
    			$this->insertValidationOptions = [
    				'issue_name' => 'required|max:255|unique:issue_types,issue_name'
    			];
    			$this->updateValidationOptions = [
    				'issue_type.*.issue_name' => 'required|max:255|unique:issue_types,issue_name'
    			];
    			break;

    		case 'provider':
    			$this->insertValidationOptions = [
    				'provider_name' => 'required|max:255|unique:providers,provider_name',
    				'provider_email' => 'required|email|max:255|unique:providers,provider_email'
    			];
    			$this->updateValidationOptions = [
    				'provider.*.name' => 'required|max:255|unique:providers,provider_name',
    				'provider.*.email' => 'required|email|max:255|unique:providers,provider_email'
    			];

    		case 'staffMember':
    			$this->insertValidationOptions = [
    				'staff_first_name' => 'required|max:255|unique:staff_members,staff_first_name',
    				'staff_last_name' => 'required|max:255|unique:staff_members,staff_last_name',
    				'staff_email' => 'required|email|max:255|unique:staff_members,staff_email'
    			];
    			$this->updateValidationOptions = [
    				'staff_member.*.first_name' => 'required|max:255|unique:staff_members,staff_first_name',
    				'staff_member.*.last_name' => 'required|max:255|unique:staff_members,staff_last_name',
    				'staff_member.*.email' => 'required|email|max:255|unique:staff_members,staff_email'
    			];

            case 'user':
                $this->insertValidationOptions = [
                    'user_first_name' => 'required|max:255|unique:users,user_first_name',
                    'user_last_name' => 'required|max:255|unique:users,user_last_name',
                    'user_email' => 'required|email|max:255|unique:users,user_email',
                    'user_password' => 'required|min:6'
                ];
                $this->updateValidationOptions = [
                    'user.*.first_name' => 'required|max:255|unique:users,user_first_name',
                    'user.*.last_name' => 'required|max:255|unique:users,user_last_name',
                    'user.*.email' => 'required|email|max:255|unique:users,user_email'
                ];

    		default:
    			$this->insertValidationOptions = [];
    			$this->updateValidationOptions = [];
    			break;
    	}
    }
}
