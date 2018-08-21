<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\AdminTrait;
use Validator;

class AdminSectionController extends Controller
{
    // The purpose of this controller is to set up all of the repeated properties and methods that /admin pages should inherit.

	// TODO: Check for existing relationships when processing deletions - probably better to tag them as deleted than actually delete (because of the log table).
    // TODO: Add duplicate checking in validation rules.

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

    protected function buildDeleteArray($request)
    {
    	// Checks the request for items tagged for deletion and return an array if found.
    	$deleteArray = [];

        foreach ($request->issue_type as $item => $fieldValues) {
            if (array_key_exists('delete', $fieldValues)) {
                $deleteArray[$fieldValues['original_value']] = $fieldValues['id'];
            }
        }

        return $deleteArray;
    }

    protected function buildUpdateArray($request)
    {
    	// Checks the request for any fields that have been updated and return an array if found.
    	$updateArray = [];

    	foreach ($request->issue_type as $item => $fieldValues) {
            if ($fieldValues['original_value'] !== $fieldValues['name']) {
                $updateArray[$fieldValues['id']]['original_value'] = $fieldValues['original_value'];
                $updateArray[$fieldValues['id']]['new_value'] = $fieldValues['name'];
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
    	// Build sucess messages to pass back to the front end.
        $successMessage = '<p>Success! The following updates were made:</p>';

        if (! empty($updateArray)) {
            $successMessage .= '<p>'. count($updateArray).' record(s) were updated:</p>';
            
            $successMessage .= '<ul>';

            foreach ($updateArray as $issueTypeId => $updatedValues) {
                $successMessage .= '<li>'. $updatedValues['original_value'] .' updated to '. $updatedValues['new_value'] .'</li>';
            }
            $successMessage .= '</ul>';
        }

        if (! empty($deleteArray)) {
            $successMessage .= '<p>'. count($deleteArray).' record(s) were deleted:</p>';
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
    		case 'issueType':
    			$this->insertValidationOptions = [
    				'issue_name' => 'required'
    			];
    			$this->updateValidationOptions = [
    				'issue_type.*.name' => 'required'
    			];
    			break;
    		case 'config':
    			$this->insertValidationOptions = [];

    			$this->updateValidationOptions = [
    				'form_heading' => 'required', 
    				'form_title' => 'required', 
    				'intro_html' => 'required', 
    				'provider_list' => 'required', 
    				'show_multiple_providers' => 'required', 
    				'use_staff_list' => 'required'
    			];
    		
    		default:
    			$this->insertValidationOptions = [];
    			$this->updateValidationOptions = [];
    			break;
    	}
    }
}
