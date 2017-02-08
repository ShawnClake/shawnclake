<?php namespace Clake\UserExtended\Classes;

use Clake\UserExtended\Traits\StaticFactoryTrait;

/**
 * User Extended by Shawn Clake
 * Class StaticFactory
 * User Extended is licensed under the MIT license.
 *
 * @author Shawn Clake <shawn.clake@gmail.com>
 * @link https://github.com/ShawnClake/UserExtended
 *
 * @license https://github.com/ShawnClake/UserExtended/blob/master/LICENSE MIT
 *
 * Used as a method of simplifying syntax whilst safely creating objects.
 * 		An example would be for a Class called ClassD to have a funcion destroyFactory() and appendAndPrint()
* 			ClassD::destroy('never say never ')->appendAndPrint('not like this');
 *
 * Any functions inside of ClassD which you desire to be factory compatible must have a function name that ends in 'Factory'
* However when utilizing the factory, don't write the word 'Factory' as you saw in the example above.
 *
 * @package Clake\UserExtended\Classes
 */
class StaticFactory
{
    use StaticFactoryTrait;
}