<?php

/**
 * Base model class
 * @package lumasms
 */

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace,PSR1.Methods.CamelCapsMethodName.NotCamelCaps
/**
 * Base model class
 */
class Model
{
    /**
     * Save initial model data to the database
     *
     * @param   mixed $data The data to create it with.
     *
     * @return void
     */
    public static function Create($data = [])
    {
    }

    /**
     * Read model data from the database
     *
     * @param   mixed $data The data to read it with.
     *
     * @return mixed    The data that was read
     */
    public static function Read($data = [])
    {
    }

    /**
     * Update model data in the database
     *
     * @param   mixed $data The data to update it with.
     *
     * @return void
     */
    public static function Update($data = [])
    {
    }

    /**
     * Delete model data in the database
     *
     * @param   mixed $data The data to delete it with.
     *
     * @return void
     */
    public static function Delete($data = [])
    {
    }

    /**
     * The number of pages of a given model
     *
     * @param   mixed $data The data to get the number of pages with.
     *
     * @return mixed  The number of pages
     */
    public static function NumberOfPages($data = [])
    {
    }
}
