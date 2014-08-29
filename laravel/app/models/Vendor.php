<?php


class Vendor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vendors'; // --------------------> NEED TO CHANGE Table to 'vendors'

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the vendor.
	 *
	 * @return mixed
	 */
	public function getVendorIdentifier()
	{
		return $this->getKey();
	}





}