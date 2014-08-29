<?php
class VendorController extends BaseController {

	/*
	| Return the View for loading map as XML file
	*/
	public function loadXMLmap() {

		return View::make('layout.phpsqlajax_genxml');
	}


}